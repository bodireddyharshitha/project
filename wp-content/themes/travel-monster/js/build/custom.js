/********** accessibility **********/

var travelMonster = travelMonster || {};

// event "polyfill"
travelMonster.createEvent = function (eventName) {
    var event;
    if (typeof window.Event === 'function') {
        event = new Event(eventName);
    } else {
        event = document.createEvent('Event');
        event.initEvent(eventName, true, false);
    }
    return event;
};

/*  -----------------------------------------------------------------------------------------------
    Cover Modals
--------------------------------------------------------------------------------------------------- */

travelMonster.coverModals = {

    init: function () {
        if (document.querySelector('.cover-modal')) {
            // Handle cover modals when they're toggled.
            this.onToggle();

            // Close on escape key press.
            this.closeOnEscape();

            // Hide and show modals before and after their animations have played out.
            this.hideAndShowModals();

            this.keepFocusInModal();
        }
    },

    // Handle cover modals when they're toggled.
    onToggle: function () {
        document.querySelectorAll('.cover-modal').forEach(function (element) {
            element.addEventListener('toggled', function (event) {
                var modal = event.target,
                    body = document.body;

                if (modal.classList.contains('active')) {
                    body.classList.add('showing-modal');
                } else {
                    body.classList.remove('showing-modal');
                    body.classList.add('hiding-modal');

                    // Remove the hiding class after a delay, when animations have been run.
                    setTimeout(function () {
                        body.classList.remove('hiding-modal');
                    }, 500);
                }
            });
        });
    },

    // Close modal on escape key press.
    closeOnEscape: function () {
        document.addEventListener('keydown', function (event) {
            if (event.keyCode === 27) {
                event.preventDefault();
                document.querySelectorAll('.cover-modal.active').forEach(function (element) {
                    this.untoggleModal(element);
                }.bind(this));
            }
        }.bind(this));
    },

    // Hide and show modals before and after their animations have played out.
    hideAndShowModals: function () {
        var _doc = document,
            _win = window,
            modals = _doc.querySelectorAll('.cover-modal'),
            htmlStyle = _doc.documentElement.style,
            adminBar = _doc.querySelector('#wpadminbar');

        function getAdminBarHeight(negativeValue) {
            var height,
                currentScroll = _win.pageYOffset;

            if (adminBar) {
                height = currentScroll + adminBar.getBoundingClientRect().height;

                return negativeValue ? -height : height;
            }

            return currentScroll === 0 ? 0 : -currentScroll;
        }

        function htmlStyles() {
            var overflow = _win.innerHeight > _doc.documentElement.getBoundingClientRect().height;

            return {
                'overflow-y': overflow ? 'hidden' : 'scroll',
                position: 'fixed',
                width: '100%',
                top: getAdminBarHeight(true) + 'px',
                left: 0
            };
        }

        // Show the modal.
        modals.forEach(function (modal) {
            modal.addEventListener('toggle-target-before-inactive', function (event) {
                var styles = htmlStyles(),
                    offsetY = _win.pageYOffset,
                    paddingTop = (Math.abs(getAdminBarHeight()) - offsetY) + 'px',
                    mQuery = _win.matchMedia('(max-width: 600px)');

                if (event.target !== modal) {
                    return;
                }

                modal.classList.add('show-modal');
            });

            // Hide the modal after a delay, so animations have time to play out.
            modal.addEventListener('toggle-target-after-inactive', function (event) {
                if (event.target !== modal) {
                    return;
                }

                setTimeout(function () {
                    var clickedEl = travelMonster.toggles.clickedEl;

                    modal.classList.remove('show-modal');

                    if (clickedEl !== false) {
                        clickedEl.focus();
                        clickedEl = false;
                    }

                    _win.travelMonster.scrolled = 0;
                }, 500);
            });
        });
    },

    // Untoggle a modal.
    untoggleModal: function (modal) {
        var modalTargetClass,
            modalToggle = false;

        // If the modal has specified the string (ID or class) used by toggles to target it, untoggle the toggles with that target string.
        // The modal-target-string must match the string toggles use to target the modal.
        if (modal.dataset.modalTargetString) {
            modalTargetClass = modal.dataset.modalTargetString;

            modalToggle = document.querySelector('*[data-toggle-target="' + modalTargetClass + '"]');
        }

        // If a modal toggle exists, trigger it so all of the toggle options are included.
        if (modalToggle) {
            modalToggle.click();

            // If one doesn't exist, just hide the modal.
        } else {
            modal.classList.remove('active');
        }
    },

    keepFocusInModal: function () {
        var _doc = document;

        _doc.addEventListener('keydown', function (event) {
            var toggleTarget, modal, selectors, elements, menuType, bottomMenu, activeEl, lastEl, firstEl, tabKey, shiftKey,
                clickedEl = travelMonster.toggles.clickedEl;

            if (clickedEl && _doc.body.classList.contains('showing-modal')) {
                toggleTarget = clickedEl.dataset.toggleTarget;
                selectors = 'input, a, button';
                modal = _doc.querySelector(toggleTarget);

                elements = modal.querySelectorAll(selectors);
                elements = Array.prototype.slice.call(elements);

                if ('.menu-modal' === toggleTarget) {
                    menuType = window.matchMedia('(min-width: 99999px)').matches;
                    menuType = menuType ? '.expanded-menu' : '.mobile-menu';

                    elements = elements.filter(function (element) {
                        return null !== element.closest(menuType) && null !== element.offsetParent;
                    });

                    elements.unshift(_doc.querySelector('.close-nav-toggle'));

                    bottomMenu = _doc.querySelector('.menu-bottom > nav');

                    if (bottomMenu) {
                        bottomMenu.querySelectorAll(selectors).forEach(function (element) {
                            elements.push(element);
                        });
                    }
                }

                if ('.main-menu-modal' === toggleTarget) {
                    menuType = window.matchMedia('(min-width: 1025px)').matches;
                    menuType = menuType ? '.expanded-menu' : '.mobile-menu';

                    elements = elements.filter(function (element) {
                        return null !== element.closest(menuType) && null !== element.offsetParent;
                    });

                    elements.unshift(_doc.querySelector('.close-main-nav-toggle'));

                    bottomMenu = _doc.querySelector('.menu-bottom > nav');

                    if (bottomMenu) {
                        bottomMenu.querySelectorAll(selectors).forEach(function (element) {
                            elements.push(element);
                        });
                    }
                }

                lastEl = elements[elements.length - 1];
                firstEl = elements[0];
                activeEl = _doc.activeElement;
                tabKey = event.keyCode === 9;
                shiftKey = event.shiftKey;

                if (!shiftKey && tabKey && lastEl === activeEl) {
                    event.preventDefault();
                    firstEl.focus();
                }

                if (shiftKey && tabKey && firstEl === activeEl) {
                    event.preventDefault();
                    lastEl.focus();
                }
            }
        });
    }

}; // travelMonster.coverModals

