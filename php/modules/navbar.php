<?php


echo '<nav id="navbar">';
echo '    <ul id="stdbar">';
echo '        <li class=""><a href="home.php">Home</a></li>';
echo '        <li class=""><a href="cercalibro.php">Cerca un Libro</a></li>';
echo '        <li class=""><a href="catalogo.php">Catalogo</a></li>';

if(!isset($_SESSION))
{
  session_start();
}
if (!isset($_SESSION['nome'])){
    echo '        <li class="right"><a href="login.php">Login</a></li>';
    echo '        <li class="right"><a href="registrati.php">Registrati</a></li>';
}
    else{
        echo '        <li class="right"><a href="logout.php">Logout</a></li>';
        echo '        <li class="right"><a href="utente.php">Pannello Utente</a></li>';
    }

echo '    </ul>';
echo '</nav>';

?>
