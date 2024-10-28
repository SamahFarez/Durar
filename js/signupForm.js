const form = document.getElementById("signupForm");
const userTypeSelect = document.getElementById("signupRole");

userTypeSelect.addEventListener("change", function () {
   const selectedValue = userTypeSelect.value;
   if (selectedValue === "student") {
      form.action = "pages/Student/confirmStudent.php";
   } else if (selectedValue === "teacher") {
      form.action = "pages/Teacher/confirmTeacher.php";
   } else if (selectedValue === "admin") {
      form.action = "pages/Admin/index.php";
   }
});
