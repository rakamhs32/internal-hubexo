export default {
    init() {
        this.countElements = document.querySelectorAll('.title--number');
        this.observer = new IntersectionObserver(this.handleIntersect.bind(this), {
            threshold: 0.1 // Adjust this value as needed
        });

        this.countElements.forEach((el) => {
            this.observer.observe(el);
        });
    },

    destroy() {
        this.observer.disconnect();
    },

    handleIntersect(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                this.startCounting(entry.target);
                this.observer.unobserve(entry.target); // Stop observing after counting
            }
        });
    },

    startCounting(el) {
        const countTo = parseInt(el.getAttribute('data-count').replace('+', ''));
        let count = 0;

        const updateCount = () => {
            const increment = Math.ceil(countTo / 100);
            count += increment;
            if (count > countTo) {
                count = countTo;
            }
            el.textContent = count + '+';
            if (count < countTo) {
                requestAnimationFrame(updateCount);
            }
        };

        updateCount();
    },
};
