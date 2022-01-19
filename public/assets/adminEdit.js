document.querySelector('#editStudentsForm').addEventListener('submit', (e) => {
  
  
    if(firstname.value === '') {
      e.preventDefault();
        showError(firstname,'First name is required');
    }else {
      removeError(firstname)
    }
    if(lastname.value === '') {
      e.preventDefault();
      showError(lastname,'Last name is required');
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
    if(password.value === '') {
      e.preventDefault();
        showError(password,' password is required');
    }else {
      removeError(password)
    }
    });
  
    const updateform = document.getElementById('editStudentsForm');
    const firstname = document.getElementById('firstname');
    const lastname = document.getElementById('lastname');
    const email = document.getElementById('email');
    const password = document.getElementById('password');
  
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
  
