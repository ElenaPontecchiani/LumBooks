<?php
class SqlWrap{
    private static function connect(){
        $dbname = 'LB';
        $dbuser = 'admin';
        $dbpass = 'admin';
        $dbhost = 'localhost';
        $connect = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if($connect->connect_errno){
            throw new Exception("Connessione al database fallita");
        }
        mysqli_set_charset($connect,"utf8");
        return $connect;
    }

    private static function collapse($result){
        if ($result == null){
            return null;
        }
        //mi ricordo di gestire il caso in cui ho un array nullo
        $key = array_keys($result[0])[0];
        $new_result = [];
        $lim = count($result);
        for($i = 0; $i < $lim; $i++){
            $new_result[$i] = $result[$i][$key];
        }
        return $new_result;
    }

    //Esegue un'interrogazione a database
    //Se collapse è true, vuol dire che il chiamante è sicuro
    //che la query ha solo una riga, pertanto verrà tornato un array
    //monodimensionale
    public static function query($query, $collapse = false){
        $connect = self::connect();
        if(!$result = $connect->query($query)){
            throw new Exception("La query non è andata a buon fine");
        }
        $connect->close();
        $lista_return = [];
        if($result->num_rows > 0){
          while($row = $result->fetch_array(MYSQLI_ASSOC)){
              array_push($lista_return,$row);
            }
            $result->free();
            if ($collapse){
                $lista_return = self::collapse($lista_return);
            }
            return $lista_return;
        }
  
        else
            return null;
    }

    //Esegue un comando su database
    //Lancia un'eccezione se non va a buon fine
    public static function command($command){
        $connect = self::connect();
        if(!($connect->query($command))){
            throw new Exception("L'operazione '$command' non è andata a buon fine");
        }
        $connect->close();
    }


    public static function input_escape($inputs){
        $connection = self::connect();
        for($i=0;$i < count($inputs);$i++){
            $inputs[$i] = htmlspecialchars($inputs[$i]);
            $inputs[$i] = $connection->escape_string($inputs[$i]);
        }
        $connection->close();
    }

    public static function isAdmin(){
        session_start();
        return (isset($_SESSION['email']) && $_SESSION['email'] == "admin@admin.com");
    }

}

?>