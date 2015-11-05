function initBangCustomer() {
    $("#bang-customer").click(function() {
        var name = $("#wx-name").val();

        loadCustomerList(1, name);
    });
}