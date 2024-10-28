
// Error priveledge card

const errorPrivOverlay = document.getElementById("errorPrivOverlay");

function showErrorPrivOverlay() {
  const errorPrivOverlay = document.getElementById("errorPrivOverlay");
  errorPrivOverlay.style.display = "block";
};

const errorPrivCloseBtn = document.getElementById("errorPrivcloseBtn");
errorPrivCloseBtn.addEventListener("click", function() {
  errorPrivOverlay.style.display = "none";
}, false);

const errorPrivCloseBtnX = document.getElementById("errorPrivcloseBtnX");
errorPrivCloseBtnX.addEventListener("click", function() {
    errorPrivOverlay.style.display = "none";
}, false);