<?php


namespace lib;

/**
 * 错误接管类
 * Class Error
 * @package chat\app\lib
 */
class Error
{
    public function __construct()
    {
        $this->isErr();
    }

    public function isErr()
    {
        // set_exception_handler — 设置用户自定义的异常处理函数
        set_exception_handler([$this, 'exception']);

        // set_error_handler — 设置用户自定义的错误处理函数
        set_error_handler([$this, 'err']);

        // register_shutdown_function — 注册一个会在php中止时执行的函数
        register_shutdown_function([$this, 'lastError']);
    }

    // 异常接管
    public function exception($exception)
    {
        // 获取错误异常信息
        $message = $exception->getMessage();
        // 获取错误异常代码
        $code = $exception->getCode();
        // 获取错误异常文件
        $file = $exception->getFile();
        // 获取错误异常文件行数
        $line = $exception->getLine();
    }

    // 错误接管
    public function err($code, $message, $file, $line)
    {
        // 记录日志
        $this->errLog($code, $message, $file, $line);
    }

    // 脚本结束前获取最后错误
    public function lastError()
    {
        // error_get_last — 获取最后发生的错误
        $last = error_get_last();
        // set_error_handler有些错误是无法获取的，所以价格判断
        if ($last['type'] == 1 || $last['type'] == 4 || $last['type'] == 16 || $last['type'] == 64 || $last['type'] == 128) {
            $this->errLog($last['type'], $last['message'], $last['file'], $last['line']);
        }
    }

    // 错误信息收集并记录 (参数传输的顺序不一样，参数还不一样)
    public function errLog($code, $message, $file, $line)
    {
        $message = Helper::doEncoding($message);
        // 拼接错误信息
        $errStr = date('Y-m-d h:i:s') . "\r\n";
        $errStr .= '错误级别：' . $code . "\r\n";
        $errStr .= '错误信息：' . $message . "\r\n";
        $errStr .= '错误文件：' . $file . "\r\n";
        $errStr .= '错误行数：' . $line . "\r\n";
        $errStr .= "\r\n";

        if (!is_dir(LOG_PATH)) {
            mkdir(LOG_PATH);
        }
        // error_log — 发送错误信息到某个地方
        error_log($errStr, 3, LOG_PATH . '/error.'.date('Ymd').'.log');
    }
}