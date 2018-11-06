<?php
		include "phpConnect.php";
		$mail = $_POST["mail"];
		$passw = $_POST["password"];
		$_POST["password"] = "";

		//escape dell'input
        $mail = $connect->escape_string($mail);
        $passw = $connect->escape_string($passw);
        
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
				
				session_start();
				$_SESSION['id'] = $row['Codice_identificativo'];
				$_SESSION['mat'] = $row['Matricola'];
				$_SESSION['nome'] = $row['Nome'];
				$_SESSION['cogn'] = $row['Cognome'];
				$_SESSION['sesso'] = $row['Sesso'];
				$_SESSION['bdate'] = $row['Data_di_nascita'];
				$_SESSION['user'] = $row['Username'];
				$_SESSION['email'] = $row['Email'];
				header("Location: home.php");
            } 
            else {
                echo 'Qualcuno vuole fare il furbetto';
}	
		}
        else{
        	echo "Email non trovata vezz";
        }
		$result->free();       
	?>
