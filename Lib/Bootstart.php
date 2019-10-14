<?php

class Bootstrap
{

    protected  static $ClassMap= [];

    public function init()
    {
        //捕获异常注册
        set_exception_handler('bootstrap::Exception');
        // 注册AUTOLOAD方法
        spl_autoload_register('bootstrap::autoloadFile');

        return $this;
    }

    /**
     * Autoload constructor.
     * @param string $class
     * @throws Exception
     */
    public static function autoloadFile($class)
    {
        if (!isset(self::$ClassMap[$class])) {
            if ( false !== stripos($class, '\\')) {
                $name = str_replace('\\', '/', $class);
                if (file_exists(ROOT_PATH . '/' . $name . '.php')) {
                    self::$ClassMap[$class] = ROOT_PATH . '/' . $name . '.php';
                    require_once self::$ClassMap[$class];
                } else {
                    throw new Exception("NOT FIND " . $name . '.php');
                }
            } else {
                self::$ClassMap[$class] = ROOT_PATH . '/' . $class . '.php';
                require_once self::$ClassMap[$class];
            }
        }
    }


    /**
     * 自定义异常处理
     * @access public
     * @param mixed $e 异常对象
     */
    public static function Exception($e) {
        $error = array();
        $error['message']   =   $e->getMessage();
        $trace              =   $e->getTrace();
        if('E'==$trace[0]['function']) {
            $error['file']  =   $trace[0]['file'];
            $error['line']  =   $trace[0]['line'];
        }else{
            $error['file']  =   $e->getFile();
            $error['line']  =   $e->getLine();
        }
        $error['trace']     =   $e->getTraceAsString();
        if(Lib\Tools::isCli()){
            foreach($error as $k=>$v){
                echo $k."::   ".$v.PHP_EOL;
            }
        } else {
            header('HTTP/1.1 404 Not Found');
            header('Status:404 Not Found');
            foreach($error as $k=>$v){
                echo $k."::........".$v.'<br/>';
            }
        }
    }

    public function run()
    {
        $router = new Lib\Router();
        $router->dispatcher();
        $class = Application.'\\'.'Controller\\'.$router->getModule().'\\'.$router->getMethod();
        $action = $router->getAction();
        $model = new $class('',$router);

        if(!method_exists($model,$action)) {
            throw new \Exception("NOT FIND action IN ".$router->getMethod());
        }
        $model->$action();

    }
}