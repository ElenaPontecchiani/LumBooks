window.onload=function()
{

  document.getElementById("email").addEventListener("focus",checkRegisterInput);
  document.getElementById("nome").addEventListener("focus",checkRegisterInput);
  document.getElementById("password").addEventListener("focus",checkRegisterInput);
  document.getElementById("cel").addEventListener("focus",checkRegisterInput);
  document.getElementById("cognome").addEventListener("focus",checkRegisterInput);
  document.getElementById("nascita").addEventListener("focus",checkRegisterInput);
  document.getElementById("sesso").addEventListener("focus",checkRegisterInput);
  document.getElementById("repeatpassword").addEventListener("focus",checkRegisterInput);
  
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
      checkPassword(password);
      checkEmail(email);
      checkName(nome);
      checkName(cognome);
      checkNascita(nascita);
      checkTel(tel);
      checkRepeatPassword(password,repeatpassword);
  }

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
  function checkEmail(email) 
{
  if(!email.value == '')
  {
  var re = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if (!re.test(email.value))
    {
      setErrorBox(email);
      return false;
    }
  }
 removeErrorBox(email);
 return true;
}

function checkPassword(password)
{
  if(!password.value == '')
  {
    // almeno un numero e una lettera minuscola
    // almeno 6 caratteri
    var re = /^(?=.*[0-9])(?=.*[a-z])[a-zA-Z0-9!.@#$%^&*]{6,16}$/;
    if(!re.test(password.value))
    {
      setErrorBox(password);
      return false;
    }
  }
  removeErrorBox(password);
  return true;
}

function checkTel(tel)
{
  if(!tel.value == '')
  {
  var re = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/;
  if(!re.test(tel.value))
  {
    setErrorBox(tel);
    return false;
  }
  }
  removeErrorBox(tel);
  return true;
}

function checkName(name)
{
  if(!name.value == '')
  {
    var re = /^[a-zA-Z]{3,16}$/;
    if(!re.test(name.value))
    {
      setErrorBox(name);
      return false;
    }
  }
  removeErrorBox(name);
  return true;
}

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
  reFebbraio = /^(31.(0[2469]|11).....)|(30.02.....)$/
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
  if(box.id == 'password' || box.id == 'email' || box.id == 'nascita')
  {
   var lastLetter = 'a';
  }
  var boxName = box.id;

  if(boxName == 'cel')
  {
    boxName = 'N. di telefono';
  } 

  if(boxName == 'nascita')
  {
    boxName = 'data';
  }
  if(boxName == 'repeatpassword')
  {
    box.outerHTML += "<p class='errorMessage'>le password non coincidono</p>";
  }else
  {
    box.outerHTML += "<p class='errorMessage' id='errorMessage"+box.id+"'>"+ boxName +" non corrett"+ lastLetter +"</p>";
  }

}

function removeErrorBox(box)
{
  if(!box.classList.contains('errorBox'))
  {
      return false;
  }
  errBox = document.getElementById("errorMessage"+box.id);
  errBox.outerHTML = ""; 
  box.classList.remove('errorBox');
  return true;
}