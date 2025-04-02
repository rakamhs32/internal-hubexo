import hamburgerNav from "./modules/hamburgerNav";
import promoBanner from "./modules/promoBanner";
import teamMembers from "./modules/teamMembers";
import GLightbox from "glightbox";
import basicIntersections from "./modules/basicIntersections";
import dotsStrip from "./modules/dotsStrip";
import logoCarousel from "./modules/logoCarousel";
import logoCarouselGrid from "./modules/logoCarouselGrid";
import testimonials from "./modules/testimonials";
import infiniteScroll from "./modules/infiniteScroll";
import fpnBlocks from "./modules/fpnBlocks";
import officeListTwo from "./modules/officeListTwo";
import searchBar from "./modules/searchBar";
import header from "./modules/header";
import {createHero} from "./modules/introDots";
import {stats} from "./modules/stats";
import {linkListMobileTriggers} from "./modules/linkList";
import {iconBlocks} from "./modules/iconBlocks";

function init() {
    header.init();
    promoBanner.init();
    hamburgerNav.init();
    dotsStrip.init();
    officeListTwo.init();
    logoCarousel.init();
    logoCarouselGrid.init();
    testimonials.init();
    teamMembers.init();
    basicIntersections.init();
    infiniteScroll.init();
    fpnBlocks.init();
    searchBar.init();

    createHero();
    stats();
    linkListMobileTriggers();
    iconBlocks();

    const videoLightbox = GLightbox({
        selector: ".glightbox-video",
        skin: "video",
        touchNavigation: true,
        loop: false,
        keyboardNavigation: false,
        touchNavigation: false,
        autoplayVideos: true,
        openEffect: "fade",
        closeEffect: "fade",
        slideEffect: "fade",
    });
}

document.addEventListener("DOMContentLoaded", function () {
    init();
});
