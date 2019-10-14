<?php

namespace Lib;

class Config
{
    //数据库名
    const MASTER_DEFAULT_DB = 'library1';
    const MASTER_SALVE      = [
        'library1',
        'library2',
        'library3'
    ];
    const DBConfig          = [
        self::MASTER_DEFAULT_DB => [
            'dbName'   => 'library1',
            'charset'  => 'utf-8',
            'host'     => '144.6.226.167',
            'port'     => 3306,
            'user'     => 'root',
            'password' => 'English#1'
        ]
    ];


    static $router = [
        'defaultModule' => 'Index',
        'defaultMethod' => 'Index',
        'defaultAction' => 'index',
        'ErrorModule'   => 'Error',
        'ErrorMethod'   => 'Index',
        'ErrorAction'   => 'index',
        'urlSuffix'     => '',
        'Modules'       => [
            'web',
            'Cli'
        ]

    ];


    public static function getDbConfig($nodeName = self::MASTER_DEFAULT_DB)
    {
        return self::DBConfig[$nodeName];
    }


    public static function getRouter()
    {
        return self::$router;
    }

}