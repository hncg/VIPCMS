<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class IndexController extends Controller {
    public function index(){
    	// $this->show();  		
    		$this->display();
    }
    public function logined(){
    	$this->display();
    }
    public function about(){
    	$this->display();
    }
    public function connect(){
    	$this->display();
    }
    public function feedback(){
    	$this->display();
    }
    public function upgrade(){
    	$this->display();
    }
    public function using(){
    	$this->display();
    }
}