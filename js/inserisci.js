window.onload=function(){
  formselector();
  document.getElementById("listato").addEventListener("click", formselector);
  document.getElementById("personale").addEventListener("click", formselector);
}

function formselector(){
  listato = document.getElementById('listato').checked;
  if(listato){
    document.getElementById('inserisci-personale').classList.add("hidden");
    document.getElementById('inserisci-listato').classList.remove("hidden");
  }
  else{
    document.getElementById('inserisci-listato').classList.add("hidden");
    document.getElementById('inserisci-personale').classList.remove("hidden");
  }

}
