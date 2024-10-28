// Add Admin Card pop up and pop out 
const closeHala9aSettings = document.getElementById("closeHala9aSettings");
const closeHala9aSettingsX = document.getElementById("closeHala9aSettingsX");


// Implementation of the card changes in the Add Admin card
const Hala9aSettings = document.getElementById('Hala9aSettings');
const Hala9aSettings1_1 = document.getElementById('Hala9aSettings1_1');
const Hala9aSettings1_2 = document.getElementById('Hala9aSettings1_2');
const Hala9aSettings2 = document.getElementById('Hala9aSettings2');
const Hala9aSettings3 = document.getElementById('Hala9aSettings3');

const moveToHala9aSettings1 = document.getElementById('moveToHala9aSettings1');
const ShowSearchChangeTeacherResult = document.getElementById('ShowSearchChangeTeacherResult');
const moveToHala9aSettings2 = document.getElementById('moveToHala9aSettings2');
const Hala9aSettings1Buttons = document.getElementById('Hala9aSettings1Buttons');
const Hala9aSettings1close = document.getElementById('Hala9aSettings1close');
const Hala9aSettings1confirm = document.getElementById('Hala9aSettings1confirm');
const Hala9aSettings2close = document.getElementById('Hala9aSettings2close');
const Hala9aSettings2confirm = document.getElementById('Hala9aSettings2confirm');
const Hala9aSettings3close = document.getElementById('Hala9aSettings3close');
const Hala9aSettings3confirm = document.getElementById('Hala9aSettings3confirm');

moveToHala9aSettings1.addEventListener("click", function (event) {
    // event.preventDefault(); // Prevents the form from being submitted
    Hala9aSettings.style.display = "none";
    Hala9aSettings1_1.style.display = "block";
    Hala9aSettings1Buttons.style.display = "flex";
}, false);


moveToHala9aSettings2.addEventListener("click", function (event) {
    event.preventDefault(); // Prevents the form from being submitted
    Hala9aSettings2.style.display = "flex";
    Hala9aSettings.style.display = "none";
}, false);

moveToHala9aSettings3.addEventListener("click", function (event) {
    event.preventDefault(); // Prevents the form from being submitted
    Hala9aSettings3.style.display = "flex";
    Hala9aSettings.style.display = "none";
}, false);


Hala9aSettings1close.addEventListener("click", function (event) {
    event.preventDefault(); // Prevents the form from being submitted
    Hala9aSettings.style.display = "flex";
    Hala9aSettings1_1.style.display = "none";
    Hala9aSettings1_2.style.display = "none";
    Hala9aSettings1Buttons.style.display = "none";

});

Hala9aSettings2close.addEventListener("click", function (event) {
    event.preventDefault(); // Prevents the form from being submitted
    Hala9aSettings.style.display = "flex";
    Hala9aSettings2.style.display = "none";
});

Hala9aSettings3close.addEventListener("click", function (event) {
    event.preventDefault(); // Prevents the form from being submitted
    Hala9aSettings.style.display = "flex";
    Hala9aSettings3.style.display = "none";
});

function deleteHalakah() {
    var hala9aSettings2 = document.getElementById('Hala9aSettings2');
    hala9aSettings2.style.display = "block";
}

function editBio() {
    var hala9aSettings3 = document.getElementById('Hala9aSettings3');
    hala9aSettings3.style.display = "block";
}