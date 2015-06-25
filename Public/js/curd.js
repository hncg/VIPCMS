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
       			 		"  <div class='form-inline ones_info "+i+"' > "+
				        "  <input  class='form-control id_card' placeholder='会员卡号' value='"+data.users[i]._id+"' disabled='true' >"+
				        "  <input  class='form-control name' placeholder='姓名' value='"+data.users[i].vip_name+"' >"+
				        "  <input  class='form-control phone_number' placeholder='手机号码' value='"+data.users[i].vip_phone+"' >"+
				        "  <input  class='form-control lastconsume_time' placeholder='最后一次消费时间' value='"+data.users[i].last_consume+"' >"+
				        "  <input  class='form-control balance' placeholder='余额' value='"+data.users[i].vip_balance+"' >"+
				        "  </div>"+
				        "  <button type='submit' class='btn btn-default consume' >消费</button>"+
				        "  <button type='submit' class='btn btn-default update'>修改</button>"+
				        "  <button type='submit' class='btn btn-default delete'>删除</button>"
       			 		);
				}
				$(".consume").click(function(){
					btn = $(this);//得到上面的input输入框
					var_input =btn.prevAll(".ones_info").children("input"); 
					user_id = var_input.eq(0).val();
					// user_name = var_input.eq(1).val();
					// user_phone = var_input.eq(2).val();
					// user_last_consume = var_input.eq(3).val();
					user_balance = var_input.eq(4).val();
					// console.log(user_id+"--"+user_name+"--"+user_phone+"--"+user_last_consume+"--"+user_balance);
					if(!user_balance || user_balance=='undefined'){//不能为空
						alert("余额不能为空");
						return 0;
					}
					btn.text("消费中...");
					btn.prop("disabled",true);
					$.ajax({
						url:consume,
						type:"post",
						data:'user_balance='+user_balance+"&user_id="+user_id,
						success:function(data){
							if(data.status){
								btn.text("消费");
								btn.prop("disabled",false);
								alert("消费成功!");
							}else{
								btn.text("消费");
								btn.prop("disabled",false);
								alert("消费失败!");
							}
						},
						error:function(){
							if(debug)
								alert("请不要频繁点击");
						}
					});
					
				});
       			 	
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
