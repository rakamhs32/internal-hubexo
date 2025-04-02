// Basic, just if they are intersecting at all
function anyIntersectionAtAll(entries) {
  entries.forEach((entry) => {
    if (entry.isIntersecting) {
      setTimeout(() => entry.target.classList.add("in-view"), 0);
      // remove the item from funning again
      Intersections.inViewObserver.unobserve(entry.target);
    } else {
      // entry.target.classList.remove("in-view");
    }
  });
}

export function moreThan15Percent(entries) {
  entries.forEach((entry) => {
    if (
      entry.isIntersecting &&
      (entry.intersectionRatio > 0.15 ||
        entry.intersectionRatio * entry.boundingClientRect.height >
          window.innerHeight * 0.15)
    ) {
      setTimeout(() => entry.target.classList.add("in-view"), 0);
      // remove the item from funning again
      Intersections.inViewObserver.unobserve(entry.target);
    } else {
      // entry.target.classList.remove("in-view");
    }
  });
}

const Intersections = {
  inViewObserver: new IntersectionObserver(moreThan15Percent, {
    threshold: [0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1],
  }),
  init() {
    document
      .querySelectorAll(
        ".fade-in, .fade-up, .fade-in-stagger, .job-card, .location-card"
      )
      .forEach((pie) => {
        this.inViewObserver.observe(pie);
      });
  },
  destroy() {
    this.inViewObserver.disconnect();
  },
};

export default Intersections;
