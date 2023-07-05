import Swiper from 'swiper/bundle';

export default function swipers() {
    const gallerySwiper = new Swiper('.gallery-slider__swiper', {
        slidesPerView: 1,
        spaceBetween: 10,
        speed: 500,
        pagination: {
            el: '.gallery__pagination',
            type: 'fraction'
        },
        navigation: {
            nextEl: '.gallery-slider__btn_next',
            prevEl: '.gallery-slider__btn_prev',
        },

    })
}