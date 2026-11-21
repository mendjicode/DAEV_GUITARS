(() => {
  const menu = document.getElementById("menu");
  const toggle = document.getElementById("toggle");
  if (menu && toggle) {
    const mobile = matchMedia("(max-width: 900px)");
    const setMenu = (open) => {
      menu.classList.toggle("open", open);
      toggle.textContent = open ? "×" : "☰";
      toggle.setAttribute("aria-expanded", String(open));
    };

    document.documentElement.classList.add("nav-ready");
    toggle.hidden = false;
    toggle.addEventListener("click", () => {
      const open = !menu.classList.contains("open");
      setMenu(open);
      if (open) menu.querySelector("a")?.focus();
    });
    menu.addEventListener("click", (event) => {
      const link = event.target.closest("a");
      if (!link || !mobile.matches) return;
      const target = link.hash && document.getElementById(link.hash.slice(1));
      setMenu(false);
      if (target) {
        target.setAttribute("tabindex", "-1");
        target.focus({ preventScroll: true });
      }
    });
    document.addEventListener("keydown", (event) => {
      if (event.key === "Escape" && menu.classList.contains("open")) {
        setMenu(false);
        toggle.focus();
      }
    });
    document.addEventListener("click", (event) => {
      if (
        menu.classList.contains("open") &&
        !menu.contains(event.target) &&
        !toggle.contains(event.target)
      )
        setMenu(false);
    });
    mobile.addEventListener("change", () => setMenu(false));
  }

  const reducedMotion = matchMedia("(prefers-reduced-motion: reduce)");
  if ("IntersectionObserver" in window && !reducedMotion.matches) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add("visible");
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.05 },
    );
    document
      .querySelectorAll(".reveal")
      .forEach((section) => observer.observe(section));
    document.documentElement.classList.add("motion-ready");
  }

  const topButton = document.getElementById("toTop");
  if (topButton) {
    const updateVisibility = () => {
      topButton.hidden = window.scrollY < 650;
    };
    window.addEventListener("scroll", updateVisibility, { passive: true });
    updateVisibility();
    topButton.addEventListener("click", () => {
      document.querySelector(".skip-link")?.focus({ preventScroll: true });
      window.scrollTo({
        top: 0,
        behavior: reducedMotion.matches ? "auto" : "smooth",
      });
    });
  }
})();
