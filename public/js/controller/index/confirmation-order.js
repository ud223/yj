$(document).ready(function() {
    initControls();

    initInput();

    initBtn();

    loadData();
});

function initBtn() {
    editAddressName();

    applyAddrClick();

    phoneValidClick();

    validPhoneCodeClick();

    initTimeClick();

    chooseDay();

    acceptTimeClick();

    initSubmitOrder();
}

function initInput() {

}

function loadData() {
    initAddress();
}

function initControls() {
    initWeek();

    initSelectTime();
}
