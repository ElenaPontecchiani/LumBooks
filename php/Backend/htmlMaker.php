<?php
class htmlMaker{

    public static function generateBookCollection($lista_libri, $lista_bottoni = null){
        if (!$lista_libri)
            return "Nessun risultato corripsondente";

        $html = "<ul class='books_collection'>";
        foreach($lista_libri as $libro){
            $html .= $lista_bottoni ? self::singleItemWithButtons($libro,$lista_bottoni) : self::singleItem($libro);
        }
        $html .= "</ul>";
        return $html;
    }

    public static function searchItemWithButtons($lista_libri,$lista_bottoni){
        if (!$lista_libri){
            return "Nessun risultato corripsondente";
        }
        $html = "<ul class='books_btn_collection'>";
        foreach($lista_libri as $libro){
            $html .= self::singleItemWithButtons($libro,$lista_bottoni);
        }
        $html .= "</ul>";
        return $html;
    }

    public static function singleItem($libro){
        $campi = array_keys($libro);
        $campi = array_diff($campi, array('Titolo'));
        $campi = array_diff($campi, array('md5_Hash'));

        $html = "<li class='search_item'>"."\n";
        $html .= isset($libro['md5_Hash']) ? "<a href='../php/pagina_libro.php?libro=". $libro['md5_Hash'] ."'>". $libro['Titolo'] ."</a>"."\n" : "";
        foreach($campi as $campo){
            $html .= "<div class='cardText'>";
            $html .= $libro[$campo] != "" ? "<span class='item_spec'>". $campo .":</span><span class='spec_desc'>". $libro[$campo] ."</span>"."\n" : "";
            $html .= "</div>"."\n";
        }
        $img = isset($libro['md5_Hash'])? self::getImage($libro['md5_Hash']): "";
        $html .= $img != "" ? "<img  class ='libro' src='". $img ."' alt='libro di". $libro['Titolo'] ."'/>"."\n": "<div class='libro_fake'>¯\_(ツ)_/¯</div>"."\n";

        $html .= "</li>"."\n";
        return $html;
    }

    /*
    lista bottoni è la lista dei testi che vanno nei bottoni
    ogni bottone manda una post con name= nome del comando del bottone
    e value = md5_Hash del libro
    */
    public static function singleItemWithButtons($libro,$lista_bottoni){
        $html = self::singleItem($libro);   //Creo il search_item di base
        if(!isset($libro['md5_Hash'])){
            $libro['md5_Hash'] = $libro['Codice_identificativo'];
        }
        $buttons = "<form action='book_action.php' method='post'>"."\n";
        foreach($lista_bottoni as $bot){
            $buttons .= "<button type='submit' name='". $bot ."' value='". $libro['md5_Hash'] ."'>". $bot ."</button>"."\n";
        }
        $buttons .= "</form></li>"."\n";
        $html = str_replace('</li>',$buttons,$html);
        return $html;
    }

    public static function getImage($hash){
        $result = glob ("../immagini_libri/{$hash}.*");
        if (count($result) == 1)
            return $result[0];
        else
            return "";
    }

    public static function navbar(){
        if(!isset($_SESSION)){
            session_start();
        }
        $nav_return  =  '<nav id="navbar">'."\n";
        $nav_return .=  '<div id="nav_user">';
        $nav_return .=  "<button class='close_nav'>chiudi x</button>";
        $nav_return .=  isset($_SESSION['nome']) ?
         "<p>".$_SESSION['nome']."</p>" : "";
        $nav_return .=  isset($_SESSION['email']) ? "<p>".$_SESSION['email']."</p>" : "";
        $nav_return .=  '</div>';
        $nav_return .=  '<ul id="stdbar">'."\n";
        $nav_return .=  '<li class=""><a href="home.php">Home</a></li>'."\n";
        $nav_return .=  '<li class=""><a href="../php/risultati_ricerca.php?">In Vendita</a></li>'."\n";
        $nav_return .=  '<li class=""><a href="catalogo.php">Catalogo</a></li>'."\n";
        $nav_return .=  '<li class=""><a href="cercalibro.php">Cerca un Libro</a></li>'."\n";
        if(isset($_SESSION['nome'])){
          $nav_return .=  '<li class=""><a href="inserisci.php">Inserisci</a></li>'."\n";
        }
        $nav_return .=  '</ul>'."\n";
        $nav_return .=  file_get_contents("../HTML/modules/footer.html");
        $nav_return .=  '</nav>'."\n";

        return $nav_return;
    }

    public static function header(){
        $header_return = file_get_contents("../HTML/modules/header.html")."\n";

        if(!isset($_SESSION)){
            session_start();
        }
        if (!isset($_SESSION['nome'])){
            $header_return .=  '<div id="header_login">'."\n";
            $header_return .=  '<a href="login.php">Login (inserire</a>'."\n";
            $header_return .=  '<a href="registrati.php">icona)Registrati</a>'."\n";
            $header_return .=  '</div>'."\n";
        }
            else{
                $header_return .=  '<div id="header_login">'."\n";
                $header_return .=  '<a href="logout.php">Logout</a>'."\n";
                $header_return .=  '<a href="utente.php">Pannello Utente</a>'."\n";
                $header_return .=  '</div>';
            }

        $header_return .= "</header>"."\n";

        return $header_return;
    }

}



?>
