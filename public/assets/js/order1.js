
$(document).ready(function() {
    serviceCategory();
});

function ikon(opt) {
    var ikon = "";
    if (opt.indexOf("Instagram") >= 0) {
        ikon = "<span class=\"ico-ig\"><i class=\"fab fa-instagram\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("IGTV") >= 0) {
        ikon = "<span class=\"ico-ig\"><i class=\"fab fa-instagram\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Facebook") >= 0) {
        ikon = "<span class=\"ico-fb\"><i class=\"fab fa-facebook-square\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Youtube") >= 0) {
        ikon = "<span class=\"ico-yt\"><i class=\"fab fa-youtube\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("YouTube") >= 0) {
        ikon = "<span class=\"ico-yt\"><i class=\"fab fa-youtube\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Twitter") >= 0) {
        ikon = "<span class=\"ico-tw\"><i class=\"fab fa-twitter\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Google") >= 0) {
        ikon = "<span class=\"ico-gp\"><i class=\"fab fa-google-plus\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Soundcloud") >= 0) {
        ikon = "<span class=\"ico-sc\"><i class=\"fab fa-soundcloud\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Spotify") >= 0) {
        ikon = "<span class=\"ico-sp\"><i class=\"fab fa-spotify\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Apple") >= 0) {
        ikon = "<span class=\"ico-apple\"><i class=\"fab fa-apple\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Telegram") >= 0) {
        ikon = "<span class=\"ico-tele\"><i class=\"fab fa-telegram-plane\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Pinterest") >= 0) {
        ikon = "<span class=\"ico-pt\"><i class=\"fab fa-pinterest-p\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Twitch") >= 0) {
        ikon = "<span class=\"ico-twc\"><i class=\"fab fa-twitch\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Tik") >= 0) {
        ikon = "<span class=\"ico-tic\"><i class=\"fab fa-tiktok\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Web") >= 0) {
        ikon = "<span class=\"ico-web\"><i class=\"fas fa-globe\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Diğer") >= 0) {
        ikon = "<span class=\"ico-dgr\"><i class=\"fas fa-stream\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Tumblr") >= 0) {
        ikon = "<span class=\"fs-tumb\"><i class=\"fab fa-tumblr\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Music") >= 0) {
        ikon = "<span class=\"fs-music\"><i class=\"fa fa-music\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Audiomack") >= 0) {
        ikon = "<span class=\"fs-music\"><i class=\"fa fa-music\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Periscope") >= 0) {
        ikon = "<span class=\"fs-peri\"><i class=\"fab fa-periscope\" aria-hidden=\"true\"></i> </span>";
    } else if (opt.indexOf("Snapchat") >= 0) {
        ikon = "<span class=\"fs-snap\"><i class=\"fab fa-snapchat-ghost\" aria-hidden=\"true\"></i> </span>";
    }
    return ikon;
}

$(function(ready) {
    $("#orderform-category").change(function() {
        serviceCategory();
        // serviceList();
    });
});

function serviceCategory(){
    $("#category-drop").empty();
    $("#orderform-category option").each(function() {
        if ($(this).attr('data-show') != 'hidden') {
            var ico = ikon($(this).text());
            $("#category-drop").append('<button id="order-cItem" class="dropdown-item" type="button" onclick="selectCategory(' + $(this).val() + ')">' + ico + $(this).text() + '</button>');
        }
    });

    var e = document.getElementById("orderform-category");
    var selected = e.options[e.selectedIndex].text;
    var ico = ikon(selected);
    $("#order-category").html(ico + selected);

}

function selectCategory(val) {
    $('#orderform-category').val(val);
    $("#orderform-category").trigger("change");
    var ico = ikon($("#orderform-category option[value='" + val + "']").text());
    $("#order-category").html(ico + $("#orderform-category option[value='" + val + "']").text());
}

