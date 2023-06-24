$(document).ready(function () {
    $.post("/static/php/public.php", {action: "get_login_status"}, function (data) {
        if (data['success']) {
            let oauth_callback = $.url.param('oauth_callback') ?? '/home';
            into(oauth_callback);
        }
    }, 'json');
    initLogin();
});

let loginType = 'account';

function initLogin() {
    $("#body").load("/static/html/login/login-form.html", function () {
        if (decodeURIComponent($.url.param('login_type')) === 'email') {
            $('#email-login').tab('show');
            loginType = 'email';
        }
        $("#login-qrcode").prop('src', 'https://api.antx.cc/api/qrcode/?text=' + 'https://passport.cloud.antx.cc/login/index.html');
        $("#login-form").submit(function (event) {
                event.preventDefault();
                login();
            }
        );
        $("#footer").load("https://www.antx.cc/static/html/footer/footer.html");
        $("#username").keyup(function () {
            checkUsername();
        });
        $("#email").keyup(function () {
            checkEmail();
        });
        $("#send-code").click(function () {
            sendLoginCode();
        });
        $("#code").keyup(function () {
            checkCode();
        });
        $("#password").keyup(function () {
            checkPassword();
        });
        $("#agree").click(function () {
            checkAgree();
        });
        $("#eye").click(function () {
            togglePassword('#eye', '#password');
        });

        $("#account-login").click(function () {
            loginType = 'account';
            $("#agree").prop("checked", false);
        });

        $("#email-login").click(function () {
            loginType = 'email';
            $("#agree").prop("checked", false);
        });
    });
}

function login() {
    let accountCallback = function () {
        $("#login-button").prop('disabled', true).html("<span class='spinner-border spinner-border-sm'></span> 登录中...");
        $.post('/static/php/login.php', {
                action: 'account_login',
                username: $("#username").val(),
                password: $("#password").val()
            }, function (data) {
                if (data["success"]) {
                    $prompt.success("登录成功");
                    $("#password-error").html('');
                    $("#username-error").html('');
                    $("#login-button").html("正在跳转中...");
                    into(decodeURIComponent($.url.param("oauth_callback") ?? '/home'));
                } else {
                    if (data['code'] === 'status.abnormal') {
                        $prompt.error("账号状态异常, 无法登录");
                        $("#code-error").html('');
                    } else {
                        $prompt.error("登录失败, 账号或密码错误")
                        $("#password").val("");
                        $("#password-error").html(error + ' 账号或密码错误');
                    }
                    $("#login-button").html("立即登录").prop('disabled', false);
                }
            }, 'json'
        );
    }
    let emailCallback = function () {
        let email = $("#email").val();
        let code = $("#code").val();
        $.post('/static/php/public.php', {'action': 'check_email_exist', 'email': email}, function (data) {
            if (data['success']) {
                if (data['exist']) {
                    $("#login-button").prop('disabled', true).html("<span class='spinner-border spinner-border-sm'></span> 登录中...");
                    $.post('/static/php/login.php', {
                        'action': 'verify_login_code', 'code': code, 'email': email
                    }, function (data) {
                        if (data['success']) {
                            $prompt.success("登录成功");
                            $("#code-error").html('');
                            $("#code-success").html('');
                            $("#login-button").html("正在跳转中...");
                            into(decodeURIComponent($.url.param("oauth_callback") ?? '/home'));
                        } else {
                            if (data['code'] === 'status.abnormal') {
                                $prompt.error("账号状态异常, 无法登录");
                                $("#code-error").html('');
                            } else {
                                $prompt.error("登录失败, 验证码错误或已失效")
                                $("#code").val('');
                                $("#code-error").html(error + ' 验证码错误或已失效');
                                $("#code-success").html('');
                                $("#login-button").prop('disabled', false).html("立即登录");
                            }
                        }
                    }, 'json');
                } else {
                    $prompt.error("该邮箱未被绑定");
                }
            } else {
                $prompt.error("服务器错误")
            }
        }, 'json');
    }
    if (loginType === 'account') {
        if (checkAgree() && checkUsername() && checkPassword()) {
            $.captcha({
                callback: function () {
                    $("#account-login-captcha-modal").on('hidden.bs.modal', function () {
                        $(this).remove();
                    }).modal('hide');
                    accountCallback();
                }, modalId: 'account-login-captcha-modal', title: '请完成安全验证', center: true,
                appkey: 'FFFF0N0000000000B42D',
                scene: 'nc_login'
            });
        }
    } else if (loginType === 'email') {
        if (checkAgree() && checkEmail() && checkCode()) {
            $.captcha({
                callback: function () {
                    $("#email-login-captcha-modal").on('hidden.bs.modal', function () {
                        $(this).remove();
                    }).modal('hide');
                    emailCallback();
                }, modalId: 'email-login-captcha-modal', title: '请完成安全验证', center: true,
                appkey: 'FFFF0N0000000000B42D',
                scene: 'nc_login'
            });
        }
    } else {
        reflush();
    }
}

