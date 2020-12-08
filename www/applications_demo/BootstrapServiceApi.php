<?php
/**
 * @name Bootstrap
 * @author carlziess
 * @desc 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * @see http://www.php.net/manual/en/class.yaf-bootstrap-abstract.php
 * 这些方法, 都接受一个参数:Yaf\Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */
class Bootstrap extends Yaf\Bootstrap_Abstract
{
    protected $config;
    
    /**
    * Initialization Yaf
    * @param Yaf\Dispatcher $dispatcher
    */
    public function _initializers(Yaf\Dispatcher $dispatcher)
    {
        $this->config = Yaf\Application::app()->getConfig();
        Yaf\Registry::set('config',$this->config);
        null !== $this->config->routes && $dispatcher->getRouter()->addConfig($this->config->routes);
        $dispatcher->registerPlugin((new ServiceApiPlugin()));
        $driver = $this->config->get('auth.driver');
        Authorize::extend($driver,function()use($driver){return new $driver;});
        unset($this->config, $driver);
    }

}
