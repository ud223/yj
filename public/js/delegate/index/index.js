function regionClick() {
    $(".tcfilter-filter").find(".itmbtn").click(function() {
        if ($(this).hasClass("selected")) {
            return;
        }

        $(".tcfilter-filter").find(".itmbtn").removeClass("selected");

        $(this).addClass("selected");

        load();

        $('.loc-bt').removeClass('selected');
        $('.tcfilter-filter').slideUp(150);
    });
}

function sortClick() {
    $(".tcfilter-sort").find(".itmbtn").click(function() {
        if ($(this).hasClass("selected")) {
            return;
        }

        $(".tcfilter-sort").find(".itmbtn").removeClass("selected");

        $(this).addClass("selected");

        load();

        $('.sort-bt').removeClass('selected');
        $('.tcfilter-sort').slideUp(150);
    });
}

function toMeClick() {
    $("#to-me").tap(function() {
        alert(0);
       var user_id = localStorage.getItem('user_id');
        alert(user_id);
        if (!user_id) {
            alert(1);
            location.href = "/me/"+ user_id;
        }
        else {
            alert(2);
            userLogin();
        }
    });
}