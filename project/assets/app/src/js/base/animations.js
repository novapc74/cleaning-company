import {gsap} from 'gsap'
import {ScrollTrigger} from 'gsap/ScrollTrigger'
import toggleWindowScroll from "../functions/toggleWindowScroll";
import locoScroll from "../components/locoScroll";
import {addClass, removeClass, toggleActiveClass} from "../functions/classMethods";

gsap.registerPlugin(ScrollTrigger)
ScrollTrigger.config({ignoreMobileResize: true});

export default function animations() {

    if(!locoScroll) {
        return
    }

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

    // header
    if(document.querySelector('.header')) {
        let deltaValue = 0
        const header = document.querySelector('.header')
        locoScroll.on('scroll', ({ delta }) => {
            if(delta.y === deltaValue) {
                deltaValue = delta.y
                return
            }
            delta.y > deltaValue ? addClass(header,'hidden') : removeClass(header,'hidden')
            deltaValue = delta.y
        })
    }

    // hero
    if (document.querySelector('.hero-section')) {
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

        gsap.to('.hero-section', {
            scrollTrigger: {
                start: 'top top',
                end: () => `+=${window.innerHeight * 2}`,
                trigger: '.hero-section',
                scroller: '.scroll-container',
                scrub: true
            },
            yPercent: 100
        })
    }

    // section titles
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

    // about
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

    const fadeFromSide = (className, reverse = false) => {
        const items = gsap.utils.toArray(className)
        items && items.forEach(item => {
            gsap.from(item, {
                opacity: 0,
                x: reverse ? 150 : -150,
                scrollTrigger: {
                    trigger: item,
                    scroller: '.scroll-container',
                    scrub: 1.5,
                    start: "top bottom",
                    end: "top center"
                }
            })
        })
    }

    // services
    fadeFromSide('.services-section__service', true)
    const services = [...document.querySelectorAll('.service')]
    if(services.length) {
        services.forEach(item => item.addEventListener('mouseenter', evt => {
            evt.target.closest('.service') && toggleActiveClass(evt.target.closest('.service'), '.service', 'active')
        }))
        services.forEach(item => item.addEventListener('mouseleave', evt => {
            evt.target.closest('.service') && removeClass(evt.target.closest('.service'), 'active')
        }))
    }

    fadeFromSide('.advantages-section__advantage')
    fadeFromSide('.steps-section__step')
    fadeFromSide('.faq-section__item')

    document.addEventListener('click', (evt) => {
        const target = evt.target
        if (target.closest('[data-anchor-link]')) {
            evt.preventDefault()
            const anchor = '#' + evt.target.closest('[data-anchor-link]').dataset.anchor
            locoScroll.scrollTo(anchor)
        }
    })

    ScrollTrigger.addEventListener("refresh", () => locoScroll.update());
    ScrollTrigger.refresh();
}

