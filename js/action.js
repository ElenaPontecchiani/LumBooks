window.onload=function(){
    document.getElementById("toggle_nav").addEventListener("click", toggleNavbar);
  }
  
  function toggleNavbar(){
    if($('#navbar').hasClass('hidden_nav')){
      $('#navbar').removeClass('hidden_nav');
      $('#toggle_nav').removeClass('hidden_nav_button');
    }else{
      $('#navbar').addClass("hidden_nav");
      $('#toggle_nav').addClass('hidden_nav_button');
    }
    
  }
  