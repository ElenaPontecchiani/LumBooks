<?php
class Validator{
    public static function lengthVal($min, $max, ...$str) {
        $val = true;
        foreach($str as $s) {
            if (!(strlen($s) >= $min && strlen($s) <= $max)) {
                $val = false;
                break;
            }
        }
        return $val;
    }

    public static function registerVal(&$scelta_list, &$titolo, &$autore, &$casa_editrice, &$corso, &$edizione, &$annopub, &$isbn, &$prezzo, &$libro_catalogo,&$descrizione) {
        require_once "Backend/sql_wrapper.php";
        //Escape di tutti gli input
        //Tutti insieme per minimiazzare accesso al db
        $inputs = array(  &$scelta_list,&$titolo,&$autore,&$casa_editrice,
                                        &$corso,&$edizione,&$annopub,&$isbn,
                                        &$prezzo,&$libro_catalogo,&$descrizione);
        SqlWrap::input_escape($inputs);
        array_walk($inputs,'trim');
        //$descrizione = htmlspecialchars($descrizione);

        //A seconda della scelta dell'utente (listato vs libero), controllo solo
        //i campi necessari
        if ($scelta_list == "listato") {
            if(!Validator::lengthVal(3,50,$libro_catalogo))
                throw new Exception("Lunghezza libro da catalogo errata");
        }
        else{
            self::corsoVal($corso);
            self::autoreVal($autore);
            self::titoloVal($titolo);
            self::edizioneVal($edizione);
        }
        self::annoVal($annopub);
        self::edizioneVal($edizione);
        self::ISBNVal($isbn);
        self::prezzoVal($prezzo);
    }

    public static function titoloVal($titolo) {
        if(!self::lengthVal(2,50,$titolo))
            throw new Exception("Titolo non valido");
    }

    public static function corsoVal($corso) {
        if(!self::lengthVal(1,50,$corso))
            throw new Exception("Corso non valido");
    }

    public static function autoreVal($autore) {
        if(!self::lengthVal(2,50,$autore))
            throw new Exception("Autore non valido");
    }

    public static function prezzoVal($prezzo) {
        $pattern = '/^\d+(?:\.\d{2})?$/';
        if (!preg_match($pattern, $prezzo)) {
            throw new Exception("Prezzo non valido");
        }
    }

    public static function ISBNVal($isbn) {
        if (( (!(preg_match("/^[0-9]*$/", $isbn))) || strlen($isbn) != 13) && $isbn != "")
            throw new Exception("ISBN non valido");
    }

    public static function edizioneVal($edizione) {
        if((!Validator::lengthVal(3,20,$edizione)) && $edizione != "")
            throw new Exception("Edizione non valida");
    }

    public static function annoVal($annopub) {
        if ($annopub != "" &&
            (!filter_var($annopub, FILTER_VALIDATE_INT, array("options" => array("min_range"=>1900, "max_range"=>2100)))))
            throw new Exception("Anno non valido");
    }


    public static function ricercaValidation(&$titolo, &$autore, &$isbn, &$corso, &$editore) {
        $inputs = array(&$titolo,&$autore,&$isbn,&$corso);
        if(strlen($titolo)>50)
            $titolo = substr($titolo,0,50);
        if(strlen($autore)>50)
            $autore = substr($titolo,0,50);
        str_replace("-","",$isbn);
        if(strlen($isbn) != 13 && strlen($isbn) != 0)
            $isbn = "error";
        if(strlen($corso)>30)
            $corso = substr($corso,0,30);
        if(strlen($editore)>30)
            $editore = substr($editore,0,30);
    }

    public static function validateDate($date) {
        $format1 = 'd/m/Y';
        $d1 = DateTime::createFromFormat($format1, $date);
        $check1 = $d1 && $d1->format($format1) == $date;

        $format2 = 'd-m-Y';
        $d2 = DateTime::createFromFormat($format2, $date);
        $check2 = $d2 && $d2->format($format2) == $date;

        $format3 = 'Y/m/d';
        $d3 = DateTime::createFromFormat($format3, $date);
        $check3 = $d3 && $d3->format($format3) == $date;

        $format4 = 'Y-m-d';
        $d4 = DateTime::createFromFormat($format4, $date);
        $check4 = $d4 && $d4->format($format4) == $date;

        return ($check1 || $check2 || $check3 || $check4);
    }

    public static function loginIsValid($mail, $password) {
    return ((!filter_var($mail, FILTER_VALIDATE_EMAIL) || strlen($password)>16 || strlen($password)<3)? false : true);
  }


}
?>
