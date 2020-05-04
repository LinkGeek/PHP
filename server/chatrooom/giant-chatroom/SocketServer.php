<?php


class SocketServer {

    private $_ip = "127.0.0.1";
    private $_port = 8080;
    private $_socket = null;
    private $_socketPool = [];
    const LISTEN_SOCKET_NUM = 9; // 最大连接数
    const LOG_PATH = './log/';
    //private $encrypt_key = 'I3K190HO-F2DA-82CZ-58VS-4A7B05B1W1EK'; // 加密的字符串
    private $encrypt_key = '258EAFA5-E914-47DA-95CA-C5AB0DC85B11'; // 加密的字符串

    public function __construct()
    {
        $this->initSocket();
    }

    /**
     * 初始化
     */
    private function initSocket()
    {
        try {
            $this->_socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            // 设置ip和port重用，在重启服务器后能重新使用此端口
            socket_set_option($this->_socket, SOL_SOCKET, SO_REUSEADDR, 1);
            socket_bind($this->_socket, $this->_ip, $this->_port);
            socket_listen($this->_socket, self::LISTEN_SOCKET_NUM);
        } catch (Exception $e) {
            $this->debugLog(["code: ".$e->getCode(), 'msg: '.$e->getMessage()]);
        }

        // 将所有套接字存于该数组
        $this->_socketPool[0] = ['resource' => $this->_socket];
        // 获取进程的ID
        $pid = getmypid();
        $this->debugLog(["server: {$this->_socket} started, pid: {$pid}"]);
    }

    public function start()
    {
        // 对socket循环进行监听，处理数据
        while (true) {
            $write = $except = null;
            $sockets = array_column($this->_socketPool, 'resource');
            /**
             * 阻塞，直到捕获到变化
             * socket_select ($sockets, $write = NULL, $except = NULL, NULL);
             * $sockets可以理解为一个数组，这个数组中存放的是文件描述符。当它有变化（就是有新消息到或者有客户端连接/断开）时，socket_select函数才会返回，继续往下执行。
             * $write是监听是否有客户端写数据，传入NULL是不关心是否有写变化。
             * $except是$sockets里面要被排除的元素，传入NULL是监听全部。

             * 最后一个参数是超时时间
             * 如果为 0：则立即结束
             * 如果为 n>1: 则最多在n秒后结束，如遇某一个连接有新动态，则提前返回
             * 如果为 null：如遇某一个连接有新动态，则返回
            */
            $read_num = socket_select($sockets, $write, $except, 3600);
            if ($read_num === false) {
                $errorCode = socket_last_error();
                $errorMsg = socket_strerror($errorCode);
                $this->debugLog(["socket_select error", $errorCode, $errorMsg]);
                return;
            }

            foreach ($sockets as $socket) {
                // 如果有新的client连接进来，则
                if ($socket == $this->_socket) {
                    // 接受一个socket连接
                    $client = socket_accept($this->_socket);
                    if ($client === false) {
                        $errorCode = socket_last_error();
                        $errorMsg = socket_strerror($errorCode);
                        $this->debugLog(["socket_accept_error", $errorCode, $errorMsg]);
                        continue;
                    }
                    // 添加客户端套接字
                    $this->addConnect($client);
                }
                // 否则 1. client断开socket连接；2. client发送信息
                else {
                    // 获取客户端发送来的信息
                    $bytes = @socket_recv($socket, $buf, 2048, 0);
                    if ($bytes == false) {
                        continue;
                    }
                    // 如果接收的信息长度为0，则该client的socket为断开连接
                    elseif ($bytes === 0) {
                        $recv_msg = $this->disConnect($socket);
                    }
                    // 判断该socket是否已经握手，如果没有握手，则进行握手操作
                    elseif ($this->_socketPool[(int)$socket]['handShake'] == false) {
                        $this->createHandShake($socket, $buf);
                        continue;
                    }
                    // client发送信息
                    else {
                        $recv_msg = $this->decodeMsg($buf);
                    }

                    $send_msg = $this->doEvents($socket, $recv_msg);
                    // 广播
                    $this->send_to_other($send_msg);

                    // 获取client ip port
                    socket_getpeername($socket, $address, $port);
                    $this->debugLog(['send success', json_encode($recv_msg), $address, $port]);
                }
            }
        }
    }

    /**
     * 广播至除发送方外的客户端
     * @param $msg
     */
    private function send_to_other($msg)
    {
        foreach ($this->_socketPool as $socket) {
            if ($socket['resource'] == $this->_socket) {
                continue;
            }
            socket_write($socket['resource'], $msg, strlen($msg));
        }
    }

    /**
     * 业务
     * @param $socket
     * @param $recv_msg
     * @return string
     */
    private function doEvents($socket, $recv_msg)
    {
        $type = $recv_msg['type'];
        $cont = $recv_msg['msg'];
        $resp = ['type' => $type, 'msg' => $cont];
        switch ($type) {
            case 'login':
                $userInfo = [
                    'name' => $cont,
                    'image' => $recv_msg['image'],
                    'login_time' => date('h:i')
                ];
                $this->_socketPool[(int)$socket]['userInfo'] = $userInfo;
                $resp['users'] = array_column($this->_socketPool, 'userInfo');
                break;
            case 'logout':
                $resp['users'] = array_column($this->_socketPool, 'userInfo');
                break;
            case 'user':
                $userInfo = $this->_socketPool[(int)$socket]['userInfo'];
                $resp['from'] = $userInfo['name'];
                $resp['image'] = $userInfo['image'];
                break;
        }
        return $this->encodeMsg(json_encode($resp));
    }

