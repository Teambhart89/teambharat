(function () {
  "use strict";

  /* Mobile navigation */
  var toggle = document.querySelector(".menu-toggle");
  var navWrap = document.querySelector(".site-nav-wrap");
  if (toggle && navWrap) {
    toggle.addEventListener("click", function () {
      var open = navWrap.classList.toggle("open");
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
    });
    navWrap.querySelectorAll("a").forEach(function (a) {
      a.addEventListener("click", function () {
        if (window.innerWidth <= 860) navWrap.classList.remove("open");
      });
    });
  }

  /* Reveal on scroll */
  var reveals = document.querySelectorAll(".reveal");
  if ("IntersectionObserver" in window && reveals.length) {
    var io = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (e) {
          if (e.isIntersecting) {
            e.target.classList.add("in");
            io.unobserve(e.target);
          }
        });
      },
      { threshold: 0.1 }
    );
    reveals.forEach(function (el) { io.observe(el); });
  } else {
    reveals.forEach(function (el) { el.classList.add("in"); });
  }

  /* Animated number counters — element uses data-count="250" data-suffix="+" */
  function animateCount(el) {
    var target = parseFloat(el.getAttribute("data-count"));
    var suffix = el.getAttribute("data-suffix") || "";
    var prefix = el.getAttribute("data-prefix") || "";
    var decimals = (String(target).split(".")[1] || "").length;
    var dur = 1400, start = null;
    function step(ts) {
      if (!start) start = ts;
      var p = Math.min((ts - start) / dur, 1);
      var eased = 1 - Math.pow(1 - p, 3);
      var val = (target * eased).toFixed(decimals);
      el.textContent = prefix + val + suffix;
      if (p < 1) requestAnimationFrame(step);
      else el.textContent = prefix + target + suffix;
    }
    requestAnimationFrame(step);
  }
  var counters = document.querySelectorAll("[data-count]");
  if ("IntersectionObserver" in window && counters.length) {
    var co = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (e) {
          if (e.isIntersecting) { animateCount(e.target); co.unobserve(e.target); }
        });
      },
      { threshold: 0.5 }
    );
    counters.forEach(function (el) { co.observe(el); });
  } else {
    counters.forEach(function (el) {
      el.textContent = (el.getAttribute("data-prefix") || "") + el.getAttribute("data-count") + (el.getAttribute("data-suffix") || "");
    });
  }

  /* Header shadow on scroll */
  var header = document.querySelector(".site-header");
  if (header) {
    var onScroll = function () {
      header.style.boxShadow = window.scrollY > 10 ? "0 8px 30px rgba(16,20,50,.08)" : "none";
    };
    window.addEventListener("scroll", onScroll, { passive: true });
    onScroll();
  }
})();
