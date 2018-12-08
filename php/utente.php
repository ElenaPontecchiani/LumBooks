<?php
require_once "Backend/htmlMaker.php";
require_once "Backend/sql_wrapper.php";

session_start();
$in_vendita = sqlWrap::query(" SELECT Titolo,Prezzo,Data_Aggiunta as 'Aggiunto il',md5_Hash
                            FROM Libri_In_Vendita
                            WHERE Venditore = {$_SESSION['id']}
                            AND Stato = \"In Vendita\"");
if ($in_vendita == null)
    $in_vendita = "Nessun libro in vendita al momento";
else
    $in_vendita = htmlMaker::searchItemWithButtons($in_vendita,array("Venduto","Rimuovi","Modifica"));

$venduti = sqlWrap::query(" SELECT Titolo,Prezzo,/*CONCAT(Nome,' ',Cognome) as Acquirente,*/Data_Aggiunta as 'Aggiunto il',md5_Hash
                            FROM Libri_In_Vendita /*as liv JOIN Utente as u*/
                            /*ON u.Codice_identificativo = liv.Acquirente*/
                            WHERE Venditore = {$_SESSION['id']}
                            AND Stato = 'Venduto'");
if ($venduti == null)
    $venduti = "Non hai venduto nessun libro";
else
    $venduti = htmlMaker::searchItemWithButtons($venduti,array("Rimuovi"));

$comprati = sqlWrap::query("SELECT Titolo,Prezzo,CONCAT(Nome,' ',Cognome) as Venditore,Data_Aggiunta as 'Aggiunto il',md5_Hash
                            FROM Libri_In_Vendita as liv JOIN Utente as u
                            ON u.Codice_identificativo = liv.Venditore
                            WHERE Acquirente = {$_SESSION['id']}
                            AND Stato = 'Venduto'");
if ($comprati == null)
    $comprati = "Non hai comprato nessun libro";
else
    $comprati = htmlMaker::searchItem($comprati);


$output = file_get_contents("../HTML/utente.html");
echo str_replace("<nav></nav>",htmlMaker::navbar(),
     str_replace("<header></header>",htmlMaker::header(),
     str_replace("<footer></footer>",htmlMaker::footer(),
     str_replace("<invendita>",$in_vendita,
     str_replace("<venduti>",$venduti,
     str_replace("<acquistati>",$comprati,
     str_replace("££nome££",$_SESSION['nome'],
     str_replace("££cognome££",$_SESSION['cogn'],
     str_replace("££datanascita££",$_SESSION['bdate'],
     str_replace("££mail££",$_SESSION['email'],
                 $output))))))))));



?>