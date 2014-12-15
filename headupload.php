<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gbk" />
<title>个人设置</title>
<link rel="shortcut icon" href="sources/weibo.png" />
<link rel="stylesheet" type="text/css" href="styles/basic.css" />
<link rel="stylesheet" type="text/css" href="styles/headupload.css" />

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
    <div id="configitem">
    	  <ul>
    		<li id="infoli"><a href="config.php" ><img src="sources/userconfig.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>个人设置</a></li>
    		<li id="headli" style="background-color: #ffffff"><a href="headupload.php" ><img src="sources/upload.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>上传头像</a></li>
    	</ul>
    </div>
    <div id="lists">
    	<div>
    		<form enctype="multipart/form-data" method="post" name="upform" target="upload_target" action="upload.php">
    		 <!--  <input type="file" name="Filedata" id="Filedata"/> -->
    		  <a href="javascript:void(0);" onclick="useCamera()">
    		      <img src="sources/camera.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>自拍头像
    		  </a>
    		  <a href="javascript:void(0);"  class="upload" >
    		      
    		      <img src="sources/headupload.png" width="20px" height="20px" style="padding-right:5px;vertical-align: top;"/>本地上传
    		      <input type="file" name="Filedata" id="Filedata" class="upload-input"></input>
    		  </a>
    		  <input style="margin-right:20px;" type="submit" name="" value="上传" onclick="return checkFile();" />
    		  <span style="visibility:hidden;" id="loading_gif">
    		      <img src="loading.gif" align="middle" ></img>上传中，请稍侯......
    		  </span>
    		</form>
    		
		<iframe src="about:blank" name="upload_target" style="display:none;"></iframe>
		<div id="avatar_editor" style="margin:10px">
		
		</div>
		<script type="text/javascript">
		//允许上传的图片类型
		var extensions = 'jpg,jpeg,gif,png';
		//保存缩略图的地址.
		var saveUrl = 'save_avatar.php';
		//保存摄象头白摄图片的地址.
		var cameraPostUrl = 'camera.php';
		//头像编辑器flash的地址.
		var editorFlaPath = 'AvatarEditor.swf';
		function useCamera()
		{
			var content = '<embed height="460" width="514" ';
			content +='flashvars="type=camera';
			content +='&postUrl='+cameraPostUrl+'?&radom=1';
			content += '&saveUrl='+saveUrl+'?radom=1" ';
			content +='pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" ';
			content +='allowscriptaccess="always" quality="high" ';
			content +='src="'+editorFlaPath+'"/>';
			document.getElementById('avatar_editor').innerHTML = content;
		}
		function buildAvatarEditor(pic_id,pic_path,post_type)
		{
			var content = '<embed height="464" width="514"'; 
			content+='flashvars="type='+post_type;
			content+='&photoUrl='+pic_path;
			content+='&photoId='+pic_id;
			content+='&postUrl='+cameraPostUrl+'?&radom=1';
			content+='&saveUrl='+saveUrl+'?radom=1"';
			content+=' pluginspage="http://www.macromedia.com/go/getflashplayer"';
			content+=' type="application/x-shockwave-flash"';
			content+=' allowscriptaccess="always" quality="high" src="'+editorFlaPath+'"/>';
			document.getElementById('avatar_editor').innerHTML = content;
		}
			/**
			  * 提供给FLASH的接口 ： 没有摄像头时的回调方法
			  */
			 function noCamera(){
				 alert("没有camera ：）");
			 }
					
			/**
			 * 提供给FLASH的接口：编辑头像保存成功后的回调方法
			 */
			function avatarSaved(){
				alert('保存成功，哈哈');
				//window.location.href = '/profile.do';
			}
			
			 /**
			  * 提供给FLASH的接口：编辑头像保存失败的回调方法, msg 是失败信息，可以不返回给用户, 仅作调试使用.
			  */
			 function avatarError(msg){
				 alert("上传失败");
			 }

			 function checkFile()
			 {
				 var path = document.getElementById('Filedata').value;
				 var ext = getExt(path);
				 var re = new RegExp("(^|\\s|,)" + ext + "($|\\s|,)", "ig");
				  if(extensions != '' && (re.exec(extensions) == null || ext == '')) {
				 alert('对不起，只能上传jpg, gif, png类型的图片');
				 return false;
				 }
				 showLoading();
				 return true;
			 }

			 function getExt(path) {
				return path.lastIndexOf('.') == -1 ? '' : path.substr(path.lastIndexOf('.') + 1, path.length).toLowerCase();
			}
              function	showLoading()
			  {
				  document.getElementById('loading_gif').style.visibility = 'visible';
			  }
			  function hideLoading()
			  {
				document.getElementById('loading_gif').style.visibility = 'hidden';
			  }
		</script>
	</div>
    </div>
    
    



</body>
</html>
