<nav>
    <ul id="stdbar">
        <li <?php if(basename($_SERVER['PHP_SELF'])=="Home.php")             { echo " class=\"active\""; } ?>><a href="../php/Home.php">Home</a>
        <li <?php if(basename($_SERVER['PHP_SELF'])=="Cerca libro.php")      { echo " class=\"active\""; } ?>><a href="../php/Cerca libro.php">Cerca un libro</a></li>
        <li <?php if(basename($_SERVER['PHP_SELF'])=="Catalogo.php")         { echo " class=\"active\""; } ?>><a href="../php/Catalogo.php">Catalogo</a></li>
        <li <?php if(basename($_SERVER['PHP_SELF'])=="Sesso Gratis.php")     { echo " class=\"active\""; } ?>><a href="http://pornhub.com">Sesso gratis</a></li>

        <li <?php if(basename($_SERVER['PHP_SELF'])=="Login.php")              { echo " class=\"activeR\""; } else{ echo " class=\"right\""; }  ?>><a href="../php/Login.php">Login</a></li>
        <li <?php if(basename($_SERVER['PHP_SELF'])=="Registrati.php")  { echo " class=\"activeR\""; } else{ echo " class=\"right\""; }  ?>><a href="../php/Registrati.php">Registrati</a></li>
        </ul>

</nav>