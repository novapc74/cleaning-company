import LocomotiveScroll from "locomotive-scroll";

const locoScroll = new LocomotiveScroll({
    el: document.querySelector(".scroll-container"),
    smooth: true,
    smoothMobile: true,
    smartphone: {
        smooth: true,
    }
});

export default locoScroll