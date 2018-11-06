// Registrazione - controllo esistenza email - username - matricola ecc. (in ajax)


/*
$( document ).ready(function()
{

  $('#registerSubmit').click(function()
  {
    var email = $("#registerEmail").val();
    var password = $("#registerPsw").val();
    var matricola = $("#matricola").val();
    var nome = $("#nome").val();
    var cognome = $("#cognome").val();
    var username = $("#user").val();
    var sesso = $("#sesso").val();
    var dataNascita = $("#birth_date").val();
    $.post("../php/Backend/controller.php",
    {
      command: 'Register',
      email: email,
      password: password,
      matricola: matricola,
      nome: nome,
      cognome: cognome,
      username: username,
      sesso: sesso,
      dataNascita: dataNascita
    }, function(res)
    {
      // darimuovere
      alert(res);
      var obj = JSON.parse(res);
      if(obj.successo)
        alert("successo");
      else
        alert(obj.error);

    });
  });// end #registersubmit.click


  //  controlla che la password sia corretta

  $("#registerPsw").focusout(function() {
  var letter=false;
  var number=false;
  var length=false;
  // Validate lowercase letters
  psw = $("#registerPsw");
  var lowerCaseLetters = /[a-z]|[A-Z]/g;
  if(psw.val().match(lowerCaseLetters))
    letter=false;
   else
      letter=true;

  // Validate numbers
  var numbers = /[0-9]/g;
  if(psw.val().match(numbers))
    number=false;
   else
      number=true;

  // Validate length
  if(psw.val().length >= 4)
    length=false;
   else
      length=true;

   if((letter | number | length) & psw.val().length>0){
      psw.addClass("errorBox");
      valid = false;
    } else{
      psw.removeClass("errorBox");
      valid = true;
    }
  });

}); // end document.ready
*/
