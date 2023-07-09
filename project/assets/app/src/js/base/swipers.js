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
        breakpoints: {
            768: {
                slidesPerView: 2,
            },
            1280: {
                spaceBetween: 20,
                slidesPerView: 2,
            },
            1600: {
                spaceBetween: 60,
                slidesPerView: 2,
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
        breakpoints: {
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

    const clientsSwiper = new Swiper('.clients-section__swiper', {
        slidesPerView: 4,
        speed: 500,
        spaceBetween: 15,
        grid: {
            fill: 'row',
            rows: 2
        },
        breakpoints: {
            1280: {
                spaceBetween: 30,
            }
        }
    })
}