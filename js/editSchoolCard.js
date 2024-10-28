// edit School card
const editSchoolCardOverlay = document.getElementById("editSchoolCardOverlay");
const editSchoolCardskipBtn = document.getElementById("editSchoolCardskipBtn");
const editSchoolCardskipBtnX = document.getElementById("editSchoolCardskipBtnX");
const editSchoolCardConfirmBtn = document.getElementById('editSchoolCardConfirmBtn');


function showEditSchoolCardOverlayOverlay(event) {
  event.preventDefault(); // Prevents the form from being submitted
  editSchoolCardOverlay.style.display = "block";
};

editSchoolCardskipBtn.addEventListener("click", function() {
    editSchoolCardOverlay.style.display = "none";
}, false);

editSchoolCardskipBtnX.addEventListener ("click", function(){
    editSchoolCardOverlay.style.display = "none";
});

editSchoolCardConfirmBtn.addEventListener("click", function() {
    editSchoolCardOverlay.style.display = "none";
}, false);