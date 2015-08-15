var Customer = function() {
    var obj = new Object();

    obj.query = function(page, name) {
        queryCustomerList(page, name);
    }

    return obj;
}