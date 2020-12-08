<?php
/**
 * @name ErrorController
 * @desc 错误控制器,
 * 在发生未捕获的异常时刻被调用,每个应用都必须要有ErrorController.
 * DEBUG为true时程序异常时会显示详细的代码栈
 * @see http://www.php.net/manual/en/yaf-dispatcher.catchexception.php
 * @author carlziess
 */
class ErrorController extends Controller 
{
    /**
     * Yaf在router dispatch后非fatal类错误都可以被errorAction捕获
     * @param exception object 异常对象
     * @return json
     */
    public function errorAction($exception) 
    {
        Yaf\Dispatcher::getInstance()->disableView();
        $code = $exception->getCode();
        $message = $exception->getMessage();
        if (false == DEBUG) {
            $message = false;
        }
		switch ($code) 
        {                                         
        case YAF\ERR\NOTFOUND\MODULE:                                            
        case YAF\ERR\NOTFOUND\CONTROLLER:                                        
        case YAF\ERR\NOTFOUND\ACTION:                                            
        case YAF\ERR\NOTFOUND\VIEW:                                              
            $code = 404;
            $message   = $message ? : '404 Not Found'; 
            break; 
        case 404:                                                              
            $message   = $message ? : '404 Not Found'; 
            break;                                              
        case 401:                                               
            $message   = $message ? : '401 Unauthorized';                                       
            break;                                              
        case 403:   
            $message   = $message ? : '403 Forbidden';                                          
            break;                                                  
        case 500:   
            $message   = $message ? : 'HTTP/1.1 500 Internal Server Error';                            
            break;                                                  
        default :                                                   
            $message   = $message ? : 'HTTP/1.1 500 Internal Server Error';
            break;                                                                   
        }
        Response::getInstance()->send(['code'=>$code, 'data'=>'', 'message'=>$message]);
	}

}
