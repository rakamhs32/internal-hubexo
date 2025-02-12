import InView from "./InView";

export default class RollUp extends InView {
  constructor(el, mods) {
    super(el);

    this.el = el;

    this.destroyed = false;

    this.original = this.el.innerText;
    this.settings = {
      ...this.settings,
      duration: 2000,
      isInt: true,
      ...mods,
    };

    this.nan = false;

    this.getNumber();
    if (this.nan) return;

    this.makeFormatter();

    this.progress = 0;
    this.dir = null;
    this.format(this.progress);
  }

  getNumber() {
    const match = this.original.match(/[0-9,.]+/gm);
    if (!match) {
      this.nan = true;
      return false;
    }
    const num = match[0];

    if (num.indexOf(".") >= 0) {
      this.parse = parseFloat;
      this.decimals = num.split(".")[1].length;
    } else {
      this.decimals = 0;
      this.parse = parseInt;
    }

    const bits = this.original.split(num);

    this.prepend = bits[0];
    this.append = bits[1];

    const plainNumber = num.replace(/,/g, "");

    this.el.innerText = 0;
    this.value = this.parse(plainNumber);
  }

  makeFormatter() {
    let args = {
      minimumFractionDigits: this.decimals,
      maximumFractionDigits: this.decimals,
    };

    // Currencies
    if (this.prepend == "$") {
      args.style = "currency";
      args.currency = "USD";
    } else if (this.prepend == "£") {
      args.style = "currency";
      args.currency = "GBP";
    } else if (this.prepend == "€") {
      args.style = "currency";
      args.currency = "EUR";
    }

    // Plus
    if (this.settings.hasPlus) {
      args.signDisplay = "always";
    }

    this.formatter = new Intl.NumberFormat(
      window.navigator.userLanguage || window.navigator.language,
      args
    );
  }

  ease(t) {
    return Math.sqrt(1 - Math.pow(t - 1, 2));
    return t === 1 ? 1 : 1 - Math.pow(2, -10 * t);
    // const sqt = t * t;
    // return sqt / (2.0 * (sqt - t) + 1.0);
  }

  loop() {
    // if (this.destroyed) return;
    if (!this.dir) return;

    if (this.dir == "up") {
      this.progress = this.ease(
        Math.min(1, 1 - (this.finishTime - Date.now()) / this.settings.duration)
      );
    } else {
      this.progress = this.ease(
        Math.max(0, (this.finishTime - Date.now()) / this.settings.duration)
      );
    }
    this.format();
    if (
      (this.dir == "down" && this.progress > 0) ||
      (this.dir == "up" && this.progress < 1)
    ) {
      // setTimeout(this.loop.bind(this), 50);
      requestAnimationFrame(this.loop.bind(this));
    } else {
      this.dir = false;
    }
  }

  up() {
    if (this.nan) return;
    this.finishTime = Date.now() + this.settings.duration;
    this.dir = "up";
    this.loop();
  }

  down() {
    if (this.nan) return;
    this.finishTime = Date.now() + this.settings.duration;
    this.dir = "down";
    this.loop();
  }

  format() {
    this.el.innerText = `${this.formatter.format(this.progress * this.value)}${
      this.append
    }`;
  }

  destroy() {
    this.destroyed = true;
  }

  inView(entry) {
    this.up();
  }

  outView(entry) {}
}
