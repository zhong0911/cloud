$(document).ready(function () {
    initPageEvent();
});

function initPageEvent() {
    $("#generate-csr").click(function () {
        generateCSR();
    });
    $("#csr-management").click(function () {
        initCSRTable();
    });
}
