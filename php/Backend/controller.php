<?php
//Includo la classe con i metodi da eseguire
//include("back_end.php");
class backend{

	//Controlla l'hash della password inserita con l'hash nel database.
	//Se corrispondono, ritorno 1, 0 altrimenti.
	public static function checkPassword($email, $password){
    
	    //Controllo validità variabili
	    if(!(isset($email) and isset($password))){
		return array(
				    "password_ok" => false,
				    "error" => "Richiesta incompleta"
			    );
	    }
    
	    //includo la connessione al database
	    include "../phpConnect.php";
    
	    if(!$result = $connect->query("SELECT * FROM Utente WHERE Email = '$email'")){
		//errore di query
		return array(
				    "password_ok" => false,
				    "error" => "Errore di query"
			    );
		    }
	    
	    $connect->close();
    
		if($result->num_rows > 0){
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$dbhash = $row["Pw_Hash"];
			if (password_verify($password, $dbhash)) {
				return array(
				"password_ok" => true,
				"error" => ""
				);
			}
				    }
	    return array(
		"password_ok" => false,
		"error" => "password e/o mail sbagliata"
	    );
	}
    
    }

if(isset($_POST['command']))
{
	switch($_POST['command']) {
        case 'Login':        
                echo json_encode(backend::checkPassword($_POST['email'],$_POST['password']));
		break;

		default:
			exit;
	}
}
else
{
	echo "Richiesta Malformata";
}
