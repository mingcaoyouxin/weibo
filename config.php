<?php 
//�ж��Ƿ��¼��
if (!isset($_COOKIE['username'])) {

    _location(null,'login.php');
}
//�ж��Ƿ��ύ��
if ($_GET['action'] == 'config') {
    //����һ�������飬��������ύ�����ĺϷ�����
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
<title>��������</title>
<link rel="shortcut icon" href="sources/weibo.png" />
<link rel="stylesheet" type="text/css" href="styles/basic.css" />
<link rel="stylesheet" type="text/css" href="styles/config.css" />
</head>
<body>
    <div id="searchtbar">
     <ul>
    	<li><a href="index.php"><img src="sources/home.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>��ҳ</a></li>
    	<li><a href="member.php"><img src="sources/user.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>�����</a></li>
    	<li><a href="received.php"><img src="sources/message.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>��Ϣ</a></li>
    	<li id="line">|</li>    
    	<li id="tool"><a href="config.php"><img src="sources/tool.png" width="20px" height="20px" style="padding-right:5px;;vertical-align: top;"/></a></li>
    	<?php 
			if (isset($_COOKIE['username'])){
				echo '<li><a href="logout.php"><img src="sources/logout.png" width="20px" height="20px" style="padding-right:5px;vertical-align:top;"/>�˳�</a></li>';
			}
		?>
        </ul>
    </div>
    <div id="configitem">
    	  <ul>
    		<li id="infolis" style="background-color: #ffffff"><a href="config.php" ><img src="sources/userconfig.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>��������</a></li>
    		<li id="headli"><a href="headupload.php" ><img src="sources/upload.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>�ϴ�ͷ��</a></li>
    	</ul>
    </div>
    <div id="lists">
    	<form method="post"  action="config.php?action=config">
		<dl>
			<dd>�� ½ ����<input type="text" name="username" class="text" />(*)</dd>
			<dd>�� �� �룺<input type="password" name="password" class="text" />(*)</dd>
			<dd>ȷ�����룺<input type="password" name="notpassword" class="text" />(*)</dd>
			<dd>�ԡ�����<input type="radio" name="sex" value="��" checked="checked" />�� <input type="radio" name="sex" value="Ů" />Ů</dd>
			<dd>�� �� �ţ�<input type="text" name="telephone" class="text" /></dd>
			<dd>�򡡡��飺<input type="text" name="informaiton" class="text" /></dd>
			<dd><input type="submit" class="submit" value="����" /><input type="submit" class="submit" value="ȡ��" /></dd>
		</dl>
	</form>
    </div>
    
    



</body>
</html>
