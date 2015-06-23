var debug=true;
$("#register").click(function(){
	username = $("#username").val();
	password = $("#password").val();
	remember = $("#remember").prop("checked");
	// if(!isUsername(username))//账号或者密码格式不对
	bnt = $(this);
	bnt.text("注册中...");
	bnt.prop("disabled",true);
	$.ajax({
		url:logining,
		type:"post",
		data:'username='+username+'&password='+password+'&remember='+remember,
		success:function(data,textStatus){
			bnt.text("注册");
			bnt.prop("disabled",false);
			if(data.status==0){
				$(".form-signin .alert-danger").text("此账号已经存在"); 
				$(".form-signin .alert-danger").show(1000);
			}
			if(data.status==-1){
				$(".form-signin .alert-danger").text("服务器繁忙，请重试."); 
				$(".form-signin .alert-danger").show(1000);
			}
			if(data.status==1){
				location.reload(true);
			}
		},
		error:function(){
			alert("请不要频繁点击");
		}
	});

});