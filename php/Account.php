<!DOCTYPE html>
<html lang="it">
   <head>
      <meta charset="UTF-8">
      <title>Impostazioni - LumBooks</title>
      <link rel="icon" href=""/><!-- link icona -->
      <meta name="title" content="Impostazioni - LumBooks" />
      <meta name="description" content="Pagina per vedere e cambiare le proprie impostazioni e credenziali /><!-- da fare -->
      <meta name="keywords" content="impostazioni, unipd, account, password, email, matricola" /><!-- da fare -->
      <meta name="language" content="italian it" />
      <meta name="author" content="" /><!-- da fare -->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
      <link rel="stylesheet" type="text/css" href="../css/account.css" /><!-- FARE CSS -->
      <link rel="stylesheet" type="text/css"  href="../css/" media="screen and (max-width:768px)" /><!-- schermi piccoli --> <!-- da fare -->
      <link rel="stylesheet" type="text/css" href="../css/" media="print" /><!-- da fare -->
   </head>
   <body>
      <?php
         include '../HTML/header.html';
         include '../php/navbar.php';
         include '../HTML/footer.html';
         ?>
      <div id="accountBox" class="outerBox">
         <h1>Informazioni personali</h1>
         <p>Ciao Nome Cognome. Qui puoi visualizzare le tue impostazioni ed eventualmente modificare e-mail e password.</p> 
         <form id="accountForm" class="innerBox" action="changeSettings.php" method="post"><!-- da fare -->
            <label>Numero di matricola</label>
            <br/>
			<input type="text" name="matricola" id="matricola" value="PHP" readonly="readonly">
			<br/>
            <label>Data di nascita</label>
            <br/>
			<input type="date" name="nascita" id="birth_data" value="PHP" readonly="readonly">
			<br/>
            <label>Email</label>
            <br/>
            <input type="email" name="email" id="registerEmail" class="formText" value="PHP" />
            <br/>
            <label>Nuova Password</label>
            <br/>
            <input type="password" id="newPsw" class="formText" />
            <br/>
            <label>Conferma password</label>
            <br/>
            <input type="password" name="password" id="repeatPsw" class="formText" />
            <br />
            <input type="submit"id="changeSubmit" value="Cambia"/>
         </form>
      </div>
      </div>
   </body>
</html>