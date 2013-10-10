<?php
$conn = mysqli_connect('localhost', 'root','1234','loopies');
if (mysqli_connect_errno($conn))
{
	echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
?>