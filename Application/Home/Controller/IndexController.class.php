<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class IndexController extends Controller {
    public function index(){
    	// $this->show();  		
		$this->show();
    }
    public function logined(){
    	$this->display();
    }
    public function logining(){
    	$user["username"] = I("username");
    	$user["password"] = I("password");
    	if(I("remember")){
	   		$user["remember"] = I("remember");
    	}
   		else{
	   		$user["remember"] = I("remember");
   		}
		$model = D("User");    
   		$result = $model->where("_id"=="q")->select();
   		if($result)
   		$this->ajaxReturn(array($result),'json');//账号已经存在
   		else
   		$this->ajaxReturn(array($result),'json');//账号不存在

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