travelMonster.modalMenu = {

    init: function () {
        // If the current menu item is in a sub level, expand all the levels higher up on load.
        this.expandLevel();
    },

    expandLevel: function () {
        var modalMenus = document.querySelectorAll('.modal-menu');

        modalMenus.forEach(function (modalMenu) {
            var activeMenuItem = modalMenu.querySelector('.current-menu-item');

            if (activeMenuItem) {
                travelMonsterFindParents(activeMenuItem, 'li').forEach(function (element) {
                    var subMenuToggle = element.querySelector('.submenu-toggle-btn');
                    if (subMenuToggle) {
                        travelMonster.toggles.performToggle(subMenuToggle, true);
                    }
                });
            }
        });
    },
}; // travelMonster.modalMenu

travelMonster.toggles = {

    clickedEl: false,

    init: function () {
        // Do the toggle.
        this.toggle();
    },

    performToggle: function (element, instantly) {
        var target, timeOutTime, classToToggle,
            self = this,
            _doc = document,
            // Get our targets.
            toggle = element,
            targetString = toggle.dataset.toggleTarget,
            activeClass = 'active';

        // Elements to focus after modals are closed.
        if (!_doc.querySelectorAll('.show-modal').length) {
            self.clickedEl = _doc.activeElement;
        }

        if (targetString === 'next') {
            target = toggle.nextSibling;
        } else {
            target = _doc.querySelector(targetString);
        }

        // Trigger events on the toggle targets before they are toggled.
        if (target.classList.contains(activeClass)) {
            target.dispatchEvent(travelMonster.createEvent('toggle-target-before-active'));
        } else {
            target.dispatchEvent(travelMonster.createEvent('toggle-target-before-inactive'));
        }

        // Get the class to toggle, if specified.
        classToToggle = toggle.dataset.classToToggle ? toggle.dataset.classToToggle : activeClass;

        // For cover modals, set a short timeout duration so the class animations have time to play out.
        timeOutTime = 0;

        if (target.classList.contains('cover-modal')) {
            timeOutTime = 10;
        }

        setTimeout(function () {
            var focusElement,
                subMenued = target.classList.contains('sub-menu'),
                newTarget = subMenued ? toggle.closest('.menu-item').querySelector('.sub-menu') : target,
                duration = toggle.dataset.toggleDuration;

            // Toggle the target of the clicked toggle.
            if (toggle.dataset.toggleType === 'slidetoggle' && !instantly && duration !== '0') {
                travelMonsterMenuToggle(newTarget, duration);
            } else {
                newTarget.classList.toggle(classToToggle);
            }

            // If the toggle target is 'next', only give the clicked toggle the active class.
            if (targetString === 'next') {
                toggle.classList.toggle(activeClass);
            } else if (target.classList.contains('sub-menu')) {
                toggle.classList.toggle(activeClass);
            } else {
                // If not, toggle all toggles with this toggle target.
                _doc.querySelector('*[data-toggle-target="' + targetString + '"]').classList.toggle(activeClass);
            }

            // Toggle aria-expanded on the toggle.
            travelMonsterToggleAttribute(toggle, 'aria-expanded', 'true', 'false');

            if (self.clickedEl && -1 !== toggle.getAttribute('class').indexOf('close-')) {
                travelMonsterToggleAttribute(self.clickedEl, 'aria-expanded', 'true', 'false');
            }

            // Toggle body class.
            if (toggle.dataset.toggleBodyClass) {
                _doc.body.classList.toggle(toggle.dataset.toggleBodyClass);
            }

            // Check whether to set focus.
            if (toggle.dataset.setFocus) {
                focusElement = _doc.querySelector(toggle.dataset.setFocus);

                if (focusElement) {
                    if (target.classList.contains(activeClass)) {
                        focusElement.focus();
                    } else {
                        focusElement.blur();
                    }
                }
            }

            // Trigger the toggled event on the toggle target.
            target.dispatchEvent(travelMonster.createEvent('toggled'));

            // Trigger events on the toggle targets after they are toggled.
            if (target.classList.contains(activeClass)) {
                target.dispatchEvent(travelMonster.createEvent('toggle-target-after-active'));
            } else {
                target.dispatchEvent(travelMonster.createEvent('toggle-target-after-inactive'));
            }
        }, timeOutTime);
    },

    // Do the toggle.
    toggle: function () {
        var self = this;

        document.querySelectorAll('*[data-toggle-target]').forEach(function (element) {
            element.addEventListener('click', function (event) {
                event.preventDefault();
                self.performToggle(element);
            });
        });
    },

}; // travelMonster.toggles

