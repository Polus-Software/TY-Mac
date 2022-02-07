
// var nav = document.getElementById("navmenu");
// var navlink = document.getElementsByClassName("nav-link");


// for (var j = 0; j < navlink.length; j++) {
//   navlink[j].addEventListener("click", function() {
  
//   var current = document.getElementsByClassName("active")[0];
//   const previousIcon = current.getElementsByTagName('i')[0];

//   previousIcon.className = previousIcon.className.replace("active", "");
//   current.className = current.className.replace(" active", "");
//   this.classList.add("active");
  
//   const icon = this.getElementsByTagName('i')[0];

//   icon.classList.add("active");

//   });
// }


// validation for edit form
document.querySelector('#editUserForm').addEventListener('submit', (e) => {
  
 
  if(firstname.value === '' || firstname.value == null) {
    e.preventDefault();
    displayError(firstname,'First name is required');
  }else {
    removeError(firstname)
  }
  if(lastname.value === '') {
    e.preventDefault();
    displayError(lastname,'Last name is required');
  }else {
  removeError(lastname)
  }
  if(email.value === '') {
    e.preventDefault();
    displayError(email,'Email is required');
  }else if(!isValidEmail(email.value)){
    e.preventDefault();
    displayError(email,'Email is not valid');
  } else {
  removeError(email)
  }
  });

  const editform = document.getElementById('editUserForm');
  const firstname = document.getElementById('firstname');
  const lastname = document.getElementById('lastname');
  const email = document.getElementById('email');

  // function showError(input,message){
  //   input.style.borderColor = 'red';
  //   const formControl=input.parentElement;
  //   const small=formControl.querySelector('small');
  //   small.innerText=message;
  //   small.style.visibility = 'visible';
  // }

  function displayError(inputs,message){
    inputs.style.borderColor = 'red';
    const formControl=inputs.parentElement;
    const small=formControl.querySelector('small');
    small.innerText=message;
    small.style.visibility = 'visible';
    console.log("poda patty");
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


//validation for file uploadong
document.getElementById('uploadButton').addEventListener('click',function(e){

var image = document.getElementById('image');
var filepath = image.value;

  if(filepath == ''){
    e.preventDefault();
    showError(image,'Please upload  an image');
  }else {
    removeError(image)
    closeModal('uploadModal')
  }

});

function showError(input,message){
  input.style.borderColor = 'red';
  const small=document.getElementById('profile_picture_error');
  small.innerText=message;
  small.style.visibility = 'visible';
}

function removeError(input){
input.style.borderColor = '#ced4da';
const small=document.getElementById('profile_picture_error');
small.style.visibility = 'hidden';
}


function closeModal(modalId) {

  const truck_modal = document.querySelector('#' + modalId);
  const modal = bootstrap.Modal.getInstance(truck_modal);    
  modal.hide();
}  
  
