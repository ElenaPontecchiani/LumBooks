<?php
//Includo la classe con i metodi da eseguire
require_once("back_end.php");

if(isset($_POST['command']))
{
	switch($_POST['command']) {
        case 'Login':
            $pwOk = back_end::checkPassword($_POST['email'],$_POST['password']);
            if($pwOk){
                echo "1";
            }
            else{
                echo "0";
            }
		break;

		default:
			exit;
	}
}
else
{
	echo "Richiesta Malformata";
}
