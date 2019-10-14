<?php
namespace Application\Controller\Index;

use Lib\Config;
use Lib\Controller;
use Lib\MysqliDrive;

class Index extends Controller
{

    public function index()
    {
        $this->assign('title','title');
        $this->display();
    }

    public function redirectTo()
    {

    }
}
