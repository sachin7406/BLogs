// window.SPA = {
//     hooks: [],

//     register(fn) {
//         if (typeof fn === 'function') {
//             this.hooks.push(fn);
//         }
//     },

//     init() {
//         console.log('SPA → init hooks');
//         this.hooks.forEach(fn => {
//             try { fn(); } catch (e) { console.error(e); }
//         });
//     }
// };

// SPA.register(function () {
//     console.log('SPA HOOK → accordion init', $('.accordion').length);
// });

// $(document).on('click', 'a.spa-link', function (e) {
//     const url = $(this).attr('href');

//     if (!url || url === '#' || url.startsWith('http')) return;

//     e.preventDefault();
//     if (location.pathname === url) return;

//     history.pushState({ url }, '', url);
//     route(url);
// });

// window.addEventListener('popstate', () => {
//     route(location.pathname);
// });

// function route(url) {
//     if (url === '/') {
//         loadSpaPage('/home');
//     } else {
//         loadSpaPage(url);
//     }
// }
// function showLoader() {
//     $('#page-loader').fadeIn(100);
// }

// function hideLoader() {
//     $('#page-loader').fadeOut(200);
// }


// function loadSpaPage(url) {

//     closeAllMegaMenus();

//     showLoader(); // 🔥 SHOW when SPA request starts

//     $('#spa-content').fadeOut(150, function () {

//         $('#spa-content').load('/spa' + url, function (response, status) {

//             if (status === 'error' || !response || !response.trim()) {
//                 console.error('SPA FAILED:', url);
//                 hideLoader();
//                 return;
//             }

//             $('#spa-content').fadeIn(150, function () {
//                 hideLoader(); // 🔥 HIDE only AFTER content is visible
//             });

//             window.scrollTo(0, 0);

//             SPA.init();        // re-init components
//             window.syncHeaderMenu();
//         });
//     });
// }


// function setActiveNav(url) {
//     $('.nav-link').removeClass('active');
//     $('.nav-link[href="' + url + '"]').addClass('active');
// }

// function initAccordion() {
//     // console.log('Accordion init →', document.querySelectorAll('.accordion').length);

//     const acc = document.querySelectorAll('.accordion');

//     acc.forEach(btn => {
//         btn.removeEventListener('click', accordionHandler);
//         btn.addEventListener('click', accordionHandler);
//     });
// }

// function accordionHandler() {
//     this.classList.toggle('active');

//     const panel = this.nextElementSibling;
//     if (!panel) return;

//     if (panel.style.maxHeight) {
//         panel.style.maxHeight = null;
//     } else {
//         panel.style.maxHeight = panel.scrollHeight + 'px';
//     }
// }

// /* 4️⃣ REGISTER WITH SPA */
// SPA.register(initAccordion);

