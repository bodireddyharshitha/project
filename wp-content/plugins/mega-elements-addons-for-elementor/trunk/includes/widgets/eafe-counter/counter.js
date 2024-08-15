/****** Counter Handler ******/
var EAFECounterHandler = function ($scope, $) {
    var counterElement = $scope.find(".eafe-counter");
    elementorFrontend.waypoint(counterElement, function () {
        var counterSettings = counterElement.data(),
            incrementElement = counterElement.find(".eafe-counter-init"),
            iconElement = counterElement.find(".icon");
        $(incrementElement).numerator(counterSettings);
        $(iconElement).addClass("animated " + iconElement.data("animation"));
    });
};
jQuery(window).on("elementor/frontend/init", function() {
    elementorFrontend.hooks.addAction(
        "frontend/element_ready/eafe-counter.default",
        EAFECounterHandler
    );
});
