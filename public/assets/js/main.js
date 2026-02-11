/* Toggle menu icon (X / ☰) */
document.addEventListener('DOMContentLoaded', function () {
    const menu = document.getElementById('navMenu');
    const openIcon = document.querySelector('.toggle-open');
    const closeIcon = document.querySelector('.toggle-close');

    if (menu && openIcon && closeIcon) {
        menu.addEventListener('shown.bs.collapse', () => {
            openIcon.classList.add('d-none');
            closeIcon.classList.remove('d-none');
        });

        menu.addEventListener('hidden.bs.collapse', () => {
            openIcon.classList.remove('d-none');
            closeIcon.classList.add('d-none');
        });
    }

    initAccordion();
    syncMegaMenuWithURL();
});

/* =========================
   GLOBAL STATE
========================= */

let openMenu = null;
let lockedMenu = null;
let activeItem = null;

/* =========================
   ACCORDION
========================= */
function initAccordion() {
    const acc = document.getElementsByClassName("accordion");
    for (let i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function () {
            this.classList.toggle("active");
            const panel = this.nextElementSibling;
            panel.style.maxHeight
                ? panel.style.maxHeight = null
                : panel.style.maxHeight = panel.scrollHeight + "px";
        });
    }
}

/* =========================
   RESET HELPERS
========================= */

function resetMenu(menu) {
    const first = menu.find('.sol-left').first();

    menu.find('.sol-left').removeClass('active');
    first.addClass('active');
    activeItem = first;

    menu.find('.sol-box').addClass('d-none');
    $('#' + first.data('target')).removeClass('d-none');

    menu.removeClass('level-2 level-3').addClass('level-1');
}

function closeAllMegaMenus() {
    $('.mega-menu')
        .slideUp(150)
        .removeClass('level-2 level-3')
        .addClass('level-1');

    openMenu = null;
}

/* =========================
   DESKTOP HOVER
========================= */
if (window.innerWidth > 920) {
    $('.nav-item.dropdown').on('mouseenter', function () {
        // console.log("callingss");
        // if (openMenu) return;
        const menu = $(this).find('.mega-menu');
        if (lockedMenu && lockedMenu.is(menu)) return;
        if (lockedMenu && !lockedMenu.is(menu)) {
            lockedMenu.slideUp(150);
            lockedMenu = null;
        }
        closeAllMegaMenus();
        menu.slideDown(200);
        openMenu = menu;
        resetMenu(menu);
    });

    $('.mega-menu').on('mouseleave', function () {
        // if (openMenu) return;
        if (lockedMenu && lockedMenu.is($(this))) return;
        $(this).slideUp(150);
        openMenu = null;
    });
}

/* =========================
   CLICK TO LOCK MENU
========================= */
$('.dropdown-toggles').on('click', function (e) {
    e.preventDefault();

    const menu = $(this).closest('.nav-item').find('.mega-menu');

    // if (openMenu && openMenu.is(menu)) {
    if (lockedMenu && lockedMenu.is(menu)) {
        menu.slideUp(150);
        lockedMenu = null;
        openMenu = null;
        return;
    }

    if (lockedMenu) {
        lockedMenu.slideUp(150);
        lockedMenu = null;
    }

    closeAllMegaMenus();
    menu.slideDown(200);
    openMenu = menu;
    lockedMenu = menu;
    resetMenu(menu);
});
$(document).on('click', '.close-x', function () {
    const menu = $(this).closest('.mega-menu');
    menu.slideUp(150);

    if (lockedMenu && lockedMenu.is(menu)) {
        lockedMenu = null;
    }

    if (openMenu && openMenu.is(menu)) {
        openMenu = null;
    }
});

/* =========================
   LEFT PANEL LOGIC
========================= */

$(document).on('mouseenter', '.sol-left', function () {
    if (window.innerWidth <= 920) return;

    const item = $(this);
    const menu = item.closest('.mega-menu');
    const target = item.data('target');

    menu.find('.sol-left').removeClass('active');
    item.addClass('active');
    activeItem = item;

    menu.find('.sol-box').addClass('d-none');
    $('#' + target).removeClass('d-none');
});

$(document).on('click', '.sol-left', function () {
    if (window.innerWidth > 920) return;

    const menu = $(this).closest('.mega-menu');
    const target = $(this).data('target');

    menu.removeClass('level-1 level-3').addClass('level-2');
    menu.find('.sol-box').addClass('d-none');
    $('#' + target).removeClass('d-none');
});

/* =========================
   SIMULATION PANEL
========================= */
$(document).on('click', '.sim-toggle', function () {
    const target = $(this).data('target');

    $('.sim-toggle').removeClass('active');
    $(this).addClass('active');

    $('.sim-panel').removeClass('show').hide();
    $('.' + target).fadeIn(150).addClass('show');
});

