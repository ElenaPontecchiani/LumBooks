<?php
require_once "Backend/sql_wrapper.php";
require_once "Backend/htmlMaker.php";
include "Backend/validator.php";
require_once "image_up.php";
$mail = $_POST["email"];
$name = $_POST["nome"];
$fname = $_POST["cognome"];
$sex = $_POST["sesso"];
$bdate = $_POST["nascita"];
$pw = $_POST["password"];
$cel = $_POST["cel"];


//DA VALIDARE TUTTI I CAMPI
try{
  $errore = "--val--";
  sqlWrap::input_escape(array(&$mail,&$name,&$fname,&$sex,&$bdate,&$pw,&$cel));
  if(!preg_match("/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/",$mail))
    $errore .= "<p>eMail non conforme</p>";
  if(!preg_match("/^[a-zA-Z]{3,16}$/",$name))
    $errore .= "<p>Nome non conforme</p>";
  if(!preg_match("/^[a-zA-Z]{3,16}$/",$fname))
    $errore .= "<p>Cognome non conforme</p>";
  if(!preg_match("/^(M|F|N){1}$/",$sex))
    $errore .= "<p>Sesso non conforme</p>";
  if(!Validator::validateDate($bdate))
    $errore .= "<p>Data di nascita non conforme$bdate</p>";
  if(!preg_match("/^(?=.*[0-9])(?=.*[a-z])[a-zA-Z0-9!.@#$%^&*]{6,16}$/",$pw))
    $errore .= "<p>Password non conforme</p>";
  if(!preg_match("/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/",$cel))
    $errore .= "<p>Numero non conforme</p>";

  if($errore != "--val--")
    throw new Exception($errore);
      

  $pw = password_hash("$pw", PASSWORD_DEFAULT);
  $sql =  "INSERT INTO Utente
          VALUES( NULL,
                  '$name',
                  '$fname',
                  '$sex',
                  '$bdate',
                  '$pw',
                  '$mail',
                  '$cel');";

  sqlWrap::command($sql);
  

  caricaImmagine($mail,"../immagini_profilo/");
  echo htmlMaker::pagina_messaggio("Fantastico!","La tua iscrizione è avvenuta con successo. Tra qualche secondo ti mando alla Home.");
  $_SESSION['id'] = sqlWrap::query("SELECT Codice_identificativo as ID FROM Utente WHERE Email='$mail'")[0]['ID'];
  $_SESSION['nome'] = $name;
  $_SESSION['cogn'] = $fname;
  $_SESSION['sesso'] = $sex;
  $_SESSION['bdate'] = $bdate;
  $_SESSION['email'] = $mail;
  $_SESSION['numero'] = $cel;
  $_SESSION['login'] = true;
  header( "refresh:4; url=home.php" ); 
}
catch(Exception $e){
  $optional = null;
  if (preg_match("/^(--val--){1}/", "{$e->getMessage()}"))
    $optional = str_replace("--val--","",$e->getMessage());
  echo htmlMaker::pagina_messaggio("Staccah staccaaahh!","Siamo stati tracciati, pertanto non abbiamo potuto portare a termine la registrazione.",$optional);
  header( "refresh:5; url=registrati.php" ); 
}
?>
