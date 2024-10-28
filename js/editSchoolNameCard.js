// Edit School Name card
const editSchoolNameOverlay = document.getElementById("editSchoolNameOverlay");
const editSchoolNameskipBtn = document.getElementById("editSchoolNameskipBtn");
const editSchoolNameskipBtnX = document.getElementById("editSchoolNameskipBtnX");
const editSchoolNameConfirmBtn = document.getElementById('editSchoolNameConfirmBtn');


function showEditSchoolNameOverlay(event) {
  event.preventDefault(); // Prevents the form from being submitted
  editSchoolNameOverlay.style.display = "block";
};

editSchoolNameskipBtn.addEventListener("click", function() {
    editSchoolNameOverlay.style.display = "none";
}, false);

editSchoolNameskipBtnX.addEventListener ("click", function(){
    editSchoolNameOverlay.style.display = "none";
});

editSchoolNameConfirmBtn.addEventListener("click", function() {
    editSchoolNameOverlay.style.display = "none";
}, false);