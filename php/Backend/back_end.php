<?php
class backend{

    //Controlla l'hash della password inserita con l'hash nel database.
    //Se corrispondono, ritorno 1, 0 altrimenti.


    //IMPLEMENTATO NEL FILE DI check_login-php
    /*public static function checkPassword($email, $password){

        //Controllo validità variabili
        if(!(isset($email) and isset($password))){
            return array(
				"password_ok" => false,
				"error" => "Richiesta incompleta"
			);
        }

        //includo la connessione al database
        include "../phpConnect.php";

        //escape dell'input
        $email = $connect->escape_string($email);
        $password = $connect->escape_string($password);

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
    */

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

  public static function searchBook($titolo,$autore,$isbn,$corso,$ordine){
      include "../phpConnect.php";

      if( $titolo == "" and
          $autore == "" and
          $isbn == null and
          $corso == "" and
          $ordine == "")
          return array("error" => "Richiesta vuota");

      //escape dell'input
      $titolo = $connect->escape_string($titolo);
      $autore = $connect->escape_string($autore);
      $isbn = $connect->escape_string($isbn);
      $corso = $connect->escape_string($corso);
      $ordine = $connect->escape_string($ordine);



      //INZIO COMPOSIZIONE DELLA QUERY"
      $query = "  SELECT Titolo,Autore,Prezzo,ISBN
                  FROM Libri_In_Vendita WHERE 1=1 ";

      if (!$titolo == "")
          $query.= " AND Titolo like '%$titolo%'";
      if (!$autore == "")
          $query.= " AND Autore like '%$autore%'";
      if (!$isbn == null)
          $query.= " AND ISBN = $isbn";
      if (!$corso == "")
          $query.= " AND Corso like '%$corso%'";
      $query .= " AND 1 = 1 ";

      if($ordine > 0)//ordine crescente o decrescente
      {
          $query .= " ORDER BY Prezzo ";
          if($ordine == 1) //dal più caro
              $query .= "DESC";
      }

      $query .= ";";
      //FINE COMPOSIZIONE DELLA QUERY

	if(!$result = $connect->query($query)){
		return array("error" => "Errore di query");
		exit();
	}
	else{
		$connect->close();
      }
      $lista_titolo = [];
      $lista_autore = [];
      $lista_prezzo = [];
      $lista_isbn   = [];
	if($result->num_rows > 0){
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			array_push($lista_titolo,$row['Titolo']);
              array_push($lista_autore,$row['Autore']);
              array_push($lista_prezzo,$row['Prezzo']);
              array_push($lista_isbn  ,$row['ISBN']);
		}
          $result->free();
          /*print_r($lista_titolo);
          print_r($lista_autore);     PER TEST
          print_r($lista_prezzo);
          print_r($lista_isbn);*/

          return array("error" => "",
                      "titolo" => $lista_titolo,
                      "autore" => $lista_autore,
                      "prezzo" => $lista_prezzo,
                      "isbn"   => $lista_isbn);
      }
      else{
          return array("error" => "Nessun risultato",
                      "titolo" => $lista_titolo,
                      "autore" => $lista_autore,
                      "prezzo" => $lista_prezzo,
                      "isbn"   => $lista_isbn);
      }

  }

  public static function getTitles(){
      include "../phpConnect.php";
      if(!$result = $connect->query("SELECT Titolo FROM Libri_Listati")){
          return array("error" => "Errore di query");
          exit();
      }
      else{
          $connect->close();
      }

      $lista_titolo = [];
      if($result->num_rows > 0){
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			array_push($lista_titolo,$row['Titolo']);
          }
          $result->free();
          return array("error" => "",
                      "titoli" => $lista_titolo);
      }

      else
          return array("error" => "Query vuota");
  }

  public static function Register($mail,$pw,$mat,$name,$fname,$user,$sex,$bdate){
      include "../phpConnect.php";

      //escape dell'input
      $mail = $connect->escape_string($mail);
      $pw = $connect->escape_string($pw);
      $mat = $connect->escape_string($mat);
      $name = $connect->escape_string($name);
      $fname = $connect->escape_string($fname);
      $user = $connect->escape_string($user);
      $sex = $connect->escape_string($sex);
      $bdate = $connect->escape_string($bdate);


      $pw = password_hash("$pw", PASSWORD_DEFAULT);

      $sql =  "INSERT INTO Utente
              VALUES( NULL,
                      '$mat',
                      '$name',
                      '$fname',
                      '$sex',
                      '$bdate',
                      '$user',
                      '$pw',
                      '$mail');";

      if ($connect->query($sql) === TRUE) {
          return array("successo" => true,
                        "error" => "");
      } else {
          /*echo "Error: " . $sql . "<br>" . $connect->error;*/
          return array("successo" => false,
                        "error" => "$connect->error;");
      }
  }

  public static function checkField($value,$field){
      include "../phpConnect.php";

      //escape dell'input
      $value = $connect->escape_string($value);

      if(!$result = $connect->query("SELECT $field FROM Utente WHERE $field ='$value'")){
          return array("errore" => "Errore di query");
          exit();
      }
      else{
          $connect->close();
      }

      if($result->num_rows > 0){
          echo "presente";
          return array(   "alreadyExist" => true,
                          "errore" => "");
      }
      else{
          echo "Assente";
          return array(   "alreadyExist" => false,
                          "errore" => "");
      }
  }

  public static function loginIsValid($mail, $password)
  {
    $valid = true;
    if(strlen($password)<3)
      $valid = false;
    $username = substr($mail,0, strpos($mail, '@'));
    $mail_f = substr($mail,strpos($mail, '@'), strlen($mail));
    if(strlen($username) < 3)
      $valid = false;
    return $valid;
  }

  public static function registerIsValid($mail,$matricola,$nome, $cognome, $user, $sex, $nascita, $password){
    $valid = self::loginIsValid($mail, $password);
    if($valid)
    {
      if(strlen($matricola) > 9 || strlen($nome) > 12 || strlen($cognome) > 12 || strlen($user) > 12 )
      {
        $valid = false;
      }
    }
    return $valid;
  }
}


?>
