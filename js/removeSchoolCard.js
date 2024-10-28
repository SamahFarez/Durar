// Remove School card
const removeSchoolOverlay = document.getElementById("removeSchoolOverlay");
const removeSchoolskipBtn = document.getElementById("removeSchoolskipBtn");
const removeSchoolskipBtnX = document.getElementById("removeSchoolskipBtnX");
const removeSchoolConfirmBtn = document.getElementById('removeSchoolConfirmBtn');


function showremoveSchoolOverlay(event) {
  event.preventDefault(); // Prevents the form from being submitted
  removeSchoolOverlay.style.display = "block";
};

removeSchoolskipBtn.addEventListener("click", function() {
    removeSchoolOverlay.style.display = "none";
}, false);

removeSchoolskipBtnX.addEventListener ("click", function(){
    removeSchoolOverlay.style.display = "none";
});

removeSchoolConfirmBtn.addEventListener("click", function() {
    removeSchoolOverlay.style.display = "none";
}, false);
