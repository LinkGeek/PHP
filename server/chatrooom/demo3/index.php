<?php

//send用户加入
//send1发送信息
//send2退出登录



error_reporting(E_ALL ^ E_NOTICE);
ob_implicit_flush();

//连接服务器
$sk = new Sock('127.0.0.1',8000);
$sk->run();


class Sock{
    public $sockets;
    public $users;
    public $master;

    private $sda = array();//已接收的数据
    private $slen = array();//数据总长度
    private $sjen = array();//接收数据的长度
    private $ar = array();//加密key
    private $n = array();

    public function __construct($address, $port){
        $this->master = $this->WebSocket($address, $port);//resource(2, Socket)  //服务器监听
        // var_dump($this->master);
        $this->sockets = array($this->master);//array (size=1) 0 => resource(2, Socket) 。运行两个php还是这样

        //var_dump($this->sockets);
        //file_put_contents('lz.text',var_dump($this->sockets), FILE_APPEND);
    }
    public function run(){

        /*
        * 第一次握手的流程
        * 连接master,接受并创建一个子链接!
        * 分配一个唯一的key,并将字连接存储,代表当前这个连接的用户
        */

        while(true){
            $changes = $this->sockets;//$changes由多变1,但$this->sockets却只是稳定的+1;
            $write = NULL;
            $except = NULL;
            //1.运行select()系统调用在给定阵列插座与指定的超时
            //2.没有接收到数据就会一直处于阻塞状态,
            //3.若没有client过来,直阻塞进程,直到有client访问,返回1。
            //4.此时返回的changes,不是曾经的changes。虽然还只是一条记录,但已经不是服务器而是客户端

            /*select的特殊作用：！！！！！！！
            初始为array(0=>resource(2, Socket))
            1,初始状态返回为array(0=>resource(2, Socket))。但socket_accept可以得到resource(3, Socket)
            2,初始状态返回为array(0=>resource(2, Socket),1=>resource(3,Socket))。
            客户来的客户为resource(3,Socket)。则返回的数据为resource(3,Socket).!!!
            */
            // var_dump($changes);
            $rr = socket_select($changes,$write,$except,NULL);
            // var_dump($changes);
            // var_dump("---*---");
            //exit;

            // file_put_contents('./lz1.text',json_encode($changes), FILE_APPEND);
            // file_put_contents('./lz.text','-----', FILE_APPEND);
            foreach($changes as $sock){
                // var_dump($sock);
                // var_dump("******");
                //连接主机的client
                //$this->master永远是 resource(2, Socket)。相当于一个缓存。两种情况,1:为空,使进程阻塞。2：存刚接收的client。
                if($sock == $this->master){ //---此处只用来存数据了
                    //第一次握手时走此处
                    //在socket套接字已创建使用socket_create()，必将与socket_bind()名字，告诉听连接socket_listen()，这个函数将接受传入的连接，插座。
                    //一旦成功连接，将返回一个!!新的套接字资源！！，该资源可用于通信。如果套接字上有多个连接，则第一个将被使用。
                    //如果没有挂起的连接，socket_accept()将阻塞直到连接成为现在。如果使用了非阻塞套接字已socket_set_blocking()或socket_set_nonblock()，错误将返回。
                    //返回socket_accept()插座资源不得用于接受新的连接。原来的听插座插座，但是,仍然是开放的，可以重复使用。
                    $client = socket_accept($this->master); //resource(3, Socket)。表示接受请求,并创建一个子链接!!
                    //var_dump($client);
                    //exit;
                    $key = 'aaa'.rand(10000,99999);
                    $this->sockets[] = $client;
                    $this->users[$key] = array(
                        'socket' => $client,
                        'shou' => false
                    );
                    // var_dump(1);
                    // echo 1;
                    /*
                    array (size=1)
                    '57d607085f92a' =>  //$key
                    array (size=2)
                    'socket' => resource(3, Socket) //$socket的表现都一样,只有通过$key区分
                    'shou' => boolean false
                    */
                    // file_put_contents('lz.text',json_encode($this->users), FILE_APPEND);
                }else{ //---此处服务器与客户端发信息
                    //发送消息时走此处
                    // echo 2;
                    $len = 0;
                    $buffer = '';
                    do{
                        /*
                        int socket_recv ( resource socket, string &buf, int len, int flags )
                        resource socket 是生成的套接字
                        string &buf 是接收缓冲区
                        int len 是你打算接收的长度
                        int flags 是一个标志
                        0x1 数据应该带外发送，所谓带外数据就是TCP紧急数据
                        0x2 使有用的数据复制到缓冲区内，但并不从系统缓冲区内删除。
                        0x4 不要将包路由出去。
                        以上三项与sock.h文件中定义完全相同
                        0x8 数据完整记录
                        0x100 数据完整处理
                        */
                        $l = socket_recv($sock,$buf,1000,0);//原来取数据是一个缓慢的过程,要一次一次取数据,并计算每次buf的长度,让总长度不超过设定值
                        // var_dump($l);
                        // exit;
                        // file_put_contents('lz.text','socket_recv', FILE_APPEND);
                        $len += $l;
                        $buffer.=$buf;
                        // var_dump($buf);
                    } while ($l == 1000);
                    $k = $this->search($sock);//跟据sock返回key值
                    // file_put_contents('./d.txt', $k.PHP_EOL,FILE_APPEND);
                    if($len < 7){ //发过来的消息太短了,系统就判断 断了,断掉链接。
                        $this->send2($k);//用户退出。1关闭这个$key值对应的socket、删除这条key记录。将sockets数组对象重新排列。
                        continue;
                    }
                    if(!$this->users[$k]['shou']){//判断用户的握手字段是true？否则重新握手。
                        $this->woshou($k,$buffer);
                        //file_put_contents('lz.text','woshou', FILE_APPEND);
                    }else{ //如果用户已经握手,则与用户之间进行通信。终于可以发消息了！
                        $buffer = $this->uncode($buffer,$k); //返编译
                        if($buffer == false){
                            continue;
                        }
                        $this->send($k,$buffer);
                    }
                }
            }

        }

    }

