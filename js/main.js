(function ($) {
  "use strict";

  /* ===============================
     SPINNER
  =============================== */
  function spinner() {
    setTimeout(function () {
      if ($("#spinner").length) {
        $("#spinner").removeClass("show");
      }
    }, 1);
  }
  spinner();

  /* ===============================
     WOW ANIMATION
  =============================== */
  if (typeof WOW === "function") {
    new WOW().init();
  }

  /* ===============================
     STICKY NAVBAR
  =============================== */
  const $navbar = $(".navbar");

  $(window).on("scroll", function () {
    $navbar.toggleClass("sticky-top shadow-sm", $(this).scrollTop() > 45);
  });

  /* ===============================
     DROPDOWN HOVER (DESKTOP ONLY)
  =============================== */
  const $dropdown = $(".dropdown");
  const $dropdownToggle = $(".dropdown-toggle");
  const $dropdownMenu = $(".dropdown-menu");
  const showClass = "show";

  $(window).on("load resize", function () {
    if (window.matchMedia("(min-width: 992px)").matches) {
      $dropdown.hover(
        function () {
          $(this).addClass(showClass);
          $(this).find($dropdownToggle).attr("aria-expanded", "true");
          $(this).find($dropdownMenu).addClass(showClass);
        },
        function () {
          $(this).removeClass(showClass);
          $(this).find($dropdownToggle).attr("aria-expanded", "false");
          $(this).find($dropdownMenu).removeClass(showClass);
        }
      );
    } else {
      $dropdown.off("mouseenter mouseleave");
    }
  });

  /* ===============================
     BACK TO TOP
  =============================== */
  $(window).on("scroll", function () {
    $(".back-to-top").toggle($(this).scrollTop() > 300);
  });

  $(".back-to-top").on("click", function () {
    $("html, body").animate({ scrollTop: 0 }, 1500, "easeInOutExpo");
    return false;
  });

  /* ===============================
     COUNTER
  =============================== */
  if ($.fn.counterUp) {
    $('[data-toggle="counter-up"]').counterUp({
      delay: 10,
      time: 2000,
    });
  }

  /* ===============================
     MODAL VIDEO
  =============================== */
  let videoSrc = "";

  $(".btn-play").on("click", function () {
    videoSrc = $(this).data("src");
  });

  $("#videoModal").on("shown.bs.modal", function () {
    $("#video").attr(
      "src",
      videoSrc + "?autoplay=1&modestbranding=1&showinfo=0"
    );
  });

  $("#videoModal").on("hide.bs.modal", function () {
    $("#video").attr("src", videoSrc);
  });

  /* ===============================
     OWL CAROUSEL
  =============================== */
  if ($.fn.owlCarousel) {
    $(".dokumen-carousel").owlCarousel({
      autoplay: true,
      smartSpeed: 1000,
      center: true,
      margin: 24,
      dots: true,
      loop: true,
      nav: false,
      responsive: {
        0: { items: 1 },
        768: { items: 2 },
        992: { items: 3 },
      },
    });
  }
})(jQuery);

/* =====================================================
   NAV ACTIVE + SMOOTH SCROLL (INTERSECTION OBSERVER)
===================================================== */
(function () {
  "use strict";

  const navbar = document.querySelector(".navbar");
  const navLinks = document.querySelectorAll(
    "#navbarCollapse .nav-link[href^='#']"
  );
  const sections = [...navLinks]
    .map((link) => document.querySelector(link.getAttribute("href")))
    .filter(Boolean);

  function getOffset() {
    return navbar ? navbar.offsetHeight + 5 : 100;
  }

  /* ===============================
     INTERSECTION OBSERVER (ACTIVE)
  =============================== */
  const observer = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          navLinks.forEach((link) => link.classList.remove("active"));

          const activeLink = document.querySelector(
            `#navbarCollapse .nav-link[href="#${entry.target.id}"]`
          );

          if (activeLink) activeLink.classList.add("active");
        }
      });
    },
    {
      root: null,
      rootMargin: "-45% 0px -55% 0px",
      threshold: 0,
    }
  );

  sections.forEach((section) => observer.observe(section));

  /* ===============================
     SMOOTH SCROLL (NAV CLICK)
  =============================== */
  navLinks.forEach((link) => {
    link.addEventListener("click", function (e) {
      const target = document.querySelector(this.getAttribute("href"));
      if (!target) return;

      e.preventDefault();

      window.scrollTo({
        top: target.offsetTop - getOffset() + 1,
        behavior: "smooth",
      });

      const collapse = document.querySelector("#navbarCollapse");
      if (collapse?.classList.contains("show")) {
        bootstrap.Collapse.getInstance(collapse)?.hide();
      }
    });
  });
})();

/* ===============================
   GLIGHTBOX
=============================== */
document.addEventListener("DOMContentLoaded", function () {
  if (typeof GLightbox === "function") {
    GLightbox({
      selector: ".glightbox",
    });
  }
});
