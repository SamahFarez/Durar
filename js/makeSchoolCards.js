// Add Student Card pop up and pop out 
const MakeSchoolOverlay = document.getElementById("MakeSchoolOverlay");

function showMakeSchoolOverlay() {
  MakeSchoolOverlay.style.display = "block";
};



// Implementation of the card changes in the Add Student card
const MakeSchool1 = document.getElementById('MakeSchool1');
const MakeSchool2 = document.getElementById('MakeSchool2');

const confirmDescriptionBtn = document.getElementById('confirmDescriptionBtn');
const confirmDescriptionBtn3 = document.getElementById('confirmDescriptionBtn3');

confirmDescriptionBtn.addEventListener("click", function(event) {
  event.preventDefault(); // Prevents the form from being submitted
  MakeSchool1.style.display = "none";
  MakeSchool2.style.display = "flex";
}, false);

confirmDescriptionBtn3.addEventListener("click", function(event) {
  event.preventDefault(); // Prevents the form from being submitted
  MakeSchool1.style.display = "none";
  MakeSchool2.style.display = "flex";
}, false);