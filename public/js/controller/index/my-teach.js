$(document).ready(function() {
    initControls();

    initInput();

    initBtn();

    loadData();

    initUser();
});

function initBtn() {
    setNameClick();

    phoneValidClick();

    validPhoneCodeClick();

    setDescriptionClick();

    setYearsClick();

    toMeClick();

    toTeachClick();
    toOrderClick();

    editAddressName();

    saveRangeClick();
}

function initInput() {

}

function loadData() {

}

function initControls() {

}

function initUser() {
    resetBottomBar(usertype, 'to-teach');
}