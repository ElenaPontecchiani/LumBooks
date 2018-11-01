


$( document ).ready(function()
{
  /*
    riempie il select #titleInput con i titoli
  */
  $.post("../php/Backend/controller.php",
  {
    command: 'getTitles'
  }, function(res)
  {
    titolo = JSON.parse(res).titoli;
    titleshtml = "<datalist id='titleInput' class='formText'>";
    for(i in titolo){
      titleshtml += "<option value='"+ titolo[i] +"'>"+ titolo[i] +"</option>";
    }
    titleshtml += "</datalist>";
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
          alert("libri trovati - da completare quando catalogo è pronto");
        }else {
          alert("libro non trovato");
        }
      });
      // creare la pagina con i libri trovati - (html deve essere completo) (!!!)
    });



});
