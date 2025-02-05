const sidebar = document.getElementById("aside");
const openNavbar = document.getElementById("open");
openNavbar.addEventListener("click", function () {
  sidebar.classList.toggle("translate-x-full");
});

