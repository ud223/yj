function skillAddNode() {
    var node = $("#skill-model").find(".form-group").clone();

    node.find(".btn-skill-remove").click(function() {
        if (confirm("确定删除该项评分吗?")) {
            removeSkill($(this).parent());
        }
    });

    $("#skill-list").append(node);
}

function check() {
    return true;
}

function checkSkill(name, value) {
    if (!name) {
        if (!value) {
            $.toastMsg("老师技能和评分不能都为空!", 1500)

            return false;
        }
    }

    if (name) {
        if (!value) {
            $.toastMsg("老师技能评分不能为空!", 1500)

            return false;
        }
    }

    if (value) {
        if (!name) {
            $.toastMsg("老师技能名称不能为空!", 1500)

            return false;
        }
    }

    return true;
}

function initSkill() {
    var result = true;
    var skill_node = $("#skill-list").find(".form-group");
    var skillText = $("#skills");
    //初始化提交的技能文本框
    skillText.val('');

    $.each(skill_node, function() {
        var name = $(this).find(".skill-name").val();
        var value =  $(this).find(".skill-value").val();
        //技能评分必须同时有名称和分数
        if (!checkSkill(name, value)) {
            result = false;

            return result;
        }

        var tmpText = skillText.val();

        if (tmpText.length > 0) {
            tmpText = tmpText + ";";
        }

        tmpText = tmpText + name + ":" + value;

        skillText.val(tmpText)
    });

    return result;
}

function initSubmit() {
    if (!check()) {
        return false;
    }

    return initSkill();
}

function removeSkill(node) {
    $(node).remove();
}

function loadCustomerList(page, name) {
    //alert(page);
    var customer = new Customer();

    customer.query(page, name);
}

function loadCustomerRow(data, page, pagecount, name) {
    if (data.length > 0) {
        $("#customer-body").html('');

        var data_html = "";

        $.each(data, function() {
            var status = "正常";
            var sex = "男";

            if (this.sex == 2) {
                sex = "女";
            }
            else if (this.sex == 0) {
                sex = "未知";
            }

            if (this.frozen == 1) {
                status = "已冻结";
            }

            data_html  = data_html + "<tr class='customer-row'><td>"+ this.nickname +"</td><td>"+ sex +"</td><td>"+ this.city +"</td><td>"+ status +"</td><td><a href='javascript:void(0)' onclick='chooseCustomer(\""+ this.id +"\", \""+ this.nickname +"\", \""+ sex +"\", \""+ this.openid +"\")'>选择</a></td></tr>";
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
function chooseCustomer(id, nickname, sex, openid) {
    $(".span-openid").html(openid);
    $(".span-nickname").html(nickname);
    $(".span-sex").html(sex);
    $("#wxid").val(id);

    $(".modal-close").click();
}

