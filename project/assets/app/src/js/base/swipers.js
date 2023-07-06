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
}