/*var thumbs = new Swiper('.gallery-thumbs', {
    direction: 'vertical',
    spaceBetween: 12,
    // Количество слайдов для показа
    slidesPerView: 3,

    // Отключение функционала
    // если слайдов меньше чем нужно
    watchOverflow: true,
    navigation: {
        nextEl: '._icon-up',
        prevEl: '._icon-down',
    },

})*/

var swiperMain = new Swiper('.swiper-main', {
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true,
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    autoHeight: true,

    /*thumbs: {
        swiper: thumbs
    }*/

});

var swiperRec = new Swiper('.swiper-rec', {
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
        dynamicBullets: true,
    },

    // Navigation arrows
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },

    autoHeight: true,

});