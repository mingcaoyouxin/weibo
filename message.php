<?php
session_start();
//�����������������Ȩ����includes������ļ�
define('IN_TG',true);
//���������������ָ����ҳ������
define('SCRIPT','message');
//���빫���ļ�
require dirname(__FILE__).'/includes/common.inc.php';
//�ж��Ƿ��¼��
if (!isset($_COOKIE['username'])) {

	_location(null,'login.php');
}
//д����
if ($_GET['action'] == 'write') {
    echo '<script>window.parent.document.getElementById("secretFrame").style.display="none"</script>';
	if (!!$_rows = _fetch_array("SELECT uniqid FROM user WHERE username='{$_COOKIE['username']}' LIMIT 1")) {
		include ROOT_PATH.'includes/message.func.php';
		$_clean = array();
		$_clean['touser'] = $_POST['touser'];
		$_clean['fromuser'] = $_COOKIE['username'];
		$_clean['content'] = $_POST['content'];
		$_clean = _mysql_string($_clean);
		//д���
		_query("INSERT INTO message (
									touser,
									fromuser,
									content,
									date
									)
									VALUES (
									'{$_clean['touser']}',
									'{$_clean['fromuser']}',
									'{$_clean['content']}',
									NOW()
							)
		");
		//�����ɹ�
		if (_affected_rows() == 1) {
			_close();
			_session_destroy();
			
		} else {
			_close();
			_session_destroy();
			_alert_back('����ʧ��');
		}
	} else {
		_alert_close('�Ƿ���¼��');
	}
}
//��ȡ����
if (isset($_GET['id'])) {
	if (!!$_rows = _fetch_array("SELECT username FROM user WHERE id='{$_GET['id']}' LIMIT 1")) {
		$_html = array();
		$_html['touser'] = $_rows['username'];
		
	} else {
		_alert_close('�����ڴ��û���');
	}
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<link rel="stylesheet" type="text/css" href="styles/message.css" />
<script type="text/javascript" src="scripts/message.js" charset="UTF-8"></script>
</head>
<body>
<div id="message">
	<p id="button"><?php echo $_html['touser'];?><input type="button" id ="close" class="close" value="�ر�" /></p>
	<div id="backgray" >
	    <?php 
	       $_queryStr="SELECT  fromuser,touser,content,date FROM message where (touser='".$_COOKIE['username']."' and fromuser='".$_html['touser']."') or 
                                                                        (fromuser='".$_COOKIE['username']."' and touser='".$_html['touser']."')
                                                                        ORDER BY date";
	       $_result = _query($_queryStr);
	       while (!!$_rows = _fetch_array_list($_result)) {
	           if($_rows['fromuser']==$_COOKIE['username'] && $_rows['touser']==$_html['touser']){
	     ?>
	     <div id="mymessage" >
    	       <span><?php echo $_rows['content']?></span>
    	 </div>
	     <?php 
	           }else{
	      ?>
	      <div id="receivemessage" >
    	       <span><?php echo $_rows['content'] ?></span>
    	</div>
	      
	      <?php 
	           }
	        } 
	      ?>                     	
	</div>

	<form method="post" action="?action=write">
	   <input type="hidden" name="touser" value="<?php echo $_html['touser']?>" />
    	<textarea id="content" name="content" onfocus="ClearDefault(this)" onblur="AddDefault(this)">���ã���ʲô����</textarea>
    	<input type="submit"  class="button" value="����" />
    </form>
</div>
</body>
</html>
