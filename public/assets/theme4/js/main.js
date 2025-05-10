document.addEventListener("DOMContentLoaded", function () {
    var sidebar = document.querySelector(".my--sidebar");
    var hamburger = document.querySelector("#hamburger");
    var closeButton = document.querySelector(".sidebar__close");

    function timeOut() {
        closeButton.style.display = "none";
        document.body.classList.remove("open");
        sidebar.classList.add("fadeOut");
        hamburger.classList.add("disabled__link");
        setTimeout(function () {
            hideMenu();
            hamburger.classList.remove("disabled__link");
            sidebar.classList.remove("fadeOut");
        }, 400);
    }

    function hideMenu() {
        sidebar.classList.remove("my--sidebar_open");
        sidebar.classList.remove("fadeIn");
        closeButton.classList.remove("fadeCloseBtn");
    }

    function showMenu() {
        closeButton.style.display = "block";
        sidebar.classList.add("my--sidebar_open");
        sidebar.classList.add("fadeIn");
        closeButton.classList.add("fadeCloseBtn");
        document.body.classList.add("open");
    }

    hamburger.addEventListener("click", function (e) {
        e.preventDefault();
        if (sidebar.classList.contains("my--sidebar_open")) {
            timeOut();
        } else {
            showMenu();
        }
    });

    document.addEventListener("keyup", function (e) {
        if (e.key === "Escape" && sidebar.classList.contains("my--sidebar_open")) {
            timeOut();
        }
    });

    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("sidebar__mask")) {
            timeOut();
        }
    });

    sidebar.addEventListener("click", function (e) {
        if (e.target.classList.contains("sidebar__close")) {
            timeOut();
        }
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Get the current URL path
    const currentPath = window.location.href;

    // Select all nav links
    const navLinks = document.querySelectorAll('.nav-link');

    // Loop through each nav link
    navLinks.forEach(link => {
        // Get the href attribute of the link
        const linkPath = link.getAttribute('href');

        // Check if the linkPath matches the currentPath
        if (linkPath == currentPath) {
            // Add the 'active' class to the matching link
            link.classList.add('active');
        }
    });
});
