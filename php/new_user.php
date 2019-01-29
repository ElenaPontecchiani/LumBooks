<?php
require_once "Backend/sql_wrapper.php";
require_once "Backend/back_end.php";
require_once "Backend/htmlMaker.php";
require_once "image_up.php";
$mail = $_POST["email"];
$name = $_POST["nome"];
$fname = $_POST["cognome"];
$sex = $_POST["sesso"];
$bdate = $_POST["nascita"];
$pw = $_POST["password"];


//DA VALIDARE TUTTI I CAMPI
try{
  /*if(backend::registerIsValid($mail, $name, $fname, $sex, $bdate, $pw))
  {*/
    
    $pw = password_hash("$pw", PASSWORD_DEFAULT);
    $sql =  "INSERT INTO Utente
            VALUES( NULL,
                    '$name',
                    '$fname',
                    '$sex',
                    '$bdate',
                    '$pw',
                    '$mail');";

    sqlWrap::command($sql);
  //}
  caricaImmagine($mail,"../immagini_profilo/");
  echo htmlMaker::pagina_messaggio("Fantastico!","La tua iscrizione è avvenuta con successo. Tra qualche secondo ti mando alla Home.");
  $_SESSION['id'] = sqlWrap::query("SELECT Codice_identificativo as ID FROM Utente WHERE Email='$mail'")[0]['ID'];
  $_SESSION['nome'] = $name;
  $_SESSION['cogn'] = $fname;
  $_SESSION['sesso'] = $sex;
  $_SESSION['bdate'] = $bdate;
  $_SESSION['email'] = $mail;
  $_SESSION['login'] = true;
  header( "refresh:4; url=home.php" ); 
}
catch(Exception $e){
  echo htmlMaker::pagina_messaggio("Staccah staccaaahh!","Siamo stati tracciati, pertanto non abbiamo potuto portare a termine la registrazione.");
  header( "refresh:5; url=registrati.php" ); 
}
?>
