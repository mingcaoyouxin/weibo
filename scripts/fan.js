/**
 * 
 */
window.onload = function () {
	document.getElementById("secretFrame").style.display="none";
	var message = document.getElementsByName('secret');
	for (var i=0;i<message.length;i++) {
		message[i].onclick = function () {
			document.getElementById("secretFrame").style.display="block";
			document.getElementById("secretFrame").src="message.php?id="+this.title;
		};
	}
};