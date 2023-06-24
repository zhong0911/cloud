let listening = setInterval(function () {
    $.post(
        "/static/php/public.php", {
            action: 'get_login_status'
        }, function (data) {
            if (!data['success']) {
                clearInterval(listening);
                into("/login/?oauth_callback=" + $.url.attr('source'));
            }
        }, 'json'
    );
}, 5000);


function logout() {
    $.removeCookie('PHPSESSID', {path: '/', domain: '.antx.cc'});
    into('https://www.antx.cc/');
}

