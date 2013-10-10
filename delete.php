<?php
include 'connect.php';

$mode = $_POST["mode"];

if ($mode == "program") {
	$nama = $_POST["nama"];
	$gambar = trim($_POST["gambar"]);
	
	$query = "DELETE FROM program WHERE Nama = '$nama'";
	$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
	
	$location = "images/program/$gambar";
	echo $location;
	
	if (is_readable($location)) {
		unlink($location);
	}
	
	header("Location:program");
} else if ($mode == "crew") {
	$nama = trim($_POST["nama"]);
	$ID = trim($_POST["ID"]);
	$Gambar = trim($_POST["gambar"]);
	
	$query = "DELETE FROM crew WHERE ID = '$ID'";
	$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
	
	$location = "images/crew/$Gambar";
	
	if (is_readable($location)) {
		unlink($location);
	}
	
	header("Location:crew");
} else if ($mode == "gallery") {
	$ID = $_POST["ID"];
	$Cat = trim($_POST["category"]);
	$Gambar = trim($_POST["gambar"]);
	
	$query = "DELETE FROM gallery WHERE ID = '$ID'";
	$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
	
	$location = "images/gallery/$Cat/$Gambar";
	
	if (is_readable($location)) {
		unlink($location);
	}
	
	header("Location:gallery");
} else if ($mode == "event") {
	$ID = $_POST["ID"];
	$gambar = trim($_POST["gambar"]);
	
	$query = "DELETE FROM event WHERE ID = '$ID'";
	$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
	
	$location = "images/event/$gambar";
	echo $location;
	
	if (is_readable($location)) {
		unlink($location);
	}
	
	header("Location:event");
} else if ($mode == "category") {
	$ID = $_POST["ID"];
	
	$query = "DELETE FROM category WHERE ID = '$ID'";
	$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
	
	$aff = mysqli_affected_rows($conn);
	
	if ($aff > 0) {
		echo "1";
	} else {
		echo $query;
	}
}
?>