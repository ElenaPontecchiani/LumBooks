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
		case 'searchBook':
			echo json_encode(backend::searchBook($_POST['titolo'],
												 $_POST['autore'],
												 $_POST['isbn'],
												 $_POST['corso'],
												 $_POST['ordine']));
		break;
		case 'getTitles':
			echo json_encode(backend::getTitles());
		break;
		case 'searchBook':
			echo json_encode(backend::Register(	$_POST['email'],
												$_POST['password'],
												$_POST['matricola'],
												$_POST['nome'],
												$_POST['cognome'],
												$_POST['username'],
												$_POST['sesso'],
												$_POST['dataNascita']));
		break;
		case 'checkEmail':
			echo json_encode(backend::checkField($_POST['email'],'Email'));
		break;
		case 'checkUsername':
			echo json_encode(backend::checkField($_POST['username'],'Username'));
		break;
		case 'getTitles':
			echo json_encode(backend::getTitles());
		break;
		default:
			exit;
	}
}
else
{
	echo "Richiesta Malformata";
}

?>

