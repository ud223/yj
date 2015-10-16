$(document).ready(function() {
    initControls();

    initInput();

    initBtn();

    loadData();
});

function initBtn() {
    editAddressName();

    applyAddrClick();

    //applyAddrDetailClick();

    phoneValidClick();

    validPhoneCodeClick();

    initTimeClick();

    chooseDayClick();

    acceptTimeClick();

    initSubmitOrder();

    getLocClick();
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
