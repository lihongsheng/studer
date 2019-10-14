<?php
//Please enter the project name for APP_NAME.
define("APP_NAME", "3");
//project root path
define('ROOT_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
define('APP_PATH', ROOT_PATH . 'Application' . DIRECTORY_SEPARATOR);
define("Application", 'Application');
define("ControllerDirectoryName", 'Controller');
define("ViewDirectoryName", 'view');
//Please do not modify the following code for this comment.
require ROOT_PATH . "Lib/Bootstart.php";
session_start();
(new Bootstrap())->init()->run();