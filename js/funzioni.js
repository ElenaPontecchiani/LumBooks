/*
  funzione: getSession
  se la sessione è aperta, ottiene i dati dell'utente
*/
export function getSession(){
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
    });
  }
