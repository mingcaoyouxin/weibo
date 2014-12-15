/**
 * 
 */
var defaultvalue="您好，有什么事吗？";
window.onload = function () {
	document.getElementById("close").onclick = function () {
		window.parent.document.getElementById('secretFrame').style.display='none';
		};
		document.getElementById('backgray').scrollIntoView(); 
		
	}
function ClearDefault(element)
{
  
   if(element.value==defaultvalue)
   {
     element.value = "";
   }
}
function AddDefault(element)
{ 
 
  if(element.value=="")
  { element.value =defaultvalue; }
}