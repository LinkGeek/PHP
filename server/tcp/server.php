<?php

/**
 * tcp 服务端
 */

// 确保在连接客户端时不会超时
set_time_limit(0);

// ip、端口
//$ip = "192.168.7.105";
$ip = "127.0.0.1";
$port = 8080;

    /**
     * 创建一个SOCKET
     * domain 参数指定哪个协议用在当前套接字上
     * AF_INET是ipv4网络协议 如果用ipv6，则参数为 AF_INET6
     * type 参数用于选择套接字使用的类型
     * SOCK_STREAM为socket的tcp类型，如果是UDP则使用SOCK_DGRAM
     * protocol 参数，是设置指定 domain 套接字下的具体协议
     */
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
        echo "socket_create() failed.\nReason: " . socket_strerror(socket_last_error()) . "\n";
    }

// 绑定接收的套接流主机和端口,与客户端相对应
    $ret = socket_bind($socket, $ip, $port);
    if (!$ret) {
        echo "socket_bind() failed.\nReason: " . socket_strerror(socket_last_error()) . "\n";
    }

// 监听套接流
    $ret = socket_listen($socket);
    if (!$ret) {
        echo "socket_listen() failed.\nReason: " . socket_strerror(socket_last_error()) . "\n";
    }

// 让服务器无限获取客户端传过来的信息
    do {
        // 接收客户端传过来的信息
        $acpSocket = socket_accept($socket);
        if ($acpSocket === false) {
            echo "socket_accept() failed.\nReason: " . socket_strerror(socket_last_error()) . "\n";
            break;
        }

        // 读取套接字的资源信息，并转化为字符串 length: 读取字符串的长度
        $buf = socket_read($acpSocket,1024);
        echo "receive from client: $buf\n";

        if ($buf != false) {
            // 回复客户端
            $sendMsg = "hello client, I have received your msg";
            socket_write($acpSocket, $sendMsg, strlen($sendMsg));
        } else {
            echo "socket_read failed.\n";
        }

    // socket_close的作用是关闭socket_create()或者socket_accept()所建立的套接流
    socket_close($acpSocket);
} while (true);
socket_close($socket);


//socket相关函数：
//----------------------------------------------------------------------------------------------
//socket_accept() 接受一个Socket连接
//socket_bind() 把socket绑定在一个IP地址和端口上
//socket_clear_error() 清除socket的错误或者最后的错误代码
//socket_close() 关闭一个socket资源
//socket_connect() 开始一个socket连接
//socket_create_listen() 在指定端口打开一个socket监听
//socket_create_pair() 产生一对没有区别的socket到一个数组里
//socket_create() 产生一个socket，相当于产生一个socket的数据结构
//socket_get_option() 获取socket选项
//socket_getpeername() 获取远程类似主机的ip地址
//socket_getsockname() 获取本地socket的ip地址
//socket_iovec_add() 添加一个新的向量到一个分散/聚合的数组
//socket_iovec_alloc() 这个函数创建一个能够发送接收读写的iovec数据结构
//socket_iovec_delete() 删除一个已经分配的iovec
//socket_iovec_fetch() 返回指定的iovec资源的数据
//socket_iovec_free() 释放一个iovec资源
//socket_iovec_set() 设置iovec的数据新值
//socket_last_error() 获取当前socket的最后错误代码
//socket_listen() 监听由指定socket的所有连接
//socket_read() 读取指定长度的数据
//socket_readv() 读取从分散/聚合数组过来的数据
//socket_recv() 从socket里结束数据到缓存
//socket_recvfrom() 接受数据从指定的socket，如果没有指定则默认当前socket
//socket_recvmsg() 从iovec里接受消息
//socket_select() 多路选择
//socket_send() 这个函数发送数据到已连接的socket
//socket_sendmsg() 发送消息到socket
//socket_sendto() 发送消息到指定地址的socket
//socket_set_block() 在socket里设置为块模式
//socket_set_nonblock() socket里设置为非块模式
//socket_set_option() 设置socket选项
//socket_shutdown() 这个函数允许你关闭读、写、或者指定的socket
//socket_strerror() 返回指定错误号的详细错误
//socket_write() 写数据到socket缓存
//socket_writev() 写数据到分散/聚合数组
