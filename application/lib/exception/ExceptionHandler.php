<?php
/**
 * Created by PhpStorm.
 * User: lxj
 * Date: 2019/9/27
 * Time: 19:51
 */

namespace app\lib\exception;

use Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

/*
 * 覆盖thinkphp原有的Handle异常抛出方法
 * 做全局异常处理
 */

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    public function render(Exception $e)
    {
        if ($e instanceof BaseException) {
            //如果是来自BaseException的自定义异常,控制http状态码
            //这通常是因为客户端传递参数错误或者是用户请求造成的异常
            //需要向用户返回信息  不记录日志
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }
        else {
            if (config('app_debug')) {
                //调试状态下返回比较全面的tp异常页面
                //在上线或客户端使用时可关闭app_debug配置
                return parent::render($e);
            }
            //服务器未处理异常,将http状态码设置成500
            $this->code = 500;
            $this->msg = '服务器内部错误';
            $this->errorCode = 999;
            //需要记录日志
            $this->recordErrorLog($e);
        }
        $request = Request::instance();

        $result = [
            'msg' => $this->msg,
            'errorCode' => $this->errorCode,
            'request_url' => $request->url(),
        ];
        return json($result, $this->code);
    }

    public function recordErrorLog(Exception $e)
    {
        //开启thinkphp记录日志的行为
        Log::init([
            'type' => 'File',
            'path' => LOG_PATH,
            'level' => ['error'],
        ]);
        Log::record($e->getMessage(), 'error');
    }
}