    public function close($k){
        socket_close($this->users[$k]['socket']);
        unset($this->users[$k]);
        $this->sockets = array($this->master);
        foreach($this->users as $v){
            $this->sockets[]=$v['socket'];
        }
        $this->e("key:$k close");
    }

    function search($sock){
        foreach ($this->users as $k => $v){
            if($sock == $v['socket']) return $k;
        }
        return false;
    }


    function WebSocket($address,$port){ //服务器监听
        //创建并返回一个套接字resource，也称作一个通讯节点。一个典型的网络连接由 2 个套接字构成，一个运行在客户端，另一个运行在服务器端。
        //协议，类型，具体协议
        $server = socket_create(AF_INET, SOCK_STREAM, SOL_TCP); //resource(2, Socket)
        //file_put_contents('lz.text',$server, FILE_APPEND);//supplied resource is not a valid stream resource
        //返回bool.套接字resource,协议级别,可用的socket选项,值。
        $r = socket_set_option($server, SOL_SOCKET, SO_REUSEADDR, 1);//boolean true

        //绑定 address 到 socket。 该操作必须是在使用 socket_connect() 或者 socket_listen() 建立一个连接之前。
        $r2 = socket_bind($server, $address, $port);//boolean true


        //在socket套接字已创建使用socket_create()定界与socket_bind()名称，它可以告诉听套接字传入的连接.
        $r3 = socket_listen($server);//boolean true

        $this->e('Server Started : '.date('Y-m-d H:i:s'));
        $this->e('Listening on  : '.$address.' port '.$port);
        return $server;
    }

    function woshou($k,$buffer){
        //对接收到的buffer处理,并回馈握手！！
        $buf = substr($buffer,strpos($buffer,'Sec-WebSocket-Key:')+18);
        $key = trim(substr($buf,0,strpos($buf,"\r\n")));

        $new_key = base64_encode(sha1($key."258EAFA5-E914-47DA-95CA-C5AB0DC85B11",true));

        $new_message = "HTTP/1.1 101 Switching Protocols\r\n";
        $new_message .= "Upgrade: websocket\r\n";
        $new_message .= "Sec-WebSocket-Version: 13\r\n";
        $new_message .= "Connection: Upgrade\r\n";
        $new_message .= "Sec-WebSocket-Accept: " . $new_key . "\r\n\r\n";
        socket_write($this->users[$k]['socket'],$new_message,strlen($new_message));//sokcet,buffer(缓冲区),长度
        $this->users[$k]['shou']=true;
        return true;
    }

