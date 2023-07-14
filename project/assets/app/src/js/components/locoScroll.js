import LocomotiveScroll from "locomotive-scroll";

const locoScroll = document.querySelector('.scroll-container') && new LocomotiveScroll({
    el: document.querySelector(".scroll-container"),
    smooth: true,
    smoothMobile: true,
    smartphone: {
        smooth: true,
    },
    scrollFromAnywhere: true
});

export default locoScroll