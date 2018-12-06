<?php
require_once "Backend/sql_wrapper.php";

if (isset($_POST['Venduto'])){
    sqlWrap::input_escape(array($_POST['Venduto']));
    session_start();
    $user = sqlWrap::query("SELECT Venditore FROM Libri_In_Vendita WHERE md5_Hash = '{$_POST['Venduto']}'",true)[0];
    if ($_SESSION['id'] = $user){
        sqlWrap::command("UPDATE Libri_In_Vendita SET Stato ='Venduto' WHERE md5_Hash = '{$_POST['Venduto']}'");
        header('Location: utente.php');
        die();
    }
}

    if (isset($_POST['Rimuovi'])){
        echo "lol";
        sqlWrap::input_escape(array($_POST['Rimuovi']));
        session_start();
        $user = sqlWrap::query("SELECT Venditore FROM Libri_In_Vendita WHERE md5_Hash = '{$_POST['Rimuovi']}'",true)[0];
        if ($_SESSION['id'] = $user){
            sqlWrap::command("DELETE FROM Libri_In_Vendita WHERE md5_Hash = '{$_POST['Rimuovi']}'");
            header('Location: utente.php');
            die();
        }
    }

?>