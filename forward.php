<?php 
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','forward');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php'; //转换成硬路径，速度更快
//判断是否登录了
if (!isset($_COOKIE['username'])) {
    _location(null,'login.php');
}
//将微博以及转发写入数据库
if ($_GET['action'] == 'post') {
    $_clean = array();
    $_clean['user'] = $_COOKIE['username'];
    $_clean['content'] = $_POST['content'];
    $_clean['fromuser'] = $_POST['touser'];
    $_clean['wid']=$_POST['wid'];
    $_clean = _mysql_string($_clean);
    $_queryContent="INSERT INTO forwards (fromuser,user,wid,content,date) VALUES ('{$_clean['fromuser']}','{$_clean['user']}','{$_clean['wid']}','{$_clean['content']}',NOW())";
    $_queryWeibo="INSERT INTO weibo (username,content,date) VALUES ('{$_clean['user']}','{$_clean['content']}',NOW())";
    //写入数据库
    _query(	$_queryContent);
    _query(	$_queryWeibo);
    if (_affected_rows() == 1) {
        _close();
        _session_destroy();
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="shortcut icon" href="sources/weibo.png" />
<title>我的首页</title>
<link rel="stylesheet" type="text/css" href="styles/forward.css" />
<script charset="UTF-8" type="text/javascript" src="scripts/jquery-1.11.1.min.js"></script>
<script charset="UTF-8" type="text/javascript" src="scripts/layer-v1.8.5/layer/layer.min.js"></script>
<script charset="UTF-8" type="application/javascript" src="scripts/forward.js"></script>
</head>
<body>
    <div id="weibo">
        <form method="post" name="post" action="?action=post">
            <input type="hidden" name="touser" value="<?php echo $_GET['username']?>" />
            <input type="hidden" name="wid" value="<?php echo $_GET['wid']?>" />
            <div id="wordCount" style="float:right;"></div>
            <textarea name="content" ><?php echo '//'.$_GET['content']?></textarea>
            <div><input id="submit" type="submit" value="发布" class="button" /></div>
            <div id="ubb" onclick="ubbclick();">
                <div style="cursor:pointer"><img src="emoj/smilea.gif" title="表情" style="width: 15px;height:15px;margin-right:3px;"/><span style="float: left;margin-top:4px;">表情</span></div>
                <img src="images/space.gif" />
    			<div id="checkbox" style="padding:5px;"><label style="margin:5px 0 0 5px;"><input name="forwardAtTime" type="checkbox" value="" />同时评论给<?php echo $_GET['username']?></label></div>             
    		</div>
            <?php include ROOT_PATH.'includes/emoj.inc.php'?>
	   </form>
    </div>

</body>
</html>