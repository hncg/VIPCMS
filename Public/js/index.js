$("#logining").click(function(){
	$.ajax({
		url:logining,
		type:"post",
		data:"username="+$("#username").val()+"&password="+$("#password").val()+"&remember="+$("#remember").prop("checked"),
		success:function(data,textStatus){
			alert(11);
		},
		error:function(){
			alert("请不要频繁点击");
		}
	});

});