var Customer = function() {
    var obj = new Object();

    obj.query = function(page, name) {
        queryCustomerList(page, name);
    }

    obj.consumeList = function(page, name) {
        queryCustomerConsumeList(page, name);
    }


    return obj;
}