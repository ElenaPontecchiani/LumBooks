<?php
require_once "Backend/htmlMaker.php";
require_once "Backend/sql_wrapper.php";
if(sqlWrap::isAdmin()) {
      $output = file_get_contents("../HTML/admin.html");
      $libri = htmlMaker::generateBookCollection(SqlWrap::query("SELECT * FROM Libri_Listati;"),array("Elimina"));
      echo str_replace("<nav></nav>",htmlMaker::navbar(),
            str_replace('<dl class="search_item"></dl>',$libri,
            str_replace("<header></header>",htmlMaker::header(),
            str_replace("<breadcrumb></breadcrumb>",htmlMaker::breadCrumb("Pannello Amministratore"),
                  $output))));
}
else{
      echo htmlMaker::pagina_messaggio("Ops, non dovresti essere qui","Questa pagina è riservata agli amministratori del sito");
}

?>
