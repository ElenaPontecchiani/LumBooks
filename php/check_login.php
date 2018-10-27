<?php
		include "phpConnect.php";
		$mail = $_POST["mail"];
		$passw = $_POST["password"];
		$_POST["password"] = "";
        
        if(!$result = $connect->query("SELECT * FROM Utente WHERE Email = '$mail'")){
			echo "Errore di query";
			exit();
		}
		else{
			$connect->close();
		}
		if($result->num_rows > 0){
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$dbhash = $row["Pw_Hash"];
            if (password_verify($passw, $dbhash)) {
                echo 'Tutto apposto zio';
            } 
            else {
                echo 'Qualcuno vuole fare il furbetto';
}	
		}
        else{
        	echo "Email non trovata vezz";
        }
		$result->free();
		session_start();
		$_SESSION["user"] = $row["Username"];
        
	?>
