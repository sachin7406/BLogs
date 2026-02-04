console.log("Loader JS loaded"); // 🔴 DEBUG LINE (IMPORTANT)

/* HIDE loader when page is fully ready */
window.addEventListener("load", function () {
    console.log("Page fully loaded"); // 🔴 DEBUG
    var loader = document.getElementById("page-loader");
    if (loader) {
        loader.style.display = "none";
    }
});

/* SHOW loader when leaving page */
window.addEventListener("beforeunload", function () {
    var loader = document.getElementById("page-loader");
    if (loader) {
        loader.style.display = "flex";
    }
});
