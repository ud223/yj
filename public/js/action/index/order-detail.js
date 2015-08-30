function removeOrderById() {
    if (confirm("是否删除该订单?")) {
        var order = new Order();

        order.remove(order_id, delSucess);
    }
}

function delSucess(response) {
    location.href = "/my/order/"+ response.data;
}