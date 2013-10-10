function logincheck() {
	if (window.XMLHttpRequest) {
		xmlhttp = new XMLHttpRequest();
	}
	else {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	document.getElementById('login-msg').style.display = 'block';
	document.getElementById('message').innerHTML = '';
	document.getElementById('ajax-animation').removeAttribute('style');
	
	user = document.getElementById("username").value;
	pass = document.getElementById("password").value;

	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var loginmessage = xmlhttp.responseText;
			if (loginmessage == 1)
			{
				document.getElementById('ajax-animation').style.display = 'none';
				document.getElementById('message').innerHTML = "Success !";
				window.location.href = location.pathname+"/..";
			}
			else
			{
				document.getElementById("username").value = "";
				document.getElementById("password").value = "";
				document.getElementById('ajax-animation').style.display = 'none';
				document.getElementById('message').innerHTML = loginmessage;
				return false;
			}
		}
	}

	xmlhttp.open("GET", "logincheck.php?u="+user+"&p="+pass,true);
	xmlhttp.send();
}

$(document).ready(function(){
	var sBrowser, sUsrAg = navigator.userAgent;

	if(sUsrAg.indexOf("Chrome") > -1) {
		sBrowser = "Google Chrome";
	} else if (sUsrAg.indexOf("Safari") > -1) {
		sBrowser = "Apple Safari";
	} else if (sUsrAg.indexOf("Opera") > -1) {
		sBrowser = "Opera";
	} else if (sUsrAg.indexOf("Firefox") > -1) {
		sBrowser = "Mozilla Firefox";
		$('#login-form').addClass('mozilla_login');
		$('.container').addClass('mozilla_container');
	} else if (sUsrAg.indexOf("MSIE") > -1) {
		sBrowser = "Microsoft Internet Explorer";
	}
});