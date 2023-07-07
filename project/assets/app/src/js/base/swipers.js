import Swiper from 'swiper/bundle';

export default function swipers() {
    const gallerySwiper = new Swiper('.gallery-slider__swiper', {
        slidesPerView: 1,
        spaceBetween: 10,
        loop: true,
        speed: 1000,
        autoplay: {
            delay: 5000,
            pauseOnMouseEnter: true
        },
        pagination: {
            el: '.gallery-slider__pagination',
            type: 'fraction'
        },
        navigation: {
            nextEl: '.gallery-slider__btn_next',
            prevEl: '.gallery-slider__btn_prev',
        },
    })

    const casesSwiper = new Swiper('.cases-swiper', {
        slidesPerView: 1,
        spaceBetween: 15,
        loop: false,
        speed: 500,
        navigation: {
            nextEl: '.cases-swiper__btn_next',
            prevEl: '.cases-swiper__btn_prev',
        },
        breakpoint: {
            768: {
                slidesPerView: 2,
            },
            1280: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            1600: {
                slidesPerView: 2,
                spaceBetween: 60
            },
        }
    })

    const reviewsSwiper = new Swiper('.reviews-swiper', {
        slidesPerView: 1,
        spaceBetween: 15,
        loop: false,
        speed: 500,
        navigation: {
            nextEl: '.reviews-swiper__btn_next',
            prevEl: '.reviews-swiper__btn_prev',
        },
        breakpoint: {
            768: {
                slidesPerView: 2,
            },
            1280: {
                slidesPerView: 3,
                spaceBetween: 50
            },
            1600: {
                slidesPerView: 3,
                spaceBetween: 60
            },
        }
    })
}