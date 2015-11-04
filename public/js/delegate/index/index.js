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

function editTeacherName() {
    $("#btn-teacher-query").tap(function() {
        if ($("#edit-teacher-name").val() == "") {
            return;
        }

        queryTeacherByName($("#edit-teacher-name").val());
    });
}