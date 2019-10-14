<?php
/**
 * Controller.php
 *
 * 作者: Bright (dannyzml@qq.com)
 * 创建日期: 17/2/15 下午11:42
 * 修改记录:
 *
 * $Id$
 */
namespace Lib;

abstract class Controller
{
    protected $module;
    protected $method;
    protected $action;
    protected $viewModel;
    protected $params = [];
    protected $_name;
    protected $assignList = [];
    protected $router;
    protected $htmlspecialchars = true;

    public function __construct($viewModel,Router $router){
        $this->module = $router->getModule();
        $this->method = $router->getMethod();
        $this->action = $router->getAction();
        $this->params = $router->getParams();
        $this->router = $router;
        $this->viewModel = $viewModel;
        $this->_name = get_class($this);
        $this->init();
    }


    protected function init()
    {
        //xss检测
         Xss::handle();
    }



    protected function assign($key, $val)
    {
        $this->assignList[$key] = $val;
    }

    protected final function display($viewPath = '')
    {
        $viewPath = $viewPath ? $viewPath : $this->action;
        $viewPath = APP_PATH.'/'.ControllerDirectoryName.'/'.$this->module.'/View/'.$this->method.'.'.$viewPath.'.phtml';
        if(!file_exists($viewPath)){
            throw new \Exception($this->action." VIEW is NO find");
        } else {
            if ($this->assignList) {
                extract($this->assignList, EXTR_OVERWRITE);
            }
            require_once $viewPath;
        }

    }

    protected final function redirect($path)
    {
        header("Location: {$path}");
    }
}