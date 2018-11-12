window.onload=function(){
  radio();
  document.getElementById("listato").addEventListener("click", radio);
  document.getElementById("personale").addEventListener("click", radio);
}

// sto pensando a un nome decente per il metodo. lo finisco quando ho l'html
function radio(){
  listato = document.getElementById('listato').selected;
  if(listato)
    alert("nascondi titolo, autore, casaeditrice, corso");
  else
    alert("nascondi select catalogo");

}
