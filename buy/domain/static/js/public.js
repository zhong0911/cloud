$("#footer").load("https://www.antx.cc/static/html/footer/footer.html");



let domainSuffixes;

function describeDomainSuffixes() {
    $.get({
        url: "/static/json/suffix.json",
        success:
            function (data) {
                domainSuffixes = data;
            },
        dataType: 'json',
        type: "GET",
        async: false
    });
    return domainSuffixes;
}