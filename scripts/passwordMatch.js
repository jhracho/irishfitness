// JavaScript to dynamically update whether or not passwords match
var p1 = document.getElementById('password1-input');
var p2 = document.getElementById('password2-input');
var passwordMatch = document.getElementById('passwordMatch');

p1.addEventListener('keyup', checkMatch, false);
p2.addEventListener('keyup', checkMatch, false);

function checkMatch(e){
    if (p1.value != p2.value){
        passwordMatch.textContent = "Passwords Do Not Match";
    }
    else{
        passwordMatch.textContent = "Passwords Match!";
    }
}