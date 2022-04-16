const swiper = new Swiper('.swiper', {
    direction: 'horizontal',
    slidesPerView: 5,
    slidesPerGroup: 5,

    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },

    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
        
    },


});