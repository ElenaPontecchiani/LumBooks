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

		default:
			exit;
	}
}
else
{
	echo "Richiesta Malformata";
}
?>
