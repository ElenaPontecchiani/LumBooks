
$( document ).ready(function()
{
  $('#submitSrc').click(function()
    {
      var titolo = $('#titleInput').val();
      var autore = $('#authorInput').val();
      var isbn = $('#isbnInput').val();
      var corso = $('#courseInput').val();
      var ordine=2;
      var libri = cercaLibro(titolo, autore, isbn, corso, ordine);
      // creare la pagina con i libri trovati - (html deve essere completo) (!!!)
    });



});

/*
  funzione: cercaLibro
  ricerca i libri dati dei parametri
  return: array di libri. libri è un array della struttura {titolo,autore,prezzo,isbn}
*/
function cercaLibro(titolo, autore, isbn, corso, ordine)
{                                     //inserire le funzioni nel ready? (!!!)
  $.post("../php/Backend/controller.php",
  {
    command: 'searchBook',
    titolo: titolo,
    autore: autore,
    isbn: isbn,
    corso: corso,
    ordine: ordine
  }, function(res)
  {
    alert(res);  //errore nella traduzione json ->obj (!!!)
    var obj = JSON.parse(res);
    if(obj.error == ""){
    for(var i in obj){
        libro[i].titolo = obj.titolo[i];
        libro[i].autore = obj.autore[i];
        libro[i].prezzo = obj.prezzo[i];
        libro[i].isbn = obj.isbn[i];
    }
    return libro;
  }else {
    return obj.error;
  }
  });
}

/*
  funzione: getTitles
  ritorna la lista dei titolo dei libri in vendita
*/
function titoli()
{
  $.post("../php/Backend/controller.php",
  {
    command: 'getTitles'
  }, function(res)
  {
    alert(res);
    var obj = JSON.parse(res);
  });
}
