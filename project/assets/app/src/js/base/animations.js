import LocomotiveScroll from 'locomotive-scroll';
import {gsap} from 'gsap'
import {ScrollTrigger} from 'gsap/ScrollTrigger'
import {log} from "video.js";

gsap.registerPlugin(ScrollTrigger)
ScrollTrigger.config({ignoreMobileResize: true});

export default function animations() {

    const locoScroll = new LocomotiveScroll({
        el: document.querySelector(".scroll-container"),
        smooth: true,
        smoothMobile: true,
        tablet: {
            breakpoint: 0,
        }
    });

    locoScroll.on("scroll", ScrollTrigger.update);

    ScrollTrigger.scrollerProxy(".scroll-container", {
        scrollTop(value) {
            return arguments.length ? locoScroll.scrollTo(value, 0, 0) : locoScroll.scroll.instance.scroll.y;
        },
        getBoundingClientRect() {
            return {top: 0, left: 0, width: window.innerWidth, height: window.innerHeight};
        },

        pinType: document.querySelector(".scroll-container").style.transform ? "transform" : "fixed"
    });

    if(document.querySelector('.hero-section')) {
        const tl = gsap.timeline()
        tl.fromTo('.hero-section__title', {
            opacity: 0,
            y: -100
        }, {
            opacity: 1,
            y: 0
        }).fromTo('.hero-section__description', {
            opacity: 0,
            y: -25
        }, {
            opacity: 1,
            y: 0
        })
    }

    const baseSectionTitles = gsap.utils.toArray('.base-section__title')
    baseSectionTitles.length && baseSectionTitles.forEach(item => {
        gsap.fromTo(item, {
            opacity: 0,
            xPercent: -50,
            duration: 1.5
        }, {
            opacity: 1,
            xPercent: 0,
            scrollTrigger: {
                start: 'top bottom 25%',
                trigger: item,
                scroller: '.scroll-container'
            }
        })
    })

    if (document.querySelector('.about-section')) {
        const tl = gsap.timeline({
            scrollTrigger: {
                start: 'top center',
                trigger: '.about-section',
                scroller: '.scroll-container'
            }
        })
        tl.fromTo('.about-section__heading', {
            opacity: 0,
            x: -300
        }, {
            opacity: 1,
            x: 0
        }).fromTo('.about-section__description', {
            opacity: 0,
            x: -200
        }, {
            opacity: 1,
            x: 0
        })
    }

    document.addEventListener('click', (evt) => {
        evt.preventDefault()
        const target = evt.target
        if(target.closest('[data-anchor-link]')) {
            const anchor = '#' + evt.target.closest('[data-anchor-link]').dataset.anchor
            locoScroll.scrollTo(anchor)
        }
    })

    ScrollTrigger.addEventListener("refresh", () => locoScroll.update());
    ScrollTrigger.refresh();
}

