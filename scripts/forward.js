window.onload = function () {
	var ubb = document.getElementById('ubb');
	var ubbimg = ubb.getElementsByTagName('span');
	var emj = document.getElementById('emoj');
	var fm = document.getElementsByTagName('form')[0];
	var html = document.getElementsByTagName('html')[0];
	 $('#submit').click(function(){
		 parent.location.reload();
		 parent.location.href = "index.php";
	 });
	 
	var weibo=document.getElementById('weibo');  
    var wordCount=document.getElementById('wordCount');
    document.getElementById('submit').disabled=true;
	document.getElementById('submit').style.background="#ccc";
	document.getElementById('submit').style.cursor="default";
	var textarea=weibo.getElementsByTagName('textarea')[0];  
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
	html.onmouseup = function () {
		emj.style.display = 'none';
	};
	ubbimg[0].onclick = function() {
		emj.style.display = 'block';
		 $("iframe", parent.document).css("height","500px");
	};
	function content(string) {
		fm.content.value += string; 
	}
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
	//document.getElementsByTagName('form')[0].content.value = +document.getElementsByTagName('form')[0].content.value;
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

