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
$('#gv-toggle-menu').on('click', function () {
$('.site-navigation').toggleClass('is-open');
});
}

function applyCustomizerColors() {
if (typeof glassvioletOptions !== 'undefined') {
document.documentElement.style.setProperty('--gv-primary', glassvioletOptions.primaryColor);
document.documentElement.style.setProperty('--gv-secondary', glassvioletOptions.secondaryColor);
}
}

$(document).ready(function () {
animateOnScroll();
toggleMenu();
applyCustomizerColors();
});

$(window).on('scroll', animateOnScroll);
})(jQuery);
