window.onload = function () {
	var ubb = document.getElementById('ubb');
	var ubbimg = ubb.getElementsByTagName('span');
	var emj = document.getElementById('emoj');
	var fm = document.getElementsByTagName('form')[0];
	
	var html = document.getElementsByTagName('html')[0];
	html.onmouseup = function () {
		emj.style.display = 'none';
	};
	ubbimg[0].onclick = function() {
		emj.style.display = 'block';
	};
	ubbimg[1].onclick = function () {
		var url = prompt('请输入音乐：','http://');
		if (url!=null) {
			if (/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(url)) {
				content('[url]'+url+'[/url]');
			} else {
				alert('网址不合法！');
			}
		}
	};
	ubbimg[2].onclick = function () {
		var img = prompt('请输入图片地址：','');
		if (img!=null) {
			content(img);
		}
	};
	ubbimg[3].onclick = function () {
		var flash = prompt('请输入视频地址：','http://');
		if (flash!=null) {
			if (/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(flash)) {
				content(flash);
			} else {
				alert('视频不合法！');
			}
		}
	};
	function content(string) {
		fm.content.value += string; 
	}
	var weibo=document.getElementById('weibo');  
    var textarea=weibo.getElementsByTagName('textarea')[0];  
    var wordCount=document.getElementById('wordCount');
    document.getElementById('submit').disabled=true;
	document.getElementById('submit').style.background="#ccc";
	document.getElementById('submit').style.cursor="default";
    var ie=!-[1,];//判断是否为ie浏览器  
    var bbtn=true;  
    var timer=null;  
    var nnn=0;  
    textarea.onfocus=function(){  
        if(bbtn){   
            bbtn=false;  
        }  
    };  
    if(ie){  
    	textarea.onpropertychange=toChange;  
    }else{  
    	textarea.oninput=toChange;     
    }  
    function toChange(){  
        var num=Math.ceil(getLength(textarea.value)/2);  
        if(num<=140){
        	wordCount.innerHTML='还可以输入<span><em>140</em></span>字';
        	var oSpan=weibo.getElementsByTagName('em')[0];  
            oSpan.innerHTML=140-num;  
            oSpan.style.color='';  
        }else{
        	wordCount.innerHTML='您已经超过<span><em>1</em></span>字'; 
        	var oSpan=weibo.getElementsByTagName('em')[0];
            oSpan.innerHTML=num-140;  
            oSpan.style.color='red';  
        }  
        if(textarea.value==''||num>140){  
        	document.getElementById('submit').disabled=true;
        	document.getElementById('submit').style.background="#ccc";
        	document.getElementById('submit').style.cursor="default";
        	
        }else{  
        	document.getElementById('submit').disabled=false;
        	document.getElementById('submit').style.background="#fff";
        	document.getElementById('submit').style.cursor="pointer";
        }  
    }  
    function getLength(str){  
        return String(str).replace(/[^\x00-\xff]/g,'aa').length;  
    }   
};

function emoj(value) {
	var tc = document.getElementsByTagName('form')[0].content;  
    var tclen = tc.value.length;  
    tc.focus();  
    if(typeof document.selection != "undefined")  
    {  
        document.selection.createRange().text = str;    
    }  
    else  
    {  
        tc.value = tc.value.substr(0,tc.selectionStart)+'['+value+']'+tc.value.substring(tc.selectionStart,tclen);  
    }  
};
function emoj1(value,text) {
	var tc = document.getElementById(text);  
    var tclen = tc.value.length;  
    tc.focus();  
    if(typeof document.selection != "undefined")  
    {  
        document.selection.createRange().text = str;    
    }  
    else  
    {  
        tc.value = tc.value.substr(0,tc.selectionStart)+'['+value+']'+tc.value.substring(tc.selectionStart,tclen);  
    }  
};
function displaycomment(value){
	if(document.getElementById(value).style.display=='block')
	{
		document.getElementById(value).style.display='none'
	}
	else{
		document.getElementById(value).style.display='block';
	}	
}
function spanonclick(value){
	var span = document.getElementById(value);
	var subvalue=value.substring(0,value.length-4);
	var emojvalue=subvalue+"emoj";
	var emj = document.getElementById(emojvalue);
	if(emj.style.display=='block'){
		emj.style.display='none';
	}
	else
		emj.style.display='block';
	var html = document.getElementsByTagName('html')[0];
	html.onmouseup = function () {
		emj.style.display = 'none';
	};
}
function forwardonclick(username,content,id){
	var src="forward.php?"+"username="+username+"&content="+content+"&wid="+id;
    $.layer({
        type: 2,
        title: ['转发微博', 'font-size:12px;'],
        maxmin: false,
	    closeBtn: false,
        shadeClose: true, //开启点击遮罩关闭层
        area : ['550px' , '220px'],
        offset : ['90px', ''],
        iframe: {src: src,scrolling:'no'}
    });
}
