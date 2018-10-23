<?php
$dbname = 'LB';
$dbuser = 'admin';
$dbpass = 'admin';
$dbhost = 'localhost';
$connect = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if($connect->connect_errno){
	echo "Conncection Error";
	exit();
}
mysqli_set_charset($connect,"utf8");
if(!$result = $connect->query("SELECT * FROM Libri_Listati")){
	echo "Errore di query";
	exit();
}
else{
	$connect->close();
}

?>

