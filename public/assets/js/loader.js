console.log("Loader JS loaded"); // 🔴 DEBUG LINE (IMPORTANT)

/* HIDE loader when page is fully ready */
function hideLoader() {
    var loader = document.getElementById("page-loader");
    if (loader) {
        loader.style.display = "none";
    }
}

/* SHOW loader when leaving page */
function showLoader() {
    var loader = document.getElementById("page-loader");
    if (loader) {
        loader.style.display = "flex";
    }
}

window.addEventListener("load", function () {
    console.log("Page fully loaded"); // 🔴 DEBUG
    hideLoader();
});

// Show loader when navigating away from the page
window.addEventListener("beforeunload", function () {
    showLoader();
});

// Hide loader when coming back from bfcache (browser back/forward cache)
window.addEventListener("pageshow", function (event) {
    // If the event.persisted is true, the page was restored from bfcache (e.g. back/forward navigation)
    if (event.persisted) {
        hideLoader();
    }
});