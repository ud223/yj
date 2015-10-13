var Teacher = function() {
    var obj = new Object();

    obj.check = function(code, email, bank, bank_code) {
        if (!code) {
            obj.message = "身份证号不能为空!";

            return false;
        }

        var tmp_return = IdentityCodeValid(code);

        if (tmp_return != "true") {
            obj.message = tmp_return;

            return false;
        }

        if (!email) {
            obj.message = "电子邮箱不能为空!";

            return false;
        }

        if (!bank) {
            obj.message = "请选择银行!";

            return false;
        }

        if (bank == '选择银行') {
            obj.message = "请选择银行!";

            return false;
        }

        if (!bank_code) {
            obj.message = "银行账号不能为空!";

            return false;
        }

        return true;
    }

    obj.checkRange = function(cell, range, lat, lng) {
        if (!cell) {
            obj.message = "小区名称不能为空!!";

            return false;
        }

        if (!range) {
            obj.message = "请选择授课范围!";

            return false;
        }

        if (!lat) {
            obj.message = "坐标数据不完整!";

            return false;
        }

        if (!lng) {
            obj.message = "坐标数据不完整!";

            return false;
        }

        return true;
    }

    obj.query = function(search, sort, page) {
        queryTeacherList(search, sort, page);
    }

    obj.apply = function(customer_id, sex, birthday, code, email, wechat, region_id, category_id, bank, bank_code, description, location, fun) {
        if (!obj.check(code, email, bank, bank_code)) {
            $.toastMsg(obj.message, 1500);

            return;
        }

        var birthday = "";

        if (code.length == 18)
            birthday = code.substr(6, 4) + "-"  + code.substr(10, 2) + "-" +  code.substr(12, 2);
        else
            birthday = "19" + code.substr(6, 2) + "-"  + code.substr(8, 2) + "-" +  code.substr(10, 2);

        applyTeacher(customer_id, sex, birthday, code, email, wechat, region_id, category_id, bank, bank_code, description, location, fun);
    }

    obj.saveRange = function(teacher_id, cell, range, lat, lng, fun) {
        if (!obj.checkRange(cell, range, lat, lng)) {
            $.toastMsg(obj.message, 1500);

            return;
        }

        setRange(teacher_id, cell, range, lat, lng, fun);
    }

    return obj;
}