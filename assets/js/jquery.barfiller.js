/*
* File: jquery.barfiller.js
* Version: 1.0.1
* Description: A plugin that fills bars with a percentage and color
*/
(function ($) {
    $.fn.barfiller = function (options) {
        var defaults = $.extend({
            barColor: '#b0712f',
            tooltip: true,
            duration: 1000,
            animateOnResize: true,
            symbol: "%"
        }, options);

        return this.each(function () {
            var $this = $(this);
            var $fill = $this.find('.fill');
            var $tip = $this.find('.tip');
            var percentage = $this.attr('data-percentage') || 70;

            if ($fill.length === 0) {
                $this.wrapInner('<span class="fill"></span>');
                $fill = $this.find('.fill');
            }

            $fill.css({
                'background': defaults.barColor,
                'width': '0%'
            });

            var animateBar = function () {
                $fill.stop().animate({
                    width: percentage + '%'
                }, defaults.duration);

                if (defaults.tooltip && $tip.length) {
                    $tip.text(percentage + defaults.symbol);
                }
            };

            animateBar();

            if (defaults.animateOnResize) {
                $(window).on('resize', function () {
                    animateBar();
                });
            }
        });
    };
})(jQuery);
