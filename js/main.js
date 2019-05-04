$(document).ready(function () {
    wow = new WOW({
        boxClass: 'wow',
        animateClass: 'animated',
        offset: 200,
        mobile: false,
        live: false
    });
    wow.init();
    //smooth_scroll
    smoothScroll.init();
    var amountScrolled = 300;
    $(window).scroll(function () {
        if ($(window).scrollTop() > amountScrolled) {
            $('#scroll-btn').fadeIn('slow');
        } else {
            $('#scroll-btn').fadeOut('slow');
        }
    });
    $('#scroll-btn').click(function () {
        $('html, body').animate({
            scrollTop: 0
        }, 1000);
        return false;
    });
    //fancybox
    $("[data-fancybox]").fancybox({
        selector: '[data-fancybox="images"]',
        loop: true
    });
    //tooltip
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    $('.owl-about').owlCarousel({
        // center: true,
        loop: true,
        dots: false,
        autoplay: true,
        margin: 0,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                dots: true,
            },
            600: {
                items: 3,
            },
            1000: {
                items: 3,
            }
        }
    });
    $('.owl-sport').owlCarousel({
        center: true,
        loop: true,
        dots: true,
        autoplay: true,
        margin: 0,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 3,
            },
            1000: {
                items: 3,
            }
        }
    });
    $('.owl-clients').owlCarousel({
        loop: true,
        dots: false,
        nav: true,
        navText: ['<img src="images/shape-4.png">', '<img src="images/shape-4-copy.png">'],
        autoplay: true,
        margin: 0,
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: false,
                dots: true,
                margin: 15
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,
            }
        }
    });
   
    $('.owl-collection').owlCarousel({
        loop: true,
        dots: false,
        nav: true,
        navText: ['<img src="images/shape-4.png">', '<img src="images/shape-4-copy.png">'],
        autoplay: true,
        margin: 0,
        responsiveClass: true,
        autoplayHoverPause: true,
        // Enable thumbnails
        thumbs: true,
        // When only using images in your slide (like the demo) use this option to dynamicly create thumbnails without using the attribute data-thumb.
        thumbImage: true,
        // Enable this if you have pre-rendered thumbnails in your html instead of letting this plugin generate them. This is recommended as it will prevent FOUC
        thumbsPrerendered: true,
        // Class that will be used on the thumbnail container
        thumbContainerClass: 'owl-thumbs',
        // Class that will be used on the thumbnail item's
        thumbItemClass: 'owl-thumb-item',
        responsive: {
            0: {
                items: 1,
            },
            600: {
                items: 1,
            },
            1000: {
                items: 1,
            }
        }
    });
    $('.dropdown').hover(function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeIn(500);
    }, function () {
        $(this).find('.dropdown-menu').stop(true, true).delay(200).fadeOut(500);
    });
    $('body').on('mouseenter mouseleave', '.dropdown', function (e) {
        var _d = $(e.target).closest('.dropdown');
        if (e.type === 'mouseenter') _d.addClass('show');
        setTimeout(function () {
            _d.toggleClass('show', _d.is(':hover'));
            $('[data-toggle="dropdown"]', _d).attr('aria-expanded', _d.is(':hover'));
        }, 300);
    });
    $('.color-selector .entry').on('click', function () {
        $(this).parent().find('.active').removeClass('active');
        $(this).addClass('active');
    });
    $('.quantaty-selector .entry-quantaty').on('click', function () {
        $(this).parent().find('.active').removeClass('active');
        $(this).addClass('active');
    });
    $('.heart').on('click', function () {
        el = $(this);
        if (el.hasClass('liked')) {
            el.removeClass('liked');
            return
        } else {
            el.addClass('liking');
            el.one('webkitAnimationEnd oanimationend msAnimationEnd animationend', function (e) {
                el.addClass('liked').removeClass('liking');
            });
        }
    });
});
