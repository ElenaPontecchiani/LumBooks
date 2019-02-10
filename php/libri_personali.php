<?php
require_once "Backend/htmlMaker.php";
require_once "Backend/sql_wrapper.php";

session_start();
$in_vendita = sqlWrap::query(" SELECT Titolo,Prezzo,Data_Aggiunta as 'Aggiunto il',md5_Hash
                            FROM Libri_In_Vendita
                            WHERE Venditore = {$_SESSION['id']}
                            AND Stato = \"In Vendita\"");
$in_vendita = (!$in_vendita) ? "Nessun libro in vendita al momento" : htmlMaker::generateBookCollection($in_vendita,array("Venduto","Rimuovi","Modifica"));

$venduti = sqlWrap::query(" SELECT Titolo,Prezzo,/*CONCAT(Nome,' ',Cognome) as Acquirente,*/Data_Aggiunta as 'Aggiunto il',md5_Hash
                            FROM Libri_In_Vendita /*as liv JOIN Utente as u*/
                            /*ON u.Codice_identificativo = liv.Acquirente*/
                            WHERE Venditore = {$_SESSION['id']}
                            AND Stato = 'Venduto'");
$venduti = (!$venduti) ? "Non hai venduto nessun libro" : htmlMaker::generateBookCollection($venduti,array("Rimuovi"));

$output = file_get_contents("../HTML/libri_personali.html");
echo str_replace("<nav></nav>",htmlMaker::navbar(),
     str_replace("<header></header>",htmlMaker::header(),
     str_replace("<invendita>",$in_vendita,
     str_replace("<venduti>",$venduti,
     str_replace("<acquistati>",$comprati,
     str_replace("<breadcrumb></breadcrumb>",htmlMaker::breadCrumb("I miei libri"),
     
                 $output))))));

?>