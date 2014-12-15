<?php
    session_start();
    //定义个常量，用来授权调用includes里面的文件
    define('IN_TG',true);
    //定义个常量，用来指定本页的内容
    define('SCRIPT','register');
    //引入公共文件
    require dirname(__FILE__).'/includes/common.inc.php'; 
    //登录状态
    _login_state();
    //判断是否提交了
    if ($_GET['action'] == 'register') {
        //为了防止恶意注册，跨站攻击
        _check_code($_POST['code'],$_SESSION['code']);
        //引入验证文件
        include ROOT_PATH.'includes/register.func.php';
        //创建一个空数组，用来存放提交过来的合法数据
        $_clean = array();
        //可以通过唯一标识符来防止恶意注册，伪装表单跨站攻击等。
        //这个存放入数据库的唯一标识符还有第二个用处，就是登录cookies验证
        $_clean['uniqid'] = _check_uniqid($_POST['uniqid'],$_SESSION['uniqid']);
        //active也是一个唯一标识符，用来刚注册的用户进行激活处理，方可登录。
        $_clean['active'] = _sha1_uniqid();
        $_clean['username'] = _check_username($_POST['username'],2,20);
        $_clean['password'] = _check_password($_POST['password'],$_POST['notpassword'],6);
        $_clean['sex'] = _check_sex($_POST['sex']);
        $_clean['url'] = $_POST['url'];
        //在新增之前，要判断用户名是否重复
        _is_repeat(
        "SELECT username FROM user WHERE username='{$_clean['username']}' LIMIT 1",
        '对不起，此用户已被注册'
            );

        //新增用户  //在双引号里，直接放变量是可以的，比如$_username,但如果是数组，就必须加上{} ，比如 {$_clean['username']}
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
    	_location('注册成功！','login.php');
    } else {
         _close();
		_session_destroy();
        _location('很遗憾，注册失败！','register.php');
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
<title>注册</title>
</head>
<body>
<div id="register">
	<h2>微博注册</h2>
	<form method="post" name="register" action="register.php?action=register">
	    <input type="hidden" name="uniqid" value="<?php echo $_uniqid ?>" />
		<dl>
			<dd>用 户 名：<input type="text" name="username" class="text" /> (*必填，至少两位)</dd>
			<dd>密　　码：<input type="password" name="password" class="text" /> (*必填，至少六位)</dd>
			<dd>确认密码：<input type="password" name="notpassword" class="text" /> (*必填，至少六位)</dd>
			<dd>性　　别：<input type="radio" name="sex" value="男" checked="checked" />男 <input type="radio" name="sex" value="女" />女</dd>
			<dd>主页地址：<input type="text" name="url" class="text" value="http://" /></dd>
			<dd>验 证 码：<input type="text" name="code" class="text yzm"  /><img src="code.php" id="code" /> </dd>
			<dd><input type="submit" class="submit" value="注册" /><input type="button" value="登陆" id="location" class="button location" onclick="javascrtpt:window.location.href='login.php'"/></dd></dd>
		</dl>
	</form>
</div>


</body>
</html>
