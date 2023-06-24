let error = '<i class="fa fa-exclamation-circle"></i>';
let success = '<i class="fa fa-check-circle"></i>';

let usernameExists = false;

let host = $.url.attr("host");
if (!(host === "passport.cloud.antx.cc" || host === "localhost"))
    into("https://passport.cloud.antx.cc" + $.url.attr("path"));
$.get("https://www.antx.cc/static/html/footer/footer.html", function (data) {
    $("footer").append(data);
})


function checkUsernameExist(username) {
    $.post({
        url: '/static/php/public.php', data: {
            'action': 'check_username_exist', 'username': username
        }, dataType: 'json', async: false, type: "POST", success: function (data) {
            usernameExists = data["exist"];
        }
    });
    return usernameExists;
}

let emailExists = false;

function checkEmailExist(email) {
    $.post({
        url: '/static/php/public.php', data: {
            'action': 'check_email_exist', 'email': email
        }, dataType: 'json', async: false, type: "POST", success: function (data) {
            emailExists = data["exist"];
        }
    });
    return emailExists;
}


let loginStatus = false;

function getLoginStatus() {
    $.post({
        url: '/static/php/public.php',
        data: {
            action: 'get_login_status'
        }, dataType: 'json',
        async: false,
        type: "POST",
        success: function (data) {
            loginStatus = data['success'];
        }
    });
    return loginStatus;
}

let userInfo;

function getUserInfo() {
    $.post({
        url: '/static/php/public.php',
        data: {
            action: 'get_user_info'
        }, dataType: 'json',
        async: false,
        type: "POST",
        success: function (data) {
            userInfo = data;
        }
    });
    return userInfo;
}
