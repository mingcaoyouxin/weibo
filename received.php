<?php 
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','received');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否登录了
if (!isset($_COOKIE['username'])) {

	_location(null,'login.php');
}
//分页模块
global $_pagesize,$_pagenum;
$_sqlStr="SELECT  fromuser,content,date FROM message where message.touser='".$_COOKIE['username']."'";
_page($_sqlStr,6);   //第一个参数获取总条数，第二个参数，指定每页多少条
$_queryStr='SELECT A.username AS name, B.username AS fname FROM user AS A,user AS B,fans AS C where A.id=C.id and B.id=C.f_id and A.username="'.$_COOKIE['username'].'"';
$_result = _query($_queryStr);

$_myFansNum=mysql_affected_rows();
$_SESSION['myFansNum'] =$_myFansNum;

$_queryStr='SELECT A.username AS name, B.username AS fame FROM user AS A,user AS B, fans AS C where A.id=C.id and B.id=C.f_id and B.username="'.$_COOKIE['username'].'"';
$_result = _query($_queryStr);
$_myFollowsNum=mysql_affected_rows();
$_SESSION['myFollowsNum'] =$_myFollowsNum;
if (isset($_GET['fromuser'])) {
    $_fromuser=$_GET['fromuser'];
    $_touser=$_COOKIE['username'];
    $_insert="update  message set del='1' where fromuser='".$_fromuser."' and touser='".$_touser."' and date='".$_GET['date']."'" ;
    _query($_insert);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="shortcut icon" href="sources/weibo.png" />
<title>私信</title>
<link rel="stylesheet" type="text/css" href="styles/receive.css" />
<script type="text/javascript" src="scripts/fan.js"></script>
</head>
<body>
    <div id="searchtbar">
     <ul>
		<li><a href="index.php"><img src="sources/home.png" width="20px" height="20px" style="padding-right:5px"/>首页</a></li>
		<?php 
			if (isset($_COOKIE['username'])){
				echo '<li><a href="member.php"><img src="sources/user.png" width="20px" height="20px" style="padding-right:5px"/>'.$_COOKIE['username'].'</a></li>';
				echo "\n";
			} 
			
		?>
				<li><a href="received.php"><img src="sources/message.png" width="20px" height="20px" style="padding-right:5px"/>消息</a></li>
		<li id="line">|</li>    
    	<li id="tool"><a href="config.php"><img src="sources/tool.png" width="20px" height="20px" style="padding-right:5px;;vertical-align: top;"/></a></li>
    	<?php 
			if (isset($_COOKIE['username'])){
				echo '<li><a href="logout.php"><img src="sources/logout.png" width="20px" height="20px" style="padding-right:5px;vertical-align:top;"/>退出</a></li>';
			}
		?>
    	
    </ul>
    </div>
    <div id="message">
		<dl>
			<dt><a href="index.php" style="text-decoration: none;color:white;">首页</a></dt>
		</dl>
		<dl>
			<dt>消息</dt>
			<dd id="receivedd"><a href="received.php" style="background-color: #ccc">私信</a></dd>
			<dd><a href="###">@我的</a></dd>
		</dl>
	</div>
     <div id="fans">
        <img id="imgbg" src="sources/userback.jpg"  width="196px" height="120px" style="
            position: absolute;z-index: 0" />
        <div id="small" style="text-align:center;">
            <img id="imghead" src="sources/head.jpg" ></img>
            <ul>
    		<li><a href="follow.php">
    		<span style="padding:0 12px 0 5px">
    		<?php 
    		  echo $_SESSION['myFollowsNum'];
    		?>
    		</span>
    		关注
    		</a></li>
    		<li><a href="fan.php">
    		<span style="padding:0 12px 0 5px">
    		  <?php 
    		      echo $_SESSION['myFansNum'];
    		  ?>
    		</span>
    		粉丝
    		
    		</a></li>
    		<li><a href="fan.php">
    		<span style="padding:0 12px 0 5px">
    		  <?php 
    		      echo $_SESSION['myFansNum'];
    		  ?>
    		</span>
    		
    		微博
    		
    		</a></li>
    	</ul>            
       </div>
    </div>
    <div id="grayback">
        <p style="padding:4px;">私信</p>
    </div>
    <?php 
	       $_queryStr="SELECT  fromuser,content,date FROM message where message.touser='".$_COOKIE['username']."' and del=0 ORDER BY date desc LIMIT $_pagenum,$_pagesize";
	      //echo $_queryStr;
	       $_result = _query($_queryStr);
	       while (!!$_rows = _fetch_array_list($_result)) {
	           $_idStr="select id from user where username='".$_rows['fromuser']."'";
	           $_idResult = _query($_idStr);
	           $_rowid = _fetch_array_list($_idResult);
    ?>
	       
    <div id="receive">
        <div style="margin-top:15px;">
            <div id="time" class="time"><?php echo $_rows['date'] ?></div>
            <div><img id="head" src="sources/defaultpic.png"  alt="" /></div>
            <div id="username" class="username"><?php echo $_rows['fromuser'] ?></div>
            <div id="content" class="content"><?php echo $_rows['content'] ?></div>
            <div id="delete"><a name="delete"  href="received.php?fromuser=<?php echo $_rows['fromuser']?>&date=<?php echo $_rows['date'];?>" >删除</a></div>
            <div id="detail"><a name="secret"  href="###" title="<?php echo $_rowid['id']?>">查看</a></div>
        </div>
        
    </div>
    
  
     <?php 
	       }
		//_pageing函数调用分页，1|2，1表示数字分页，2表示文本分页
		_paging(2);
	?>
    
      <iframe id="secretFrame" name="secretFrame"   >
            
        </iframe>
    

</body>
</html>