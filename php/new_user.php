<?php
require_once "Backend/sql_wrapper.php";
require_once "Backend/back_end.php";
$mail = $_POST["email"];
$mat = $_POST["matricola"];
$name = $_POST["nome"];
$fname = $_POST["cognome"];
$user = $_POST["user"];
$sex = $_POST["sesso"];
$bdate = $_POST["nascita"];
$pw = $_POST["password"];


//DA VALIDARE TUTTI I CAMPI


/*if(backend::registerIsValid($mail, $mat, $name, $fname, $user, $sex, $bdate, $pw))
{*/
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

  sqlWrap::command($sql);
//}


?>
