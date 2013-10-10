<!DOCTYPE HTML>
<HTML>
<HEAD>
	<TITLE>
		Loopies Radio | Inspirasi Manis untuk Pendengar Cerdas
	</TITLE>
	<link rel="stylesheet" href="css/main.css" media="screen" />
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.easing.1.3.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.10.3.js"></script>
	<script type="text/javascript" src="js/fadeSlideShow.js"></script>
	<script type="text/javascript" src="js/login.js"></script>
	<script type="text/javascript" src="js/main.js"></script>
	<script type="text/javascript" src="js/program.js"></script>
	<script type="text/javascript" src="js/event.js"></script>
	<script type="text/javascript" src="js/crew.js"></script>
	<script type="text/javascript" src="js/gallery.js"></script>
	<script type="text/javascript"> /* Function for Chatwing */
	  (function(d) {
		var cwjs, id='chatwing-js';  if(d.getElementById(id)) {return;}
		cwjs = d.createElement('script'); cwjs.type = 'text/javascript'; cwjs.async = true; cwjs.id = id
		cwjs.src = "//chatwing.com/code/56134557-dfdb-4a95-ab50-b258b13674ca/embedded";
		d.getElementsByTagName('head')[0].appendChild(cwjs);
	  })(document);
	</script>
</HEAD>
<BODY>
	<?php
		include 'connect.php';
		session_start();
	?>
	<section id="header">
	<?php if (isset($_SESSION['admin'])) { ?>
		<div id="admin_bar">
			<button id="logout-btn">Logout</button>
			<div id="welcome">
				Welcome, Admin !
			</div>
		</div>
	<?php } ?>
		<div id="logo">
			LOGO
		</div>
		<div id="apps-streaming">
			<div id="apps-str-content">
				APPS - STREAMING
			</div>
			<div id="apps-str-btn">
				BAM !
			</div>
		</div>
		<div id="menu_container">
			<ul id="menu">
				<li class="menu_active"><a href="http://localhost/loopies">Home</a></li>
				<li><a href="program">Program</a></li>
				<li><a href="event">Event</a></li>
				<li><a href="crew">Crew</a></li>
				<li><a href="about">About</a></li>
				<li><a href="gallery">Gallery</a></li>
			</ul>
		</div>
		<div id="follow_us">
			<a href="https://twitter.com/loopiesradio" target="_blank">
				<img id="twitpic" src="images/Twitter.png" />
			</a>
		</div>
		<div id="music_chart">
			<div id="the_chart_container">
				<table id="the_chart">
					<tr>
						<th>#</th>
						<th>Title</th>
						<th>Artist</th>
					</tr>
					<?php
						$chart_query = "SELECT * FROM chart ORDER BY Position ASC";
						$chart_exec = mysqli_query($conn, $chart_query);
						
						while ($chart = mysqli_fetch_array($chart_exec)) { ?>
							<tr>
								<td><?php echo $chart["Position"]; ?></td>
								<td style="display:none"><?php echo $chart["ID"]; ?></td>
								<td><?php echo $chart["Song"]; ?></td>
								<td><?php echo $chart["Artist"]; ?></td>
							</tr>
					<?php } ?>
				</table>
			<?php if (isset($_SESSION["admin"])) { ?>
				<button id="chart_edit" class="button chart_edit">Edit</button>
				<button id="chart_edit_save" class="button chart_edit">Save</button>
			<?php } ?>
			</div>
			<div id="chart_button">Top 10 Chart !</div>
		</div>
		<div id="chatbox">
			<div id="chat_button">Chat now !</div>
			<div id="chat_cover">Loopies Chatbox</div>
			<div id="chatwing-embedded-56134557-dfdb-4a95-ab50-b258b13674ca" class="chatwing"></div>
		</div>
	</section>