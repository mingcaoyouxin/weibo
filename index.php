<?php 
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来指定本页的内容
define('SCRIPT','index');
//引入公共文件
require dirname(__FILE__).'/includes/common.inc.php'; //转换成硬路径，速度更快
//分页模块
global $_pagesize,$_pagenum;
 $_queryStr="SELECT username,content,forwardcount,commentcount,date FROM weibo AS a 
                        WHERE a.username = '". $_COOKIE['username']."' OR a.username IN (
                        SELECT name
                        FROM fans
                        WHERE fans.fname ='". $_COOKIE['username']."' ORDER BY date 
                    )";
_page($_queryStr,6);   //第一个参数获取总条数，第二个参数，指定每页多少条

$_queryStr='SELECT A.username AS name, B.username AS fname FROM user AS A,user AS B,fans AS C where A.id=C.id and B.id=C.f_id and A.username="'.$_COOKIE['username'].'"';
$_result = _query($_queryStr);
$_myFansNum=mysql_affected_rows();
$_SESSION['myFansNum'] =$_myFansNum;

$_queryStr='SELECT A.username AS name, B.username AS fame FROM user AS A,user AS B, fans AS C where A.id=C.id and B.id=C.f_id and B.username="'.$_COOKIE['username'].'"';
$_result = _query($_queryStr);
$_myFollowsNum=mysql_affected_rows();
$_SESSION['myFollowsNum'] =$_myFollowsNum;

$_queryStr='SELECT * FROM weibo AS A where A.username="'.$_COOKIE['username'].'"';
$_result = _query($_queryStr);
$_myFollowsNum=mysql_affected_rows();
$_SESSION['myWeiboNum'] =$_myFollowsNum;

//判断是否登录了
if (!isset($_COOKIE['username'])) {
    _location(null,'login.php');
}
//将微博写入数据库
if ($_GET['action'] == 'post') {
	$_clean = array();
	$_clean['username'] = $_COOKIE['username'];
	$_clean['content'] = $_POST['content'];
	$_clean = _mysql_string($_clean);
	$_queryContent="INSERT INTO weibo (username,content,date)VALUES ('{$_clean['username']}','{$_clean['content']}',NOW())";
	//写入数据库
	_query(	$_queryContent);
		        if (_affected_rows() == 1) {
		        _close();
		        _session_destroy();
		         _location(null,'index.php');
		        }  
  }
  //将评论写入数据库
  if ($_GET['action'] == 'postcomm') {
        
      $_clean = array();
      $_clean['fromuser'] = $_COOKIE['username'];
      $_clean['content'] = $_POST['content'];
      $_clean['touser']=$_POST['touser'];
      $_clean['wid']=$_POST['wid'];
      $_clean = _mysql_string($_clean);
      $_queryComment="INSERT INTO comments (fromuser,touser,wid,content,date)VALUES
      ('{$_clean['fromuser']}','{$_clean['touser']}','{$_clean['wid']}',
      '{$_clean['content']}',NOW())";
      //写入数据库
      _query($_queryComment);
      if(intval($_POST['forwardAtTime'])){
          $_queryContents="INSERT INTO weibo (username,content,date)VALUES ('{$_clean['fromuser']}','{$_clean['content']}',NOW())";
          _query($_queryContents);
      }
      if (_affected_rows() == 1) {
      _close();
      _session_destroy();
      _location(null,'index.php');
      }
      }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="shortcut icon" href="sources/weibo.png" />
