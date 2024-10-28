const loginLinks = document.getElementsByClassName("third-btn");
const modal = document.getElementById("modal_container");
const body = document.getElementsByTagName("body")[0];

for (let i = 0; i < loginLinks.length; i++) {
  loginLinks[i].addEventListener("click", function() {
    modal.style.display = "block";
    body.classList.add("modal-open");
  });
}

const closeModal = function() {
  modal.style.display = "none";
  body.classList.remove("modal-open");
};

document.getElementById("close").addEventListener("click", closeModal);

window.onclick = function(event) {
  if (event.target == modal) {
    closeModal();
  }
};
