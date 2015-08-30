var Teacher = function() {
    var obj = new Object();

    obj.query = function(search, sort, page) {
        queryTeacherList(search, sort, page);
    }

    return obj;
}