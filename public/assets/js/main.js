
$(document).ready(function() {
    var app = document.getElementsByTagName("BODY")[0];
        if (localStorage.lightMode == "dark") {
        app.setAttribute("class", "dark");
    }
});

function dashMenuToggle() {
  $('.app-container').toggleClass('sidebar-action');
}

function homeMenuToggle() {
  $('.head-menu').slideToggle(200);
}

function mainDropdown() {
  $('.main-dd').toggleClass('hidden');
}

$(function () {
  $('[data-toggle="tooltip"]').tooltip();

  if($("#dc-body").length) {
      $("#dc2-body").height($("#dc-body").height());
  }
})

$(document).ready(function() {
    $("#serv-inp").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".app-mtable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});

$('.sss-tab').click(function() {
    if ($(this).hasClass('active')) {
        $(this).find('.ss-tab-content').slideToggle(200);
        $(this).toggleClass('active');
    } else {
        $('.sss-tab').removeClass('active');
        $('.sss-tab > .ss-tab-content').slideUp(200);
        $(this).find('.ss-tab-content').slideToggle(200);
        $(this).toggleClass('active');
    }
});

function change_mode() {

    var app = document.getElementsByTagName("BODY")[0];

    if (localStorage.lightMode == "dark") {
        localStorage.lightMode = "light";
        app.setAttribute("class", "light");
    } else {
        localStorage.lightMode = "dark";
        app.setAttribute("class", "dark");
    }
    console.log("lightMode = " + localStorage.lightMode);
}

document.addEventListener("DOMContentLoaded", function () {
    // Get the current URL
    var currentUrl = window.location.href;

    // Get all the <a> elements in the sidebar menu
    var sidebarLinks = document.querySelectorAll(".sidebar-menu a");

    // Loop through each <a> element
    sidebarLinks.forEach(function (link) {
        // Compare the href attribute of the <a> element with the current URL
        if (link.getAttribute("href") === currentUrl) {
            // Add the "active" class to the parent <li> element
            var parentLi = link.closest("li");
            if (parentLi) {
                parentLi.classList.add("active");
            }
        }
    });
});
