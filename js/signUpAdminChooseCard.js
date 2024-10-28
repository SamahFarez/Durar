// Add Student Card pop up and pop out 
const SignUpAdminChooseOverlay = document.getElementById("SignUpAdminChooseOverlay");
const goToMakeSchool = document.getElementById("goToMakeSchool");
const goToMainAdmin = document.getElementById("goToMainAdmin");

function showMakeSchoolOverlay() {
    SignUpAdminChooseOverlay.style.display = "block";
};

goToMakeSchool.addEventListener("click", function() {
    window.location.href = "../School/MakeSchool.php";
    SignUpAdminChooseOverlay.style.display = "none";
}, false);

goToMainAdmin.addEventListener("click", function() {
    window.location.href = "../School/MakeSchool.php";
    SignUpAdminChooseOverlay.style.display = "none";
}, false);




