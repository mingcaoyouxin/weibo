/**
 * 
 */
//等在网页加载完毕再执行
window.onload = function () {
	code();
	var faceimg = document.getElementById('faceimg');
	faceimg.onclick = function () {
		window.open('face.php','face','width=400,height=400,top=0,left=0,scrollbars=1');
	}
	
	//表单验证
	var fm = document.getElementsByTagName('form')[0];
	fm.onsubmit = function () {
		//能用客户端验证的，尽量用客户端
		//JS对于PHP课程来说，选学，并不强制掌握
		//用户名验证
		if (fm.username.value.length < 2 || fm.username.value.length > 20) {
			alert('用户名不得小于2位或者大于20位');
			fm.username.value = ''; //清空
			fm.username.focus(); //将焦点以至表单字段
			return false;
		}
		if (/[<>\'\"\ \　]/.test(fm.username.value)) {
			alert('用户名不得包含非法字符');
			fm.username.value = ''; //清空
			fm.username.focus(); //将焦点以至表单字段
			return false;
		}
		
		//密码验证
		if (fm.password.value.length < 6) {
			alert('密码不得小于6位');
			fm.password.value = ''; //清空
			fm.password.focus(); //将焦点以至表单字段
			return false;
		}
		if (fm.password.value != fm.notpassword.value) {
			alert('密码和密码确认必须一致');
			fm.notpassword.value = ''; //清空
			fm.notpassword.focus(); //将焦点以至表单字段
			return false;
		}

	/*	//网址
		if (fm.url.value != '') {
			if (!/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(fm.url.value)) {
				alert('网址不合法');
				fm.url.value = ''; //清空
				fm.url.focus(); //将焦点以至表单字段
				return false;
			}
		}
		*/
		//验证码验证
		if (fm.code.value.length != 4) {
			alert('验证码必须是4位');
			fm.code.value = ''; //清空
			fm.code.focus(); //将焦点以至表单字段
			return false;
		}
		
		
		return true;
	};
};









