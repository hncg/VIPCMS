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
        if(!IS_AJAX || !I('session._id')) return 0;//不是ajax提交

        $condisions = I("condisions");
        $model = D("vips");
        $map['id_number']=(int)$condisions;
        $map['admin_id']=(int)I('session._id');
        $result = $model->where($map)->select();//卡号查询
         if($result){
             $this->ajaxReturn(array(
            'status'=>1,
            'users'=>$result,
            ),'json');
         }else{
            $map1['vip_phone|vip_name']=$condisions;
            $map1['admin_id']=(int)I('session._id');
            $result1 = $model->where($map1)->select();
            if($result1){
                   $this->ajaxReturn(array(
                    'status'=>1,
                    'users'=>$result1,
                    ),'json');
            }else{
                   $this->ajaxReturn(array(
                    'status'=>0,
                    // 'users'=>$result,
                    ),'json');
            }
         }
    }

    public function add(){
        
        $this->show();
    }
    public function do_add(){
        if(!IS_AJAX || !I('session._id')) return 0;//不是ajax提交
        $model = D("vips");
        $map_repeat['admin_id'] = (int)I('session._id');
        $map_repeat['vip_phone'] = I('post.phone');
        $exist = $model->where($map_repeat)->find();//是否存在这个手机号码
        if($exist){
            $this->ajaxReturn(array("status"=>2,//此手机号码已经存在,不能添加
                ));
            return 0;
        }
        $map['admin_id'] =(int)I('session._id'); 
        $id_number =$model->where($map)->order('_id desc')->getField('id_number'); 
        if(!$id_number){//还没有数据，id_number从管理员默认开始
            $model_user = D('user');
            $map_user['_id'] =(int)I('session._id');
            $id_number = $model_user->getField('default_id_number');
        }else{
        $id_number++;
        }
        $user["vip_name"] = I("post.name");//姓名
        $user["admin_id"] =(int)I('session._id');//管理员id
        $user["vip_phone"] = I("post.phone");//手机号码
        $user["vip_balance"] = (int)I("post.balance");//余额
        $user["last_consume"] = date("y-m-d H:i:s",time());//最后一次消费时间
        $user["id_number"] =$id_number; //会员卡号
        $result = $model->add($user);
        if($result){//增加成功
            $this->ajaxReturn(array("status"=>1,
                "id_number"=>$id_number
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
        if(!IS_AJAX || !I('session._id')) return 0;//不是ajax提交
        $modul_admin = D("user");
        $result_default = $modul_admin->where('_id='.I("session._id"))->getField("default");//默认消费
        $map['id_number'] =(int)I("post.user_id_number");
        $map['admin_id'] =(int)I("session._id");
        $model = D("vips");
        $last_consume = date("y-m-d H:i:s",time());
        $result = $model->where($map)->setDec("vip_balance",$result_default);
        $model->where($map)->setField("last_consume",$last_consume);
        $vip_balance = $model->where($map)->getField("vip_balance");
        if($result["ok"]){//更新成功
            $this->ajaxReturn(array("status"=>true,
                "balance"=>$vip_balance,
                "last_consume"=>$last_consume,
                ));
        }else{
            $this->ajaxReturn(array("status"=>false));
        }
    }
    public function update(){
        if(!IS_AJAX || !I('session._id')) return 0;//不是ajax提交
        $map['id_number'] = (int)I('post.user_id_number');//会员卡号
        $map['admin_id'] = (int)I('session._id');//管理员id号
        $vips['vip_name'] = I('post.user_name');//姓名
        $vips['vip_balance'] = (int)I('post.user_balance');//余额
        $vips['vip_phone'] = I('post.user_phone');//手机
        $vips['last_consume'] = date("y-m-d H:i:s",time());//最后一次消费时间
        $model = D("vips");
        //先判断电话号码别人是在使用
        $map_repeat['admin_id'] = (int)I('session._id');//管理员id
        $map_repeat['id_number'] = array('neq',(int)I('post.user_id_number'));//会员卡号
        $map_repeat['vip_phone'] = I('post.user_phone');//手机号码
        $exist = $model->where($map_repeat)->getField("id_number");
        if($exist){//此手机号码已经被使用
            $this->ajaxReturn(array("status"=>2));
            return 0;
        }
        $result = $model->where($map)->save($vips);
        if($result["ok"]){//更新成功
            $this->ajaxReturn(array("status"=>1,"user"=>$vips));
        }else{
            $this->ajaxReturn(array("status"=>0));
        }
        
    }
    public function del(){
        if(!IS_AJAX || !I('session._id')) return 0;//不是ajax提交
        
    }
}
