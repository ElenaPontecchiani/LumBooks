<?php
class htmlMaker{

    public static function generateBookCollection($lista_libri, $lista_bottoni = null) {
        if (!$lista_libri)
            return "Nessun risultato corripsondente";

        $html = "<ul class='books_collection'>";
        foreach($lista_libri as $libro) {
            $html .= $lista_bottoni ? self::singleItemWithButtons($libro,$lista_bottoni) : self::singleItem($libro);
        }
        $html .= "</ul>";
        return $html;
    }

    public static function singleItem($libro) {
        $campi = array_keys($libro);
        $campi = array_diff($campi, array('Titolo'));
        $campi = array_diff($campi, array('md5_Hash'));

        $html = "<li class='search_item'>"."\n";
        $html .= "<div class='search_spec'>";
        $html .= isset($libro['md5_Hash']) ? "<a href='../php/pagina_libro.php?libro=". $libro['md5_Hash'] ."'>". $libro['Titolo'] ."</a>"."\n" : 
        "<a class='titolo' href='../php/risultati_ricerca.php?titolo=".urlencode($libro['Titolo'])."'> ".$libro['Titolo']." </a>";
        if (isset($libro["Prezzo"]))
            $libro["Prezzo"] .= " €";
        foreach($campi as $campo) {
            $html .= "<p class='$campo'>";
            $html .= $libro[$campo] != "" ? $libro[$campo] : "";
            $html .= "</p>"."\n";
        }
        $html .= "</div>";
        $img = isset($libro['md5_Hash'])? self::getImage($libro['md5_Hash'],"../immagini_libri/"): "";
        $a1 = "";
        $a2 = "";
        if(isset($libro['md5_Hash'])) {
            $a1 = "<a href='../php/pagina_libro.php?libro=". $libro['md5_Hash'] ."'>";
            $a2 = "</a>";
        }
        $html .= $a1;
        $html .= $img != "" ? "<img  class ='libro' src='". $img ."' alt='libro di". $libro['Titolo'] ."'/>"."\n": "<div class='libro_fake'>¯\_(ツ)_/¯</div>"."\n";
        $html .= $a2;
        $html .= "</li>"."\n";
        return $html;
    }

    /*
    lista bottoni è la lista dei testi che vanno nei bottoni
    ogni bottone manda una post con name= nome del comando del bottone
    e value = md5_Hash del libro
    */
    public static function singleItemWithButtons($libro,$lista_bottoni) {
        $html = self::singleItem($libro);
        if(!isset($libro['md5_Hash'])) {
            $libro['md5_Hash'] = $libro['Codice_identificativo'];
        }
        $buttons = "<form action='book_action.php' method='post' class='sc_form'>"."\n";
        foreach($lista_bottoni as $bot) {
            $buttons .= "<button type='submit' class='sc_button' name='". $bot ."' value='". $libro['md5_Hash'] ."'>". $bot ."</button>"."\n";
        }
        $buttons .= "</form></li>"."\n";
        $html = str_replace('</li>',$buttons,$html);
        $html = str_replace('search_item','search_item with_bt',$html);
        return $html;
    }

    public static function getImage($nome,$dir) {
        $result = glob ("$dir{$nome}.*");
        if (count($result) == 1)
            return $result[0];
        else
            return "";
    }

    public static function navbar() {
        if(!isset($_SESSION)) {
            session_start();
        }
        $nav_return  =  '<nav id="navbar">'."\n";
        $nav_return .=  '<div class="closeNav"><div id="close"></div></div>'."\n";
        $nav_return .=  '<div id="nav_user">';
        $img = "../images/user.png";
        if(isset($_SESSION['nome'])) {
            $userImg = self::getImage($_SESSION['email'],"../immagini_profilo/");
            if ($userImg != "") {
               $img = $userImg;
            }
        }
        $nav_return .=  isset($_SESSION['nome']) ?"<img id=\"profile_pic\" src=\"$img\" alt=\"immagine profilo\" />"."\n" : "";
        $nav_return .=  isset($_SESSION['nome']) ? "<p id='user_name'>".$_SESSION['nome']."</p>" : "";
        $nav_return .=  isset($_SESSION['email']) ? "<p id='user_email'>".$_SESSION['email']."</p>" : "";
        if(isset($_SESSION['nome'])) {
            $nav_return .=  '<div class ="user_data_button">';
            $nav_return .=  '<a class="user_data_link" href="dati_personali.php">I miei dati</a>'."\n";
            $nav_return .=  '<a class="user_data_link" href="libri_personali.php">I miei libri</a>'."\n"; 
            $nav_return .=  '</div>';
        }
        $nav_return .=  '</div>';
        $nav_return .=  '<ul id="stdbar">'."\n";
        $nav_return .=  '<li><a href="home.php">Home</a></li>'."\n";
        $nav_return .=  '<li><a href="../php/risultati_ricerca.php?">In Vendita</a></li>'."\n";
        $nav_return .=  '<li><a href="catalogo.php">Catalogo</a></li>'."\n";
        $nav_return .=  '<li><a href="cercalibro.php">Cerca un Libro</a></li>'."\n";
        if(isset($_SESSION['nome'])) {
          $nav_return .=  '<li><a href="inserisci.php">Inserisci</a></li>'."\n";
        }
        if(isset($_SESSION['email']) && $_SESSION['email'] == "admin@admin.com") {
            $nav_return .=  '<li><a href="admin.php">Pannnello Amministratore</a></li>'."\n";
          }
        $nav_return .=  '<li><a href="regolamento.php">Regolamento</a></li>'."\n";
        $nav_return .=  '<li><a href="about.php" accesskey="c">Chi Siamo</a></li>'."\n";
        $nav_return .=  '</ul>'."\n";
        $nav_return .=  '</nav>'."\n";

        return $nav_return;
    }

    public static function header() {
        $header_return = file_get_contents("../HTML/modules/header.html")."\n";

        if(!isset($_SESSION)) {
            session_start();
        }
        if (!isset($_SESSION['nome'])) {
            $header_return .=  "<div id='header_login'>"."\n";
            $header_return .=  "<a href='../php/registrati.php' class='button register-button'>Registrati</a>"."\n";
            $header_return .=  "<a href='../php/login.php' class='button login-button'>Accedi</a>"."\n";
            $header_return .=  '</div>'."\n";
        }
            else{
                $header_return .=  '<div id="header_login">'."\n";
                $header_return .=  "<a href='logout.php' class='button logout-button'>Logout</a>"."\n";
                $header_return .=  '</div>';
            }

        $header_return .= "</header>"."\n";
        return $header_return;
    }

    public static function pagina_messaggio($titolo,$sottotitolo,$extra = "") {
        $pagina_return = file_get_contents("../HTML/pag_messaggio.html");
        
        return  str_replace("<header></header>",htmlMaker::header(),
                str_replace("<nav></nav>",htmlMaker::navbar(),
                str_replace("££TITOLO££",$titolo,
                str_replace("££SOTTOTITOLO££",$sottotitolo,
                str_replace("££EXTRA££",$extra,$pagina_return)))));
    }

    public static function breadCrumb(...$sequeza) {
        $breadcrumb = "Ti trovi in: Home ";
        foreach($sequeza as $el) {
            $breadcrumb .= "> $el ";
        }
        return "<p id=\"map-position\">$breadcrumb</p>";
    }

}



?>
