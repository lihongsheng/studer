<?php
/**
 * Router.php
 * 路由控制器
 * 只支持PATH_INFO和CLI模式下
 * 作者: 李红生 (549940183@qq.com)
 * 创建日期: 17/2/12 下午4:32
 * 修改记录:
 *
 * $Id$
 */
namespace Lib;

class Router
{

    protected  $module;
    protected  $method;
    protected  $action;
    private    $pathInfo;
    protected  $params = [];
    private $returnArray = [
        'classPath' => '',
        'action'=>'',
    ];


    public function dispatcher(){
        $isCli = Tools::isCli();
        if($isCli) {
            $this->pathInfo = isset($_SERVER['argv'][1]) ? $_SERVER['argv'][1] : (isset($argv[1]) ? $argv['1'] : '');
        } else {
            $pathInfo = isset($_SERVER['REQUEST_URI']) && !empty($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : $_SERVER['PATH_INFO'];
            if (strpos($pathInfo,'?') !== false) {
                $pathInfo = substr($pathInfo,0, strpos($pathInfo,"?"));
            }
            //获取PATH_INFO
            $this->pathInfo = str_replace(array('//', '../','./'), '/', trim($pathInfo, '/'));
        }

        $this->formatUri();
        $this->setParams();

        return $this->returnArray;
    }



    protected function setParams()
    {
        if($this->pathInfo == ''){
            $this->setDefaultPath();
        } else {
            $uri = explode('/',trim($this->pathInfo,'/'));
            $this->module = ucfirst(strtolower($uri[0]));
            $this->method = ucfirst(strtolower($uri[1]));
            $this->action = strtolower($uri[2]);
            $len = count($uri);
            if($len > 3) {
                for($i = 3;$i<$len;$i++){
                    $this->params[$uri[$i]] = $uri[$i+1];
                }
            }
        }

        $this->returnArray['classPath'] = APP_PATH.ControllerDirectoryName.'/'.$this->module.'/'.$this->method.'.php';
        $this->returnArray['action'] = $this->action."Action";
        if(!file_exists($this->returnArray['classPath'])){
           throw new \Exception(" file not find ".$this->returnArray['classPath']);
        }
    }



    public function getParams()
    {
        return $this->params;
    }

    private function formatUri()
    {
        $this->pathInfo = Tools::removeInvisibleCharacters($this->pathInfo,false);
        //echo $this->pathInfo.PHP_EOL;
        $slen = strlen(Config::$router['urlSuffix']);

        if (substr($this->pathInfo, -$slen) === Config::$router['urlSuffix'])
        {
            $this->pathInfo = substr($this->pathInfo, 0, -$slen);
        }
        //exit($this->pathInfo);

    }




    private function setDefaultPath()
    {
        $this->module = ucfirst(strtolower(Config::$router['defaultModule']));
        $this->method = ucfirst(strtolower(Config::$router['defaultMethod']));
        $this->action = strtolower(Config::$router['defaultAction']);


    }

    public function getModule()
    {
        return $this->module;
    }


    public function getMethod()
    {
        return $this->method;
    }

    public function getAction()
    {
        return $this->action;
    }
}