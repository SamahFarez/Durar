// Add Admin Card pop up and pop out 
const AddAdminOverlay = document.getElementById("AddAdminOverlay");
const AddAdmincloseBtn = document.getElementById("close-btn");
const AddAdmincloseBtnX = document.getElementById("close-btnX");

function showAddAdminOverlay() {
  AddAdminOverlay.style.display = "block";
};

AddAdmincloseBtn.addEventListener("click", function() {
  AddAdminOverlay.style.display = "none";
}, false);

AddAdmincloseBtnX.addEventListener("click", function() {
  AddAdminOverlay.style.display = "none";
}, false);



// Implementation of the card changes in the Add Admin card
const addAdmin1 = document.getElementById('addAdmin1');
const addAdmin2 = document.getElementById('addAdmin2');
const addAdmin3 = document.getElementById('addAdmin3');
const addAdminButtons2 = document.getElementById('addAdminButtons2');

const move2addAdmin2 = document.getElementById('move2addAdmin2');
const ShowSearchResult = document.getElementById('ShowSearchResult');
const confirmAddAdmin = document.getElementById('confirmAddAdmin');
const backbtnAddAdmin = document.getElementById('backbtnAddAdmin');

move2addAdmin2.addEventListener("click", function() {
  addAdmin1.style.display = "none";
  addAdmin2.style.display = "flex";
  addAdminButtons2.style.display = "flex";
}, false);

ShowSearchResult.addEventListener("click", function(event) {
  event.preventDefault(); // Prevents the form from being submitted
  addAdmin3.style.display = "flex";
}, false);

confirmAddAdmin.addEventListener("click", function() {
  AddAdminOverlay.style.display = "none";
}, false);

backbtnAddAdmin.addEventListener("click", function() {
  addAdmin1.style.display = "flex";
  addAdmin2.style.display = "none";
  addAdminButtons2.style.display = "none";
});

