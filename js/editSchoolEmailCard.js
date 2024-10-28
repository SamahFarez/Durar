// Edit School Email card
const editSchoolEmailOverlay = document.getElementById("editSchoolEmailOverlay");
const editSchoolEmailskipBtn = document.getElementById("editSchoolEmailskipBtn");
const editSchoolEmailskipBtnX = document.getElementById("editSchoolEmailskipBtnX");
const editSchoolEmailConfirmBtn = document.getElementById('editSchoolEmailConfirmBtn');

function showEditSchoolEmailOverlay(event) {
  event.preventDefault(); // Prevents the form from being submitted
  editSchoolEmailOverlay.style.display = "block";
};

editSchoolEmailskipBtn.addEventListener("click", function() {
    editSchoolEmailOverlay.style.display = "none";
}, false);

editSchoolEmailskipBtnX.addEventListener ("click", function(){
    editSchoolEmailOverlay.style.display = "none";
});

editSchoolEmailConfirmBtn.addEventListener("click", function() {
    editSchoolEmailOverlay.style.display = "none";
}, false);