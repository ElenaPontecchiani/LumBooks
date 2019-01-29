<?php
try{
	require_once "Backend/sql_wrapper.php";
	require_once "Backend/back_end.php";
	$mail = $_POST["mail"];
	$passw = $_POST["password"];
	$_POST["password"] = "";

	SqlWrap::input_escape(array($mail,$passw));

	if(backend::loginIsValid($mail, $passw) && !$result = SqlWrap::query("SELECT * FROM Utente WHERE Email = '$mail'"))
	{
		header("Location: login.php"); // facciamo finta che non sia successo niente :)
		exit();
	}

	if(count($result)>0)
	{
		$row = $result[0];
		$dbhash = $row["Pw_Hash"];
		if (password_verify($passw, $dbhash))
		{
			if(!isset($_SESSION))
				session_start();
			$_SESSION['id'] = $row['Codice_identificativo'];
			$_SESSION['nome'] = $row['Nome'];
			$_SESSION['cogn'] = $row['Cognome'];
			$_SESSION['sesso'] = $row['Sesso'];
			$_SESSION['bdate'] = $row['Data_di_nascita'];
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
}
catch(Exception $e){
	echo htmlMaker::pagina_messaggio("Operazione non riuscita!","Purtroppo i poteri forti non vogliono farti loggare al nostro sito. Riprova, dai");
	header( "refresh:5; url=login.php" ); 
}
?>
