// Acount Page
var loginForm = document.getElementById("loginForm")
var regForm = document.getElementById("regForm")
var indicator = document.getElementById("indicator")


function login(){
    loginForm.style.transform = "translateX(0px)"
    regForm.style.transform = "translateX(0px)"
    indicator.style.transform = "translateX(0px)"
    loginForm.classList.add("transition")
    regForm.classList.add("transition")
    indicator.classList.add("transition")
}

function register(){
    loginForm.style.transform = "translateX(-450px)"
    regForm.style.transform = "translateX(-450px)"
    indicator.style.transform = "translateX(100px)"
    loginForm.classList.add("transition")
    regForm.classList.add("transition")
    indicator.classList.add("transition")
}

function registererror(){
    loginForm.style.transform = "translateX(-450px)"
    regForm.style.transform = "translateX(-450px)"
    indicator.style.transform = "translateX(100px)"
    loginForm.classList.remove("transition")
    regForm.classList.remove("transition")
    indicator.classList.remove("transition")
}