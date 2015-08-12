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
            alert("老师技能和评分不能都为空!")

            return false;
        }
    }

    if (name) {
        if (!value) {
            alert("老师技能评分不能为空!")

            return false;
        }
    }

    if (value) {
        if (!name) {
            alert("老师技能名称不能为空!")

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