export default class InView {
  constructor(element, args) {
    this.settings = {
      amount: 0.15,
      delay: 100,
      ...args,
    };

    this.boundCallBack = this.callback.bind(this);

    this.inViewObserver = new IntersectionObserver(this.boundCallBack, {
      threshold: [0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1],
    });

    this.inViewObserver.observe(element);
  }

  callback(entries) {
    entries.forEach((entry) => {
      const test =
        entry.isIntersecting &&
        (entry.intersectionRatio > this.settings.amount ||
          entry.intersectionRatio * entry.boundingClientRect.height >
            window.innerHeight * this.settings.amount);

      if (test) {
        setTimeout(() => {
          this.inView(entry);
        }, this.settings.delay);
        // remove the item from funning again
        this.inViewObserver.unobserve(entry.target);
      } else {
        // entry.target.classList.remove("in-view");
      }
    });
  }

  inView(entry) {
    return entry.target.classList.add("in-view");
  }

  outView(entry) {
    return;
  }

  destroy() {
    this.inViewObserver.disconnect();
  }
}
