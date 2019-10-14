<?php

namespace Lib;

/**
 * Mysqli drvice
 */
class MysqliDrive
{
    protected $connect;
    protected $config;

    public function __construct($config = '')
    {
        $this->config = $config;
        if (!function_exists('mysqli_connect')) {
            throw new \Exception(' NOT SUPPERT mysqli');
        }
        $this->connect();
    }

    /**
     * 连接数据库方法
     * @access public
     * @throws ThinkExecption
     */
    public function connect()
    {
        $config        = $this->config;
        $this->connect = mysqli_connect($config['host'],
            $config['user'],
            $config['password'],
            $config['dbName'],
            $config['port'] ? intval($config['port']) : 3306
        );
        mysqli_query($this->connect, "SET NAMES '" . $config['charset'] . "'");
    }


    public function selectDb($dbName = '')
    {
        mysqli_select_db($this->connect,$dbName);
        return $this;
    }


    public function isConnect()
    {
        return mysqli_ping($this->connect);
    }


    public function insert($sql)
    {
        $result = mysqli_query($this->connect, $sql);

        if (!$result) {
            throw new \Exception("exec sql: 【" . $sql . "】 fail");
        }
        return $result;
    }


    public function select($sql)
    {
        if (!$this->isConnect()) {
            $this->connect();
        }

        $result = mysqli_query($this->connect, $sql);
        $data   = $result->fetch_all(MYSQLI_ASSOC);
        //$result->free_result();
        $result->close();
        return $data;
    }

    public function update($sql)
    {
        $result = mysqli_query($this->connect, $sql);
        if (!$result) {
            throw new \Exception("exec sql: 【" . $sql . "】 fail");
        }

        return $result;
    }


    public function delete($sql)
    {
        $result = mysqli_query($this->connect, $sql);
        if (!$result) {
            throw new \Exception("exec sql: 【" . $sql . "】 fail");
        }
        return $result;
    }
}
