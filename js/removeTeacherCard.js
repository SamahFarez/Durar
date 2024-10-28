// Remove Teacher Card pop up and pop out 
const RemoveTeacherOverlay = document.getElementById("RemoveTeacherOverlay");
const RemoveTeachercloseBtn = document.getElementById("RemoveTeachercloseBtn");
const RemoveTeachercloseBtnX = document.getElementById("RemoveTeachercloseBtnX");
const confirmRemoveTeacher = document.getElementById('confirmRemoveTeacher');


function showRemoveTeacherOverlay(event, teacher_id, teacher_name, eps_num) {
  event.preventDefault(); // Prevents the form from being submitted
  const teacherNameElement = document.getElementById('teacherName');
  teacherNameElement.textContent = teacher_name;
  updateTeacherIdandEpsNum(teacher_id, eps_num);
  RemoveTeacherOverlay.style.display = "block";
};

function updateTeacherIdandEpsNum(teacherId, epsNum) {
  var confirmButton = document.getElementById('confirmRemoveTeacher');
  var currentOnClickValue = confirmButton.getAttribute('onclick');

  // Replace the current teacher_id value with the new one
  var newOnClickValue = currentOnClickValue.replace(/teacher_id=\d+/, 'teacher_id=' + teacherId);

  // Replace the current eps_num value with the new one
  newOnClickValue = newOnClickValue.replace(/eps_num=\d+/, 'eps_num=' + epsNum);

  // Update the onclick attribute with the new value
  confirmButton.setAttribute('onclick', newOnClickValue);
  console.log(newOnClickValue);
}


RemoveTeachercloseBtn.addEventListener("click", function() {
  RemoveTeacherOverlay.style.display = "none";
}, false);

RemoveTeachercloseBtnX.addEventListener("click", function() {
    RemoveTeacherOverlay.style.display = "none";
  }, false);

confirmRemoveTeacher.addEventListener("click", function() {
  RemoveTeacherOverlay.style.display = "none";
}, false);