/**
 * Is the DOM ready?
 *
 * This implementation is coming from https://gomakethings.com/a-native-javascript-equivalent-of-jquerys-ready-method/
 *
 * @param {Function} fn Callback function to run.
 */
function travelMonsterDomReady(fn) {
    if (typeof fn !== 'function') {
        return;
    }

    if (document.readyState === 'interactive' || document.readyState === 'complete') {
        return fn();
    }

    document.addEventListener('DOMContentLoaded', fn, false);
}

travelMonsterDomReady(function () {
    travelMonster.toggles.init(); // Handle toggles.
    travelMonster.coverModals.init(); // Handle cover modals.
});

/* Toggle an attribute ----------------------- */

function travelMonsterToggleAttribute(element, attribute, trueVal, falseVal) {
    if (trueVal === undefined) {
        trueVal = true;
    }
    if (falseVal === undefined) {
        falseVal = false;
    }
    if (element.getAttribute(attribute) !== trueVal) {
        element.setAttribute(attribute, trueVal);
    } else {
        element.setAttribute(attribute, falseVal);
    }
}

/**
 * Traverses the DOM up to find elements matching the query.
 *
 * @param {HTMLElement} target
 * @param {string} query
 * @return {NodeList} parents matching query
 */
function travelMonsterFindParents(target, query) {
    var parents = [];

    // Recursively go up the DOM adding matches to the parents array.
    function traverse(item) {
        var parent = item.parentNode;
        if (parent instanceof HTMLElement) {
            if (parent.matches(query)) {
                parents.push(parent);
            }
            traverse(parent);
        }
    }

    traverse(target);

    return parents;
}

