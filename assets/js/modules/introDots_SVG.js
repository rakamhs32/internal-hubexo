import { createNoise3D } from "simplex-noise";

const dist = (p1, p2) => Math.sqrt((p2.x - p1.x) ** 2 + (p2.y - p1.y) ** 2);
const lerp = (v0, v1, t) => (1 - t) * v0 + t * v1;

// initialize the noise function
const noise3D = createNoise3D();

const settings = {
  width: 25,
  height: 25,
};

const mouse = {
  x: 12.5,
  y: 12.5,
};

const heroCirclePattern = document.querySelector("#hero-circles");
const heroCircleArray = [];
const makeHeroCircles = () => {
  for (let y = 0; y < settings.height; y++) {
    for (let x = 0; x < settings.width; x++) {
      const circle = document.createElementNS(
        "http://www.w3.org/2000/svg",
        "circle"
      );
      circle.setAttribute("r", 0);
      circle.setAttribute("cx", 30 + x * 60);
      circle.setAttribute("cy", 30 + y * 60);
      circle.setAttribute("fill", "#C8D2D2");
      heroCircleArray.push({ circle, r: 0 });
      heroCirclePattern.appendChild(circle);
    }
  }
};
export const createHero = async () => {
  if (!heroCirclePattern) return;

  // Define the isIntersecting variable
  let isIntersecting = false;

  // Define the callback function that will be triggered when the intersection occurs
  const callback = (entries, observer) => {
    entries.forEach((entry) => {
      // Update the isIntersecting variable based on whether the element is intersecting
      isIntersecting = entry.isIntersecting;

      if (isIntersecting) {
        console.log("Div is intersecting the viewport!");
      } else {
        console.log("Div is NOT intersecting the viewport.");
      }
    });
  };

  // Create a new Intersection Observer
  const observer = new IntersectionObserver(callback);

  // Start observing the target div
  observer.observe(heroCirclePattern);

  makeHeroCircles();

  document.documentElement.addEventListener("mousemove", (e) => {
    // Mouse position relative to heroCirclePattern

    const rect = heroCirclePattern.getBoundingClientRect();
    mouse.x = ((e.clientX - rect.left) / rect.width) * settings.width;
    mouse.y = ((e.clientY - rect.top) / rect.height) * settings.height;
  });

  let t = Date.now();
  let last = Date.now();

  const draw = async () => {
    requestAnimationFrame(draw);
    if (!isIntersecting) return;

    t = Date.now();
    const dt = t - last;

    if (dt < 1000 / 30) {
      return;
    }
    last = t;

    const scale = 0.1;

    const maximumDistance = dist(
      { x: 0, y: 0 },
      { x: settings.width, y: settings.height }
    );

    for (let i = 0; i < heroCircleArray.length; i++) {
      const x = i % settings.width;
      const y = Math.floor(i / settings.width);
      let noise = noise3D(x * scale, y * scale, t / 3000) + 0.3;
      // noise = 1;
      // noise -=
      //   Math.max(0, 32 - dist({ x, y }, { x: 0, y: settings.height }) - 20) /
      //   10;
      // noise -=
      //   Math.max(0, 32 - dist({ x, y }, { x: settings.width, y: 0 }) - 20) / 10;
      const mouseDistance = dist({ x, y }, { x: mouse.x, y: mouse.y });

      //  Old version:
      const mouseDistanceModifier = (mouseDistance * 5) / maximumDistance;
      noise *= Math.min(1, mouseDistanceModifier * 2);

      const n = Math.min(1, Math.max(0, noise));

      // With lerp
      heroCircleArray[i].r = lerp(heroCircleArray[i].r, n, 0.3);
      heroCircleArray[i].circle.setAttribute("r", heroCircleArray[i].r * 25);

      // Without lerp
      // heroCircleArray[i].circle.setAttribute("r", n * 25);
    }
  };
  requestAnimationFrame(draw);
};
