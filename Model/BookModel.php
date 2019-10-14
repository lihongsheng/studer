<?php
namespace Model;
use Lib\MysqliDrive;
use Lib\Config;

class BookModel
{

    protected $table = 'library_book';

    protected $field = [
        'id',
	'publisher_name',
	'author_name',
	'book_type',
	'book_name',
	'book_status',
	'published_time',
    ];

    public function search($bookName, $page, $limit)
    {

        if ($page && $limit) {
            $skip  = ($page - 1) * $limit;
        }

        $count = '';
        if ($bookName) {
            $sql = "SELECT * FROM `{$this->table}` WHERE `book_name` = '{$bookName}' LIMIT {$skip},{$limit};";
            $countSql = "SELECT count(*) as num FROM `{$this->table}` WHERE `book_name` = '{$bookName}';";
        } else {
            $sql = "SELECT * FROM `{$this->table}` LIMIT {$skip},{$limit};";
            $countSql = "SELECT count(*) as num FROM `{$this->table}`";
        }

        $count = (new MysqliDrive(Config::getDbConfig()))
            ->selectDb(Config::MASTER_DEFAULT_DB)
            ->select($countSql);
        if ($count) {
            $count = $count[0]['num'];
        } else {
            $count = 0;
        }

        $result  = (new MysqliDrive(Config::getDbConfig()))
            ->selectDb(Config::MASTER_DEFAULT_DB)
            ->select($sql);

        return [$count, $result];
    }


}