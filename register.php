<?php
    session_start();
    //�����������������Ȩ����includes������ļ�
    define('IN_TG',true);
    //���������������ָ����ҳ������
    define('SCRIPT','register');
    //���빫���ļ�
    require dirname(__FILE__).'/includes/common.inc.php'; 
    //��¼״̬
    _login_state();
    //�ж��Ƿ��ύ��
    if ($_GET['action'] == 'register') {
        //Ϊ�˷�ֹ����ע�ᣬ��վ����
        _check_code($_POST['code'],$_SESSION['code']);
        //������֤�ļ�
        include ROOT_PATH.'includes/register.func.php';
        //����һ�������飬��������ύ�����ĺϷ�����
        $_clean = array();
        //����ͨ��Ψһ��ʶ������ֹ����ע�ᣬαװ����վ�����ȡ�
        //�����������ݿ��Ψһ��ʶ�����еڶ����ô������ǵ�¼cookies��֤
        $_clean['uniqid'] = _check_uniqid($_POST['uniqid'],$_SESSION['uniqid']);
        //activeҲ��һ��Ψһ��ʶ����������ע����û����м�������ɵ�¼��
        $_clean['active'] = _sha1_uniqid();
        $_clean['username'] = _check_username($_POST['username'],2,20);
        $_clean['password'] = _check_password($_POST['password'],$_POST['notpassword'],6);
        $_clean['sex'] = _check_sex($_POST['sex']);
        $_clean['url'] = $_POST['url'];
        //������֮ǰ��Ҫ�ж��û����Ƿ��ظ�
        _is_repeat(
        "SELECT username FROM user WHERE username='{$_clean['username']}' LIMIT 1",
        '�Բ��𣬴��û��ѱ�ע��'
            );

        //�����û�  //��˫�����ֱ�ӷű����ǿ��Եģ�����$_username,����������飬�ͱ������{} ������ {$_clean['username']}
        _query(
        "INSERT INTO user (
        uniqid,
        active,
        username,
        passwords,
        sex,
        url,
        reg_time,
        last_time,
        last_ip
        )
        VALUES (
        '{$_clean['uniqid']}',
        '{$_clean['active']}',
        '{$_clean['username']}',
        '{$_clean['password']}',      
        '{$_clean['sex']}',
        '{$_clean['url']}',
            NOW(),
            NOW(),
            '{$_SERVER["REMOTE_ADDR"]}'
        )"
        ); 
	if (_affected_rows() == 1) {
    	_close();
    	_session_destroy();
    	_location('ע��ɹ���','login.php');
    } else {
         _close();
		_session_destroy();
        _location('���ź���ע��ʧ�ܣ�','register.php');
    }
    } else {
        $_SESSION['uniqid'] = $_uniqid = _sha1_uniqid();
    }
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="shortcut icon" href="sources/weibo.png" />
<link rel="stylesheet" type="text/css" href="styles/basic.css" />
<link rel="stylesheet" type="text/css" href="styles/register.css" />
<script type="text/javascript" src="scripts/code.js"></script>
<script type="text/javascript" src="scripts/register.js"></script>
<title>ע��</title>
</head>
<body>
<div id="register">
	<h2>΢��ע��</h2>
	<form method="post" name="register" action="register.php?action=register">
	    <input type="hidden" name="uniqid" value="<?php echo $_uniqid ?>" />
		<dl>
			<dd>�� �� ����<input type="text" name="username" class="text" /> (*���������λ)</dd>
			<dd>�ܡ����룺<input type="password" name="password" class="text" /> (*���������λ)</dd>
			<dd>ȷ�����룺<input type="password" name="notpassword" class="text" /> (*���������λ)</dd>
			<dd>�ԡ�����<input type="radio" name="sex" value="��" checked="checked" />�� <input type="radio" name="sex" value="Ů" />Ů</dd>
			<dd>��ҳ��ַ��<input type="text" name="url" class="text" value="http://" /></dd>
			<dd>�� ֤ �룺<input type="text" name="code" class="text yzm"  /><img src="code.php" id="code" /> </dd>
			<dd><input type="submit" class="submit" value="ע��" /><input type="button" value="��½" id="location" class="button location" onclick="javascrtpt:window.location.href='login.php'"/></dd></dd>
		</dl>
	</form>
</div>


</body>
</html>
