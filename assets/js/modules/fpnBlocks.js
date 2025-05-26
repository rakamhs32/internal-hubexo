export default {
    init() {
        const itemColumns = document.querySelectorAll('.item-column');

        itemColumns.forEach((itemColumn) => {
            // Add event listeners for mouseenter and mouseleave
            itemColumn.addEventListener('mouseenter', this.handleMouseEnter);
            itemColumn.addEventListener('mouseleave', this.handleMouseLeave);
        });
    },

    destroy() {
        const itemColumns = document.querySelectorAll('.item-column');

        itemColumns.forEach((itemColumn) => {
            // Remove event listeners for mouseenter and mouseleave
            itemColumn.removeEventListener('mouseenter', this.handleMouseEnter);
            itemColumn.removeEventListener('mouseleave', this.handleMouseLeave);
        });
    },

    handleMouseEnter(event) {
        const itemColumn = event.currentTarget;

        itemColumn.classList.add('plum-bg');

        const iconImg = itemColumn.querySelector('.icon-item img');
        if (iconImg) {
            iconImg.classList.add('filter-white');
        }

        const itemLink = itemColumn.querySelector('.item-content a');
        if (itemLink) {
            itemLink.classList.add('filter-white');
            itemLink.classList.add('hidden');
        }

        const hoverDescription = itemColumn.querySelector('.hover-description');
        if (hoverDescription) {
            hoverDescription.classList.add('visible');
        }
    },

    handleMouseLeave(event) {
        const itemColumn = event.currentTarget;

        itemColumn.classList.remove('plum-bg');

        const iconImg = itemColumn.querySelector('.icon-item img');
        if (iconImg) {
            iconImg.classList.remove('filter-white');
        }

        const itemLink = itemColumn.querySelector('.item-content a');
        if (itemLink) {
            itemLink.classList.remove('filter-white');
            itemLink.classList.remove('hidden');
        }

        const hoverDescription = itemColumn.querySelector('.hover-description');
        if (hoverDescription) {
            hoverDescription.classList.remove('visible');
        }
    },
};