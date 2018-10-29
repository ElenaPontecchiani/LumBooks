//import {} from 'funzioni';

$( document ).ready(function()
{
  /*
    controlla che la password sia corretta
  */
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

     if((letter | number | length) & psw.val().length>0)
      psw.addClass("errorBox");
     else
      psw.removeClass("errorBox");

    });

}); // end document.ready
