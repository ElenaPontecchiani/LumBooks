<?php
require_once "Backend/sql_wrapper.php";
require_once "Backend/back_end.php";
require_once "Backend/htmlMaker.php";
$mail = $_POST["email"];
$name = $_POST["nome"];
$fname = $_POST["cognome"];
$sex = $_POST["sesso"];
$bdate = $_POST["nascita"];
$pw = $_POST["password"];


//DA VALIDARE TUTTI I CAMPI


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

echo htmlMaker::pagina_messaggio("Fantastico!","La tua iscrizione è avvenuta con successo");


?>
