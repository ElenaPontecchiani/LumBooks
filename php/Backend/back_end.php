<?php
class backend{

  public static function getSessionData(){
      session_start();
      if (!isset($_SESSION['id']))
          return array(
              "sessionOpen" => false,
              "id" => "",
              "matricola" => "",
              "nome" => "",
              "cognome" => "",
              "sesso" => "",
              "data_nascita" => "",
              "username" => "",
              "email" => ""
          );
      return array(
          "sessionOpen" => true,
          "id" => $_SESSION['id'],
          "matricola" => $_SESSION['mat'],
          "nome" => $_SESSION['nome'],
          "cognome" => $_SESSION['cogn'],
          "sesso" => $_SESSION['sesso'],
          "data_nascita" => $_SESSION['bdate'],
          "username" => $_SESSION['user'],
          "email" => $_SESSION['email']
      );
  }

  public static function getTitles(){
      include "../phpConnect.php";
      if(!$result = $connect->query("SELECT Titolo FROM Libri_Listati")){
          return array("error" => "Errore di query");
          exit();
      }
      else{
          $connect->close();
      }

      $lista_titolo = [];
      if($result->num_rows > 0){
		while($row = $result->fetch_array(MYSQLI_ASSOC)){
			array_push($lista_titolo,$row['Titolo']);
          }
          $result->free();
          return array("error" => "",
                      "titoli" => $lista_titolo);
      }

      else
          return array("error" => "Query vuota");
  }

  public static function Register($mail,$pw,$mat,$name,$fname,$user,$sex,$bdate){
      include "../phpConnect.php";

      //escape dell'input
      $mail = $connect->escape_string($mail);
      $pw = $connect->escape_string($pw);
      $mat = $connect->escape_string($mat);
      $name = $connect->escape_string($name);
      $fname = $connect->escape_string($fname);
      $user = $connect->escape_string($user);
      $sex = $connect->escape_string($sex);
      $bdate = $connect->escape_string($bdate);


      $pw = password_hash("$pw", PASSWORD_DEFAULT);

      $sql =  "INSERT INTO Utente
              VALUES( NULL,
                      '$mat',
                      '$name',
                      '$fname',
                      '$sex',
                      '$bdate',
                      '$user',
                      '$pw',
                      '$mail');";

      if ($connect->query($sql) === TRUE) {
          return array("successo" => true,
                        "error" => "");
      } else {
          /*echo "Error: " . $sql . "<br>" . $connect->error;*/
          return array("successo" => false,
                        "error" => "$connect->error;");
      }
  }

  public static function checkField($value,$field){
      include "../phpConnect.php";

      //escape dell'input
      $value = $connect->escape_string($value);

      if(!$result = $connect->query("SELECT $field FROM Utente WHERE $field ='$value'")){
          return array("errore" => "Errore di query");
          exit();
      }
      else{
          $connect->close();
      }

      if($result->num_rows > 0){
          echo "presente";
          return array(   "alreadyExist" => true,
                          "errore" => "");
      }
      else{
          echo "Assente";
          return array(   "alreadyExist" => false,
                          "errore" => "");
      }
  }

  /*
  http://php.net/manual/en/filter.examples.validation.php
  http://php.net/manual/en/function.filter-input.php
  */
  public static function loginIsValid($mail, $password)
  {
    return ((!filter_var($mail, FILTER_VALIDATE_EMAIL) || strlen($password)>16 || strlen($password)<3)? false : true);
  }

  public static function registerIsValid($mail,$matricola,$nome, $cognome, $user, $sex, $nascita, $password){
    $valid = self::loginIsValid($mail, $password);
    $a = array($matricola, $nome, $cognome, $user);

    if($valid){
      foreach($a as $val){
        if(strlen($val) < 3 || strlen($val) > 15)
          $valid = false;
      }
      if ($sex != "M" && $sex != "F" && $sex != "N")
        $valid = false;
    }
    return $valid;
  }

}


?>
