<?php
namespace Model;

use Lib\Config;
use Lib\MysqliDrive;

class UserModel
{
    protected $tableName = 'library_user';
    /**
     * @param $userName
     * @param $password
     * @return |null
     * @throws \Exception
     */
    public function find($userName, $password)
    {
        $sql = "SELECT * FROM `library_user` WHERE `username`='{$userName}' and `password`='{$password}' LIMIT 1; ";
       $data = (new MysqliDrive(Config::getDbConfig()))
           ->selectDb(Config::MASTER_DEFAULT_DB)
            ->select($sql);
       if (empty($data)) {
           return null;
       } else {
           return $data[0];
       }
    }


    /**
     * @param $fieldValue
     * @return bool|\mysqli_result|null
     * @throws \Exception
     */
    public function add($fieldValue)
    {
        $sql = "INSERT INTO `library_user`";
        $keys = '';
        $val = '';
        if (empty($fieldValue)) {
            return null;
        }
        foreach ($fieldValue as $field => $value) {
            $keys .= "`{$field}`,";
            $val .= "'{$value}',";
        }
        $keys = rtrim($keys,',');
        $val  = rtrim($val,',');
        $sql .= "({$keys}) VALUES ({$val});";

        $dbs = Config::MASTER_SALVE;
        $model = new MysqliDrive(Config::getDbConfig());
        $result = false;
        foreach ($dbs as $dbName) {
            $result = $model->selectDb($dbName)
                ->insert($sql);
        }

        return $result;

    }
}