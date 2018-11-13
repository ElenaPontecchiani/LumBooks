<?php
require_once "Backend/htmlMaker.php";
$output = file_get_contents("../HTML/home.html");
echo str_replace("<nav></nav>",htmlMaker::navbar(),
     str_replace("<header></header>",htmlMaker::header(),
     str_replace("<footer></footer>",htmlMaker::footer(),
                 $output)));
?>
