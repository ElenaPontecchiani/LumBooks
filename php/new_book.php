<?php
include "/Backend/sql_wrapper.php";

/*  INSERIMENTO DELLE VARIABILI DALLA POST
    E CONSEGUENTE VALIDAZIONE
*/

//QUA DEVO ALMENO VALIDARE I CAMPI CHE VANNO INSERITI IN ENTRAMBI I CASI



//NELLE QUERY DEVO METTERE ASSOLUTAMENTE GLI ATTRIVUTI CON IL LORO NOME DA DATABASE
$dati = [];
if (isset($_POST['precomp']))
    if($_POST['precomp'] == "Si" && $libro_da_catalogo){
        //caso precompilato
        $dati = SqlWrapper::query(" SELECT Titolo, Autore, Casa_Editrice,Corso, Codice_identificativo
                                    FROM Libri_Listati
                                    WHERE Titolo = $libro_da_catalogo",true);
    }
    else if(($_POST['precomp'] == "No")){
        //caso non precompilato
        $dati = array(  "Titolo" => $titolo
                        "Autore" => $autore
                        "Casa_Editrice" => $casa_editrice
                        "Corso" => $corso);
    }
    else
        throw Exception("Richiesta Malformata");
}

$dati = $dati + array(  "Stato" => $stato
                        "Edizione" => $edizione
                        "AnnoPub" => $annopub
                        "ISBN" => $isbn
                        "Prezzo" => $prezzo);


$insert = "INSERT INTO Libri_Listati(";
$par1 = "";
$par2 = "";
$keys = array_keys($dati);
foreach($keys as $key){
    $par1 .= $key.",";
    $par2 .= $dati[$key].","; //problema: virgole alla fine
}
//risolvibile forse mettendo in più l'id come null

$insert .= $par1.") VALUES(\"".$par2.");"
SqlWrapper::Command($insert);

echo "libro inserito con successo";

?>