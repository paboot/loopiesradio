<HTML>
<HEAD>
	<TITLE> Login to Loopies Radio </TITLE>
	<link rel="stylesheet" href="css/main.css" media="screen" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.js"></script>
	<script type="text/javascript" src="js/fadeSlideShow.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
</HEAD>
<BODY style="background:url(images/bg.png) no-repeat fixed left top">
	<div id="login-container">
		<h1>Welcome to Loopies Radio Admin Page !</h1>
		<form action="javascript:logincheck()" method="post" id="login-form">
			<table id="login-table">
				<tbody>
					<tr>
						<td><label for="frmuser">Username</label></td>
						<td><input type="Text" name="frmuser" size="15" id="username"></td>
					</tr>
					<tr>
						<td><label for="frmpass">Password</label></td>
						<td><input type="password" name="frmpass" size="15" id="password"></td>
					</tr>
				</tbody>
			</table>
			<div id="login-msg" style="display:none">
				<img id="ajax-animation" src="images/ajax.gif">
				<span id="message"></span>
			</div>
			<input id="submit-button" type="submit" name="login" value="Login">
		</form><br><br>
		<div id="ribbon">
			<div id="ribbon-curve">
				<span id="ribbon-content">
					Welcome to Loopies Radio
				</span>
			</div>
		</div>
	</div>
</BODY>
</HTML>