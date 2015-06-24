 /*
 <div class="form-inline ones_info" >
          <input  class="form-control" class="id_card" placeholder="会员卡号">
          <input  class="form-control" clas="name" placeholder="姓名">
          <input  class="form-control" class="phone_number" placeholder="手机号码">
          <input  class="form-control" class="lastconsume_time" placeholder="最后一次消费时间">
          <input  class="form-control" class="balance" placeholder="余额">
          </div>
          <button type="submit" class="btn btn-default" >消费</button>
          <button type="submit" class="btn btn-default">修改</button>
          <button type="submit" class="btn btn-default">删除</button>
*/
var debug=true;
$("#consume").click(function(){
	condisions = $("#condisions").val();
	if(!condisions || condisions=="undefined"){
		$("#alert_info").text("输入不能为空");
		return 0;
	}
	bnt =$(this);
	bnt.text("查找中...");
	bnt.prop("disabled",true);
	$.ajax({
		url:find,
		type:"post",
		data:'condisions='+condisions,
		success:function(data){
			if(data.status==1){
				$("#hid").text("");
				bnt.text("查找");
				bnt.prop("disabled",false);
				$("#alert_info").text("");
				var i;
				var cpdata=data;
				for(var p in cpdata.users ){
					i=p;
					break;
				}
				for(;data.users[i];i++){
					$("#hid").append(
       			 		"<div class='underlines'></div>	"+
       			 		"  <div class='form-inline ones_info' > "+
				        "  <input  class='form-control' class='id_card' placeholder='会员卡号' value='"+data.users[i]._id+"' >"+
				        "  <input  class='form-control' clas='name' placeholder='姓名' value='"+data.users[i].vip_name+"' >"+
				        "  <input  class='form-control' class='phone_number' placeholder='手机号码' value='"+data.users[i].vip_phone+"' >"+
				        "  <input  class='form-control' class='lastconsume_time' placeholder='最后一次消费时间' value='"+data.users[i].last_consume+"' >"+
				        "  <input  class='form-control' class='balance' placeholder='余额' value='"+data.users[i].vip_balance+"' >"+
				        "  </div>"+
				        "  <button type='submit' class='btn btn-default' >消费</button>"+
				        "  <button type='submit' class='btn btn-default'>修改</button>"+
				        "  <button type='submit' class='btn btn-default'>删除</button>"
       			 		);
				}
       			 	
			 }
		},
		error:function(){
			bnt.text("查找");
			bnt.prop("disabled",false);
			if(debug)
			alert("请不要频繁点击");
		}
	});
});

$("#add").click(function(){
	name = $("#name").val();
	phone_number = $("#phone_number").val();
	balance = $("#balance").val();

	reg_name = /[\u4e00-\u9fa5]{2,16}|\w{2,32}/
	reg_phone = /\d{11}/;
	reg_balance = /\d{1,6}/;
	if(!name||name=='undefined'||!reg_name.test(name)){
		$("#alert_info").text("姓名格式不正确");
		return 0;
	}
	if(!phone_number||phone_number=='undefined'||!reg_phone.test(phone_number)){
		$("#alert_info").text("电话格式不正确");
		return 0;
	}
	if(!balance||balance=='undefined'||!reg_balance.test(balance)){
		$("#alert_info").text("金额格式不正确");
		return 0;
	}
	bnt =$(this);
	bnt.text("增加中...");
	bnt.prop("disabled",true);
	$.ajax({
		url:add,
		type:"post",
		data:'name='+name+"&phone="+phone_number+"&balance="+balance,
		success:function(data){
			if(data.status==1){
				bnt.text("增加");
				bnt.prop("disabled",false);
				alert("增加成功,会员卡号为："+data._id);
			}
		},
		error:function(){
				bnt.text("增加");
				bnt.prop("disabled",false);
				if(debug)
				alert("请不要频繁点击");
		}
	});
});