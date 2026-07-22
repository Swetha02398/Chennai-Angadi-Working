/**
 * Ultimate Slider Fix - Scoped exclusively to hero banner to prevent breaking other sliders
 */

(function () {
    'use strict';

    function fixSlider() {
        var selectors = ['.hero-slider-1 img.hero-responsive-img'];
        var sliderImages = [];
        selectors.forEach(function (sel) {
            var imgs = document.querySelectorAll(sel);
            imgs.forEach(function (img) {
                sliderImages.push(img);
            });
        });

        sliderImages = [...new Set(sliderImages)];

        sliderImages.forEach(function (img) {
            img.removeAttribute('style');
            if (window.innerWidth >= 768) {
                img.style.cssText = `
                    width: 100vw !important;
                    max-width: 100vw !important;
                    height: auto !important;
                    object-fit: fill !important;
                    display: block !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    position: relative !important;
                    left: 50% !important;
                    transform: translateX(-50%) !important;
                `;
            }
            fixParentContainers(img);
        });
    }

    function fixParentContainers(img) {
        if (window.innerWidth < 768) return; // Keep mobile untouched
        var parents = [];
        var current = img.parentElement;

        for (var i = 0; i < 5 && current; i++) {
            parents.push(current);
            current = current.parentElement;
        }

        parents.forEach(function (parent) {
            var className = parent.className || '';
            // Only fix classes related to the hero banner
            if (className.includes('home-slider') ||
                className.includes('home-slide-cover') ||
                className.includes('hero-slider-1') ||
                className.includes('container')) {

                // Only stretch container if it's explicitly the hero slider parent container
                if (className.includes('container') && !parent.closest('.home-slider')) {
                    return;
                }

                parent.style.cssText = `
                    width: 100vw !important;
                    max-width: 100vw !important;
                    margin: 0 !important;
                    padding: 0 !important;
                    overflow: hidden !important;
                `;
            }
        });
    }

    window.addEventListener('load', function () {
        setTimeout(fixSlider, 100);
        setTimeout(fixSlider, 500);
    });

    var resizeTimer;
    window.addEventListener('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(fixSlider, 250);
    });

    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(fixSlider, 100);
    } else {
        document.addEventListener('DOMContentLoaded', function () {
            setTimeout(fixSlider, 100);
        });
    }

})();
