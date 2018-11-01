


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
    cerca i libri
  */
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

    /*
      funzione: cercaLibro
      ricerca i libri dati dei parametri
      return: array di libri. libri è un array della struttura {titolo,autore,prezzo,isbn}
    */
    function cercaLibro(titolo, autore, isbn, corso, ordine)
    {
                                        //inserire le funzioni nel ready? (!!!)
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
        if(obj.error == ""){
          for(var i in obj){
              libri[i].titolo = obj.titolo[i];
              libri[i].autore = obj.autore[i];
              libri[i].prezzo = obj.prezzo[i];
              libri[i].isbn = obj.isbn[i];
          }
          return libri;
        }else {
          return obj.error;
        }
      });
    }

});
