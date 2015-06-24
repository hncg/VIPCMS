var debug=true;
$("#login").click(function(){
	username = $("#username").val();
	password = $("#password").val();
	remember = $("#remember").prop("checked");
	if(!isUsername(username)){//账号式不对 
		$(".form-signin .alert-danger").text("账号格式不对");
		$(".form-signin .alert-danger").show(1000);
		return 0;
	}
	if(!isPassword(password)){//密码格式不对
		$(".form-signin .alert-danger").text("密码格式不对");
		$(".form-signin .alert-danger").show(1000);
		return 0;
	}
	bnt = $(this);
	bnt.text("登录中...");
	bnt.prop("disabled",true);
	$.ajax({
		url:logining,
		type:"post",
		data:'username='+username+'&password='+password+'&remember='+remember,
		success:function(data,textStatus){
			if(data.status==1){
				bnt.text("登录");
				bnt.prop("disabled",false);
				location.reload(true);
			}
			if(data.status==0){
				$(".form-signin .alert-danger").text("账号或密码错误."); 
				$(".form-signin .alert-danger").show(1000);
				bnt.text("登录");
				bnt.prop("disabled",false);
			}
		},
		error:function(){
			if(debug)
			alert("请不要频繁点击");
		}
	});

});