/* =========================
   MOBILE BACK
========================= */
$(document).on('click', '.mobile-back', function () {
    const menu = $(this).closest('.mega-menu');

    if (menu.hasClass('level-3')) {
        menu.removeClass('level-3').addClass('level-2');
    } else {
        menu.removeClass('level-2').addClass('level-1');
    }
});
/* =========================
   URL → MENU SYNC (FINAL)
========================= */

function activateTopNavByURL(path) {
    $('.nav-link').removeClass('active');
    $('.sol-left').removeClass('active'); // Reset submenu active states
    $('.sol-box').addClass('d-none');     // Hide all subpanels

    // Normalize path: lowercase and ensure leading slash
    let normalPath = (path || '').toLowerCase();

    if (!normalPath.startsWith('/')) {
        normalPath = '/' + normalPath;
    }

    // Track top and sub menu IDs to enable submenu activation
    let topMenuId = null;
    let subPanelId = null;

    if (normalPath.startsWith('/solutions')) {
        topMenuId = '#solutionsDropdown';
        // Extract subpath for submenu (e.g., /solutions/simulation)
        const subMatch = normalPath.match(/^\/solutions\/([^\/]+)/);
        if (subMatch && subMatch[1]) subPanelId = 'sol-' + subMatch[1].replace(/-/g, '').toLowerCase();
    }
    else if (normalPath.startsWith('/industries')) {
        topMenuId = '#industriesDropdown';
        const subMatch = normalPath.match(/^\/industries\/([^\/]+)/);
        if (subMatch && subMatch[1]) subPanelId = 'ind-' + subMatch[1].replace(/-/g, '').toLowerCase();
    }
    else if (normalPath.startsWith('/licensing')) {
        topMenuId = '#licensingDropdown';
        const subMatch = normalPath.match(/^\/licensing\/([^\/]+)/);
        if (subMatch && subMatch[1]) subPanelId = 'lic-' + subMatch[1].replace(/-/g, '').toLowerCase();
    }
    else if (normalPath.startsWith('/service')) {
        topMenuId = '#servicesDropdown';
        const subMatch = normalPath.match(/^\/service\/([^\/]+)/);
        if (subMatch && subMatch[1]) subPanelId = 'srv-' + subMatch[1].replace(/-/g, '').toLowerCase();
    }
    else if (normalPath === '/' || normalPath === '/home') {
        $('.nav-link[href="/"]').addClass('active');
    }
    else if (normalPath.startsWith('/contact')) {
        $('.nav-link[href="/contact"]').addClass('active');
    }

    // Activate top nav
    if (topMenuId) {
        $(topMenuId).addClass('active');
    }

    // If subPanelId found, activate panel and highlight sub menu as active
    if (subPanelId) {
        // Show sol-box/submenu panel
        const $panel = $('#' + subPanelId);
        if ($panel.length) {
            $panel.removeClass('d-none');
        }

        // Activate matching sol-left
        $('.sol-left[data-target="' + subPanelId + '"]').addClass('active');
    }
}


function syncMegaMenuWithURL() {
    const path = window.location.pathname;

    // 1️⃣ Activate TOP navbar correctly (FIX)
    activateTopNavByURL(path);

    // 2️⃣ Reset mega menu state
    $('.sol-left').removeClass('active');
    $('.mega-menu')
        .hide()
        .removeClass('level-2 level-3')
        .addClass('level-1');
    $('.sol-box').addClass('d-none');

    // 3️⃣ Find matching SPA link
    const activeLink = $('.spa-link').filter(function () {
        return new URL(this.href).pathname === path;
    }).first();

    if (!activeLink.length) return;

    // 4️⃣ Open correct mega menu
    const megaMenu = activeLink.closest('.mega-menu');
    if (!megaMenu.length) return;

    megaMenu.show();
    openMenu = megaMenu;

    // 5️⃣ Find sol-box (wrapped OR parent)
    let solBox = activeLink.find('.sol-box');
    if (!solBox.length) {
        solBox = activeLink.closest('.sol-box');
    }
    if (!solBox.length) return;

    solBox.removeClass('d-none');

    // 6️⃣ Activate corresponding sol-left
    const targetId = solBox.attr('id');
    megaMenu
        .find('.sol-left[data-target="' + targetId + '"]')
        .addClass('active');

    // 7️⃣ Mobile level handling
    if (window.innerWidth <= 920) {
        megaMenu.removeClass('level-1').addClass('level-2');
    }
}

document.addEventListener('DOMContentLoaded', function () {
    syncMegaMenuWithURL();
});


// Call this AFTER every SPA page load
window.syncHeaderMenu = function () {
    syncMegaMenuWithURL();
};
