<?php
include 'connect.php';
include("resize-class.php");

$mode = $_POST["mode"];

if ($mode == "slide") {
	$gambar = $_FILES['gambar']['name'];
	
	$query = "INSERT INTO slide(Gambar) VALUES('$gambar')";
	$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
	
	if ($_FILES['gambar']['error'] > 0) {
		echo "Return Code: " . $_FILES["gambar"]["error"] . "<br>";
	} else {
		move_uploaded_file($_FILES["gambar"]["tmp_name"], "images/" . $_FILES["gambar"]["name"]);
	}
	
	header("Location:http://localhost/loopies");
} else if ($mode == "program") {
	$gambar = $_FILES['gambar']['name'];
	$nama = $_POST["nama"];
	$host = $_POST["host"];
	$jadwal = $_POST["jadwal"];
	$desc = $_POST["desc"];
	
	$query = "INSERT INTO program(Gambar,Nama,Host,Jadwal,Description) VALUES('$gambar','$nama','$host','$jadwal','$desc')";
	$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
	
	if ($_FILES['gambar']['error'] > 0) {
		echo "Return Code: " . $_FILES["gambar"]["error"] . "<br>";
	} else {
		move_uploaded_file($_FILES["gambar"]["tmp_name"], "images/program/" . $_FILES["gambar"]["name"]);
	}
	
	header("Location:program");
} else if ($mode == "event") {
	$gambar = $_FILES['gambar']['name'];
	$nama = $_POST["nama"];
	$nama = mysqli_real_escape_string($conn, $nama);
	$content = $_POST["content"];
	$content = mysqli_real_escape_string($conn, $content);
	
	$query = "INSERT INTO event(Gambar,Nama,Content) VALUES('$gambar','$nama','$content')";
	$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
	
	if ($_FILES['gambar']['error'] > 0) {
		echo "Return Code: " . $_FILES["gambar"]["error"] . "<br>";
	} else {
		move_uploaded_file($_FILES["gambar"]["tmp_name"], "images/event/" . $_FILES["gambar"]["name"]);
	}
	
	header("Location:event");
} else if ($mode == "crew") {
	$gambar = $_FILES['gambar']['name'];
	$nama = $_POST["nama"];
	
	$query = "INSERT INTO crew(Gambar,Nama) VALUES('$gambar','$nama')";
	$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
	
	if ($_FILES['gambar']['error'] > 0) {
		echo "Return Code: " . $_FILES["gambar"]["error"] . "<br>";
	} else {
		move_uploaded_file($_FILES["gambar"]["tmp_name"], "images/crew/" . $_FILES["gambar"]["name"]);
	}
	
	$resizeObj = new resize("images/crew/".$gambar);
	$resizeObj -> resizeImage(1600, 900, 'auto');
	$resizeObj -> saveImage("images/crew/".$gambar, 80);
	
	header("Location:crew");
} else if ($mode == "gallery") {
	$gambar = $_FILES['gambar']['name'];
	$nama = $_POST["nama"];
	$category = $_POST["category"];
	
	foreach($_FILES['gambar']['tmp_name'] as $key => $tmp_name ) {
		$gambar = $_FILES['gambar']['name'][$key];
		$gambar_tmp = $_FILES['gambar']['tmp_name'][$key];
		
		$desired_dir = "images/gallery/".$category;
		
		if (is_dir($desired_dir) == false) {
			mkdir("$desired_dir", 0700);		// Create directory if it does not exist
		}
		
		if (is_readable("$desired_dir/".$gambar) == false) {
			move_uploaded_file($gambar_tmp,"$desired_dir/".$gambar);
		} else {									//rename the file if another one exist
			$arrGambar = explode(".", $gambar);
			$new_gambar = $arrGambar[0].time().".".$arrGambar[1];
			$gambar = $new_gambar;
			move_uploaded_file($gambar_tmp,"$desired_dir/".$gambar);			
		}
		
		$query = "INSERT INTO gallery(Gambar,Nama,Category) VALUES('$gambar','$nama','$category')";
		$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
		
		$resizeObj = new resize("$desired_dir/".$gambar);
		$resizeObj -> resizeImage(1600, 900, 'auto');
		$resizeObj -> saveImage("$desired_dir/".$gambar, 80);
	}
	
	header("Location:gallery");
} else if ($mode == "category") {
	$nama = $_POST["nama"];
	
	$query = "INSERT INTO category(Nama) VALUES('$nama')";
	$exec = mysqli_query($conn, $query) or die("Error in database <b>".mysqli_error()."</b> $query");
	
	header("Location:gallery");
}
?>
<?php /*
if(isset($_FILES['files'])){
    $errors= array();
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
		$file_name = $key.$_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
        if($file_size > 2097152){
			$errors[]='File size must be less than 2 MB';
        }		
        $query="INSERT into upload_data (`USER_ID`,`FILE_NAME`,`FILE_SIZE`,`FILE_TYPE`) VALUES('$user_id','$file_name','$file_size','$file_type'); ";
        $desired_dir="user_data";
        if(empty($errors)==true){
            if(is_dir($desired_dir)==false){
                mkdir("$desired_dir", 0700);		// Create directory if it does not exist
            }
            if(is_dir("$desired_dir/".$file_name)==false){
                move_uploaded_file($file_tmp,"user_data/".$file_name);
            }else{									//rename the file if another one exist
                $new_dir="user_data/".$file_name.time();
                 rename($file_tmp,$new_dir) ;				
            }
            mysql_query($query);			
        }else{
                print_r($errors);
        }
    }
	if(empty($error)){
		echo "Success";
	}
} */
?>