document.addEventListener("DOMContentLoaded", () => {
  const scrollTopBtn = document.getElementById("scroll-top");
  scrollTopBtn.addEventListener("click", () => {
    window.scrollTo({ top: 0, behavior: "smooth" });
  });
});
