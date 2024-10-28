const menu = document.querySelector(".responsive_menu");
const navLinks = document.querySelector(".navbar_links");
const authLinks = document.querySelector(".navbar_authentication");

menu.addEventListener("click", () => {
  navLinks.classList.toggle("mobile_menu");
  authLinks.classList.toggle("mobile_menu");
});

// all links tags in navbar, when click on one the mobile navbar goes up
const lnks = document.querySelectorAll(".nav-link")
lnks.forEach((lnk) => {
  lnk.addEventListener("click", () => {
    navLinks.classList.remove("mobile_menu");
    authLinks.classList.remove("mobile_menu");
  })
})