function sendLoginCode() {
    let callback = function () {
        let email = $("#email").val();
        $.post("/static/php/public.php",
            {'action': 'check_email_exist', 'email': email},
            function (data) {
                if (data['success']) {
                    if (data['exist']) {
                        $("#send-code").prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> 获取中');
                        if (email) {
                            if (!isEmail(email)) {
                                $('#email-error').html(error + ' 邮箱格式错误');
                            } else {
                                $.post('/static/php/login.php', {
                                    'action': 'send_login_code', 'email': email
                                }, function (data) {
                                    if (data['success']) {
                                        $prompt.success("验证码发送成功");
                                        $("#code-error").html('');
                                        $("#code-success").html(success + ' 验证码已发送, 可能会有延迟, 请耐心等待');
                                        $("#send-code").html("获取验证码").prop('disabled', true);
                                        let intervalId = null;
                                        let countdown = 60;
                                        intervalId = setInterval(function () {
                                            countdown--;
                                            $("#send-code").html(countdown + '秒后重试');
                                            if (countdown <= 0) {
                                                clearInterval(intervalId);
                                                $("#sent-code").html('');
                                                $("#send-code").html("获取验证码").prop('disabled', false);
                                            }
                                        }, 1000);
                                        $("#send-code").html('获取验证码');
                                    } else {
                                        $prompt.error("验证码发送失败\n" + data['message']);
                                        $("#sent-code").html('');
                                        $("#code-error").html(error + ' 发送失败');
                                        $("#send-code").html('获取验证码').prop('disabled', false);
                                    }
                                }, 'json');
                            }
                        } else {
                            $('#email-error').html(error + ' 邮箱不可为空');
                        }
                    } else {
                        $prompt.error("该邮箱未被绑定");
                    }
                } else {
                    $prompt.error("服务器错误");
                }
            }, 'json');
    }
    if (checkEmail()) {
        $.captcha({
            callback: function () {
                $("#send-code-captcha-modal").on('hidden.bs.modal', function () {
                    $(this).remove();
                }).modal('hide');
                callback();
            },
            modalId: 'send-code-captcha-modal',
            title: '请完成安全验证',
            center: true,
            appkey: 'FFFF0N0000000000B42D',
            scene: 'nc_login'
        });
    }
}

function checkUsername() {
    let username = $("#username").val()
    if (username) {
        $('#username-error').html('');
        return true;
    } else {
        $('#username-error').html(error + ' 用户名不可为空');
        return false;
    }
}

function checkPassword() {
    let password = $("#password").val()
    if (password) {
        $('#password-error').html('');
        return true;
    } else {
        $('#password-error').html(error + ' 密码不可为空');
        return false;
    }
}

function checkEmail() {
    let res;
    let email = $("#email").val();
    if (email) {
        if (!isEmail(email)) {
            $('#email-error').html(error + ' 邮箱格式错误');
            res = false;
        } else {
            $('#email-error').html('');
            res = true;
        }
    } else {
        $('#email-error').html(error + ' 邮箱不可为空');
        res = false;
    }
    return res;
}

function checkCode() {
    let code = $("#code").val()
    if (code) {
        $("#code-error").html('');
        $("#code-success").html('');
        return true;
    } else {
        $("#code-success").html('');
        $("#code-error").html(error + ' 验证码不可为空');
        return false;
    }
}

function checkAgree() {
    if ($("#agree").is(":checked")) {
        $('#agree-error').html('');
        return true;
    } else {
        $('#agree-error').html(error + ' 请阅读并同意服务条约和隐私政策');
        return false;
    }
}