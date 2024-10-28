// Add Student Card pop up and pop out 
const AddStudentOverlay = document.getElementById("AddStudentOverlay");
const AddStudentcloseBtn = document.getElementById("AddStudentcloseBtn");
const AddStudentcloseBtnX = document.getElementById("AddStudentcloseBtnX");

function showAddStudentOverlay() {
    AddStudentOverlay.style.display = "block";
    const AddStudentButtons = document.getElementById("addStudentButtons");
    AddStudentButtons.style.display = "flex";
};

AddStudentcloseBtn.addEventListener("click", function() {
  AddStudentOverlay.style.display = "none";
}, false);

AddStudentcloseBtnX.addEventListener("click", function() {
  AddStudentOverlay.style.display = "none";
});



// Implementation of the card changes in the Add Student card
const addStudent1 = document.getElementById('addStudent1');
const addStudent2 = document.getElementById('addStudent2');

const ShowStudentSearchResult = document.getElementById('ShowStudentSearchResult');
const confirmAddStudent = document.getElementById('confirmAddStudent');

ShowStudentSearchResult.addEventListener("click", function(event) {
  event.preventDefault(); // Prevents the form from being submitted
  addStudent2.style.display = "flex";
}, false);

confirmAddStudent.addEventListener("click", function() {
  AddStudentOverlay.style.display = "none";
}, false);