<title>我的首页</title>
<link rel="stylesheet" type="text/css" href="styles/index.css" />
<script charset="UTF-8" type="text/javascript" src="scripts/jquery-1.11.1.min.js"></script>
<script charset="UTF-8" type="text/javascript" src="scripts/layer-v1.8.5/layer/layer.min.js"></script>
<script charset="UTF-8" type="text/javascript" src="scripts/index.js"></script>
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
    		<dd><a href="received.php">私信</a></dd>
    		<dd><a href="###">@我的</a></dd>
    	</dl>
    </div>
   
     <div id="fans">
        <img id="imgbg" src="sources/userback.jpg"  width="196px" height="120px" style="
            position: absolute;z-index: 0" />
        <div id="small" style="text-align:center;">
            <img id="imghead" src="sources/head.jpg"></img>
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
    		<li><a href="member.php">
    		<span style="padding:0 12px 0 5px">
    		  <?php 
    		      echo $_SESSION['myWeiboNum'];
    		  ?>
    		</span>
    		微博
    		</a></li>
    	</ul> 
            
       </div>
        
    </div>
    <div id="weibo">
    <form method="post" name="post" action="?action=post">
        <div id="wordCount" style="float:right;"></div>
        <textarea name="content" ></textarea>
        <div><input id="submit" type="submit" value="发布" class="button" /></div>
        <div id="ubb">
            <div style="cursor:pointer"><img src="emoj/smilea.gif" title="表情" style="width: 15px;height:15px;margin-right:3px;"/><span style="float: left;margin-top:4px;">表情</span></div>
            <img src="images/space.gif" />
			<div style="cursor:pointer"><img src="images/music.gif" style="width: 15px;height:15px;margin-right:3px;" title="音乐" /><span style="float: left;margin-top:4px;">音乐</span></div>
			<img src="images/space.gif" />
			<div style="cursor:pointer"><img src="images/image.gif" style="width: 15px;height:15px;margin-right:3px;" title="图片" /><span style="float: left;margin-top:4px;">图片</span></div>
			<img src="images/space.gif" />
			<div style="cursor:pointer"><img src="images/movie.gif" style="width: 15px;height:15px;margin-right:3px;" title="视频" /><span style="float: left;margin-top:4px;">视频</span></div>
		</div>
        <?php include ROOT_PATH.'includes/emoj.inc.php'?>
	   </form>
    </div>
    <div id="list">
    
        <div id="grayback">
            <p style="padding:4px;">全部</p>
        </div>
         <?php 
	       $_queryStr="SELECT id,username,content,forwardcount,commentcount,date FROM weibo AS a 
                        WHERE a.username = '". $_COOKIE['username']."' OR a.username IN (
                        SELECT name
                        FROM fans
                        WHERE fans.fname ='". $_COOKIE['username']."' 
                    ) ORDER BY date desc LIMIT $_pagenum,$_pagesize ";
	       //echo $_queryStr;
	       $_result = _query($_queryStr);
	       while (!!$_rows = _fetch_array_list($_result)) {
	           $_idStr="select id from user where username='".$_rows['fromuser']."'";
	           $_idResult = _query($_idStr);
	           $_rowid = _fetch_array_list($_idResult);
        ?>
        <div id="detailweibo">
             <div><img id="head" src="sources/defaultpic.png"  alt="" /></div>
             <div id="username" class="username"><?php echo $_rows['username']?> </div>
             <div id="content" class="content">
                  <?php echo _ubb($_rows['content']) ?>                               
             </div>
            <div id="comment"><a name="comment"  href="javascript:;" onclick="displaycomment('<?php echo $_rows['id'];?>hide')">评论
            <?php 
            $_qComments="SELECT *  FROM comments AS a
                        WHERE a.wid=".$_rows['id'];
            //echo $_queryForwards;
            $_resultComments= _query($_qComments);
            $_commentsNum=mysql_affected_rows();
            echo $_commentsNum;
            ?>
            </a></div>
            <div id="forward" onclick="forwardonclick('<?php echo $_rows['username']?>','<?php echo $_rows['content']?>','<?php echo $_rows['id']?>');"><a name="forward"   href="javascript:;">转发
             <?php 
            $_queryForwards="SELECT *   FROM forwards AS a
                        WHERE a.wid=".$_rows['id'];
            //echo $_queryForwards;
            $_resultForwards = _query($_queryForwards);
            $_ForwardsNum=mysql_affected_rows();
            echo $_ForwardsNum;
            //
            //$_queryForwards="SELECT *   FROM forwards AS a where a.wid like '%".$_rows[id]."%'";
            
            //echo $_queryForwards;
           // $_resultForwards = _query($_queryForwards);
            //$_ForwardsNum=mysql_affected_rows();
            //echo $_ForwardsNum;
            
            ?>
            
            
            </a></div>
            <div class="hidecomment" id="<?php echo $_rows['id'];?>hide">
             <form method="post" name="postcomm" action="?action=postcomm">
                <input type="hidden" name="touser" value="<?php echo $_rows['username']?>" />
                <input type="hidden" name="wid" value="<?php echo $_rows['id']?>" />
                <textarea name="content" id="<?php echo $_rows['id'];?>text"></textarea>
                <div><input id="submit" type="submit" value="评论" class="button" /></div>
                <div id="<?php echo $_rows['id'];?>ubb">
                    <div style="cursor:pointer"><img src="emoj/smilea.gif" title="表情" style="width: 15px;height:15px;margin-right:3px;"/><span id="<?php echo $_rows['id'];?>span" style="float: left;margin-top:4px;" onclick="spanonclick('<?php echo $_rows['id'];?>span')">表情</span></div>
                    <div id="checkbox" style="padding:5px;"><label style="margin:5px 0 0 5px;"><input name="forwardAtTime[]" type="checkbox" value="1 " />同时转发到我的微博 </label></div>             
                </div>
                <?php include ROOT_PATH.'includes/emojcomment.inc.php'?>
             </form>
             <?php 
        	       $_queryComments="SELECT id,fromuser,touser,content,wid,date FROM comments AS a 
                                WHERE a.wid=".$_rows['id']." order by date desc";
            	       //echo $_queryComments;
            	       $_comments = _query($_queryComments);
            	       while (!!$_lines = _fetch_array_list($_comments)) {
             ?>
                <div id="commentlist">
                    <div id="time" class="time">
                       <?php echo $_lines['date']?>
                    </div>
                    <div><img id="head" src="sources/defaultpic.png"  alt="" /></div>
                    <div id="username" class="username"><?php echo $_lines['fromuser']?></div>
                    <div id="content" class="content">
                         <?php echo _ubb( $_lines['content'])?>
                          &nbsp;&nbsp;
                    </div>
                    
                    <hr style="margin-left:15px;margin-top:10px;"/>
                </div>
             <?php 
	                }
             ?>
            </div>
        </div> 
        <?php 
	       }
	       _paging(2);
        ?> 
        
    </div>
  
    
    
    
    

</body>
</html>