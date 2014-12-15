<?php 
//判断是否登录了
if (!isset($_COOKIE['username'])) {

    _location(null,'login.php');
}
//判断是否提交了
if ($_GET['action'] == 'config') {
    //创建一个空数组，用来存放提交过来的合法数据
	$_clean = array();
	$_clean['username'] = $_POST['username'];
	$_clean['password'] = $_POST['password'];
	print_r($_clean);
	exit;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>个人设置</title>
<link rel="shortcut icon" href="sources/weibo.png" />
<link rel="stylesheet" type="text/css" href="styles/basic.css" />
<link rel="stylesheet" type="text/css" href="styles/config.css" />
</head>
<body>
    <div id="searchtbar">
     <ul>
    	<li><a href="index.php"><img src="sources/home.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>首页</a></li>
    	<li><a href="member.php"><img src="sources/user.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>霍玮光</a></li>
    	<li><a href="received.php"><img src="sources/message.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>消息</a></li>
    	<li id="line">|</li>    
    	<li id="tool"><a href="config.php"><img src="sources/tool.png" width="20px" height="20px" style="padding-right:5px;;vertical-align: top;"/></a></li>
    	<?php 
			if (isset($_COOKIE['username'])){
				echo '<li><a href="logout.php"><img src="sources/logout.png" width="20px" height="20px" style="padding-right:5px;vertical-align:top;"/>退出</a></li>';
			}
		?>
        </ul>
    </div>
    <div id="configitem">
    	  <ul>
    		<li id="infolis" style="background-color: #ffffff"><a href="config.php" ><img src="sources/userconfig.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>个人设置</a></li>
    		<li id="headli"><a href="headupload.php" ><img src="sources/upload.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>上传头像</a></li>
    	</ul>
    </div>
    <div id="lists">
    	<form method="post"  action="config.php?action=config">
		<dl>
			<dd>登 陆 名：<input type="text" name="username" class="text" />(*)</dd>
			<dd>密 　 码：<input type="password" name="password" class="text" />(*)</dd>
			<dd>确认密码：<input type="password" name="notpassword" class="text" />(*)</dd>
			<dd>性　　别：<input type="radio" name="sex" value="男" checked="checked" />男 <input type="radio" name="sex" value="女" />女</dd>
			<dd>手 机 号：<input type="text" name="telephone" class="text" /></dd>
			<dd>简　　介：<input type="text" name="informaiton" class="text" /></dd>
			<dd><input type="submit" class="submit" value="保存" /><input type="submit" class="submit" value="取消" /></dd>
		</dl>
	</form>
    </div>
    
    



</body>
</html>
