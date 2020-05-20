<?php

// Web服务器

$http = new swoole_http_server("0.0.0.0", "9503");
// request
$http->on("request", function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {
    var_dump($request->get, $request->post);
    $response->header("Content-Type", "text/html; charset=utf-8");
    $response->end("<h1>Hello Swoole. #" . mt_rand(1000, 9999) . "</h1>\n");
});
// start
$http->start();

// cli命令
// php http_server.php

//curl -XGET "127.0.0.1:9503?id=1&name=aa&age=26"
//curl -XPOST "127.0.0.1:9503?id=1&name=aa&age=26" -d "love=like"