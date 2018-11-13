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

}




?>