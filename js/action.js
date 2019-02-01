window.onload=function()
{

  // pulsante per l'apertura/chiusura del menu' laterale
  document.getElementById("toggle_nav").addEventListener("click",toggleNavbar);

  // *********** validazione campi Registrazione ********
  if(document.getElementById("registerForm") != null)
  {
    document.getElementById("email").addEventListener("focus",checkRegisterInput);
    document.getElementById("nome").addEventListener("focus",checkRegisterInput);
    document.getElementById("password").addEventListener("focus",checkRegisterInput);
    document.getElementById("cel").addEventListener("focus",checkRegisterInput);
    document.getElementById("cognome").addEventListener("focus",checkRegisterInput);
    document.getElementById("nascita").addEventListener("focus",checkRegisterInput);
    document.getElementById("sesso").addEventListener("focus",checkRegisterInput);
    document.getElementById("repeatpassword").addEventListener("focus",checkRegisterInput);
    
    // disattivazione form quando i dati inseriti sono incorretti
    document.getElementById("registerForm").addEventListener("submit",function(event){
      checkRegisterInput();
      var email = document.getElementById("email");
      var password = document.getElementById("password");
      var nome = document.getElementById("nome");
      var tel = document.getElementById("cel");
      var cognome = document.getElementById("cognome");
      var nascita = document.getElementById("nascita");
      var repeatpassword = document.getElementById("repeatpassword");

      // controllo se i campi sono vuoti
      [email,password,nome,tel,cognome,nascita,repeatpassword].filter(el => el.value == 0)
        .forEach(element => setErrorBox(element));

      errors = document.getElementsByClassName("errorLine");
      if (!errors.length==0)
      {
        event.preventDefault();
      }
    });
  }

}
  
  function toggleNavbar()
  {
    if($('#navbar').hasClass('hidden_nav'))
    {
      $('#navbar').removeClass('hidden_nav');
      $('#toggle_nav').removeClass('hidden_nav_button');
    }else
    {
      $('#navbar').addClass("hidden_nav");
      $('#toggle_nav').addClass('hidden_nav_button');
    }
    
  }
  
  function checkRegisterInput()
  {
    var email = document.getElementById("email");
    var password = document.getElementById("password");
    var nome = document.getElementById("nome");
    var tel = document.getElementById("cel");
    var cognome = document.getElementById("cognome");
    var nascita = document.getElementById("nascita");
    var repeatpassword = document.getElementById("repeatpassword");

    checkItem(password,/^(?=.*[0-9])(?=.*[a-z])[a-zA-Z0-9!.@#$%^&*]{6,16}$/);
    checkItem(email, /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/);
    checkItem(nome, /^[a-zA-Z]{3,16}$/);
    checkItem(cognome, /^[a-zA-Z]{3,16}$/);
    checkNascita(nascita);
    checkItem(tel, /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/);
    checkRepeatPassword(password,repeatpassword);

  }
  /*
    se una password ripetuta non è corretta segnala un errore
  */
  function checkRepeatPassword(password,rpassword)
  {
    if(!rpassword.value == '')
    {
      if(! (password.value == rpassword.value))
      {
        setErrorBox(rpassword);
        return false;
      }
    }
    removeErrorBox(rpassword);
    return true;
  }

  /*
    se l'item non rispetta l'espressione regolare (RE) => segnala un errore
    altrimenti => rimuovi la segnalazione (se presente)
  */
  function checkItem(item, re)
  {
    if(!item.value == '' && !re.test(item.value))
    {
      setErrorBox(item);
      return false;
    }
    removeErrorBox(item);
    return true;
  }

  /*
    come checkItem, ma specifico per la data
  */
function checkNascita(data)
{
  if(!data.value == '')
  {
    correct = true;
    //controllo iniziale, data generica
    var re = /^(0[1-9]|[12][0-9]|3[01])[\- \/.](?:(0[1-9]|1[012])[\- \/.](19|20)[0-9]{2})|$/;
    if (!re.test(data.value))
    {
      correct = false;
    }
    //controllo 31 02,04-06... e febbraio
    re = /^(31.(0[2469]|11).....)|(30.02.....)$/;
    if(re.test(data.value))
    {
      correct = false;
    }
    //return : true se tutti i controlli passano
    if(!correct)
    {
      setErrorBox(data);
      return false;
    }
  }
  removeErrorBox(data);
  return true;
}


function setErrorBox(box)
{
  if(box.classList.contains('errorBox'))
  {
    return;
  }
  box.classList.add('errorBox');
  var lastLetter = 'o';
  var firstLetter = 'Il';
  if(box.id == 'password' || box.id == 'email' || box.id == 'nascita')
  {
   var lastLetter = 'a';
   var firstLetter = 'La';
  }
  var boxName = box.id;
  if (boxName == 'cel')
  {
    boxName = 'N. di telefono';
  }
  if (boxName == 'nascita')
  {
    boxName = 'data';
  }
  var legend = document.getElementsByTagName("legend")[0];
  if (boxName == 'repeatpassword')
  {
    legend.outerHTML += "<p class='errorLine' id='errorMessage"+ box.id +"'>Le password non coincidono.</p>";
  }else
  {
    legend.outerHTML += "<p class='errorLine' id='errorMessage"+ box.id +"'>"+firstLetter+ " " +boxName +" non è corrett"+ lastLetter +"</p>";
  }

}

function removeErrorBox(box)
{
  if(box.value == "" || !box.classList.contains('errorBox'))
  {
      return false;
  }
  errBox = document.getElementById("errorMessage"+box.id);
  errBox.outerHTML = ""; 
  box.classList.remove('errorBox');
  return true;
}