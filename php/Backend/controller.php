<?php
//Includo la classe con i metodi da eseguire
require_once 'back_end.php';

if(isset($_POST['command']))
{
	switch($_POST['command']) {
        case 'Login':
            echo json_encode(backend::checkPassword($_POST['email'],$_POST['password']));
		break;
		case 'getSession':
			echo json_encode(backend::getSessionData());
		break;
		case 'searchBook'
			echo json_encode(backend::searchBook($_POST['titolo'],
												 $_POST['autore'],
												 $_POST['isbn'],
												 $_POST['corso'],
												 $_POST['ordine']));
		break;

		default:
			exit;
	}
}
else
{
	echo "Richiesta Malformata";
}



/*
command: searchBook

jQuery 2 Php: 
	String titolo
	String autore
	string isbn
	String corso
	int ordine // 1 = dal più caro, 2 = dal meno caro, 0 = a caso
	(almeno un campo deve essere non null)

php 2 jQuery:
	una lista di libri possibilmente vuota:
	String titolo
	String autore
	int prezzo
	String isbn


*/

?>