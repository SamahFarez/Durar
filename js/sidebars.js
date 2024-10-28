const sidebar_menu = document.querySelector(".sidebar-slider");
const sidebar = document.querySelector(".side_bar");

sidebar_menu.addEventListener("click", () => {
  sidebar.classList.toggle("mobile_sidebar");
});
