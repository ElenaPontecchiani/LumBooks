<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
	<title>Registrati</title>
	<link rel="icon" href=""/> <!-- link icona -->
	<meta name="title" content="Registrati" />
	<meta name="description" content="Pagins di registrazione al sito" /> <!-- da fare -->
	<meta name="keywords" content="libro, unipd" /> <!-- da fare -->
	<meta name="language" content="italian it" />
	<meta name="author" content="" /> <!-- da fare -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../css/login.css" /> <!-- da fare -->
  <link rel="stylesheet" type="text/css"  href="../css/" media="screen and (max-width:768px)" /> <!-- schermi piccoli --> <!-- da fare -->
  <link rel="stylesheet" type="text/css" href="../css/" media="print" /> <!-- da fare -->
  <script type="text/javascript" src="../js/validation.js"></script>
</head>
<body>
  <?php
    include '../HTML/header.html';
    include '../php/navbar.php';
    include '../HTML/footer.html';
	?>
  <div id="registerBox" class="outerBox">
    <form id="registerForm" class="innerBox" action="new_user.php" method="post">
      <label>Email</label>
      <br/>
      <input type="email" name="email" id="registerEmail" class="formText" />
      <br/>
      <label>Matricola</label>
      <br/>
      <input type="text"  name="matricola" id="matricola" class="formText" />
      <br />
      <label>Nome</label>
      <br/>
      <input type="text" name="nome" id="nome" class="formText" />
      <br />
      <label>Cognome</label>
      <br/>
      <input type="text" name="cognome" id="cognome" class="formText" />
      <br />
      <label>Nome utente</label>
      <br/>
      <input type="text" name="user" id="user" class="formText" />
      <br />
      <input list="Sesso" name="sesso" placeholder="Sesso" class="formText">
        <datalist id="Sesso">
          <option value="M">
          <option value="F">
          <option value="N">
        </datalist>
      <br/>
      <input type="date" name="nascita" id="birth_date" class="formText" />
      <br />
      <label>Password</label>
      <br/>
      <input type="password" id="registerPsw" class="formText" />
      <br/>
      <label>Ripeti password</label>
      <br/>
      <input type="password" name="password" id="repeatPsw" class="formText" />
      <br />
      <input type="submit"id="registerSubmit" value="Registrati"/>
    </form>
  </div>
</div>
</body>
</html>
