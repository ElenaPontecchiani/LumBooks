window.onload=function(){
  formselector();
  document.getElementById("listato").addEventListener("click", formselector);
  document.getElementById("personale").addEventListener("click", formselector);
  document.getElementById("openNavButton").addEventListener("click", toggleNavbar);
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
/*
function toggleNavbar(){
  if($('#navbar').hasClass('hidden_nav')){
    $('#navbar').removeClass('hidden_nav');
    $('#openNavButton').removeClass('hidden_nav_button');
  }else{
    $('#navbar').addClass("hidden_nav");
    $('#openNavButton').addClass('hidden_nav_button');
  }
  
}
*/