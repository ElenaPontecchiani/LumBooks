/*window.onload = function(){
    document.getElementById("registerPsw").addEventListener("focusout", pswCheck);
}

var letter=false;
var number=false;
var length=false;

function pswCheck() {
$("loginSubmit").click(function(){
  var letter=false;
  var number=false;
  var length=false;
  // Validate lowercase letters
  psw = $("inputPsw");
  var lowerCaseLetters = /[a-z]|[A-Z]/g;
  if(psw.value.match(lowerCaseLetters))
    letter=false;
   else
      letter=true;


  // Validate numbers
  var numbers = /[0-9]/g;
  if(psw.value.match(numbers))
    number=false;
   else
      number=true;

  // Validate length
  if(psw.value.length >= 4)
    length=false;
   else
      length=true;

   if((letter | number | length) & psw.value.length>0)
    psw.classList.add("errorBox");
   else
    psw.classList.remove("errorBox");

}
*/
$( document ).ready(function()
{

  // richiesta di login al server
  $('#loginSubmit').click(function()
  {
    var password = $('#inputPsw').val();
    var email = $('#loginEmail').val();
    $.post("../php/Backend/controller.php", {
      command: 'Login',
      email: email,
      password: password
    }, function(res) {
      var obj = JSON.parse(res);
      if(obj.password_ok === true)
        alert("Login Effettuato con Successo"); //darimuovere
      else
        alert(obj.error+" >:["); //darimuovere
      getSession();
  	});
	});



}); // end document.ready

// controllo stato sessione
function getSession(){
  $.post("../php/Backend/controller.php", {
    command: 'getSession'
  }, function(res) {
    //darimuovere
    alert(res);
      var obj = JSON.parse(res);
      if(obj.sessionOpen === true){
        id = obj.id;
        matricola = obj.matricola;
        nome = obj.nome;
        cognome = obj.cognome;
        sesso = obj.sesso;
        data_nascita = obj.data_nascita; //YYYY-MM-DD
        username = obj.username;
        email = obj.email;
        //darimuovere
        alert("sessione aperta");
        return true;
      }
      //darimuovere
      alert("sessione chiusa");
      return false;
     });
 } // end function getSession
