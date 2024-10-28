const RemoveStudentOverlay = document.getElementById("RemoveStudentOverlay");
const RemoveStudentcloseBtn = document.getElementById("RemoveStudentcloseBtn");
const RemoveStudentcloseBtnX = document.getElementById("RemoveStudentcloseBtnX");
const confirmRemoveStudent = document.getElementById('confirmRemoveStudent');

function showRemoveStudentOverlay(event, student_id, student_name) {
  event.preventDefault(); // Prevents the form from being submitted
  const studentNameElement = document.getElementById('studentName');
  studentNameElement.textContent = student_name;
  updateStudentId(student_id);
  RemoveStudentOverlay.style.display = "block";
}

function updateStudentId(studentId) {
  var confirmButton = document.getElementById('confirmRemoveStudent');
  var currentOnClickValue = confirmButton.getAttribute('onclick');

  // Replace the current student_id value with the new one
  var newOnClickValue = currentOnClickValue.replace(/student_id=\d+/, 'student_id=' + studentId);
  // Update the onclick attribute with the new value
  confirmButton.setAttribute('onclick', newOnClickValue);
  console.log(newOnClickValue);
}



RemoveStudentcloseBtn.addEventListener("click", function() {
  RemoveStudentOverlay.style.display = "none";
}, false);

RemoveStudentcloseBtnX.addEventListener("click", function() {
    RemoveStudentOverlay.style.display = "none";
  }, false);

confirmRemoveStudent.addEventListener("click", function() {
  RemoveStudentOverlay.style.display = "none";
}, false);