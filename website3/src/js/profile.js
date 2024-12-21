// SweetAlert for success message
function submitProfile() {
  Swal.fire({
    title: "Profile Updated!",
    text: "Your profile has been updated successfully.",
    icon: "success",
    confirmButtonText: "Okay",
    confirmButtonColor: "#28a745",
  });
}

// Back to Home functionality
function goHome() {
  window.location.href = "index.php"; // Replace with actual home page URL
}
