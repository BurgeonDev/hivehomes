/**
 * Dashboard Analytics
 */

'use strict';

(function () {
    let cardColor, headingColor, fontFamily, labelColor;
    cardColor = config.colors.cardColor;
    labelColor = config.colors.textMuted;
    headingColor = config.colors.headingColor;

    // swiper loop and autoplay
    // --------------------------------------------------------------------
    const swiperWithPagination = document.querySelector('#swiper-with-pagination-cards');
    if (swiperWithPagination) {
        new Swiper(swiperWithPagination, {
            loop: true,
            autoplay: {
                delay: 2500,
                disableOnInteraction: false
            },
            pagination: {
                clickable: true,
                el: '.swiper-pagination'
            }
        });
    }



})();
