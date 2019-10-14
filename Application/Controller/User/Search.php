<?php
namespace Application\Controller\User;

use Lib\Controller;
use Model\BookModel;

class Search extends Controller
{
    protected $limit = 50;

    public function index()
    {
        $this->assign('ttile','search');
        $this->display();
    }

    public function search()
    {
        $bookName = $_GET['search'];
        $page     = $_GET['page'] ?? 1;

        $model = new BookModel();
        list($count, $result) = $model->search($bookName, $page, $this->limit);

        $maxPage = ceil($count/$this->limit);
        $pageStr = "<a href='user/search/search?search={$bookName}&page=1'>pre</a>";
        if ($page <= 1) {
            $pageStr = "<a href='user/search/search?search={$bookName}&page=1'>pre</a>";
        } else {
            $pre = $page - 1;
            $pageStr = "<a href='user/search/search?search={$bookName}&page={$pre}'>pre</a>";
        }

        if ($page < $maxPage) {
            $next = $page + 1;
            $pageStr .= "<a href='user/search/search?search={$bookName}&page={$next}'>next</a>";
        }
        $this->assign('title','search');
        $this->assign('count',$count);
        $this->assign('result',$result);
        $this->assign('page',$pageStr);
        $this->display();
    }
}
