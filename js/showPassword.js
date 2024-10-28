var state = false;
function toggle_password() {
   if (state) {
      document.getElementById(
         "password").setAttribute("type", "password");
      document.getElementById("eye").style.color = '#7a797e';
      state = false;
   } else {
      document.getElementById(
         "password").setAttribute("type", "text");
      document.getElementById("eye").style.color = '#0278A8';
      state = true;
   }
}
function toggle_confirm_password() {
   if (state) {
      document.getElementById(
         "confirm_pass").setAttribute("type", "password");
      document.getElementById("eye_confirm").style.color = '#7a797e';
      state = false;
   } else {
      document.getElementById(
         "confirm_pass").setAttribute("type", "text");
      document.getElementById("eye_confirm").style.color = '#0278A8';
      state = true;
   }
}
function toggle_login_password() {
   if (state) {
      document.getElementById(
         "login_password").setAttribute("type", "password");
      document.getElementById("eye_login").style.color = '#7a797e';
      state = false;
   } else {
      document.getElementById(
         "login_password").setAttribute("type", "text");
      document.getElementById("eye_login").style.color = '#0278A8';
      state = true;
   }
}