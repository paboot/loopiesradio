<?php
include 'connect.php';

$u = $_GET["u"] ;
$p = $_GET["p"] ;

$query = "SELECT * FROM login WHERE username = '$u' and password = md5('$p')";

$result = mysqli_query($conn, $query);
$count = mysqli_num_rows($result);
$tuple = mysqli_fetch_array($result);

if ($count == 1) {
    session_start();
	$_SESSION['admin'] = 1;
	echo "1";
} else {
    echo "Wrong Username or Password";
}

mysqli_close($conn);
?>
