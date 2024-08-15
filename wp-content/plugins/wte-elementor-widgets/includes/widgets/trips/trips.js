
function initializeSliders($scope, $) {

    let swiperContainer = $scope.find('.wpte-swiper')

    if (swiperContainer[0]) {
        let options = Object.assign({
            navigation: {
                nextEl: '.wpte-swiper-button-next',
                prevEl: '.wpte-swiper-button-prev',
            },
            pagination: {
                el: '.wpte-swiper-pagination',
                type: 'bullets',
                clickable: true
            },
        }, swiperContainer[0].dataset.swiperOptions ? JSON.parse(swiperContainer[0].dataset.swiperOptions) : {})
        new elementorFrontend.utils.swiper(swiperContainer[0], options)
    }
}

jQuery(window).on("elementor/frontend/init", function () {
    elementorFrontend.hooks.addAction(
        "frontend/element_ready/wptravelengine-trips.default",
        initializeSliders
    );
});
