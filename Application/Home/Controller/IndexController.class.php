<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class IndexController extends Controller {
    public function index(){
    	// $this->show(); 
		if($_SESSION['_id']){
    	$this->display('logined');  		
    	}else{
    		$this->display();
    	}	
    }
    public function logined(){
    	$this->display();
    }
    public function logining(){
    	$user["username"] = I("username");
    	$user["password"] = I("password");
    	$remember  = I("remember");//是否记住登录
    	$model = D("User");
    	$result = $model->where(array(
			"username"=>"$user[username]",
			"password"=>"$user[password]"
			))->find();
    	if($result){
    		//账号密码验证完成,登陆成功
   			if($remember)
   			setcookie("_id",md5($result["_id"]),time()+3600*24*30,'/');
   			$_SESSION["_id"] = $result["_id"];
	   		$this->ajaxReturn(array("status"=>"1"),'json');
   		}else{//账号或者密码错误
	   		$this->ajaxReturn(array("status"=>"0"),'json');
   		}
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
    public function show(){
    	$this->display();
    }
    public function add(){
    	$this->display();
    }
    public function sign_out(){
    	
    }
}