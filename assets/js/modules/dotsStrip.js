export default {
  init() {
    const masterPatternA = document.querySelector("#master-pattern-a");
    const circleGroup = masterPatternA.querySelector("#master-pattern-a-group");
    const aInstances = Array.from(document.querySelectorAll(".pattern-a"));

    const fillChildren = () => {
      aInstances.forEach((pattern) => {
        const group = pattern.querySelector("g");
        while (group.firstChild) {
          group.removeChild(group.firstChild);
        }
        const clone = circleGroup.cloneNode(true);
        group.appendChild(clone);
      });
    };
    const settings = {
      gridSize: 32,
    };

    const grid = [];

    const fillGrid = () => {
      grid.length = 0;
      while (circleGroup.firstChild) {
        circleGroup.removeChild(circleGroup.firstChild);
      }

      for (let row = 0; row < settings.rows; row++) {
        for (let col = 0; col <= settings.cols; col++) {
          const center = {
            x: col * settings.gridSize + settings.offsetX,
            y: row * settings.gridSize,
          };

          const circle = document.createElementNS(
            "http://www.w3.org/2000/svg",
            "circle"
          );

          circle.setAttribute("cx", center.x);
          circle.setAttribute("cy", center.y);
          circle.setAttribute("r", settings.gridSize / 2);
          circle.setAttribute("fill", "currentColor");
          circle.style.setProperty("--x", col);
          circle.style.setProperty("--y", row);

          grid.push({
            circle,
            center,
          });
          circleGroup.appendChild(circle);
        }
      }

      fillChildren();
    };

    const setViewBox = () => {
      masterPatternA.setAttribute(
        "viewBox",
        `0 0 ${settings.width} ${settings.height}`
      );
      aInstances.forEach((pattern) =>
        pattern.setAttribute(
          "viewBox",
          `0 0 ${settings.width} ${settings.height}`
        )
      );
    };

    const reset = () => {
      settings.width = window.innerWidth;
      settings.height = settings.gridSize * 2.5;

      // Calculate the number of rows and columns
      settings.cols = Math.ceil(settings.width / settings.gridSize);
      settings.rows = Math.ceil(settings.height / settings.gridSize);

      // Calculate the offset to center the grid
      settings.offsetX =
        (settings.width - settings.cols * settings.gridSize) / 2;
      settings.offsetY =
        (settings.height - settings.rows * settings.gridSize) / 2;

      setViewBox();
      fillGrid();
    };

    reset();

    window.addEventListener("resize", reset);
  },
};
