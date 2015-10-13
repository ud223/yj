var page = 1;
var teacher_list_count = 1;

function load() {
    //var tmp_region= $(".tcfilter-filter").find(".selected");
    var tmp_sort = $(".tcfilter-sort").find(".selected");

    var search = "lat:"+ lat +";lng:"+ lng;
    var sort = $(tmp_sort).attr("sort");

    var tmp_search = localStorage.getItem("teacher_search");
    var tmp_sort = localStorage.getItem("teacher_sort");

    //如果条件不变，加载就翻页
    if (search == tmp_search && sort == tmp_sort) {
        page = parseInt(page) + 1;

        //如果后面没有新的数据，这里最好还是标记一个记号
    }
    else {
        //如果条件变化，这里翻页索引改为 1
        page = 1;

        localStorage.setItem("teacher_search", search);
        localStorage.setItem("teacher_sort", sort);
    }

    var teacher = new Teacher();

    teacher.query(search, sort, page);
}

function loadTeacher(data, current_page_no, page_count) {
    //alert(JSON.stringify(data));
    var list = $(".tcfilter-container");
    //如果当前页为 1 则表示第一次查询或更换了条件，清空一次里面的html
    if (current_page_no == 1) {
        list.html("");
    }

    $.each(data, function() {
        if (user_id == this.id)
            return;

       var node = $("#teacher-item").find(".teacher-itm").clone();

        node.find(".cd_hottap").attr("hottap", "/mentordetail/" + this.id);

        if (this.head_pic) {
            node.find(".user-intro-img").attr("src", '/photo/image/'+ this.head_pic);
        }

        node.find(".teacher-name").html(this.name);
        node.find(".this-teacher-score").html(this.score);

        var tmp_category = this.category;

        if (this.category.length > 20) {
            tmp_category = this.category.substr(0, 19) + "...";
        }

        node.find(".user-intro-skill").html(tmp_category);
        node.find(".price").html(this.price);
        node.find(".teacher-img-big").attr("src", this.photo);
        node.find(".cd_hottap").attr("hottap", "/teacher/" + this.id);

        list.append(node);
    });

    if (data.length < 1) {
        return;
    }

    page = current_page_no;
    teacher_list_count = page_count;
}

function setAddressList(response) {
    var addresses = response.result.pois;
    var list = $("#addr-list");

    list.html("");

    $("#address-view").html(addresses[0].name);

    $.each(addresses, function() {
        var node = $("#div-addr-node").find(".loc-ddl-itm").clone();

        node.find(".t1").html(this.name);
        node.find(".t2").html(this.addr);

        node.find(".t1").attr("lng", this.point.x);
        node.find(".t1").attr("lat", this.point.y);

        addrClick(node);

        list.append(node);
    });
}

function chooseAddr(node) {
    ///$("#edit-addr").val(text);
    if (node.find(".t1").html().length > 5) {
        $("#address-view").html(node.find(".t1").html().substr(0, 5) +  "...");
    }
    else {
        $("#address-view").html(node.find(".t1").html());
    }

    lat = node.find(".t1").attr("lat");
    lng = node.find(".t1").attr("lng");

    load();

    closePopup($("#pp-change-loc").find('.cd-slidepopupback'));
}