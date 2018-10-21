<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
	<title>Login</title>
	<link rel="icon" href=""/> <!-- link icona -->
	<meta name="title" content="Login" />
	<meta name="description" content="Pagina di Login" /> <!-- da fare -->
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
<div class="">
	<div id="loginBox" class="centerBox">
		<form id="loginForm">
      <input type="email" id="loginEmail" placeholder="Email" />
      <br/>
      <input type="password" id="loginPwd" placeholder="Password" />
      <br />
      <a href="recuperoPwd.php" id="recuperoPwd">password dimenticata?</a>
      <input type="submit" id="loginSubmit" value="Accedi"/>
    </form>
	</div>
</div>
</body>
</html>
