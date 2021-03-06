// espressioni regolari per la validazione dei campi 
const RE_PASSWORD = /^(?=.*[0-9])(?=.*[a-z])[a-zA-Z0-9!.@#$%^&*]{6,16}$/;
const RE_EMAIL = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
const RE_NOME = /^[a-zA-Z]{3,16}$/;
const RE_TEL = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
const RE_AUTORE = /^[a-zA-Z ]{3,32}$/;
const RE_CORSO = /^[a-zA-Z0-9 ]{2,64}$/;
const RE_EDIZIONE = /^[a-zA-Z0-9 ]{3,32}$/;
const RE_ANNO = /^(1|2)[0-9]{3}$/;
const RE_ISBN = /^[0-9]{13}$/;
const RE_PREZZO = /(^(\€|\$)?0*[1-9][0-9]{0,3}((,|.)[0-9]{0,2}0*)?$)|(^0*[1-9][0-9]{0,3}((,|.)[0-9]{0,2}0*)?(\€|\$)?$)/;
window.onload = function () {

  // pulsante per l'apertura/chiusura del menu' laterale
  document.getElementById("openNavButton").addEventListener("click", openNavbar);
  document.getElementById("close").addEventListener("click", closeNavbar);

  // *********** validazione campi Registrazione ******** //
  if (document.getElementById("registerForm") != null) {
    items = [
      "email",
      "password",
      "nome",
      "cel",
      "cognome",
      "nascita",
      "repeatpassword"
    ];
    items.forEach(function (item) {
      document.getElementById(item).addEventListener("focus", checkRegisterInput);
    });

    //disabilito il form se almeno uno dei seguenti elementi passati come parametro non è corretto
    disableForm(items, "registerForm", checkRegisterInput);
  }

  // ************ validazione login ********* //
  if (document.getElementById("loginForm") != null) {
    items = [
      "loginEmail",
      "inputPsw"
    ];
    items.forEach(function (item) {
      document.getElementById(item).addEventListener("focus", checkLoginInput);
    });
    disableForm(items, "loginForm", checkLoginInput);
  }
  /************ Validazione inserimento libri *******************/
  if (document.getElementById("insertBox") != null) {
    items = [
      "insertEdizione",
      "insertAnno",
      "insertISBN",
      "insertPrezzo",
      "insertTitolo",
      "insertAutore",
      "insertCasaEditrice",
      "insertCorso"
    ];
    document.getElementById("listato").addEventListener("change", changeBooksInput);    
    document.getElementById("personale").addEventListener("change", changeBooksInput);
    items.forEach(function (item) {
      document.getElementById(item).addEventListener("focus", checkBookInput);
    });
    disableForm(items, "insertBox", checkBookInput);
  }
  /************** Validazione modifica libro *************/
  if (document.getElementById("modifyBox") != null) {
    items = [
      "insertEdizione",
      "insertAnno",
      "insertISBN",
      "insertPrezzo",
      "insertTitolo",
      "insertAutore",
      "insertCasaEditrice",
      "insertCorso"
    ];
    items.forEach(function (item) {
      document.getElementById(item).addEventListener("focus", checkBookInput);
    });
    disableForm(items, "modifyBox", checkBookInput);
  }

  //nascondere/mostrare le opzioni per il libro listato (inserisci.html)
  if (document.getElementById('listato') != null) {
    formselector();
    document.getElementById("listato").addEventListener("change", formselector);
    document.getElementById("personale").addEventListener("change", formselector);
  }

  /* mostrare e nascondere regole in regolamento.html */
  if (document.getElementById("ruleBox") != null) {
    var input = document.getElementsByTagName("dt");
    titles = Array.prototype.slice.call(input).map(el => el.id);
    titles.forEach(function (el) {
      toggleRuleBox(el);
      toggleRuleBox(el.replace('Title', 'Desc'));
    });
  }
}//end window.onload()

/*
  attiva o disattiva le descrizioni nel regolamento
*/
function toggleRuleBox(el) {
  document.getElementById(el).addEventListener("click", function () {
    descId = el.replace('Title', 'Desc');
    document.getElementById(descId).classList.toggle("hidden");
    // non posso usare il last element di css perché dopo di questo c'è un dd che può comparire o scomparire.
    if (el == "contactsTitle") {
      document.getElementById(el).classList.toggle("lastElement");
    }
  });
}
/*
  changeBooksInput cambia i campi obbligatori per "inserisci.html" 
*/
function changeBooksInput() {
  items = [
    "insertTitolo",
    "insertAutore",
    "insertCasaEditrice",
    "insertCorso"
  ];
  items.forEach(function (item) {
    var itemClass = document.getElementById(item).classList;
    if (itemClass.contains("required")) {
      removeErrorBox(document.getElementById(item), true);
      document.getElementById(item).value = "";
      itemClass.remove("required");
    } else {
      itemClass.add("required");
    }
  });
}

/*  
  nascondere/mostrare la navbar 
*/
function openNavbar() {
  var nav = document.getElementById("navbar");
  nav.classList.add("showNavbar");
}

function closeNavbar() {
  var nav = document.getElementById("navbar");
  nav.classList.remove("showNavbar");
}


/*
  se una password ripetuta non è corretta segnala un errore
*/
function checkRepeatPassword(password, rpassword) {
  if (!rpassword.value == '') {
    if (!(password.value == rpassword.value)) {
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
function checkItem(item, re) {
  if (!item.value == '' && !re.test(item.value)) {
    setErrorBox(item);
    return false;
  }
  removeErrorBox(item, true);
  return true;
}

/*
  come checkItem, ma specifico per una data
*/
function checkNascita(date) {
  if (!date.value == '') {
    correct = true;
    //controllo iniziale, data generica
    var re = /(^(0[1-9]|[12][0-9]|3[01])[\- \/.](?:(0[1-9]|1[012])[\- \/.](19|20)[0-9]{2})$)|(^(19|20)[0-9]{2}[\- \/.](0[1-9]|1[012])[\- \/.](0[1-9]|[12][0-9]|3[01])$)/;
    if (!re.test(date.value)) {
      correct = false;
    }
    //controllo 31 02,04-06... e febbraio
    re = /^(31.(0[2469]|11).....)$|^(30.02.....)$|^(.....(0[2469]|11).31)$|^(.....02.30)$/;
    if (re.test(date.value)) {
      correct = false;
    }
    //return : true se tutti i controlli passano
    if (!correct) {
      setErrorBox(date);
      return false;
    }
  }
  removeErrorBox(date);
  return true;
}
function setErrorBox(box) {
  if (box.classList.contains('errorBox')) {
    return;
  }
  box.classList.add('errorBox');
  /* stampa un errore scritto bene */
  var lastLetter = 'o';
  var firstLetter = 'Il';
  var boxName = box.id;

  switch (boxName) {
    case 'cel': boxName = 'N. di telefono';
      break;
    case 'nascita': boxName = 'data';
      break;
    case 'inputPsw': boxName = 'password';
      break;
    case 'loginEmail': boxName = 'email';
      break;
    case 'insertTitolo': boxName = 'titolo';
      break;
    case 'insertAutore': boxName = 'autore';
      break;
    case 'insertCasaEditrice': boxName = 'casa editrice';
      break;
    case 'insertCorso': boxName = 'corso';
      break;
    case 'insertEdizione': boxName = 'edizione';
      break;
    case 'insertAnno': boxName = 'anno';
      break;
    case 'insertISBN': boxName = 'isbn';
      break;
    case 'insertPrezzo': boxName = 'prezzo';
  }
  var legend = document.getElementsByTagName("legend")[0];
  if (boxName == 'password' || boxName == 'email' || boxName == 'nascita' || boxName == 'casa editrice' || boxName == 'edizione' || boxName == 'data') {
    lastLetter = 'a';
    firstLetter = 'La';
  }
  if (boxName == 'isbn' || boxName == 'anno' || boxName == 'email' || boxName == 'edizione') {
    firstLetter = "L'";
  }
  legend.outerHTML += (boxName == 'repeatpassword') ?
    "<p class='errorLine' id='errorMessage" + box.id + "'>Le password non coincidono.</p>" : /* true */
    "<p class='errorLine' id='errorMessage" + box.id + "'>" + firstLetter + " " + boxName + " non è corrett" + lastLetter + "</p>"; /*false*/

}

function removeErrorBox(box, emptyAllowed = false) {
  if ((box.value == "" && emptyAllowed == false) || !box.classList.contains('errorBox')) {
    return false;
  }
  errBox = document.getElementById("errorMessage" + box.id);
  errBox.outerHTML = "";
  box.classList.remove('errorBox');
  return true;
}

/* funzione per inserisci.html */
function formselector() {
  document.getElementById('inserisci-personale').classList.toggle("hidden");
  document.getElementById('inserisci-listato').classList.toggle("hidden");
}

/* validazione login */

function checkLoginInput() {
  var email = document.getElementById("loginEmail");
  var password = document.getElementById("inputPsw");
  checkItem(password, /^(?=.*[0-9])(?=.*[a-z])[a-zA-Z0-9!.@#$%^&*]{6,16}$/);
  checkItem(email, /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/);

}

/*
  /////// validazione campi registrazione ////////
*/
function checkRegisterInput() {
  var email = document.getElementById("email");
  var password = document.getElementById("password");
  var nome = document.getElementById("nome");
  var tel = document.getElementById("cel");
  var cognome = document.getElementById("cognome");
  var nascita = document.getElementById("nascita");
  var repeatpassword = document.getElementById("repeatpassword");
  checkItem(password, RE_PASSWORD);
  checkItem(email, RE_EMAIL);
  checkItem(nome, RE_NOME);
  checkItem(cognome, RE_NOME);
  checkItem(tel, RE_TEL);
  checkNascita(nascita);
  checkRepeatPassword(password, repeatpassword);
}

/*
  disabilita un form se gli elementi non validano la funzione di validazione
  parametri: elements => id degli elementi da validare
            form => form da disabilitare
            funzioneValidazione => funzione che valida gli elementi 
*/
function disableForm(elements, form, funzioneValidazione) {
  if (document.getElementById(form) != null) {
    elements.forEach(function (el) {
      document.getElementById(el).addEventListener("focus", funzioneValidazione);
    });
    document.getElementById(form).addEventListener("submit", function (event) {
      funzioneValidazione();

      if (elements.includes("repeatpassword"))
        elements.splice(elements.indexOf("repeatpassword"), 1);

      var items = elements.map(function (item) {
        return document.getElementById(item);
      });
      // controllo campi sono vuoti e segnalazione errore. 
      items.filter(el => (el.classList.contains("required") && el.value == ""))
        .forEach(element => setErrorBox(element));
      errors = document.getElementsByClassName("errorLine");
      if (!errors.length == 0) {
        event.preventDefault();
      }
    });
  }
}
/*
  Validazione dei campi inserimento libro
*/
function checkBookInput() {
  var autore = document.getElementById("insertAutore");
  var corso = document.getElementById("insertCorso");
  var edizione = document.getElementById("insertEdizione");
  var anno = document.getElementById("insertAnno");
  var isbn = document.getElementById("insertISBN");
  var prezzo = document.getElementById("insertPrezzo");
  checkItem(autore, RE_AUTORE);
  checkItem(corso, RE_CORSO);
  checkItem(edizione, RE_EDIZIONE);
  checkItem(anno, RE_ANNO);
  checkItem(isbn, RE_ISBN);
  checkItem(prezzo, RE_PREZZO);
}
