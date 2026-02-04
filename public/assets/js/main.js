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
        if (openMenu) return;
        const menu = $(this).find('.mega-menu');
        closeAllMegaMenus();
        menu.slideDown(200);
        resetMenu(menu);
    });

    $('.mega-menu').on('mouseleave', function () {
        if (openMenu) return;
        $(this).slideUp(150);
    });
}

/* =========================
   CLICK TO LOCK MENU
========================= */
$('.dropdown-toggles').on('click', function (e) {
    e.preventDefault();

    const menu = $(this).closest('.nav-item').find('.mega-menu');

    if (openMenu && openMenu.is(menu)) {
        menu.slideUp(150);
        openMenu = null;
        return;
    }

    closeAllMegaMenus();
    menu.slideDown(200);
    openMenu = menu;
    resetMenu(menu);
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

    if (path.startsWith('/solutions')) {
        $('#solutionsDropdown').addClass('active');
    }
    else if (path.startsWith('/industries')) {
        $('#industriesDropdown').addClass('active');
    }
    else if (path.startsWith('/licensing')) {
        $('#licensingDropdown').addClass('active');
    }
    else if (path.startsWith('/service')) {
        $('#servicesDropdown').addClass('active');
    }
    else if (path === '/' || path === '/home') {
        $('.nav-link[href="/"]').addClass('active');
    }
    else if (path.startsWith('/contact')) {
        $('.nav-link[href="/contact"]').addClass('active');
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
