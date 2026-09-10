(function ($) {
    'use strict';

    /*==================================
     * 1. Preloader / Loader
     *==================================*/
    function handlePreloader() {
        if ($('.loader-wrapper').length) {
            $('body').addClass('loaded');
        }
    }

    $(window).on('load', function () {
        handlePreloader();
    });

    // Safety fallback: dismiss loader after 600ms if load event already fired or is delayed
    setTimeout(function () {
        handlePreloader();
    }, 600);

    $(document).ready(function () {

        /*==================================
         * 2. Sticky Header
         *==================================*/
        $(window).on('scroll', function () {
            var scroll = $(window).scrollTop();
            if (scroll < 100) {
                $('#sticky-header').removeClass('sticky');
            } else {
                $('#sticky-header').addClass('sticky');
            }
        });

        /*==================================
         * 3. Modern Mobile Navigation (meanmenu disabled)
         *==================================*/
        // meanmenu disabled in favor of modern Stridewel Offcanvas Drawer

        /*==================================
         * 4. Search Popup
         *==================================*/
        if ($('.search-box-outer, .search-box-btn').length) {
            $('.search-box-outer, .search-box-btn').on('click', function (e) {
                e.preventDefault();
                $('body').addClass('search-active');
            });
            $('.close-search').on('click', function (e) {
                e.preventDefault();
                $('body').removeClass('search-active');
            });
        }

        /*==================================
         * 5. Offcanvas Info Sidebar
         *==================================*/
        if ($('.navSidebar-button').length) {
            $('.navSidebar-button').on('click', function (e) {
                e.preventDefault();
                $('.xs-sidebar-group').addClass('isActive');
            });
        }
        if ($('.close-side-widget, .xs-overlay').length) {
            $('.close-side-widget, .xs-overlay').on('click', function (e) {
                e.preventDefault();
                $('.xs-sidebar-group').removeClass('isActive');
            });
        }

        /*==================================
         * 6. Cart Sidebar
         *==================================*/
        if ($('.cart_btn').length) {
            $('.cart_btn').on('click', function (e) {
                e.preventDefault();
                $('.cart_sidebar, .cart_sidebar_overlay').addClass('active');
            });
        }
        if ($('.cart_sidebar .close_btn, .cart_sidebar_overlay').length) {
            $('.cart_sidebar .close_btn, .cart_sidebar_overlay').on('click', function (e) {
                e.preventDefault();
                $('.cart_sidebar, .cart_sidebar_overlay').removeClass('active');
            });
        }

        /*==================================
         * 7. Scroll-to-Top Circular Progress
         *==================================*/
        var progressPath = document.querySelector('.prgoress_indicator path');
        if (progressPath) {
            var pathLength = progressPath.getTotalLength();
            progressPath.style.transition = progressPath.style.WebkitTransition = 'none';
            progressPath.style.strokeDasharray = pathLength + ' ' + pathLength;
            progressPath.style.strokeDashoffset = pathLength;
            progressPath.getBoundingClientRect();
            progressPath.style.transition = progressPath.style.WebkitTransition = 'stroke-dashoffset 10ms linear';
            var updateProgress = function () {
                var scroll = $(window).scrollTop();
                var height = $(document).height() - $(window).height();
                var progress = pathLength - (scroll * pathLength / (height > 0 ? height : 1));
                progressPath.style.strokeDashoffset = progress;
            };
            updateProgress();
            $(window).scroll(updateProgress);
            var offset = 50;
            var duration = 550;
            $(window).on('scroll', function () {
                if ($(this).scrollTop() > offset) {
                    $('.prgoress_indicator').addClass('active-progress');
                } else {
                    $('.prgoress_indicator').removeClass('active-progress');
                }
            });
            $('.prgoress_indicator').on('click', function (event) {
                event.preventDefault();
                $('html, body').animate({ scrollTop: 0 }, duration);
                return false;
            });
        }

        /*==================================
         * 8. Owl Carousels
         *==================================*/
        // Advanced Animated Hero Slider
        if ($('.hero_slider_area').length && $.fn.owlCarousel) {
            $('.hero_slider_area').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 4500,
                autoplayHoverPause: false,
                autoplaySpeed: 1000,
                smartSpeed: 1000,
                items: 1,
                dots: true,
                nav: true,
                navText: ['<i class="bi bi-chevron-left"></i>', '<i class="bi bi-chevron-right"></i>'],
                animateOut: 'fadeOut',
                animateIn: 'fadeIn'
            });
        }

        // Category Filter Tabs
        $('.cat_filter_btn').on('click', function () {
            $('.cat_filter_btn').removeClass('active');
            $(this).addClass('active');
            var filter = $(this).attr('data-filter');
            if (filter === 'all') {
                $('.cat_5col_item').fadeIn(350);
            } else {
                $('.cat_5col_item').hide();
                $('.cat_5col_item[data-category="' + filter + '"]').fadeIn(350);
            }
        });

        // Modern FAQ Accordion Toggle (Smooth, Single-Open, No Double Triggers)
        $(document).off('click', '.faq_question').on('click', '.faq_question', function (e) {
            e.preventDefault();
            var $item = $(this).closest('.faq_item');
            var $answer = $item.find('.faq_answer');

            if ($item.hasClass('active')) {
                $item.removeClass('active');
                $answer.stop(true, true).slideUp(250);
            } else {
                // Collapse any other open accordion item smoothly
                $('.faq_item.active').not($item).removeClass('active').find('.faq_answer').stop(true, true).slideUp(250);
                $item.addClass('active');
                $answer.stop(true, true).slideDown(250);
            }
        });

        // Banner Slider
        if ($('.banner_slider').length && $.fn.owlCarousel) {
            $('.banner_slider').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 5000,
                smartSpeed: 1000,
                items: 1,
                dots: false,
                nav: false,
                animateOut: 'fadeOut'
            });
        }

        // Service List
        if ($('.service_list').length && $.fn.owlCarousel) {
            $('.service_list').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 6000,
                smartSpeed: 1000,
                margin: 30,
                dots: false,
                nav: false,
                responsive: {
                    0: { items: 1 },
                    576: { items: 1 },
                    768: { items: 2 },
                    992: { items: 3 },
                    1200: { items: 3 }
                }
            });
        }

        // Case Study 1
        if ($('.case_study').length && $.fn.owlCarousel) {
            $('.case_study').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 5000,
                smartSpeed: 1000,
                margin: 30,
                dots: false,
                nav: false,
                responsive: {
                    0: { items: 1 },
                    768: { items: 2 },
                    992: { items: 3 },
                    1200: { items: 4 }
                }
            });
        }

        // Case Study 2
        if ($('.case_study2').length && $.fn.owlCarousel) {
            $('.case_study2').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 5000,
                smartSpeed: 1000,
                margin: 30,
                dots: false,
                nav: false,
                responsive: {
                    0: { items: 1 },
                    768: { items: 2 },
                    992: { items: 3 },
                    1200: { items: 4 }
                }
            });
        }

        // Testimonial (Home 1)
        if ($('.testimonial').length && $.fn.owlCarousel) {
            $('.testimonial').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 6000,
                smartSpeed: 1000,
                margin: 30,
                dots: true,
                nav: false,
                items: 1,
                responsive: {
                    0: { items: 1 },
                    768: { items: 1 },
                    992: { items: 1 }
                }
            });
        }

        // Testimonial List Carousel

        // Species Specific Carousel
        if ($('.species_carousel').length && $.fn.owlCarousel) {
            $('.species_carousel').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 5500,
                autoplayHoverPause: true,
                smartSpeed: 800,
                margin: 24,
                dots: true,
                nav: false,
                responsive: {
                    0: { items: 1 },
                    768: { items: 2 },
                    1200: { items: 2 }
                }
            });
        }

        if ($('.testi_list').length && $.fn.owlCarousel) {
            $('.testi_list').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                smartSpeed: 800,
                margin: 24,
                dots: true,
                nav: false,
                responsive: {
                    0: { items: 1 },
                    768: { items: 2 },
                    1200: { items: 3 }
                }
            });
        }

        // Testimonial List 3
        if ($('.testi_list3').length && $.fn.owlCarousel) {
            $('.testi_list3').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 6000,
                smartSpeed: 1000,
                margin: 30,
                dots: true,
                nav: false,
                items: 1
            });
        }

        // Brand List 1
        if ($('.brand_list').length && $.fn.owlCarousel) {
            $('.brand_list').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 4000,
                smartSpeed: 800,
                margin: 30,
                dots: false,
                nav: false,
                responsive: {
                    0: { items: 2 },
                    576: { items: 3 },
                    768: { items: 4 },
                    992: { items: 4 },
                    1200: { items: 4 }
                }
            });
        }

        // Brand List 2
        if ($('.brand_list2').length && $.fn.owlCarousel) {
            $('.brand_list2').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 4000,
                smartSpeed: 800,
                margin: 30,
                dots: false,
                nav: false,
                responsive: {
                    0: { items: 2 },
                    576: { items: 3 },
                    768: { items: 4 },
                    992: { items: 5 }
                }
            });
        }

        // Blog List 1
        if ($('.blog_list').length && $.fn.owlCarousel) {
            $('.blog_list').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 6000,
                smartSpeed: 1000,
                margin: 30,
                dots: false,
                nav: false,
                responsive: {
                    0: { items: 1 },
                    768: { items: 2 },
                    992: { items: 3 }
                }
            });
        }

        // Blog List 2
        if ($('.blog_list2').length && $.fn.owlCarousel) {
            $('.blog_list2').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 6000,
                smartSpeed: 1000,
                margin: 30,
                dots: false,
                nav: false,
                responsive: {
                    0: { items: 1 },
                    768: { items: 2 }
                }
            });
        }

        // Product List (Home 4)
        if ($('.product_list').length && $.fn.owlCarousel) {
            $('.product_list').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 5000,
                smartSpeed: 1000,
                margin: 30,
                dots: false,
                nav: false,
                responsive: {
                    0: { items: 1 },
                    576: { items: 2 },
                    992: { items: 3 },
                    1200: { items: 4 }
                }
            });
        }

        /*==================================
         * 9. Product Tab Switching (Home 4)
         *==================================*/
        $('.product_tab_btn button').on('click', function () {
            var index = $(this).index();
            $('.product_tab_btn button').removeClass('active');
            $(this).addClass('active');
            $('.product_container').removeClass('active').hide();
            $('.product_container').eq(index).addClass('active').fadeIn();
        });

        /*==================================
         * 10. Counter Up
         *==================================*/
        if ($('.counter').length && $.fn.counterUp) {
            $('.counter').counterUp({
                delay: 10,
                time: 1000
            });
        }

        /*==================================
         * 11. WOW Animations
         *==================================*/
        if (typeof WOW !== 'undefined') {
            new WOW({
                boxClass: 'wow',
                animateClass: 'animated',
                offset: 0,
                mobile: false,
                live: true
            }).init();
        }

        /*==================================
         * 12. Venobox Lightbox
         *==================================*/
        if ($('.venobox').length && $.fn.venobox) {
            $('.venobox').venobox({
                numeratio: true,
                infinigall: true
            });
        }

        /*==================================
         * 13. Portfolio / Isotope Filtering
         *==================================*/
        if ($('.image_load').length && $.fn.isotope) {
            var $grid = $('.image_load');
            if ($.fn.imagesLoaded) {
                $grid.imagesLoaded(function () {
                    $grid.isotope({
                        itemSelector: '.grid-item',
                        percentPosition: true,
                        masonry: {
                            columnWidth: '.grid-item'
                        }
                    });
                });
            } else {
                $grid.isotope({
                    itemSelector: '.grid-item',
                    percentPosition: true
                });
            }

            $('.portfolio_menu ul li').on('click', function () {
                $('.portfolio_menu ul li').removeClass('current_menu_item');
                $(this).addClass('current_menu_item');
                var filterValue = $(this).attr('data-filter');
                $grid.isotope({ filter: filterValue });
            });
        }

        /*==================================
 * 14. Barfiller
 *==================================*/
        if ($.fn.barfiller) {
            if ($('#bar1').length) $('#bar1').barfiller();
            if ($('#bar2').length) $('#bar2').barfiller();
            if ($('#bar3').length) $('#bar3').barfiller();
            if ($('.barfiller').length) $('.barfiller').barfiller();
        }

        /*==================================
         * 15. Mega Menu Product Hover Image Preview
         *==================================*/
        (function () {
            if ($('#mega_prod_hover_card').length === 0) {
                var cardHtml = '<div id="mega_prod_hover_card">' +
                    '<div class="preview_img_box"><img src="" alt="Product Preview"></div>' +
                    '<div class="preview_name"></div>' +
                    '<span class="preview_code"></span>' +
                    '</div>';
                $('body').append(cardHtml);
            }

            var $card = $('#mega_prod_hover_card');
            var $img = $card.find('img');
            var $name = $card.find('.preview_name');
            var $code = $card.find('.preview_code');

            function updatePosition(e) {
                var cardWidth = 210;
                var cardHeight = 180;
                var winWidth = $(window).width();
                var winHeight = $(window).height();

                var x = e.clientX + 20;
                var y = e.clientY - (cardHeight / 2);

                if (x + cardWidth > winWidth - 10) {
                    x = e.clientX - cardWidth - 20;
                }
                if (y < 10) {
                    y = 10;
                } else if (y + cardHeight > winHeight - 10) {
                    y = winHeight - cardHeight - 10;
                }

                $card.css({
                    left: x + 'px',
                    top: y + 'px'
                });
            }

            $(document).on('mouseenter', '.mega_menu_list li a[data-img]', function (e) {
                var imgSrc = $(this).attr('data-img');
                var prodName = $(this).attr('data-name') || $(this).text();
                var prodCode = $(this).attr('data-code') || '';

                if (imgSrc) {
                    $img.attr('src', imgSrc);
                    $name.text(prodName);
                    if (prodCode) {
                        $code.text(prodCode).show();
                    } else {
                        $code.hide();
                    }
                    updatePosition(e);
                    $card.addClass('active');
                }
            });

            $(document).on('mousemove', '.mega_menu_list li a[data-img]', function (e) {
                if ($card.hasClass('active')) {
                    updatePosition(e);
                }
            });

            $(document).on('mouseleave', '.mega_menu_list li a[data-img]', function () {
                $card.removeClass('active');
            });

            $(document).on('mouseleave', '.has-mega-menu', function () {
                $card.removeClass('active');
            });
        })();

        /*==================================================
         * 16. Dynamic FAQ Section Sticky Image Controller
         *==================================================*/
        (function initFaqStickyController() {
            var $faqCard = $('.faq_visual_card');
            var $faqCol = $('.faq_sticky_column');
            var $faqArea = $('.faq_area');

            if (!$faqCard.length || !$faqCol.length || !$faqArea.length) return;

            function updateFaqStickyPosition() {
                if ($(window).width() < 992) {
                    $faqCard.css({ 'transform': 'none' });
                    return;
                }

                var scrollTop = $(window).scrollTop();
                var colTop = $faqCol.offset().top;
                var colHeight = $faqCol.outerHeight();
                var cardHeight = $faqCard.outerHeight();
                var headerOffset = 95; // aligns below sticky header

                var maxTranslate = colHeight - cardHeight;
                if (maxTranslate <= 0) {
                    $faqCard.css({ 'transform': 'none' });
                    return;
                }

                var targetY = scrollTop - colTop + headerOffset;

                if (targetY <= 0) {
                    $faqCard.css({ 'transform': 'translateY(0px)' });
                } else if (targetY >= maxTranslate) {
                    $faqCard.css({ 'transform': 'translateY(' + maxTranslate + 'px)' });
                } else {
                    $faqCard.css({ 'transform': 'translateY(' + targetY + 'px)' });
                }
            }

            $(window).on('scroll resize', updateFaqStickyPosition);
            $(document).on('click', '.faq_question', function () {
                setTimeout(updateFaqStickyPosition, 320);
                setTimeout(updateFaqStickyPosition, 600);
            });
            setTimeout(updateFaqStickyPosition, 200);
        })();

        /*==================================================
         * 17. Get Quote / Institutional Enquiry Modal Controller
         *==================================================*/
        (function initQuoteModalHandler() {
            // Trigger Modal on click of any Quote Button
            $(document).on('click', '.header_quote_btn, .open_quote_modal, [data-trigger="quote-modal"]', function (e) {
                e.preventDefault();
                var modalEl = document.getElementById('quoteModal');
                if (modalEl) {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        var modalInstance = bootstrap.Modal.getOrCreateInstance(modalEl);
                        modalInstance.show();
                    } else if ($.fn.modal) {
                        $('#quoteModal').modal('show');
                    }
                }
            });

            // Handle Enquiry Form Submission with instant feedback
            $(document).on('submit', '#quoteEnquiryForm', function (e) {
                e.preventDefault();
                var $form = $(this);
                var $btn = $form.find('button[type="submit"]');
                var originalBtnHtml = $btn.html();

                $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Submitting Request...');

                setTimeout(function () {
                    $form.slideUp(300, function () {
                        $('#quoteSuccessAlert').fadeIn(350);
                    });
                    $btn.prop('disabled', false).html(originalBtnHtml);
                }, 800);
            });

            // Reset Form when Modal is closed
            var modalEl = document.getElementById('quoteModal');
            if (modalEl) {
                modalEl.addEventListener('hidden.bs.modal', function () {
                    $('#quoteSuccessAlert').hide();
                    $('#quoteEnquiryForm').show()[0].reset();
                });
            }
        })();

        /*==================================================
         * 18. Offcanvas Mobile Navigation Drawer Controller
         *==================================================*/
                /*==================================================
         * 18. Offcanvas Mobile Navigation Drawer & Products Accordion Handler
         *==================================================*/
        (function initMobileDrawerHandler() {
            // Ensure accordion starts strictly hidden/collapsed on load
            $('.mobile_products_accordion, #mobileProdCollapse, .mobile_submenu_wrap').hide();

            // Open Drawer
            $(document).on('click', '#mobileNavToggle, .mobile_nav_toggler', function (e) {
                e.preventDefault();
                $('#mobileNavDrawer').addClass('active');
                $('#mobileNavBackdrop').addClass('active');
                $('body').addClass('mobile_drawer_open').css('overflow', 'hidden');
            });

            // Toggle Mobile Products Catalog Accordion (Closed by default, click to expand)
            $(document).on('click', '.mobile_accordion_toggle, .mobile_submenu_toggle, #mobileProdToggle', function (e) {
                e.preventDefault();
                e.stopPropagation();
                var $this = $(this);
                var $parent = $this.closest('.mobile_has_submenu');
                var $accordion = $parent.find('.mobile_products_accordion, #mobileProdCollapse, .mobile_submenu_wrap');
                
                if ($accordion.is(':visible')) {
                    $parent.removeClass('open');
                    $this.addClass('collapsed').attr('aria-expanded', 'false');
                    $accordion.stop(true, true).slideUp(280);
                } else {
                    $parent.addClass('open');
                    $this.removeClass('collapsed').attr('aria-expanded', 'true');
                    $accordion.stop(true, true).slideDown(280);
                }
            });

            // Prevent clicks inside accordion container from closing or bubbling
            $(document).on('click', '.mobile_products_accordion, #mobileProdCollapse', function (e) {
                e.stopPropagation();
            });

            // Close Drawer (on close button, backdrop, direct top-level navigation links, or action buttons)
            $(document).on('click', '#mobileNavClose, #mobileNavBackdrop, .mobile_nav_list > li:not(.mobile_has_submenu) > a, .mobile_product_link, .btn_drawer_quote, .btn_drawer_catalog', function () {
                $('#mobileNavDrawer').removeClass('active');
                $('#mobileNavBackdrop').removeClass('active');
                $('body').removeClass('mobile_drawer_open').css('overflow', '');
            });
        })();

        /*==================================================
         * 19. Desktop Mega Menu Smooth Hover Intent & Bridge
         *==================================================*/
        (function initMegaMenuHoverIntent() {
            var $megaTriggers = $('.has-mega-menu');
            var closeTimeout = null;

            function showMegaMenu() {
                if (closeTimeout) {
                    clearTimeout(closeTimeout);
                    closeTimeout = null;
                }
                $megaTriggers.addClass('show-mega-menu');
            }

            function hideMegaMenuWithGrace() {
                if (closeTimeout) {
                    clearTimeout(closeTimeout);
                }
                closeTimeout = setTimeout(function () {
                    $megaTriggers.removeClass('show-mega-menu');
                }, 60); // Snappy 60ms exit for crisp, lag-free close
            }

            // Bind to triggers and dropdown content
            $(document).on('mouseenter', '.has-mega-menu, .sub_menu.mega_menu', showMegaMenu);
            $(document).on('mouseleave', '.has-mega-menu, .sub_menu.mega_menu', hideMegaMenuWithGrace);
        })();

    });

        /*==================================================
         * Modern Homepage Blog Carousel Initialization
         *==================================================*/
        if ($('.blog_carousel').length && $.fn.owlCarousel) {
            $('.blog_carousel').owlCarousel({
                loop: true,
                autoplay: true,
                autoplayTimeout: 5500,
                autoplayHoverPause: true,
                smartSpeed: 800,
                margin: 24,
                dots: true,
                nav: false,
                responsive: {
                    0: { items: 1 },
                    576: { items: 2 },
                    992: { items: 3 },
                    1200: { items: 4 }
                }
            });
        }

    })(jQuery);
