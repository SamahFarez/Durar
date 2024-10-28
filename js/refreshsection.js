function refreshBio() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
       if (this.readyState == 4 && this.status == 200) {
          document.getElementById("panelMe").innerHTML = this.responseText;
       }
    };
    xhttp.open("GET", "refreshBio.php", true);
    xhttp.send();
 }
 
 function refreshID() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
       if (this.readyState == 4 && this.status == 200) {
          document.getElementById("panelID").innerHTML = this.responseText;
       }
    };
    xhttp.open("GET", "refreshID.php", true);
    xhttp.send();
 }
 
 function refreshContact() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
       if (this.readyState == 4 && this.status == 200) {
          document.getElementById("panelContact").innerHTML = this.responseText;
       }
    };
    xhttp.open("GET", "refreshContact.php", true);
    xhttp.send();
 }
 
 function refreshProfilePic() {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function () {
       if (this.readyState == 4 && this.status == 200) {
          document.getElementById("panelProfilePic").innerHTML = this.responseText;
       }
    };
    xhttp.open("GET", "refreshProfilePic.php", true);
    xhttp.send();
 }
 