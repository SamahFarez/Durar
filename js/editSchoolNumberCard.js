// Edit School Number card
const editSchoolNumberOverlay = document.getElementById("editSchoolNumberOverlay");
const editSchoolNumberskipBtn = document.getElementById("editSchoolNumberskipBtn");
const editSchoolNumberskipBtnX = document.getElementById("editSchoolNumberskipBtnX");
const editSchoolNumberConfirmBtn = document.getElementById('editSchoolNumberConfirmBtn');


function showEditSchoolNumberOverlay(event) {
  event.preventDefault(); // Prevents the form from being submitted
  editSchoolNumberOverlay.style.display = "block";
};

editSchoolNumberskipBtn.addEventListener("click", function() {
    editSchoolNumberOverlay.style.display = "none";
}, false);

editSchoolNumberskipBtnX.addEventListener ("click", function(){
    editSchoolNumberOverlay.style.display = "none";
});

editSchoolNumberConfirmBtn.addEventListener("click", function() {
    editSchoolNumberOverlay.style.display = "none";
}, false);