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
