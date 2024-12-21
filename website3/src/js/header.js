$(document).ready(function () {
  // Ensure dropdown closes on clicking outside
  $(document).on("click", function (event) {
    if (!$(event.target).closest(".navbar-nav").length) {
      $(".dropdown-menu").removeClass("show");
    }
  });

  // Toggle dropdowns
  $(".dropdown-toggle").on("click", function (event) {
    event.preventDefault();
    const $dropdown = $(this).siblings(".dropdown-menu");
    $(".dropdown-menu").not($dropdown).removeClass("show");
    $dropdown.toggleClass("show");
  });

  // Close dropdown on link click
  $(".dropdown-item").on("click", function () {
    $(".dropdown-menu").removeClass("show");
  });
});
