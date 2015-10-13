function addrClick(node) {
    $(node).tapA(function() {
        chooseAddr(node);
    })
}

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