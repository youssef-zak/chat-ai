(function ($) {
    function animateOnScroll() {
        $('.animation-fade').each(function () {
            var $el = $(this);
            var rect = this.getBoundingClientRect();
            if (rect.top < window.innerHeight - 80) {
                setTimeout(function () {
                    $el.addClass('is-visible');
                }, parseInt($el.data('delay') || 0, 10));
            }
        });
    }

    function toggleMenu() {
        var $toggle = $('#gv-toggle-menu');
        var $nav = $('#gv-primary-menu');
        var $overlay = $('#gv-menu-overlay');

        if (!$toggle.length || !$nav.length) {
            return;
        }

        var closeMenu = function () {
            $toggle.attr('aria-expanded', 'false');
            $nav.removeClass('is-open');
            $('body').removeClass('gv-menu-open');
            if ($overlay.length) {
                $overlay.removeClass('is-visible');
            }
        };

        var openMenu = function () {
            $toggle.attr('aria-expanded', 'true');
            $nav.addClass('is-open');
            $('body').addClass('gv-menu-open');
            if ($overlay.length) {
                $overlay.addClass('is-visible');
            }
        };

        var handleToggle = function () {
            if ($nav.hasClass('is-open')) {
                closeMenu();
            } else {
                openMenu();
            }
        };

        $toggle.on('click', handleToggle);

        if ($overlay.length) {
            $overlay.on('click', closeMenu);
        }

        $(document).on('keyup', function (event) {
            if (event.key === 'Escape') {
                closeMenu();
            }
        });

        $(window).on('resize', function () {
            if (window.matchMedia('(min-width: 992px)').matches) {
                closeMenu();
            }
        });

        $nav.find('a').on('click', function () {
            if (!$('body').hasClass('gv-menu-open')) {
                return;
            }
            closeMenu();
        });
    }

    function applyCustomizerColors() {
        if (typeof glassvioletOptions === 'undefined') {
            return;
        }

        var root = document.documentElement;
        var mapping = {
            '--gv-primary': glassvioletOptions.primaryColor,
            '--gv-secondary': glassvioletOptions.secondaryColor,
            '--gv-accent': glassvioletOptions.accentColor,
            '--gv-bg': glassvioletOptions.gradientStart,
            '--gv-bg-alt': glassvioletOptions.gradientEnd
        };

        Object.keys(mapping).forEach(function (key) {
            if (mapping[key]) {
                root.style.setProperty(key, mapping[key]);
            }
        });

        if (typeof glassvioletOptions.glassOpacity !== 'undefined') {
            root.style.setProperty('--gv-glass-opacity', glassvioletOptions.glassOpacity);
        }

        if (typeof glassvioletOptions.glassBlur !== 'undefined') {
            root.style.setProperty('--gv-blur', glassvioletOptions.glassBlur + 'px');
        }

        if (glassvioletOptions.stickyHeader === false) {
            $('body').addClass('gv-header-static');
        }
    }

    $(document).ready(function () {
        animateOnScroll();
        toggleMenu();
        applyCustomizerColors();
    });

    $(window).on('scroll', animateOnScroll);
})(jQuery);
