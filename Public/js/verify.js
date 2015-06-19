function isUsername(username){
	if(!username){
		$(".form-signin .alert-danger").text("账号不能为空");
		$(".form-signin .alert-danger").show(1000);
		return 0;
	}
	var reg = /\w+|[\u4e00-\u9fa5]+/;
	var reg_en = /\w{6,32}/;
	var reg_CH = /[\u4e00-\u9fa5]{2,16}/;
	if(reg_en.test(username)){//英文账号符合格式
		return 1;
	}else{
		$(".form-signin .alert-danger").text("英文账号长度只能在6-32之间"); 
		$(".form-signin .alert-danger").show(1000);
	}
}
function isPassword(password){
	var reg_en = /\w{6,32}/;
	if(!username){
		$(".form-signin .alert-danger").text("密码不能为空");
		$(".form-signin .alert-danger").show(1000);
		return 0;
	}
	if(!reg_en.test(username)){
		$(".form-signin .alert-danger").text("密码必须在6-32个数量之间的字母或数字或下划线");
		$(".form-signin .alert-danger").show(1000);
		return 0;
	}else{
		return 1;
	}
}

