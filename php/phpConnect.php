<html lang="it">
<head>
    <meta charset="UTF-8">
	<title>LumBooks</title>
	<link rel="icon" href=""/> <!-- link icona -->
	<meta name="title" content="LumBooks" />
	<meta name="description" content="Acquista e vendi libri" /> <!-- da fare -->
	<meta name="keywords" content="libro, unipd" /> <!-- da fare -->
	<meta name="language" content="italian it" />
	<meta name="author" content="" /> <!-- da fare -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../css/style.css" /> <!-- da fare -->
  <link rel="stylesheet" type="text/css"  href="../css/" media="screen and (max-width:768px)" /> <!-- schermi piccoli --> <!-- da fare -->
  <link rel="stylesheet" type="text/css" href="../css/" media="print" /> <!-- da fare -->
</head>
<body>

<h3>Welcome to the PHP Connect Test</h3>

<?php
$dbname = 'LB';
$dbuser = 'admin';
$dbpass = 'admin';
$dbhost = 'localhost';
$connect = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if($connect->connect_errno){
	echo "lol";
	exit();
}
if(!$result = $connect->query("SELECT * FROM Libri_Listati")){
	echo "Errore di query";
	exit();
}
else{
	$connect->close();
}
if($result->num_rows > 0){
	while($row = $result->fetch_array(MYSQLI_ASSOC)){
		$str = "<p>".$row['Titolo']." | ".$row['Autore']." | ".$row['Casa_Editrice']." | ".$row['Corso']."</p>";
		$str = mb_convert_encoding($str, "utf-8", "auto");
		echo $str;
	}
	$result->free();
}

?>

</body>
</html>
