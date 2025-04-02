const settings = {
  width: 25,
  height: 21,
};

const heroCirclePattern = document.querySelector("#hero-circles");

const getHeroSVG = (paths, t) => {
  const pathLength = 55;
  const duration = 5;
  const pathString = paths
    .map((path, i) => {
      const it = (t + (i / paths.length) * duration) % duration;
      let dashArray = ``;
      if (it < duration / 2) {
        dashArray = `stroke-dasharray: 0 0 ${
          (it / (duration / 2)) * pathLength
        }px ${pathLength}px;`;
      } else {
        dashArray = `stroke-dasharray: 0 ${
          ((it - duration / 2) / (duration / 2)) * pathLength
        }px ${pathLength}px ${pathLength}px;`;
      }
      // output.innerText = output.innerText + "\n\n" + it;

      return `<path d="${path}" style="${dashArray}" stroke="black" stroke-width="2"/>`;
    })
    .join("");

  const svg = `<svg id="path-reference" width="25" height="21" viewBox="0 0 25 21" fill="none" xmlns="http://www.w3.org/2000/svg">
  ${pathString}
  </svg>`;

  return svg;
};

const loadSvgImage = (svgString) => {
  return new Promise((resolve, reject) => {
    const img = new Image();
    img.crossOrigin = "anonymous";
    const svgBlob = new Blob([svgString], {
      type: "image/svg+xml;charset=utf-8",
    });
    const url = URL.createObjectURL(svgBlob);

    img.onload = function () {
      resolve({ img, url });
    };

    img.onerror = reject; // Handle image load errors
    img.src = url;
  });
};
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
      heroCircleArray.push({ circle, on: false });
      heroCirclePattern.appendChild(circle);
    }
  }
};
export const createHero = async () => {
  if (!heroCirclePattern) return;

  makeHeroCircles();

  const paths = [
    // "M30.9491 26.8632C29.6577 22.7182 24.2728 13.5468 13.0643 10.0215C1.8559 6.49617 -2.72035 -0.882945 -3.60742 -4.13184",
    "M33.18 14.4184C31.5105 14.9924 25.0249 14.7079 12.4388 8.97845C-0.147377 3.24895 -11.3297 2.54711 -15.3477 2.91237",
    "M-8.14746 1.07324C-6.1907 6.8784 5.33105 13.7062 13.534 7.09994C21.9163 0.349325 25.9009 21.8932 27.388 23.8499",
    // "M34.7064 22.8324C26.9579 21.4234 19.8346 11.6 12.2035 8.86074C6.09858 6.66931 -1.74151 12.7745 -4.89844 16.101",
    // "M30.8711 25.0631C28.732 21.7367 19.749 14.5905 14.0819 10.583C6.9981 5.5736 5.51126 17.8229 -0.0459785 11.522C-4.49177 6.48138 -11.0171 7.3064 -14.6436 9.71977",
    "M-3.21596 -1.78382C2.92832 2.44282 -0.888826 11.2724 6.68771 10.8968C16.1584 10.4272 15.141 4.28288 21.6375 11.7578C28.134 19.2326 30.2134 24.0854 33.5399 24.9855",
  ];

  const canvas = document.querySelector("#hero-path-canvas");

  canvas.width = settings.width;
  canvas.height = settings.height;

  const ctx = canvas.getContext("2d", { willReadFrequently: true });
  let t = 0;

  const draw = async () => {
    t += 0.08;
    try {
      const svgString = getHeroSVG(paths, t);
      const { img, url } = await loadSvgImage(svgString);
      ctx.clearRect(0, 0, settings.width, settings.height);
      // ctx.fillStyle = "blue";
      // // ctx.fillRect(0, 0, settings.width, settings.height);
      ctx.drawImage(img, 0, 0, canvas.width, canvas.height);
      ctx.fillStyle = "#ffffff";
      // ctx.fillRect(0, 0, 10, 10);

      const data = ctx.getImageData(0, 0, settings.width, settings.height).data;
      for (let i = 0; i < data.length / 4; i++) {
        const i4 = i * 4;
        const x = i % settings.width;
        const y = Math.floor(i / settings.width);
        if (x > 4 && x < 25 && y > 0 && y < 4) {
          continue;
        }
        if (x > 0 && x < 18 && y > 15 && y < 21) {
          continue;
        }

        if (data[i4 + 3] > 125 != heroCircleArray[i].on) {
          heroCircleArray[i].on = !heroCircleArray[i].on;
          if (heroCircleArray[i].on) {
            heroCircleArray[i].circle.classList.add("is-on");
            heroCircleArray[i].circle.setAttribute("r", 30);
          } else {
            heroCircleArray[i].circle.classList.remove("is-on");
            heroCircleArray[i].circle.setAttribute("r", 0);
          }
          // heroCircleArray[i].circle.setAttribute("r", heroCircleArray[i].on ? "30" : "0")
        }
      }
      URL.revokeObjectURL(url); // Clean up the object URL
    } catch (error) {
      console.error("Error loading the image", error);
    }
  };

  draw();
  setInterval(draw, 200);
};
