// Add Teacher Card pop up and pop out 
const AddTeacherOverlay = document.getElementById("AddTeacherOverlay");
const AddTeachercloseBtn = document.getElementById("AddTeachercloseBtn");
const AddTeachercloseBtnX = document.getElementById("AddTeachercloseBtnX");

function showAddTeacherOverlay() {
  const AddTeacherOverlay = document.getElementById("AddTeacherOverlay");
  AddTeacherOverlay.style.display = "block";
  const AddTeacherButtons = document.getElementById("AddTeacherButtons");
  AddTeacherButtons.style.display = "flex";
};

AddTeachercloseBtn.addEventListener("click", function() {
  const AddTeacherOverlay = document.getElementById("AddTeacherOverlay");
  console.log(AddTeacherOverlay);
  AddTeacherOverlay.style.display = "none";
}, false);

AddTeachercloseBtnX.addEventListener("click", function(){
  const AddTeacherOverlay = document.getElementById("AddTeacherOverlay");
  AddTeacherOverlay.style.display = "none";
},false);



// Implementation of the card changes in the Add Teacher card
const addTeacher1 = document.getElementById('addTeacher1');
const addTeacher2 = document.getElementById('addTeacher2');

const ShowTeacherSearchResult = document.getElementById('ShowTeacherSearchResult');
const confirmAddTeacher = document.getElementById('confirmAddTeacher');

ShowTeacherSearchResult.addEventListener("click", function(event) {
  console.log("HHH");
  event.preventDefault(); // Prevents the form from being submitted
  const addTeacher2 = document.getElementById('addTeacher2');
  addTeacher2.style.display = "flex";
}, false);

confirmAddTeacher.addEventListener("click", function() {
  AddTeacherOverlay.style.display = "none";
}, false);