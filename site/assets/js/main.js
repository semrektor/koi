/* KOI | Cocuk ve Aile Gelisim Merkezi - taslak etkilesimleri */
(function () {
  "use strict";

  /* 0. JS isareti - reveal animasyonu yalnizca JS varken devreye girer */
  document.documentElement.classList.add("js");

  /* 1. Mobil menu */
  var toggle = document.querySelector(".nav-toggle");
  var nav = document.getElementById("primary-nav");
  if (toggle && nav) {
    toggle.addEventListener("click", function () {
      var open = nav.classList.toggle("is-open");
      toggle.setAttribute("aria-expanded", open ? "true" : "false");
      document.body.style.overflow = open ? "hidden" : "";
    });
    nav.querySelectorAll("a").forEach(function (link) {
      link.addEventListener("click", function () {
        nav.classList.remove("is-open");
        toggle.setAttribute("aria-expanded", "false");
        document.body.style.overflow = "";
      });
    });
  }

  /* 2. Header golgesi */
  var header = document.querySelector(".site-header");
  if (header) {
    var onScroll = function () {
      header.classList.toggle("is-stuck", window.scrollY > 12);
    };
    onScroll();
    window.addEventListener("scroll", onScroll, { passive: true });
  }

  /* 3. Scroll ile ortaya cikma */
  var revealables = document.querySelectorAll(".reveal");
  if (revealables.length) {
    if ("IntersectionObserver" in window) {
      var io = new IntersectionObserver(
        function (entries) {
          entries.forEach(function (entry) {
            if (entry.isIntersecting) {
              entry.target.classList.add("is-visible");
              io.unobserve(entry.target);
            }
          });
        },
        { rootMargin: "0px 0px -8% 0px", threshold: 0.08 }
      );
      revealables.forEach(function (el, i) {
        el.style.transitionDelay = (i % 4) * 70 + "ms";
        io.observe(el);
      });
    } else {
      revealables.forEach(function (el) {
        el.classList.add("is-visible");
      });
    }
  }

  /* 4. Akordeon */
  document.querySelectorAll(".accordion__trigger").forEach(function (btn) {
    btn.addEventListener("click", function () {
      var item = btn.closest(".accordion__item");
      var isOpen = item.classList.contains("is-open");
      item.parentElement.querySelectorAll(".accordion__item").forEach(function (other) {
        other.classList.remove("is-open");
        other.querySelector(".accordion__trigger").setAttribute("aria-expanded", "false");
      });
      if (!isOpen) {
        item.classList.add("is-open");
        btn.setAttribute("aria-expanded", "true");
      }
    });
  });

  /* 5. Kart filtreleri */
  document.querySelectorAll("[data-filter-group]").forEach(function (group) {
    var targetSel = group.getAttribute("data-filter-target");
    var items = document.querySelectorAll(targetSel + " [data-cat]");
    group.querySelectorAll("button").forEach(function (btn) {
      btn.addEventListener("click", function () {
        var cat = btn.getAttribute("data-filter");
        group.querySelectorAll("button").forEach(function (b) {
          b.classList.toggle("is-active", b === btn);
        });
        items.forEach(function (item) {
          var match = cat === "all" || item.getAttribute("data-cat") === cat;
          item.style.display = match ? "" : "none";
        });
      });
    });
  });

  /* 6. Form gonderimi (taslak - WordPress'te form eklentisine baglanacak) */
  document.querySelectorAll("form[data-demo-form]").forEach(function (form) {
    form.addEventListener("submit", function (e) {
      e.preventDefault();
      var note = form.querySelector(".form-note");
      if (note) {
        note.textContent =
          "Taslak onizleme: form gonderimi WordPress kurulumunda aktif edilecektir.";
        note.style.color = "var(--koi-terra)";
      }
    });
  });

  /* 7. Yil */
  document.querySelectorAll("[data-year]").forEach(function (el) {
    el.textContent = new Date().getFullYear();
  });
})();