    function uncode($str,$key){ //返编译
        $mask = array();
        $data = '';
        $msg = unpack('H*',$str);//unpack() 函数从二进制字符串对数据进行解包。
        $head = substr($msg[1],0,2);
        if ($head == '81' && !isset($this->slen[$key])) {
            $len=substr($msg[1],2,2);
            $len=hexdec($len);
            if(substr($msg[1],2,2)=='fe'){
                $len=substr($msg[1],4,4);
                $len=hexdec($len);//hexdec() 函数把十六进制转换为十进制。
                $msg[1]=substr($msg[1],4);
            }else if(substr($msg[1],2,2)=='ff'){
                $len=substr($msg[1],4,16);
                $len=hexdec($len);
                $msg[1]=substr($msg[1],16);
            }
            $mask[] = hexdec(substr($msg[1],4,2));
            $mask[] = hexdec(substr($msg[1],6,2));
            $mask[] = hexdec(substr($msg[1],8,2));
            $mask[] = hexdec(substr($msg[1],10,2));
            $s = 12;
            $n=0;
        }else if($this->slen[$key] > 0){
            $len=$this->slen[$key];
            $mask=$this->ar[$key];
            $n=$this->n[$key];
            $s = 0;
        }

        $e = strlen($msg[1])-2;
        for ($i=$s; $i<= $e; $i+= 2) {
            $data .= chr($mask[$n%4]^hexdec(substr($msg[1],$i,2)));
            $n++;
        }
        $dlen=strlen($data);

        if($len > 255 && $len > $dlen+intval($this->sjen[$key])){
            $this->ar[$key]=$mask;
            $this->slen[$key]=$len;
            $this->sjen[$key]=$dlen+intval($this->sjen[$key]);
            $this->sda[$key]=$this->sda[$key].$data;
            $this->n[$key]=$n;
            return false;
        }else{
            unset($this->ar[$key],$this->slen[$key],$this->sjen[$key],$this->n[$key]);
            $data=$this->sda[$key].$data;
            unset($this->sda[$key]);
            return $data;
        }
    }
    function code($msg){ //编译
        $frame = array();
        $frame[0] = '81';
        $len = strlen($msg);
        if($len < 126){
            $frame[1] = $len<16?'0'.dechex($len):dechex($len);
        }else if($len < 65025){
            $s=dechex($len);
            $frame[1]='7e'.str_repeat('0',4-strlen($s)).$s;
        }else{
            $s=dechex($len);
            $frame[1]='7f'.str_repeat('0',16-strlen($s)).$s;
        }
        $frame[2] = $this->ord_hex($msg);
        $data = implode('',$frame);
        return pack("H*", $data);
    }

    function ord_hex($data) {
        $msg = '';
        $l = strlen($data);
        for ($i= 0; $i<$l; $i++) {
            $msg .= dechex(ord($data{$i}));
        }
        return $msg;
    }
    //用户加入
    function send($k,$msg){
        parse_str($msg,$g);//把查询字符串解析到变量中
        $ar = array();
        if($g['type'] == 'add'){
            $this->users[$k]['name'] = $g['ming'];
            $ar['type'] = 'add';
            $ar['name'] = $g['ming'];
            $key = 'all';
        }else{
            $ar['nrong'] = $g['nr'];
            $key = $g['key'];
        }
        $this->send1($k,$ar,$key);
    }

    function getusers(){
        $ar = array();
        foreach($this->users as $k => $v){
            $ar[]=array('code' => $k,'name' => $v['name']);
        }
        return $ar;
    }
    //$k 发信息人的code $key接受人的 code
    function send1($k,$ar,$key='all'){
        file_put_contents('./cookie.txt', $_COOKIE['name'].PHP_EOL,FILE_APPEND);
        $ar['code1']=$key;
        $ar['code']=$k;
        $ar['time']=date('m-d H:i:s');
        $str = $this->code(json_encode($ar));
        if($key == 'all'){
            $users = $this->users;
            if($ar['type'] == 'add'){
                $ar['type'] = 'madd';
                $ar['users'] = $this->getusers();
                $str1 = $this->code(json_encode($ar));
                socket_write($users[$k]['socket'],$str1,strlen($str1));//发送者
                unset($users[$k]);
            }
            foreach($users as $v){
                socket_write($v['socket'],$str,strlen($str));//接收者
            }
        }else{
            socket_write($this->users[$k]['socket'],$str,strlen($str));//发送者
            socket_write($this->users[$key]['socket'],$str,strlen($str));//接收者
        }
    }

    //用户退出
    function send2($k){
        $this->close($k);
        $ar['type']='rmove';
        $ar['nrong']=$k;
        $this->send1(false,$ar,'all');
    }

    function e($str){
        //$path=dirname(__FILE__).'/log.txt';
        $str = $str."\n";
        //error_log($str,3,$path);
        echo iconv('utf-8','gbk//IGNORE',$str);
    }

}