    /**
     * socket握手
     * @param $socket
     * @param $buf
     * @return bool
     */
    public function createHandShake($socket, $buf)
    {
        $acceptKey = $this->encrypt($buf);
        // 每一个请求和相应的格式，最后有一个空行，也就是 \r\n
        $upgrade  = "HTTP/1.1 101 Switching Protocol\r\n" .
            "Upgrade: websocket\r\n" .
            "Connection: Upgrade\r\n" .
            "Sec-WebSocket-Accept: " . $acceptKey . "\r\n" .
            "\r\n";
        // 写入socket
        socket_write($socket, $upgrade, strlen($upgrade));

        // 标记握手已经成功
        $this->_socketPool[(int)$socket]['handShake'] = true;
        socket_getpeername($socket, $address, $port);
        $this->debugLog(['handShake success', $socket, $address, $port]);

        // 通知握手成功
        $msg = ['type' => 'handShake', 'msg' => '握手成功！'];
        $msg = $this->encodeMsg(json_encode($msg));
        socket_write($socket, $msg, strlen($msg));
        return true;
    }

    /**
     * 客户端的套接字
     * @param $client
     */
    public function addConnect($client)
    {
        // 获取ip、端口
        socket_getpeername($client, $address, $port);
        $info = [
            'resource' => $client,
            'ip' => $address,
            'port' => $port,
            'userInfo' => [],
            'handShake' => false, // 标记该socket没有完成握手
        ];
        // 将新连接进来的socket存进连接池
        $this->_socketPool[intval($client)] = $info;
        $this->debugLog(['add connect', json_encode($info)]);
    }

    /**
     * 断开连接
     * @param $socket
     * @return array
     */
    public function disConnect($socket)
    {
        $msg = [
            'type' => 'logout',
            'msg' => @$this->_socketPool[(int)$socket]['userInfo']['name']
        ];
        unset($this->_socketPool[(int)$socket]);
        return $msg;
    }

    /**
     * 加密 Sec-WebSocket-Key
     * @param $buf
     * @return string
     */
    private function encrypt($buf)
    {
        $client_key = $this->getKey($buf);
        return base64_encode(sha1($client_key.$this->encrypt_key,true));
    }

    /**
     * 返回帧信息处理
     * @param $msg
     * @return string
     */
    private function encodeMsg($msg)
    {
        $frame = [];
        $frame[0] = '81';
        $len = strlen($msg);
        if ($len < 126) {
            $frame[1] = $len < 16 ? '0' . dechex($len) : dechex($len);
        } else if ($len < 65025) {
            $s = dechex($len);
            $frame[1] = '7e' . str_repeat('0', 4 - strlen($s)) . $s;
        } else {
            $s = dechex($len);
            $frame[1] = '7f' . str_repeat('0', 16 - strlen($s)) . $s;
        }
        $data = '';
        $l = strlen($msg);
        for ($i = 0; $i < $l; $i++) {
            $data .= dechex(ord($msg{$i}));
        }
        $frame[2] = $data;
        $data = implode('', $frame);
        return pack("H*", $data);
    }

    /**
     * 解析数据帧
     * @param $buffer
     * @return mixed 解码后的字符串
     */
    private function decodeMsg($buffer)
    {
        $decoded = '';
        // 返回字符串第一个字符的 ASCII 码值
        $len = ord($buffer[1]) & 127;
        if ($len === 126) {
            $masks = substr($buffer, 4, 4);
            $data = substr($buffer, 8);
        } else if ($len === 127) {
            $masks = substr($buffer, 10, 4);
            $data = substr($buffer, 14);
        } else {
            $masks = substr($buffer, 2, 4);
            $data = substr($buffer, 6);
        }
        for ($index = 0; $index < strlen($data); $index++) {
            $decoded .= $data[$index] ^ $masks[$index % 4];
        }

        return json_decode($decoded, true);
    }

    /**
     * 提取 Sec-WebSocket-Key
     * @param $buf
     * @return mixed|null
     */
    private function getKey($buf)
    {
        $client_key = null;
        if (preg_match("/Sec-WebSocket-Key: (.*)\r\n/", $buf, $matches)) {
            $client_key = $matches[1];
        }
        return $client_key;
    }

    /**
     * 打印日志
     * @param array $info
     */
    private function debugLog($info)
    {
        $time = date("Y-m-d H:i:s");
        $info = array_merge(['time' => $time], $info);
        $info = array_map('json_encode', $info);
        $fileName = self::LOG_PATH.date('Ymd').'_socket_debug.log';
        file_put_contents($fileName, implode(' | ', $info). "\r\n", FILE_APPEND);
    }
}