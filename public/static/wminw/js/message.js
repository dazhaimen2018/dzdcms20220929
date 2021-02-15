$("#submit").click(function(){
	var checkemail = /^[0-9a-zA-Z_.-]+[@][0-9a-zA-Z_.-]+([.][a-zA-Z]+){1,2}$/;
	var checkmobile = /^1([35678]\d|4[57])\d{8}$/;
	var name 	=$("#name").val();
	var phone	=$("#phone").val();
	var email	=$("#email").val();
	var content =$("#content").val();
	if(name==""){
		layer.msg("请输入姓名!",{icon: 5});
		return false;
	}
	if(phone==""){
		layer.msg("请输入手机号!",{icon: 5});
		return false;
	}
	if(!checkmobile.test(phone)){
		layer.msg('手机号格式不正确',{icon: 2});
		return false;
	}
	if(email==""){
		layer.msg("请输入邮箱号!",{icon: 5});
		return false;
	}
	if(!checkemail.test(email)){
		layer.msg("邮箱格式不正确",{icon: 2});
		return false;
	}
	if(content==""){
		layer.msg("请输入留言内容!",{icon: 5});
		return false;
	}

	$.ajax({
		url: '/formguide/index/post.html?id=6',
		type: 'POST',
		data: {name:name,phone:phone,email:email,content:content},
		dataType: 'json',
		success: function (data) {
			if(data.code==1){
				layer.msg(data.msg,{icon: 1});
				$("#name").val("");
				$("#phone").val("");
				$("#email").val("");
				$("#content").val("");
				return false;
			}else{
				layer.msg(data.msg,{icon: 2});
				return false;
			}
		}
	});

})