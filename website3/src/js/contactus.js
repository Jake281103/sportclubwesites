document.addEventListener("DOMContentLoaded", () => {
  const formFields = document.querySelectorAll(".form-control");
  const submitButton = document.querySelector(".submit-btn");
  const socialLinks = document.querySelectorAll(".social-links a");

  // Add focus effect on form fields
  formFields.forEach((field) => {
    field.addEventListener("focus", () => {
      field.style.borderColor = "#8B4513"; // Main Brown Color
      field.style.backgroundColor = "#fdf5e6"; // Light Tan
    });

    field.addEventListener("blur", () => {
      field.style.borderColor = "#8B4513"; // Reset to main border color
      field.style.backgroundColor = "#fff"; // Reset to white
    });
  });

  // Submit button hover effect
  submitButton.addEventListener("mouseover", () => {
    submitButton.style.transform = "scale(1.05)";
    submitButton.style.boxShadow = "0 4px 8px rgba(0, 0, 0, 0.2)";
  });

  submitButton.addEventListener("mouseout", () => {
    submitButton.style.transform = "scale(1)";
    submitButton.style.boxShadow = "none";
  });

  // Social links hover effect
  socialLinks.forEach((link) => {
    link.addEventListener("mouseover", () => {
      link.style.color = "#FFD700"; // Highlight Accent Color (Gold)
      link.style.transform = "rotate(15deg)";
    });

    link.addEventListener("mouseout", () => {
      link.style.color = "#8B4513"; // Reset to Main Brown
      link.style.transform = "rotate(0)";
    });
  });
});
