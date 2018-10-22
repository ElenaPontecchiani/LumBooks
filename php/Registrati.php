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
</head>
<body>
  <?php
    include '../HTML/header.html';
    include '../php/navbar.php';
    include '../HTML/footer.html';
	?>
  <div id="registerBox" class="outerBox">
    <form id="registerForm" class="innerBox">
      <input type="email" id="registerEmail" placeholder="Email" />
      <br/>
      <input type="password" id="registerPwd" placeholder="Password" />
      <br/>
      <input type="password" id="repeatPwd" placeholder="Ripeti la Password" />
      <br />
      <input type="submit" id="registerSubmit" value="Registrati"/>
    </form>
  </div>
</div>
</body>
</html>
