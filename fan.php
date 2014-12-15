<?php 
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','fan');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php';
//判断是否登录了
if (!isset($_COOKIE['username'])) {

    _location(null,'login.php');
}
/* //分页模块
if (isset($_GET['page'])) {
	$_page = $_GET['page'];
	if (empty($_page) || $_page < 0 || !is_numeric($_page)) {
		$_page = 1;
	} else {
		$_page = intval($_page);
	}
} else {
	$_page = 1;
}
$_pagesize = 7;
$_pagenum = ($_page - 1) * $_pagesize;
//首页要得到所有的数据总和
$_queryStr='SELECT A.username AS name, B.username AS fname ,B.sex AS sex FROM user AS A,user AS B,fans AS C where A.id=C.id and B.id=C.f_id and A.username="'.$_COOKIE['username'].'"';
$_result = _query($_queryStr);
$_num = mysql_num_rows($_result);
//获取总共的页数
$_pageabsolute = ceil($_num / $_pagesize); */
//分页模块
global $_pagesize,$_pagenum;
$_queryStr='SELECT A.username AS name, B.username AS fname ,B.sex AS sex FROM user AS A,user AS B,fans AS C where A.id=C.id and B.id=C.f_id and A.username="'.$_COOKIE['username'].'"';
_page($_queryStr,7);   //第一个参数获取总条数，第二个参数，指定每页多少条
$_test=1;
$_idStr="select id from user where username='".$_COOKIE['username']."'";
$_idResult = _query($_idStr);
$_rows = _fetch_array_list($_idResult);
$_fnameStr="select username from user where id='".$_GET['id']."'";
$_fnameResult = _query($_fnameStr);
$_fnamerows = _fetch_array_list($_fnameResult);
if (isset($_GET['id'])&&$_GET['type']==0) {
    $_fid=$_GET['id']; 
    $_id=$_rows['id'];
    $_name=$_COOKIE['username'];
    $_fname=$_fnamerows['username'];
    $_insert="insert into fans(id,f_id,name,fname) values($_fid,$_id,'$_fname','$_name')";
    //echo $_insert;
    _query($_insert);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>我的粉丝</title>
<link rel="shortcut icon" href="sources/weibo.png" />
<link rel="stylesheet" type="text/css" href="styles/basic.css" />
<link rel="stylesheet" type="text/css" href="styles/fan.css" />
<script type="text/javascript" src="scripts/fan.js"></script>
</head>
<body>
    <div id="searchtbar">
     <ul>
    	<li><a href="index.php"><img src="sources/home.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>首页</a></li>
    	<?php 
			if (isset($_COOKIE['username'])){
				echo '<li><a href="member.php"><img src="sources/user.png" width="20px" height="20px" style="padding-right:5px"/>'.$_COOKIE['username'].'</a></li>';
				echo "\n";
			} 
			
		?>
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
    <div id="friends">
    	  <ul>
    		<li id="follows" ><a href="follow.php" ><img src="sources/follow.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>关注</a></li>
    		<li id="fan" style="background-color: #ffffff"><a href="fan.php" ><img src="sources/fans.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>粉丝</a></li>
    	</ul>
    </div>
    <div id="lists" style="overflow:auto">
      <h2>粉丝列表</h2>
       <?php 
	       $_queryStr="SELECT A.username AS name, A.id AS id,B.username AS fname ,B.sex AS sex,B.id AS fid FROM user AS A,user AS B,fans AS C where A.id=C.id and B.id=C.f_id and A.username='".$_COOKIE['username']."' LIMIT $_pagenum,$_pagesize";
	      // echo $_queryStr;
	       $_result = _query($_queryStr);
	       while (!!$_rows = _fetch_array_list($_result)) {
	           $_queryFans='SELECT A.username AS name, B.username AS fname ,B.sex AS sex FROM user AS A,user AS B,fans AS C where A.id=C.id and B.id=C.f_id and A.username="'.$_rows['fname'].'"';
	           $_resultFans = _query($_queryFans);
	           $_FansNumber=mysql_affected_rows();
	           $_queryFollows='SELECT A.username AS name, B.username AS fame,A.sex as sex FROM user AS A,user AS B, fans AS C where A.id=C.id and B.id=C.f_id and B.username="'.$_rows['fname'].'"';
	           $_resultFollows = _query($_queryFollows);
	           $_FollowsNumber=mysql_affected_rows();
	           $_queryWeibos="select * from weibo where username='".$_rows['fname']."'";
	           $_resultWeibos = _query($_queryWeibos);
	           $_WeiboNumber=mysql_affected_rows();
	           
	           
	   ?>
	   <div class="fanlist">
    	  <div class="message"><a name="secret"  href="###" title="<?php echo $_rows['fid']?>">私信</a></div>
    	  <div class="addfollow"><a href="fan.php?id=<?php echo $_rows['fid']?>&type=<?php 
    	  $_tip="select * from fans where id=".$_rows['fid']." and f_id=".$_rows['id'];
    	  
    	  $_resultTip = _query($_tip);
    	  $_tipNum=mysql_affected_rows();
    	  if($_tipNum>=1)
    	      echo "1";
    	  else
    	      echo "0";
    	  ?>">
    	 <?php
    	   $_tip="select * from fans where id=".$_rows['fid']." and f_id=".$_rows['id'];
    	   $_resultTip = _query($_tip);
    	   $_tipNum=mysql_affected_rows();
    	   if($_tipNum>=1)
    	       echo "互相关注";
    	   else 
    	       echo "加关注";
    	 ?> 
    	 </a></div>
    	  <div><img id="head" src="sources/defaultpic.png"  alt="" /></div>
    	  <?php
    	   if ($_rows['sex']=="男"){
    	       $_imgSex="sources/males.png";
    	   }
    	   else{
    	       $_imgSex="sources/females.png";
    	   }
    	  ?>
    	  <div class="username" style="background:url(<?php echo $_imgSex?>) no-repeat 20%;">
    	   <?php 
    	       echo $_rows['fname']
    	   ?>
    	  </div>
    	  <div class="follow">关注
    	  <?php 
    	       echo $_FollowsNumber;
    	   ?>
    	  </div>
    	  <div class="fans">粉丝
    	  
    	   <?php 
    	       echo $_FansNumber;
    	   ?>
    	  </div>
    	  
    	  <div class="weibo">微博
    	  <?php 
    	  echo $_WeiboNumber;
    	  
    	  ?>
    	  </div>
    		
    </div>
     <div>
        <p>&nbsp;&nbsp;</p>
     </div>
     <?php }
		//_pageing函数调用分页，1|2，1表示数字分页，2表示文本分页
		_paging(2);
	?>
	 
	
   
</div>


        <iframe id="secretFrame" name="secretFrame"   >
            
        </iframe>
    
</body>
</html>
