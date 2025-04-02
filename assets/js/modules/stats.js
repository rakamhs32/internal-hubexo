import RollUp from "./classes/Rollup";

export const stats = () => {
  const stats = Array.from(document.querySelectorAll(".stat-block--number"));
  const statMap = new WeakMap();
  stats.forEach((stat) => {
    const rollup = new RollUp(stat);
    // rollup.destroy();
    statMap.set(stat, rollup);
  });

  // function moreThan15Percent(entries) {
  //   entries.forEach((entry) => {
  //     if (
  //       entry.isIntersecting &&
  //       (entry.intersectionRatio > 0.15 ||
  //         entry.intersectionRatio * entry.boundingClientRect.height >
  //           window.innerHeight * 0.15)
  //     ) {
  //       setTimeout(() => entry.target.classList.add("in-view"), 0);
  //       stats.forEach((stat) => {
  //         console.log("hi!");
  //         statMap.get(stat).loop();
  //       });
  //       // remove the item from funning again
  //       // Intersections.inViewObserver.unobserve(entry.target);
  //     }
  //   });
  // }

  // const inViewObserver = new IntersectionObserver(moreThan15Percent, {
  //   threshold: [0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1],
  // });

  // inViewObserver.observe(document.querySelector(".special-fade-in"));
};
