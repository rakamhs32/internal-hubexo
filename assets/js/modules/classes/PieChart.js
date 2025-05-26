import InView from "./InView";

export default class PieChart extends InView {
  constructor(el, mods = {}) {
    super(el, mods);
    this.el = el;
    this.percent = parseFloat(this.el.getAttribute("data-percent"));
  }
  inView(entry) {
    this.el.style.setProperty("--amount", this.percent);
  }

  outView(entry) {}
}
