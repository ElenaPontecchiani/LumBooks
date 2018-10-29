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

  /*
   richiesta di login al server
  */
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

/*
  funzione: getSession
  se la sessione è aperta, ottiene i dati dell'utente
*/
function getSession(){
  $.post("../php/Backend/controller.php", {
    command: 'getSession'
  }, function(res) {
      var obj = JSON.parse(res);
      if(obj.sessionOpen === true){
        //variabili locali o globali?
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

/*
  funzione: cercaLibro
  ricerca i libri dati dei parametri
  return: array di libri. libri è un array della struttura {titolo,autore,prezzo,isbn} 
*/
 function cercaLibro(titolo, autore, isbn, corso, ordine){
   $.post("../php/backend/controller.php", {
     comand: 'searchBook',
     titolo: tiolo,
     autore: autore,
     isbn: isbn,
     corso: corso,
     ordine: ordine
   }, function(response) {
     var libri;
     var obj = JSON.parse(response);
     for(var i in obj){
         libro[i].titolo = obj.titolo[i];
         libro[i].autore = obj.autore[i];
         libro[i].prezzo = obj.prezzo[i];
         libro[i].isbn = obj.isbn[i];
     }
     return libri;
   }
 }
