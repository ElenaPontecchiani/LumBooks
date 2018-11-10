<?php
include "Backend/back_end.php";
include "phpConnect.php";
    $mail = $_POST["email"];
    $mat = $_POST["matricola"];
    $name = $_POST["nome"];
    $fname = $_POST["cognome"];
    $user = $_POST["user"];
    $sex = $_POST["sesso"];
    $bdate = $_POST["nascita"];
    $pw = $_POST["password"];


    if(backend::registerIsValid($mail, $mat, $name, $fname, $user, $sex, $bdate, $pw))
    {
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

      if ($connect->query($sql) === TRUE)
      {
        header("Location: login.php");
      } else
      {
          header("Location: registrati.php");
          error_log("Error: " . $sql . ": " . $connect->error);
      }
    }else
    {
      //header("Location: registrati.php");
      error_log("parametri per la registrazione non corretti");
    }


?>
