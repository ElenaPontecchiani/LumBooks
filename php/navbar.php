<nav>
    <ul id="stdbar">
        <li <?php if(basename($_SERVER['PHP_SELF'])=="Home.php")             { echo " class=\"active\""; } ?>><a href="../php/Home.php">Home</a>
        <li <?php if(basename($_SERVER['PHP_SELF'])=="Cercalibro.php")      { echo " class=\"active\""; } ?>><a href="../php/Cercalibro.php">Cerca un libro</a></li>
        <li <?php if(basename($_SERVER['PHP_SELF'])=="Catalogo.php")         { echo " class=\"active\""; } ?>><a href="../php/Catalogo.php">Catalogo</a></li>
        <li <?php if(basename($_SERVER['PHP_SELF'])=="SessoGratis.php")     { echo " class=\"active\""; } ?>><a href="http://pornhub.com">Sesso gratis</a></li>

        <li <?php if(basename($_SERVER['PHP_SELF'])=="Login.html")              { echo " class=\"activeR\""; } else{ echo " class=\"right\""; }  ?>><a href="../html/Login.html">Login</a></li>
        <li <?php if(basename($_SERVER['PHP_SELF'])=="Registrati.php")  { echo " class=\"activeR\""; } else{ echo " class=\"right\""; }  ?>><a href="../php/Registrati.php">Registrati</a></li>
        </ul>

</nav>
