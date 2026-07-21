/* Avdesh SEO theme - light front-end interactions */
(function () {
  "use strict";

  // Mobile navigation toggle
  var toggle = document.querySelector(".nav-toggle");
  var menu = document.getElementById("primary-menu");
  if (toggle && menu) {
    toggle.addEventListener("click", function () {
      var open = menu.classList.toggle("open");
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
    });
  }

  // Close mobile menu after clicking a link
  if (menu) {
    menu.addEventListener("click", function (e) {
      if (e.target.tagName === "A" && menu.classList.contains("open")) {
        menu.classList.remove("open");
        if (toggle) toggle.setAttribute("aria-expanded", "false");
      }
    });
  }

  // Duplicate ticker content for a seamless loop
  document.querySelectorAll(".ticker-track").forEach(function (track) {
    track.innerHTML += track.innerHTML;
  });
})();
