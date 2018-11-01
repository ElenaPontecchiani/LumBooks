


$( document ).ready(function()
{
  /*
    riempie il select #titleInput con i titoli
  */
  var t;
  $.post("../php/Backend/controller.php",
  {
    command: 'getTitles'
  }, function(res)
  {
    t = JSON.parse(res).titoli;
    titleshtml = "<select id='titleInput' class='formText'>";
    for(i in t){
      titleshtml += "<option value='"+ t[i] +"'>"+ t[i] +"</option>";
    }
    titleshtml += "</select>";
    $('#titleInput').html(titleshtml);
  });

  /*
    var t;
  $.post("../php/Backend/controller.php",
  {
    command: 'getTitles'
  }, function(res)
  {
    t = JSON.parse(res).titoli;

    titleshtml = "<datalist id='titleInput'>";
    for(i in t){
      titleshtml += "<option value='"+ t[i] +"'/>";
    }
    $('#titleInput').html(titleshtml);
  });
  */

  /*
    cerca i libri
  */
  $('#submitSrc').click(function()
    {
      var titolo = $('#titleInput').val();
      var autore = $('#authorInput').val();
      var isbn = $('#isbnInput').val();
      var corso = $('#courseInput').val();
      var ordine=2;
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
        var obj = JSON.parse(res);
        var libri = [];
        if(obj.error == ""){
          for(var i in obj.titolo){
              libri.push({
                titolo: obj.titolo[i],
                autore: obj.autore[i],
                prezzo: obj.prezzo[i],
                isbn:   obj.isbn[i]
              });

          }
          //successo
          
        }else {
          alert("errore nella ricerca dei libri");
        }
      });
      // creare la pagina con i libri trovati - (html deve essere completo) (!!!)
    });



});

/*
  funzione: cercaLibro
  ricerca i libri dati dei parametri
  return: array di libri. libri è un array della struttura {titolo,autore,prezzo,isbn}
*/
function cercaLibro(titolo, autore, isbn, corso, ordine)
{
                                    //inserire le funzioni nel ready? (!!!)

}
