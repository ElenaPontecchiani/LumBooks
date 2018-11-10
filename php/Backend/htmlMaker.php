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
                $html.= str_replace('££NOMECAMPO££',$campo,
                        str_replace('££CAMPO££',$libro[$campo],
                        $item_spec))."\n";
            }
            $html .= "</dl>\n";
        }
        return $html;
    }
}



?>