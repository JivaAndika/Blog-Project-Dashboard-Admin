const sidebar = document.getElementById("aside");
const openNavbar = document.getElementById("open");
openNavbar.addEventListener("click", function () {
  sidebar.classList.toggle("translate-x-full");
});

// function openNavbar() {
//   sidebar.classList.add("-translate-x-0");
//   sidebar.classList.remove("translate-x-full");
// }
// function closeNavbar() {
//   sidebar.classList.add("translate-x-full");
//   sidebar.classList.remove("-translate-x-0");
// }
