<?php
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
            
            session_start();
            $_SESSION['id'] = $row['Codice_identificativo'];
            $_SESSION['mat'] = $row['Matricola'];
            $_SESSION['nome'] = $row['Nome'];
            $_SESSION['cogn'] = $row['Cognome'];
            $_SESSION['sesso'] = $row['Sesso'];
            $_SESSION['bdate'] = $row['Data_di_nascita'];
            $_SESSION['user'] = $row['Username'];
            $_SESSION['email'] = $row['Email'];

            if (password_verify($password, $dbhash)) {
                return array(
                    "password_ok" => true,
                    "error" => ""
                );
            }
        }
        return array(
            "password_ok" => false,
            "error" => "Password o email sbagliata. Stacca, stacaaahhhh!!!"
        );
    }

    public static function getSessionData(){
        session_start();
        if (!isset($_SESSION['id']))
        return array(
            "sessionOpen" => false,
			"id" => "",
			"matricola" => "",
			"nome" => "",
			"cognome" => "",
			"sesso" => "",
			"data_nascita" => "",
            "username" => "",
            "email" => ""	
        );
    return array(
        "sessionOpen" => true,
        "id" => $_SESSION['id'],
        "matricola" => $_SESSION['mat'],
        "nome" => $_SESSION['nome'],
        "cognome" => $_SESSION['cogn'],
        "sesso" => $_SESSION['sesso'],
        "data_nascita" => $_SESSION['bdate'],
        "username" => $_SESSION['user'],
        "email" => $_SESSION['email']	
    );
    }

}
?>
