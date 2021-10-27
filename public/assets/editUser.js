
var nav = document.getElementById("navmenu");
var navlink = document.getElementsByClassName("nav-link");


for (var j = 0; j < navlink.length; j++) {
  navlink[j].addEventListener("click", function() {
  
  var current = document.getElementsByClassName("active")[0];
  const previousIcon = current.getElementsByTagName('i')[0];
//   previousIcon.style.visibility = 'hidden';
  previousIcon.className = previousIcon.className.replace("active", "");
  current.className = current.className.replace(" active", "");
  this.classList.add("active");
  
  const icon = this.getElementsByTagName('i')[0];
//   icon.style.visibility = 'visible';
  icon.classList.add("active");
//   this.className += " active";
  });
}