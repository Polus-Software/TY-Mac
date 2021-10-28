
var nav = document.getElementById("navmenu");
var navlink = document.getElementsByClassName("nav-link");


for (var j = 0; j < navlink.length; j++) {
  navlink[j].addEventListener("click", function() {
  
  var current = document.getElementsByClassName("active")[0];
  const previousIcon = current.getElementsByTagName('i')[0];

  previousIcon.className = previousIcon.className.replace("active", "");
  current.className = current.className.replace(" active", "");
  this.classList.add("active");
  
  const icon = this.getElementsByTagName('i')[0];

  icon.classList.add("active");

  });
}



document.querySelector('#editUserForm').addEventListener('submit', (e) => {
  
  
  if(firstname.value === '') {
    e.preventDefault();
      showError(firstname,'First name is required');
  }else if(!isValidFirstName(firstname.value)){
    e.preventDefault();
    showError(firstname,'First name must contain only letters');
  }else {
    removeError(firstname)
  }
  if(lastname.value === '') {
    e.preventDefault();
    showError(lastname,'Last name is required');
  } else if(!isValidLastName(lastname.value)){
    e.preventDefault();
    showError(lastname,'Last name must contain only letters');
  }else {
  removeError(lastname)
  }
  if(email.value === '') {
    e.preventDefault();
    showError(email,'Email is required');
  }else if(!isValidEmail(email.value)){
    e.preventDefault();
    showError(email,'Email is not valid');
  } else {
  removeError(email)
  }
  });

  const editform = document.getElementById('editUserForm');
  const firstname = document.getElementById('firstname');
  const lastname = document.getElementById('lastname');
  const email = document.getElementById('email');

  function showError(input,message){
    input.style.borderColor = 'red';
    const formControl=input.parentElement;
    const small=formControl.querySelector('small');
    small.innerText=message;
    small.style.visibility = 'visible';
}

function removeError(input){
  input.style.borderColor = '#ced4da';
  const formControl=input.parentElement;
  const small=formControl.querySelector('small');
  small.style.visibility = 'hidden';
}

function isValidEmail(email)
{
    const re= /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
}



function isValidFirstName(firstname){
  const regName = /^[a-zA-Z]+ [a-zA-Z]+$/;
  return regName.test(String(firstname));
}

function isValidLastName(lastname){
  const regName = /^[a-zA-Z]$/;
  return regName.test(String(lastname));
}
