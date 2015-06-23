<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class RegisterController extends Controller {
    public function index(){
          if($_SESSION['_id']){
          $this->display('Index/logined');      
          }else{
            $this->display();
          }  		
  	  }
  	  public function register(){
        	$user["username"] = I("username");
        	$user["password"] = md5(I("password"));
      		$model = D("User");
    		//查找此用户    
    	  	$result = $model->where(array(
    			"username"=>"$user[username]"
    			))->find();
       		if($result){
       		$this->ajaxReturn(array("status"=>"0"),'json');//账号已经存在,不能用此账号注册
       		}else{
       		$register = $model->add($user);
       		if($register){
       			$_SESSION['_id'] = $register;
    	   		$this->ajaxReturn(array("status"=>"1"),'json');//账号不存在,注册成功
       		}
    	   	else{
            $this->ajaxReturn(array("status"=>"-1"),'json');//数据插入失败,注册失败
            }
          }
    }
}
    