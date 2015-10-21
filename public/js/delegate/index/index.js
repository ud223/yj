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

function toMeClick() {
    $("#to-me").click(function() {
        var user_id = localStorage.getItem('user_id');
        //alert(user_id);
        if (user_id) {
            location.href = "/me/"+ user_id;
        }
        else {
            userLogin();
        }
    });
}

function toTeachClick() {
    $("#to-teach").click(function() {
        var user_id = localStorage.getItem('user_id');
        //alert(user_id);
        if (user_id) {
            location.href = "/my/teach/"+ user_id;
        }
        else {
            userLogin();
        }
    });
}

function editAddressName() {
    $("#btn-addr-query").tap(function() {
        if ($("#edit-addr").val() == "") {
            return;
        }

        getAddressByAddressName($("#edit-addr").val(), setAddressList);
    });
}

function getLocClick() {
    $("#btn-get-loc").tapA(function() {
        closePopup($("#pp-change-loc").find('.cd-slidepopupback'));

        getLocal(load);
    })
}