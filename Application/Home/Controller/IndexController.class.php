<?php
namespace Home\Controller;
use Think\Controller;
header("Content-type:text/html;charset=utf-8");
class IndexController extends Controller {

    public function index(){
        if(I("cookie._id")){//记住密码，以后再添加账号密码验证
            session("_id",I("cookie._id"));
            $this->display('logined');          
            return 0;
        }        
		if(I("session._id")){
    	$this->display('logined');  		
    	}else{
    		$this->display();
    	}	
    }
    public function logined(){
    	if(I("session._id")||I("cookie._id")){//权限验证
            $this->display();
        }else{
            echo "Not Permission";
        }
    }
    public function login(){
        if(!IS_AJAX) return 0;//不是ajax提交
    	
        $user["username"] = I("username");
    	$user["password"] = I("password");
    	$remember  = I("remember");//是否记住登录
    	$model = D("User");
    	$result = $model->where(array(
			"username"=>"$user[username]",
			"password"=>MD5("$user[password]")
			))->find();
    	if($result){
    		//账号密码验证完成,登陆成功
   			if($remember)//是否记住密码
   			setcookie("_id",$result["_id"],time()+3600*24*30,'/');
   			$_SESSION["_id"] = $result["_id"];
	   		$this->ajaxReturn(array("status"=>"1"),'json');
   		}else{//账号或者密码错误
	   		$this->ajaxReturn(array("status"=>"0"),'json');
   		}
    }
 

    public function about(){
        echo "Coded By checgg";
    }
    public function connect(){
        echo "Email:574878649@qq.com";
    }
    public function feedback(){
        echo "出现任何问题，请将结果反馈至邮箱574878649@qq.com";
    }
    public function upgrade(){
        echo  "网站在不断升级";        
    }
    public function using(){
        echo "网站在测试使用中,使用者应当明白使用风险。";
    }
    public function show(){
    	$this->display();
    }
    public function find(){
        if(!IS_AJAX) return 0;//不是ajax提交

        $condisions = I("condisions");
        $model = D("vips");
        $map['vip_phone|vip_name|_id']=$condisions;
        $map1['_id']=(int)$condisions;
        $result = $model->where($map)->select();
        $result1 = $model->where($map1)->select();
        $result = $result?$result:$result1;
        $this->ajaxReturn(array(
            'status'=>1,
            'users'=>$result,
            ),'json');
    }

    public function add(){
        
        $this->show();
    }
    public function do_add(){
        if(!IS_AJAX) return 0;//不是ajax提交
        $model = D("vips");
        $user["vip_name"] = I("post.name");//姓名
        $user["admin_id"] = I('session._id');//管理员id
        $user["vip_phone"] = I("post.phone");//手机号码
        $user["vip_balance"] = (int)I("post.balance");//余额
        $user["last_consume"] = date("y-m-d H:i:s",time());//最后一次消费时间
        $result = $model->add($user);
        if($result){//增加成功
            $this->ajaxReturn(array("status"=>1,
                "_id"=>$result
                ));
        }else{//增加失败
            $this->ajaxReturn(array("status"=>0));
        }
    }
    public function sign_out(){
        setcookie("_id",'0',time()-3600,'/');
        unset($_SESSION['_id']);
        session_unset();
    	session_destroy();
        $this->redirect('index');
    }
    public function consume(){
        if(!IS_AJAX) return 0;//不是ajax提交
        $modul_admin = D("user");
        $modul_admin->where('_id='.I("session._id"))->getField("default");
        $balance = I("post.balance");
        $user_id = I("post.user_id");
        $model = D("vips");
        $result = $model->where('_id=1')->setInc("vip_balance",10);
        if($result){//更新成功
            $this->ajaxReturn(array("status"=>true));
        }else{
            $this->ajaxReturn(array("status"=>false));
        }
    }
    public function update(){
        if(!IS_AJAX) return 0;//不是ajax提交
        
    }
    public function del(){
        if(!IS_AJAX) return 0;//不是ajax提交
        
    }
}
