const cycle = (logo) => {
  if (logo.classList.contains("animating")) {
    return;
  }

  logo.classList.add("animating");
  logo.addEventListener(
    "animationend",
    () => {
      logo.classList.remove("animating");
    },
    {
      once: true,
    }
  );
};

const intermittentCycle = (logo, n = 0) => {
  const rate = 10;
  const rand = 10;
  const t = Math.round((Math.random() * rand + rate + n / 3) * 1000);
  console.log(`Cycling in ${t / 1000}s`);
  n++;
  setTimeout(() => {
    cycle(logo);
    intermittentCycle(logo, n);
  }, t);
};

export default {
  init() {
    if (!document.querySelector("#header")) {
      return;
    }

    const logo = document.querySelector(".animated-hubexo-logo");

    logo.addEventListener("pointerenter", () => {
      cycle(logo);
    });

    intermittentCycle(logo);

    var lastScrollTop = 0; // Initialize lastScrollTop
    var navbar = document.getElementById("header");

    if (navbar.classList.contains("hide")) {
      setTimeout(() => {
        if (window.scrollY < 10) {
          navbar.classList.remove("hide");
        }
      }, 20);
    }

    function handleScroll() {
      // Check if we're at the top of the page
      if (window.scrollY < 3) {
        navbar.classList.remove("header-bg");
      } else {
        navbar.classList.add("header-bg");
      }
    }

    window.addEventListener("scroll", function () {
      var scrollTop = document.documentElement.scrollTop;

      if (scrollTop > lastScrollTop) {
        // Scrolling down
        navbar.classList.add("hide");
      } else {
        // Scrolling up
        navbar.classList.remove("hide");
      }

      // Update lastScrollTop after handling the scroll direction
      lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // Prevent negative scroll values

      handleScroll();
    });
  },
  destroy() {},
};
