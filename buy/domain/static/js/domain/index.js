$(document).ready(function () {
    initPageEvent();
    initDomainSuffix();
});

function initPageEvent() {
    $("#query").click(
        function () {
            let suffixes = describeDomainSuffixes();
            let keyword = $("#keyword").val();
            let suffix = $('#suffix').val();
            if (keyword) {
                let arr = keyword.split('.');
                if (suffixes.includes(arr[arr.length-1])) {
                    into(`./query.html?keyword=${arr[0]}&suffix=${arr[arr.length-1]}`);
                }else {
                    into(`./query.html?keyword=${keyword}&suffix=${suffix}`);
                }
            }
        }
    );
}

function initDomainSuffix() {
    let prefixes = describeDomainSuffixes();
    for (let index in prefixes) {
        let suffix = prefixes[index];
        let item = `<option id="${suffix}" value="${suffix}">.${suffix}</option>`;
        $("#suffix").append(item);
    }
}