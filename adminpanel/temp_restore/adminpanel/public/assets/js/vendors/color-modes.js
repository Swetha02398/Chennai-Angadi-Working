(() => {
  "use strict";

  // Check if there's a mode stored in localStorage
  const savedMode = localStorage.getItem("mode");

  // Apply the saved mode or default to system preference immediately to prevent flash
  if (savedMode === "dark" || (!savedMode && window.matchMedia("(prefers-color-scheme: dark)").matches)) {
    document.documentElement.classList.remove("light");
    document.documentElement.classList.add("dark");
  } else {
    document.documentElement.classList.remove("dark");
    document.documentElement.classList.add("light");
  }

  // Handle dark/light mode toggle after DOM is loaded
  document.addEventListener("DOMContentLoaded", () => {
    const toggleBtn = document.querySelector(".darkmode");
    if (toggleBtn) {
      toggleBtn.addEventListener("click", function () {
        if (document.documentElement.classList.contains("dark")) {
          document.documentElement.classList.remove("dark");
          document.documentElement.classList.add("light");
          localStorage.setItem("mode", "light");
        } else {
          document.documentElement.classList.remove("light");
          document.documentElement.classList.add("dark");
          localStorage.setItem("mode", "dark");
        }
      });
    }
  });
})();