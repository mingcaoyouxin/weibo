<?php 
session_start();
//�����������������Ȩ����includes������ļ�
define('IN_TG',true);
//���������������ָ����ҳ������
define('SCRIPT','login');
//���빫���ļ�
require dirname(__FILE__).'/includes/common.inc.php';
//��¼״̬

//��ʼ�����¼״̬
if ($_GET['action'] == 'login') {
    //Ϊ�˷�ֹ����ע�ᣬ��վ����
    _check_code($_POST['code'],$_SESSION['code']);
    //������֤�ļ�
    include ROOT_PATH.'includes/login.func.php';
    //��������
    $_clean = array();
    $_clean['username'] = $_POST['username'];
    $_clean['password'] = _check_password($_POST['password'],6);
    $_clean['time'] = _check_time($_POST['time']);
    //�����ݿ�ȥ��֤
    if (!!$_rows = _fetch_array("SELECT username,uniqid FROM user WHERE username='{$_clean['username']}' AND passwords='{$_clean['password']}'  LIMIT 1")) {
        _close();
        _session_destroy();
        _setcookies($_rows['username'],$_rows['uniqid'],$_clean['time']);
        _location(null,'index.php');
    } else {
        _close();
        _session_destroy();
        _location('�û������벻��ȷ���߸��˻�δ�����','login.php');
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>��¼</title>
<link rel="shortcut icon" href="sources/weibo.png" />
<link rel="stylesheet" type="text/css" href="styles/basic.css" />
<link rel="stylesheet" type="text/css" href="styles/login.css" />
<script type="text/javascript" src="scripts/code.js"></script>
<script type="text/javascript" src="scripts/login.js"></script>
</head>
<body>
<div id="login">
	<h2>��¼</h2>
	<form method="post" name="login" action="login.php?action=login">
		<dl>
			<dt></dt>
			<dd>�� �� ����<input type="text" name="username" class="text" /></dd>
			<dd>�ܡ����룺<input type="password" name="password" class="text" /></dd>
			<dd>����������<input type="radio" name="time" value="0" checked="checked" /> ������ <input type="radio" name="time" value="1" /> һ�� <input type="radio" name="time" value="2" /> һ�� <input type="radio" name="time" value="3" /> һ��</dd>
			<dd>�� ֤ �룺<input type="text" name="code" class="text code"  /> <img src="code.php" id="code" /></dd>
			<dd><input type="submit" value="��¼" class="button" /> <input type="button" value="ע��" id="location" class="button location" onclick="javascrtpt:window.location.href='register.php'"/></dd>
		</dl>
	</form>
</div>
</body>
</html>

