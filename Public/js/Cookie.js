function getCk(objname){
	var ck=document.cookie.split(';');
	for(var i=0;i<ck.length;i++){
	  temp=ck[i].split("=");
	   // alert("Q"+temp[0]+"=="+temp[1]);
	  if(temp[0].substr(1)==objname) return unescape(temp[1]);//非第一个Ck前面有个空格
	  if(temp[0]==objname) return unescape(temp[1]);//第一个Ck前面无空格
	}
}
function setCk(name,value){
    var exp = new Date();
    exp.setTime(exp.getTime() +3600*24*30);//过期时间一个月
    document.cookie = name + "="+ escape (value) + ";expires=" + exp.toGMTString();
}
function delCk(name){
    var exp = new Date();
    exp.setTime(exp.getTime() -3600);
    if(getCk(name))
    document.cookie = name + "="+ getCk(name) + ";expires=" + exp.toGMTString();
}
function isUsername(username){
	reg = /[\u4e00-\u9fa5]{2,16}|\w{2,32}/;//任意英文字母数字和中文
	if(!reg.test(username) ||username=='undefined'){
		return false;//账号格式不对	
	}else{
		return true;
	}

}
function isPassword(password){
	reg = /\w{2,32}/;//任意英文
	if(!reg.test(password)){
		return false;	//密码格式不对
	}else{
		return true;
	}

}