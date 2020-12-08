<?php
/*================================================================
 *  File Name：OpenApi.php
 *  Author：carlziess, chengmo9292@126.com
 *  Create Date：2016-09-10 17:17:07
 *  Description：
 ===============================================================*/
class OpenApiPlugin extends Yaf\Plugin_Abstract
{
    public $config;
    public $register;

    /**
     * @param object $request YafRequest Yaf请求对象
     * @param object $response YafResponse Yaf响应对象
     * 
     */
    public function routerStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response)
    {
        $this->config = Yaf\Registry::get('config');
        $this->register = Yaf\Loader::getInstance();
        if (isset($this->config->application->library) && !empty($this->config->application->library)) {
            $library = explode(',',$this->config->application->library);
            foreach($library as $key)
            {
                if (false == is_dir(APPLICATION_PATH . DIRECTORY_SEPARATOR.$key)) {
                    throw new Exception(APPLICATION_PATH . DIRECTORY_SEPARATOR.$key.'目录无效.', 400);
                }
                $this->loader($key, 'class');
            }
        }
    }

    public function routerShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response)
    {
        if (isset($this->config->application->tools) && !empty($this->config->application->tools)) {
            $tools = explode(',',$this->config->application->tools);
            foreach($tools as $key)
            {
                if (false == is_dir(APPLICATION_PATH . DIRECTORY_SEPARATOR.$key)) {
                    throw new Exception(APPLICATION_PATH . DIRECTORY_SEPARATOR.$key.'目录无效.', 400);
                }
                $this->loader($key, 'tools');
            }
        }
        $requestBody = $request->getPost();
        if (empty($requestBody['params']['company_id'])) {
            throw new Exception('非法请求', 400); 
        }

        //if (!self::_RequestIgnore($request->module, $request->controller, $request->action)) {
        //    //登录状态校验
        //    if (true === Authorize::guest()) {
        //        throw new Exception('未授权访问，请登录.', 403);
        //    }
        //}
    }

    public function dispatchLoopStartup(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) 
    {

    }

    public function preDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) 
    {
        
    }

    public function postDispatch(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) 
    {
       
    }

    public function dispatchLoopShutdown(Yaf\Request_Abstract $request, Yaf\Response_Abstract $response) 
    {
        
    }
    

    /**
     * 自动加载
     * @param string $directory 目录
     * @param string $type 加载类型
     * @return void
     */
    protected function loader($directory = '', $type = '')
    {
        if ('' == $directory || '' == $type) return false;
        $libraryPath = APPLICATION_PATH . DIRECTORY_SEPARATOR . $directory;
        $handler = opendir($libraryPath);
        $globalLibraryPath = $this->register->getLibraryPath(true); 
        $this->register->setLibraryPath($libraryPath, true);
        while(true == ($fileName = readdir($handler)))
        {
            if ($fileName != '.' && $fileName != '..' && count(scandir($libraryPath)) > 2) {
                if (is_dir($libraryPath . DIRECTORY_SEPARATOR . $fileName)) {
                    $this->loader($directory . DIRECTORY_SEPARATOR . $fileName, $type);
                } else {
                    if (true == is_file($libraryPath . DIRECTORY_SEPARATOR . $fileName)) {
                        $fileInfo = pathinfo($fileName);
                        if ('php' == $fileInfo['extension']) {
                            if ('class' == $type) {
                                $this->register->autoload($fileInfo['filename']);
                            }
                            if ('tools' == $type) {
                                $this->register->import($libraryPath . DIRECTORY_SEPARATOR . $fileName);
                            }
                        }                        
                    }
                }
            }
        }
        closedir($handler);
        //必须还原全局类库的路径
        $this->register->setLibraryPath($globalLibraryPath, true);
    }

}

?>