/******************************** */

(function ($) {

    var mrtl;

    if (travel_monster_custom.rtl == '1') {
        mrtl = false;
    } else {
        mrtl = true;
    }

    /* Header Search toggle
    --------------------------------------------- */
    $('.search-form-section .header-search-btn').click(function () {
        $(this).siblings('.search-toggle-form').fadeIn();
        $('.search-toggle-form form .search-field').focus();
    });

    $('.btn-form-close').click(function () {
        $(this).parents('.search-toggle-form').fadeOut();
    });

    $('.search-toggle-form').keyup(function (e) {
        if (e.key == 'Escape') {
            $('.search-form-section .search-toggle-form').fadeOut();
        }
    });
    $('.search-form-section .header-search-inner .search-form').click(function (e) {
        e.stopPropagation();
    });

    /* Notification bar
    --------------------------------------------- */
    $(document).on('click', '.notification-bar .close', function () {
        $(this).siblings('.sticky-bar-content').slideToggle();
        $('.notification-bar').toggleClass('active');
    });

    //Sticky Widget
    if (travel_monster_custom.sticky_widget == '1' && $(window).width() > 1024) {
        $('#secondary').addClass('sticky-widget');

        if (travel_monster_custom.ed_sticky_header == '1') {
            stickyheaderheight = $('.sticky-holder').outerHeight();
            $lastwidgetsticky = $('.ed_last_widget_sticky #secondary .widget:last-child').css('top', stickyheaderheight);
        }
    }

    // Sticky header
    var mns = "sticky";
    mn = $('.sticky-header .sticky-holder');
    hcta = $('.sticky-header .notification-bar').outerHeight();
    thm = $('.sticky-header .header-m').outerHeight();
    stickHolderHeight = $('.sticky-header .header-b').outerHeight();
    var topTotal = parseInt(thm) + parseInt(stickHolderHeight);

    $(window).on('scroll', function () {
        if ($(this).scrollTop() > topTotal) {
            mn.addClass(mns);
        } else {
            mn.removeClass(mns);
        }
    });



    /************ Mobile Menu *************/

    //mobile menu


    $('.mobile-menu-wrapper ul li.menu-item-has-children').find('> a').after('<button class="arrow-down"></button>');
    $('.mobile-menu-wrapper ul li .arrow-down').on('click', function () {
        $(this).siblings('.sub-menu').stop().slideToggle();
        $(this).toggleClass('active');
    });

    $('.mobile-header .mobile-menu-opener').on('click', function () {
        $('body').addClass('menu-open');
    });

    $('.mobile-header .btn-menu-close').on('click', function () {
        $('body').removeClass('menu-open');
    });

    $('.overlay').on('click', function () {
        $('body').removeClass('menu-open');
    });

    // Script for back to top
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.to_top').fadeIn();
        } else {
            $('.to_top').fadeOut();
        }
    });

    $('.to_top').click(function () {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    //Masonry Layout
    if ((travel_monster_custom.bp_layout == 'masonry_grid') && ($('.blog').length > 0 || $('.search').length > 0 || $('.archive').length > 0)) {
        $('.travel-monster-container-wrap').imagesLoaded(function () {
            $('.travel-monster-container-wrap').masonry({
                itemSelector: '.travel-monster-post',
                isOriginLeft: mrtl
            });
        });
    }

    //alignfull js
    $(window).on('load resize', function () {
        var gbWindowWidth = $(window).width();
        var gbContainerWidth = $('.travel-monster-has-blocks .site-content > .container').width();
        var gbContentWidth = $('.travel-monster-has-blocks .site-main .entry-content').width();
        var gbMarginFull = (parseInt(gbContentWidth) - parseInt(gbWindowWidth)) / 2;
        var gbMarginFull2 = (parseInt(gbContentWidth) - parseInt(gbContainerWidth)) / 2;
        var gbMarginCenter = (parseInt(gbContentWidth) - parseInt(gbWindowWidth)) / 2;
        $(".travel-monster-has-blocks.full-width .site-main .entry-content .alignfull").css({ "max-width": gbWindowWidth, "width": gbWindowWidth, "margin-left": gbMarginFull });
        $(".travel-monster-has-blocks.full-width .site-main .entry-content .alignfull").css({ "max-width": gbWindowWidth, "width": gbWindowWidth, "margin-left": gbMarginCenter });
        $(".travel-monster-has-blocks.full-width .site-main .entry-content .alignwide").css({ "max-width": gbContainerWidth, "width": gbContainerWidth, "margin-left": gbMarginFull2 });
    });

    /** Lightbox */
    if (travel_monster_custom.lightbox == '1') {
        $('.entry-content-wrap .wp-block-gallery').find('figure.wp-block-image > a').attr('data-fancybox', 'group1');
        $('.sidebar-wrap-main .wp-block-gallery').find('figure.wp-block-image > a').attr('data-fancybox', 'group2');
        $('.footer-wrap-main .wp-block-gallery').find('figure.wp-block-image > a').attr('data-fancybox', 'group3');
        $('.gallery').find('.gallery-icon > a').attr('data-fancybox', 'icongroup1');
    }

    //Single trip onepage scroll
    var navtopOffset = $('.nav-tab-wrapper').outerHeight() + 46;
    if ($(window).width() <= 767) {
        var navoffsetVal = navtopOffset;
    } else {
        var navoffsetVal = 46;
    }

    // single trip tab sticky

    $.fn.isInViewport = function () {
        var elementTop = $(this).offset().top;
        var elementBottom = elementTop + $(this).innerHeight();

        var viewportTop = $(window).scrollTop();
        // var viewportBottom = viewportTop + $(window).height();

        return elementTop < viewportTop && elementBottom > viewportTop;
        // return elementTop < viewportTop && elementTop < viewportBottom;
    };

    $(window).on('resize scroll', function () {
        $('.tab-content').each(function () {
            if ($(this).isInViewport()) {
                $('body').addClass('fixed-tabbar');
            } else {
                $('body').removeClass('fixed-tabbar');
            }
        });
    });

    /*-----------  Navigation Accessiblity  ------------------- */
    $(document).on('mousemove', 'body', function (e) {
        $(this).removeClass('keyboard-nav-on');
    });
    $(document).on('keydown', 'body', function (e) {
        if (e.which == 9) {
            $(this).addClass('keyboard-nav-on');
        }
    });

    $('.primary-menu-wrapper li a, .primary-menu-wrapper li .arrow-down, .secondary-menu-wrapper li a').on('focus', function () {
        $(this).parents('li').addClass('focus');
    }).blur(function () {
        $(this).parents('li').removeClass('focus');
    });

    var winWidth = $(window).width();

    if (winWidth > 1024 && travel_monster_custom.ed_sticky_form == 1) {
        var sidebarHeight = $(".single-trip .trip-content-area .widget-area").outerHeight() + $(".single-trip .trip-content-area .wpte-bf-outer").outerHeight();
        if (sidebarHeight > 0) {
            $(window).on('scroll', function () {
                if ($(this).scrollTop() > sidebarHeight) {
                    $("body").addClass("sticky-bookingform");
                } else {
                    $("body").removeClass("sticky-bookingform");
                }
            });
        }
    }

}(jQuery));

jQuery.fn.travel_monsterIsOnScreen = function () {

    var win = jQuery(window);

    var viewport = {
        top: win.scrollTop(),
        left: win.scrollLeft()
    };

    viewport.right = viewport.left + win.width();
    viewport.bottom = viewport.top + win.height();

    var bounds = this.offset();
    bounds.right = bounds.left + this.outerWidth();
    bounds.bottom = bounds.top + this.outerHeight();

    return (!(viewport.right < bounds.left || viewport.left > bounds.right || viewport.bottom < bounds.top || viewport.top > bounds.bottom));
};