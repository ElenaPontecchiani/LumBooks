<?php
require_once "Backend/htmlMaker.php";
require_once "Backend/sql_wrapper.php";
if(sqlWrap::isAdmin()){
      $output = file_get_contents("../HTML/admin.html");
      $libri = htmlMaker::searchItemWithButtons(SqlWrap::query("SELECT * FROM Libri_Listati;"),array("Elimina"));
      echo str_replace("<nav></nav>",htmlMaker::navbar(),
            str_replace('<dl class="search_item"></dl>',$libri,
            str_replace("<header></header>",htmlMaker::header(),
                  $output)));
}
else{
      echo "Devi essere un ammistratore";
}

?>
