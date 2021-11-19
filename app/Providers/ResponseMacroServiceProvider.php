<?php
/**
 * Created by PhpStorm.
 * User: loong
 * Date: 11/11/21
 * Time: 3:04 PM
 */

namespace App\Providers;


use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Support\Facades\DB;

class ResponseMacroServiceProvider extends ServiceProvider
{
    public function boot(){
        //可以根据uri来定制输出格式
        $request = \request();
        Response::macro('error',function ($message,$code=400,$data=[]) use(&$request){
            $statusCode = 200;
            $msg = '';
            if(is_string($message)){
                $msg = $message;
            }elseif($message instanceof HttpException){
                $code = $statusCode = $message->getStatusCode();
                $msg = $message->getMessage()?:$message->getStatusCode();
            }elseif($message instanceof \Exception){
                $msg = $message->getMessage();
            }
            if(!$code) $code = 400;
            return Response::json(['code'=>$code,'message'=>$msg?:'未知错误','data'=>$data?:[]],$statusCode);
        });

        Response::macro('success',function ($data,$message='') use(&$request){
            return Response::json(['code'=>0,'message'=>$message,'data'=>$data?:[]]);
        });

        //打印sql
        if (config('app.debug')) {
            DB::listen(function ($query) {
                \Log::debug("connectionName:{$query->connectionName}\t#queryTime:{$query->time}\t#sql:{$query->sql}\t#params:".json_encode($query->bindings));
            });

        }
    }
}