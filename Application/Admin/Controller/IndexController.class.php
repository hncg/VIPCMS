<?php
namespace Admin\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");

class IndexController extends Controller {
    public function index(){
    	echo "后台";
    }
}