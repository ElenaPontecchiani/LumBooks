<?php
require_once "Backend/sql_wrapper.php";
require_once "Backend/htmlMaker.php";
try{
    if (isset($_POST['Venduto'])) {
        sqlWrap::input_escape(array($_POST['Venduto']));
        session_start();
        $user = sqlWrap::query("SELECT Venditore FROM Libri_In_Vendita WHERE md5_Hash = '{$_POST['Venduto']}'",true)[0];
        if ($_SESSION['id'] = $user) {
            sqlWrap::command("UPDATE Libri_In_Vendita SET Stato ='Venduto' WHERE md5_Hash = '{$_POST['Venduto']}'");
            header('Location: libri_personali.php');
            die();
        }
    }

    else if (isset($_POST['Rimuovi'])) {
        sqlWrap::input_escape(array($_POST['Rimuovi']));
        session_start();
        $user = sqlWrap::query("SELECT Venditore FROM Libri_In_Vendita WHERE md5_Hash = '{$_POST['Rimuovi']}'",true)[0];
        if ($_SESSION['id'] = $user) {
            sqlWrap::command("DELETE FROM Libri_In_Vendita WHERE md5_Hash = '{$_POST['Rimuovi']}'");
            header('Location: libri_personali.php');
            die();
        }
    }

    else if (isset($_POST['Modifica'])) {
        sqlWrap::input_escape(array($_POST['Modifica']));
        session_start();
        $user = sqlWrap::query("SELECT Venditore FROM Libri_In_Vendita WHERE md5_Hash = '{$_POST['Modifica']}'",true)[0];
        if ($_SESSION['id'] = $user) {
            $book_data = sqlWrap::query("SELECT * FROM Libri_In_Vendita WHERE md5_Hash = '{$_POST['Modifica']}'")[0];
            if ($book_data['Anno_Pubblicazione'] == '0')
                $book_data['Anno_Pubblicazione'] = '';
            $output = file_get_contents("../HTML/modifica.html");
            echo str_replace("<nav></nav>",htmlMaker::navbar(),
                str_replace("<header></header>",htmlMaker::header(),
                str_replace("<breadcrumb></breadcrumb>",htmlMaker::breadCrumb("I miei libri","Modifica"),
                str_replace("££TITOLO££",$book_data['Titolo'],
                str_replace("££AUTORE££",$book_data['Autore'],
                str_replace("££EDITORE££",$book_data['Casa_Editrice'],
                str_replace("££ISBN££",$book_data['ISBN'],
                str_replace("££ANNO££",$book_data['Anno_Pubblicazione'],
                str_replace("££CORSO££",$book_data['Corso'],
                str_replace("££PREZZO££",$book_data['Prezzo'],
                str_replace("££EDIZIONE££",$book_data['Edizione'],
                str_replace("££HASH££",$_POST['Modifica'],
                            $output))))))))))));
        }
    }

    else if (isset($_POST['Elimina'])) {
        sqlWrap::input_escape(array($_POST['Elimina']));
        session_start();
        if(sqlWrap::isAdmin()) {
            sqlWrap::command("DELETE FROM Libri_Listati WHERE Codice_Identificativo = {$_POST['Elimina']}");
        }
        header('Location: admin.php');
        die();
    }
}catch (Exception $e) {
    echo 'Errore: ',  $e->getMessage(), "\n";
}

?>