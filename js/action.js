window.onload=function()
{

  // pulsante per l'apertura/chiusura del menu' laterale
  document.getElementById("openNavButton").addEventListener("click",openNavbar);
  document.getElementById("close").addEventListener("click",closeNavbar);

  // *********** validazione campi Registrazione ********
  if(document.getElementById("registerForm") != null)
  {
      items = [
      "email",
      "password",
      "nome",
      "cel",
      "cognome",
      "nascita",
      "repeatpassword"
    ];

    //aggiungo un controllo mentre i dati vengono modificati
    items.forEach(function(item){
      document.getElementById(item).addEventListener("focus",checkRegisterInput);
    });

    //disabilito il form se almeno uno dei seguenti elementi passati come parametro non è corretto
    disableForm(items,"registerForm",checkRegisterInput);
  }

  /* validazione login */
  if(document.getElementById("loginForm") != null)
  {
    items = [
      "loginEmail",
      "inputPsw"
    ];
    items.forEach(function(item){
      document.getElementById(item).addEventListener("focus",checkLoginInput);
    });

    disableForm(items,"loginForm",checkLoginInput);
  }

  if(document.getElementById("insertBox") != null)
  {
    //..validazione inserimento libri
  }

  //nascondere/mostrare le opzioni per il libro listato (inserisci.html)
  if(document.getElementById('listato') != null)
  {
    formselector();
    document.getElementById("listato").addEventListener("click", formselector);
    document.getElementById("personale").addEventListener("click", formselector);
  }

}
 
/*  nascondere/mostrare la navbar */
  function openNavbar()
  {
    var nav = document.getElementById("navbar");
    nav.classList.add("showNavbar");
  }

  function closeNavbar()
  {
    var nav = document.getElementById("navbar");
    nav.classList.remove("showNavbar");
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
  /* stampa un errore scritto bene */
  var lastLetter = 'o';
  var firstLetter = 'Il';
  var boxName = box.id;

  switch(boxName)
  {
    case 'cel': boxName = 'N. di telefono';
          break;
    case 'nascita': boxName = 'data' ;
          break;
    case 'inputPsw': boxName = 'password';
          break;
    case 'loginEmail': boxName = 'email';
          break;
  }

  var legend = document.getElementsByTagName("legend")[0];
  if(boxName == 'password' || boxName == 'email' || boxName == 'nascita')
  {
   var lastLetter = 'a';
   var firstLetter = 'La';
  }
  legend.outerHTML += (boxName == 'repeatpassword')? 
    "<p class='errorLine' id='errorMessage"+ box.id +"'>Le password non coincidono.</p>": /* true */
    "<p class='errorLine' id='errorMessage"+ box.id +"'>"+firstLetter+ " " +boxName +" non è corrett"+ lastLetter +"</p>"; /*false*/

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

/*
  Validazione campi inserimento libro
*/



/* funzione per inserisci.html */
function formselector()
{
  listato = document.getElementById('listato').checked;
  if(listato)
  {
    document.getElementById('inserisci-personale').classList.add("hidden");
    document.getElementById('inserisci-listato').classList.remove("hidden");
  }else
  {
    document.getElementById('inserisci-listato').classList.add("hidden");
    document.getElementById('inserisci-personale').classList.remove("hidden");
  }
}

/* validazione login */

function checkLoginInput()
{
  var email = document.getElementById("loginEmail");
  var password = document.getElementById("inputPsw");
  checkItem(password,/^(?=.*[0-9])(?=.*[a-z])[a-zA-Z0-9!.@#$%^&*]{6,16}$/);
  checkItem(email, /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/);

}

/*
  /////// validazione campi registrazione ////////
*/
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

  /* validazione login */
  function disableForm(elements, form, funzioneValidazione){
  if(document.getElementById(form) != null)
  {
    elements.forEach(el => function(){
      document.getElementById(el).addEventListener("focus",funzioneValidazione);
    });
    document.getElementById(form).addEventListener("submit",function(event){
    funzioneValidazione();

    var items = elements.map(el => function(item){
      return document.getElementById(item);
    });
    // controllo campi sono vuoti e segnalazione errore. 
    items.filter(el => el.value == 0)
      .forEach(element => setErrorBox(element));
      errors = document.getElementsByClassName("errorLine");
    if (!errors.length==0)
    {
      event.preventDefault();
    }
    });
  }
}