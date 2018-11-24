<?php
class Validator{
    public static function lengthVal($min, $max, ...$str){
        $val = true;
        foreach($str as $s){
            if (!(strlen($s) >= $min && strlen($s) <= $max)){
                $val = false;
                break;
            }
        }
        return $val;
    }

    public static function registerVal($scelta_list, $titolo, $autore, $casa_editrice, $corso, $edizione, $annopub, $isbn, $prezzo, $libro_catalogo){
        require_once "Backend/sql_wrapper.php";
        //Escape di tutti gli input
        //Tutti insieme per minimiazzare accesso al db
        SqlWrap::input_escape(array(  &$scelta_list,&$titolo,&$autore,&$casa_editrice,
                                        &$corso,&$edizione,&$annopub,&$isbn,
                                        &$prezzo,&$libro_catalogo));

        //A seconda della scelta dell'utente (listato vs libero), controllo solo
        //i campi necessari
        if ($scelta_list == "listato"){
            $scelta_list = true;
            if(!Validator::lengthVal(3,50,$libro_catalogo))
                throw new Exception("Lunghezza libro da catalogo errata");
        }
        else{
            $scelta_list = false;
            if(!Validator::lengthVal(3,50,$titolo,$autore,$corso,$casa_editrice))
                throw new Exception("Lunghezze sbagliate o campi vuoti");
        }

        //Annopub può essere null oppure un anno valido
        if ($annopub != "" &&
            (!filter_var($annopub, FILTER_VALIDATE_INT, array("options" => array("min_range"=>1900, "max_range"=>2100)))))
            throw new Exception("Anno non valido");

        //Saranno necessari controlli per stabilire che valore di edizione sia corretto
        #############################################################################
        if((!Validator::lengthVal(3,20,$edizione)) && $edizione != "")
            throw new Exception("Edizione non valida");

        //Validazione anno di pubblicazione
        if  (( (!(filter_var($annopub, FILTER_VALIDATE_INT))) || strlen($isbn) != 13) && $annopub != "")
            throw new Exception("ISBN non valido");

        //Validazione del prezzo
        $prezzo = str_replace(",",".",$prezzo);
        $pattern = '/^\d+(?:\.\d{2})?$/';
        if (!preg_match($pattern, $prezzo)) {
            throw new Exception("Prezzo non valido");
        }
    }

    public static function ricercaValidation(&$titolo, &$autore, &$isbn, &$corso){
      if(strlen($titolo)>50)
        $titolo = substr($titolo,0,50);
      if(strlen($autore)>50)
        $autore = substr($titolo,0,50);
      str_replace("-","",$isbn);
      if(strlen($isbn) != 13 && strlen($isbn) != 0)
        $isbn = "error";
      if(strlen($corso)>30)
        $corso = substr($corso,0,30);
    }

}




?>
