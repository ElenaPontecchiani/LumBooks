<?php
class htmlMaker{
    public static function searchItem($lista_libri){
        $html = "";
        $campi = array_keys($lista_libri[0]);
        $campi = array_diff($campi, array('Titolo'));
        $campi = array_diff($campi, array('md5_Hash'));
        $item_title = '<dt class="item_name"><a>££TITOLO££</a></dt>';
        $item_spec = '<dt class="item_spec">££NOMECAMPO££</dt><dd class="spec_desc">££CAMPO££</dd>'."\n";
        foreach($lista_libri as $libro){
            $ref = "";
            if (isset($libro['md5_Hash']))
                $ref = "<a href=\"../php/pagina_libro.php?libro={$libro['md5_Hash']}\">";
            $html .= "<dl class=\"search_item\">\n";
            $html .= str_replace('££TITOLO££',$libro['Titolo'],$item_title)."\n";
            $html = str_replace('<a>',$ref,$html);
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
        $nav_return .=  '        <li class=""><a href="inserisci.php">Inserisci</a></li>'."\n";
        $nav_return .=  '        <li class="nav"><input type="text" placeholder="Search.."></li>';


        $nav_return .=  '    </ul>'."\n";
        $nav_return .=  '</nav>'."\n";

        return $nav_return;
    }

    public static function header(){
        $header_return = file_get_contents("../HTML/modules/header.html");

        if(!isset($_SESSION)){
            session_start();
        }
        if (!isset($_SESSION['nome'])){
            $header_return .=  '<div id="header_login">'."\n";
            $header_return .=  '  <a href="login.php">Login</a>'."\n";
            $header_return .=  '  <a href="registrati.php">Registrati</a>'."\n";
            $header_return .=  '</div>'."\n";
        }
            else{
                $header_return .=  '<div id="header_login">'."\n";
                $header_return .=  '        <a href="logout.php">Logout</a>'."\n";
                $header_return .=  '        <a href="utente.php">Pannello Utente</a>'."\n";
                $header_return .=  '</div>'."\n";
            }

        $header_return .= "</header>";

        return $header_return;
    }

    public static function footer(){
        return file_get_contents("../HTML/modules/footer.html");
    }

}



?>
