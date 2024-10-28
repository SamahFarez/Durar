// Edit School Cover card
const editSchoolCoverOverlay = document.getElementById("editSchoolCoverOverlay");
const editSchoolCoverskipBtn = document.getElementById("editSchoolCoverskipBtn");
const editSchoolCoverskipBtnX = document.getElementById("editSchoolCoverskipBtnX");
const editSchoolCoverConfirmBtn = document.getElementById('editSchoolCoverConfirmBtn');


function showEditSchoolCoverOverlay(event) {
  event.preventDefault(); // Prevents the form from being submitted
  editSchoolCoverOverlay.style.display = "block";
};

editSchoolCoverskipBtn.addEventListener("click", function() {
    editSchoolCoverOverlay.style.display = "none";
}, false);

editSchoolCoverskipBtnX.addEventListener ("click", function(){
    editSchoolCoverOverlay.style.display = "none";
});

editSchoolCoverConfirmBtn.addEventListener("click", function() {
    editSchoolCoverOverlay.style.display = "none";
}, false);