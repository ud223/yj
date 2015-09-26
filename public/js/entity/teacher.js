var Teacher = function() {
    var obj = new Object();

    obj.query = function(search, sort, page) {
        queryTeacherList(search, sort, page);
    }

    obj.apply = function($customer_id, sex, birthday, code, email, wechat, region_id, category_id, bank, bank_code, description, fun) {
        applyTeacher($customer_id, sex, birthday, code, email, wechat, region_id, category_id, bank, bank_code, description, fun);
    }

    return obj;
}