<?php
		include "phpConnect.php";
		include "/Backend/back_end.php";
		$mail = $_POST["mail"];
		$passw = $_POST["password"];
		$_POST["password"] = "";

		//escape dell'input
    $mail = $connect->escape_string($mail);
    $passw = $connect->escape_string($passw);

  	if(backend::loginIsValid($mail, $passw) && !$result = $connect->query("SELECT * FROM Utente WHERE Email = '$mail'"))
		{
			header("Location: login.php"); // facciamo finta che non sia successo niente :)
			exit();
		}
		else
		{
			$connect->close();
		}
		if($result->num_rows > 0)
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$dbhash = $row["Pw_Hash"];
	    if (password_verify($passw, $dbhash))
			{
				if(!isset($_SESSION))
		      session_start();
				$_SESSION['id'] = $row['Codice_identificativo'];
				$_SESSION['mat'] = $row['Matricola'];
				$_SESSION['nome'] = $row['Nome'];
				$_SESSION['cogn'] = $row['Cognome'];
				$_SESSION['sesso'] = $row['Sesso'];
				$_SESSION['bdate'] = $row['Data_di_nascita'];
				$_SESSION['user'] = $row['Username'];
				$_SESSION['email'] = $row['Email'];
				$_SESSION['login'] = true;
				header("Location: home.php");
			}else
			{
					if(!isset($_SESSION))
			      session_start();
					$_SESSION['login'] = false;
	        header("Location: login.php");
			}
		}else
		{
				if(!isset($_SESSION))
		      session_start();
				$_SESSION['login'] = false;
        header("Location: login.php");
		}
		$result->free();
	?>
