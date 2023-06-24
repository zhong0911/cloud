let error = '<i class="fa fa-exclamation-circle"></i>';
let success = '<i class="fa fa-check-circle"></i>';

$.get("https://www.antx.cc/static/html/footer/footer.html", function (data) {
    $("footer").append(data);
})

getLoginStatus();

let listeningLoginStatus = setInterval(function () {
    getLoginStatus();
}, 5000)


function getLoginStatus() {
    $.post({
        url: 'https://ssl.api.cloud.antx.cc/api/login/',
        data: {
            action: 'checkLogin'
        }, dataType: 'json',
        async: true,
        type: "POST",
        xhrFields: {
            withCredentials: true
        },
        success: function (data) {
            if (!data['success']) {
                clearInterval(listeningLoginStatus);
                into('https://passport.cloud.antx.cc/login/?oauth_callback=' + $.url.attr('source'));
            }
        }
    });
}