/**
 * 
 */
window.onload = function () {
	var ubb1 = document.getElementById('ubb1');
	var ubbimg1 = ubb1.getElementsByTagName('span');
	var emj1 = document.getElementById('emoj1');
	var fm1 = document.getElementsByTagName('form')[0];
	var html = document.getElementsByTagName('html')[0];
	html.onmouseup = function () {
		emj.style.display = 'none';
		emj1.style.display = 'none';
	};
	ubbimg1[0].onclick = function() {
		emj1.style.display = 'block';
	};
	function content(string) {
		fm1.content.value += string; 
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


function displaycomment(value){
	if(document.getElementById(value).style.display=='block')
	{
		document.getElementById(value).style.display='none'
	}
	else{
		document.getElementById(value).style.display='block';
	}
		
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

