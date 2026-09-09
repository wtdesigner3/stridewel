/*
* jquery.scrollUp.js
* Description: Scroll to top plugin
*/
(function ($) {
    'use strict';
    $.scrollUp = function (options) {
        var settings = $.extend({
            scrollName: 'scrollUp',
            topDistance: '300',
            topSpeed: 300,
            animation: 'fade',
            animationInSpeed: 200,
            animationOutSpeed: 200,
            scrollText: '<i class="fa fa-angle-up"></i>',
            activeOverlay: false
        }, options);

        var $self = $('#' + settings.scrollName);
        if (!$self.length) {
            $self = $('<a/>', {
                id: settings.scrollName,
                href: '#top'
            }).appendTo('body');
            $self.html(settings.scrollText);
        }

        $(window).scroll(function () {
            if ($(window).scrollTop() > settings.topDistance) {
                $self.fadeIn(settings.animationInSpeed);
            } else {
                $self.fadeOut(settings.animationOutSpeed);
            }
        });

        $self.click(function (e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, settings.topSpeed);
        });
    };
})(jQuery);
