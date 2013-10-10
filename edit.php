<?php
include 'connect.php';

$mode = $_POST["mode"];

if ($mode == "program") {
	$realname = $_POST["realname"];
	$name = $_POST["name"];
	$host = $_POST["host"];
	$jadwal = $_POST["jadwal"];
	$desc = $_POST["desc"];
	
	$query = "UPDATE program SET Nama = '$name', Host = '$host', Jadwal = '$jadwal', Description = '$desc' WHERE Nama = '$realname'";
	$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
	$aff = mysqli_affected_rows($conn);
	
	if ($aff > 0) {
		echo "1";
	} else {
		echo "0";
	}
} else if ($mode == "chart") {
	for ($i = 1; $i < 11; $i++) {
		$id = $_POST["ID".$i];
		$pos = $_POST["Pos".$i];
		$song = $_POST["Song".$i];
		$artist = $_POST["Artist".$i];
		
		$query[$i] = "UPDATE chart SET Position = '$pos', Song = \"$song\", Artist =\"$artist\" WHERE ID = '$id'";
		$exec[$i] = mysqli_query($conn, $query[$i]) or die("Error in database <b>".mysqli_error()."</b> $query[$i]");
	}
	
	header("Location:http://localhost/loopies");
} else if($mode == "crew") {
	$name = $_POST["name"];
	$realname = $_POST["realname"];
	
	$query = "UPDATE crew SET Nama = '$name' WHERE Nama = '$realname'";
	$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
	
	$aff = mysqli_affected_rows($conn);
	
	if ($aff > 0) {
		echo "1";
	} else {
		echo "0";
	}
} else if($mode == "event") {
	$ID = $_POST["ID"];
	$name = $_POST["name"];
	$name = mysqli_real_escape_string($conn, $name);
	$content = $_POST["content"];
	$content = mysqli_real_escape_string($conn, $content);
	
	$query = "UPDATE event SET Nama = '$name', Content = '$content' WHERE ID = '$ID'";
	$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
	
	$aff = mysqli_affected_rows($conn);
	
	if ($aff > 0) {
		echo "1";
	} else {
		echo $query;
	}
} else if($mode == "gallery") {
	$name = $_POST["name"];
	$ID = $_POST["ID"];
	
	$query = "UPDATE gallery SET Nama = '$name' WHERE ID = '$ID'";
	$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
	
	$aff = mysqli_affected_rows($conn);
	
	if ($aff > 0) {
		echo "1";
	} else {
		echo "0";
	}
} else if  ($mode == "category") {
	$ID = $_POST["ID"];
	$name = $_POST["nama"];
	$name = mysqli_real_escape_string($conn, $name);
	
	$query = "UPDATE category SET Nama = '$name' WHERE ID = '$ID'";
	$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
	
	$aff = mysqli_affected_rows($conn);
	
	if ($aff > 0) {
		echo "1";
	} else {
		echo $query;
	}
}
?>