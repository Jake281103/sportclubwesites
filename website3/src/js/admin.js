window.addEventListener("DOMContentLoaded", (event) => {
  // Toggle the side navigation
  const sidebarToggle = document.body.querySelector("#sidebarToggle");
  if (sidebarToggle) {
    // Uncomment Below to persist sidebar toggle between refreshes
    // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
    //     document.body.classList.toggle('sb-sidenav-toggled');
    // }
    sidebarToggle.addEventListener("click", (event) => {
      event.preventDefault();
      document.body.classList.toggle("sb-sidenav-toggled");
      localStorage.setItem(
        "sb|sidebar-toggle",
        document.body.classList.contains("sb-sidenav-toggled")
      );
    });
  }
});

$(document).ready(function () {
  // Handle the toggle switch
  $(".user-toggle").on("change", function () {
    const isChecked = $(this).is(":checked");
    const statusLabel = $(this).closest("td").find(".form-check-label");
    statusLabel.text(isChecked ? "On" : "Off");

    // Perform any action here, e.g., update the user's status in the database
    console.log("User status changed:", isChecked ? "Enabled" : "Disabled");
  });

  // Dropdown functionality is handled by Bootstrap itself, no custom code needed
  // Example usage:
  $(".dropdown-item").on("click", function () {
    const feature = $(this).text();
    console.log("Selected feature:", feature);

    // Perform any action based on the selected feature
    alert(`You selected: ${feature}`);
  });
});

// SweetAlert Message
function alertMessage(title, message) {
  Swal.fire({
    title: title,
    text: message,
    icon: "success",
    confirmButtonText: "Okay",
    confirmButtonColor: "#28a745",
  });
}
