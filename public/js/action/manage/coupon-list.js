function loadCustomerRow(data, page, pagecount, name) {
    if (data.length > 0) {
        $("#customer-body").html('');

        var data_html = "";

        $.each(data, function() {
            data_html  = data_html + "<tr class='customer-row'><td>"+ this.nickname +"</td><td>"+ this.name +"</td><td>"+ this.order_count +"</td><td>"+ this.amount +"</td><td><a href='javascript:void(0)' onclick='chooseCustomer(\""+ this.id +"\")'>选择</a></td></tr>";
        })

        $("#customer-body").html(data_html);
        //初始化分页
        $("#page-controller").find(".pagination").html('');

        var page_html = "";

        for (var i = 0; i < pagecount; i++) {
            var cls = "";
            var index = i + 1;

            if (index == page) {
                cls = "active";
            }

            page_html = page_html + "<li class='cls'><a href='javascript:void(0)' onclick='loadCustomerList("+ index +", \""+ name +"\");' >"+ index +"</a></li>";///manage/teacher/list/'+ index +"
        }

        if (page == 1) {
            page_html = "<li><a href='javascript:void(0)' onclick='loadCustomerList(1, \""+ name +"\");' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>" + page_html;
        }
        else {
            var tmp_page = page - 1;

            page_html = "<li><a href='javascript:void(0)' onclick='loadCustomerList("+ page +", \""+ name +"\");' aria-label='Previous'><span aria-hidden='true'>&laquo;</span></a></li>" + page_html;
        }

        if (page == pagecount) {
            page_html = page_html + "<li><a href='javascript:void(0)' onclick='loadCustomerList("+ pagecount +", \""+ name +"\");' aria-label='Previous'><span aria-hidden='true'>&raquo;</span></a></li>";
        }
        else {
            var tmp_page = page + 1;

            page_html = page_html + "<li><a href='javascript:void(0)' onclick='loadCustomerList("+ tmp_page +", \""+ name +"\");' aria-label='Previous'><span aria-hidden='true'>&raquo;</span></a></li>";
        }

        $("#page-controller").find(".pagination").html(page_html);
    }
    else {
        $.toastMsg("没有微信注册普通用户!", 1500);
    }
}

function chooseCustomer(id) {
    location.href = "/manage/coupon/set/" +id;
}

function loadCustomerList(page, name) {
    //alert(page);
    var customer = new Customer();

    customer.consumeList(page, name);
}