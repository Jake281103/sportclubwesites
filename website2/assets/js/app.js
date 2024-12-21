$(document).ready(function () {
  // -- Navbar Dropdown
  $(".dropdown").on("show.bs.dropdown", function () {
    $(this).find(".dropdown-menu").slideDown(200);
  });
  $(".dropdown").on("hide.bs.dropdown", function () {
    $(this).find(".dropdown-menu").slideUp(200);
  });
});

// -- Auth Page
document.querySelector(".img__btn").addEventListener("click", function () {
  document.querySelector(".cont").classList.toggle("s--signup");
});
