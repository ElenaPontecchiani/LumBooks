<?php
class htmlMaker{
    public static function searchItem($lista_libri){
        $html = "";
        $campi = array_keys($lista_libri[0]);
        $campi = array_diff($campi, array('Titolo'));
        $item_title = '<dt class="item_name">££TITOLO££</dt>';
        $item_spec = '<dt class="item_spec">££NOMECAMPO££</dt><dd class="spec_desc">££CAMPO££</dd>'."\n";
        foreach($lista_libri as $libro){
            $html .= "<dl class=\"search_item\">\n";
            $html .= str_replace('££TITOLO££',$libro['Titolo'],$item_title)."\n";
            foreach($campi as $campo){
                if ($libro[$campo] != "")
                    $html.= str_replace('££NOMECAMPO££',$campo,
                            str_replace('££CAMPO££',$libro[$campo],
                            $item_spec))."\n";
            }
            $html .= "</dl>\n";
        }
        return $html;
    }

    public static function navbar(){
        $nav_return = "";
        $nav_return .=  '<nav id="navbar">'."\n";
        $nav_return .=  '    <ul id="stdbar">';
        $nav_return .=  '        <li class=""><a href="home.php">Home</a></li>'."\n";
        $nav_return .=  '        <li class=""><a href="cercalibro.php">Cerca un Libro</a></li>'."\n";
        $nav_return .=  '        <li class=""><a href="catalogo.php">Catalogo</a></li>'."\n";
        $nav_return .=  '        <li class=""><a href="inserisci.php">Inserisci</a></li>';

        if(!isset($_SESSION)){
            session_start();
        }
        if (!isset($_SESSION['nome'])){
            $nav_return .=  '        <li class="right"><a href="login.php">Login</a></li>'."\n";
            $nav_return .=  '        <li class="right"><a href="registrati.php">Registrati</a></li>'."\n";
        }
            else{
                $nav_return .=  '        <li class="right"><a href="logout.php">Logout</a></li>'."\n";
                $nav_return .=  "        <li class=\"right\"><a>Ciao,{$_SESSION['nome']} :)</a></li>"."\n";
            }

        $nav_return .=  '    </ul>'."\n";
        $nav_return .=  '</nav>'."\n";

        return $nav_return;
    }

    public static function header(){
        return file_get_contents("../HTML/modules/header.html");
    }

    public static function footer(){
        return file_get_contents("../HTML/modules/footer.html");
    }

}



?>