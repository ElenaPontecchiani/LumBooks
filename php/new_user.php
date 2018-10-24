<?php
include "phpConnect.php";
    $mail = $_POST["email"];
    $mat = $_POST["matricola"];
    $name = $_POST["nome"];
    $fname = $_POST["cognome"];
    $user = $_POST["user"];
    $sex = $_POST["sesso"];
    $bdate = $_POST["nascita"];
    $pw = $_POST["password"];
    
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
        echo "Nuovo utente creato con successo";
    } else {
        echo "Error: " . $sql . "<br>" . $connect->error;
    }
?>