window.onscroll = function() {myFunction()};

var nav = document.getElementById("nav");
var wrapper = document.getElementById("wrapper");

var sticky = nav.offsetTop;

function myFunction() {
  if (window.pageYOffset > 100) {
    nav.classList.add("sticky");
    wrapper.classList.add("sticky-2");
  } else {
    nav.classList.remove("sticky");
    wrapper.classList.remove("sticky-2");
  }
}