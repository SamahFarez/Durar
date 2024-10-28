// Remove Admin Card pop up and pop out 
const RemoveAdminOverlay = document.getElementById("RemoveAdminOverlay");
const RemoveAdmincloseBtn = document.getElementById("RemoveAdmincloseBtn");
const RemoveAdmincloseBtnX = document.getElementById("RemoveAdmincloseBtnX");
const confirmRemoveAdmin = document.getElementById('confirmRemoveAdmin');


function showRemoveAdminOverlay(event, admin_id, admin_name) {
  event.preventDefault(); // Prevents the form from being submitted
  const adminNameElement = document.getElementById('adminName');
  adminNameElement.textContent = admin_name;
  updateAdmin(admin_id);
  RemoveAdminOverlay.style.display = "block";
};

function updateAdmin(adminId) {
  var confirmButton = document.getElementById('confirmRemoveAdmin');
  var currentOnClickValue = confirmButton.getAttribute('onclick');

  // Replace the current admin_id value with the new one
  var newOnClickValue = currentOnClickValue.replace(/admin_id=\d+/, 'admin_id=' + adminId);

  // Update the onclick attribute with the new value
  confirmButton.setAttribute('onclick', newOnClickValue);
  console.log(newOnClickValue);
}

RemoveAdmincloseBtn.addEventListener("click", function() {
  RemoveAdminOverlay.style.display = "none";
}, false);

RemoveAdmincloseBtnX.addEventListener ("click", function(){
  RemoveAdminOverlay.style.display = "none";
});

confirmRemoveAdmin.addEventListener("click", function() {
  RemoveAdminOverlay.style.display = "none";
}, false);
