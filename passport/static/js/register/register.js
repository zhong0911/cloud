$(document).ready(function () {
    initRegister();
});

function initRegister() {
    $("#app").load("/static/html/register/register-form.html", function () {
        $("#qrcode").prop('src', 'https://api.antx.cc/api/qrcode/?text=' + 'https://passport.cloud.antx.cc/register/index.html');
        $("#register-form").submit(function (event) {
            event.preventDefault();
            register();
        });
        $("#footer").load("https://www.antx.cc/static/html/footer/footer.html");
        $("#send-email-code").click(function () {
            sendCode();
        });
        $("#username").attr({
            "data-bs-toggle": "tooltip", "data-bs-placement": "right", "title": "不能包括空格\n开头必须为字母\n长度为5~12个字符\n必须包含字母和数字"
        }).keyup(function () {
            checkUsername();
        });
        $("#password").attr({
            "data-bs-toggle": "tooltip", "data-bs-placement": "right", "title": "不能包括空格\n长度为8~26个字符\n必须包含字母和数字"
        }).keyup(function () {
            checkPassword();
        })
        $("#email-code").attr({
            "data-bs-toggle": "tooltip", "data-bs-placement": "right", "title": "错误次数超过5次将失效"
        }).keyup(function () {
            checkCode();
        });
        $("#email").keyup(function () {
            checkEmail();
        });
        $("#agree").click(function () {
            checkAgree();
        });
    });
}

function register() {
    let callback = function () {
        $("#register-captcha-modal").on('hidden.bs.modal', function () {
            $(this).remove();
        }).modal('hide');
        $("#register-button").prop('disabled', true).html("<span class='spinner-border spinner-border-sm'></span> 注册中...");
        let email = $("#email").val();
        let code = $("#email-code").val();
        let username = $("#username").val();
        let password = $("#password").val();
        $.post('/static/php/register.php', {
                'action': 'verify_register_code', 'code': code, 'email': email
            }, function (data) {
                if (data["success"]) {
                    $("#code-error").html('');
                    $("#code-success").html('');
                    $.post('/static/php/register.php', {
                        action: 'register',
                        username: username,
                        password: password,
                        email: email
                    }, function (data) {
                        if (data["success"]) {
                            $("#register-button").html("注册成功");
                            registered(data);
                        } else {
                            $("#register-button").html("立即注册").prop('disabled', false);
                            $prompt.error("注册失败, 原因:<br/>" + data['message']);
                        }
                    }, 'json');
                } else {
                    $prompt.error("注册失败, 验证码错误或已失效")
                    $("#code").val('');
                    $("#code-error").html(error + ' 验证码错误或已失效');
                    $("#code-success").html('');
                    $("#register-button").prop('disabled', false).html("立即注册");
                }
            }, 'json'
        );
    };
    if (checkAgree() && checkUsername() && checkPassword() && checkEmail() && checkCode()) {
        $.captcha({
            callback: callback,
            modalId: 'register-captcha-modal',
            title: '请完成安全验证',
            center: true,
            appkey: 'FFFF0N0000000000B42D',
            scene: 'nc_register'
        })
    }
}

function registered(data) {
    let uid = data['uid'];
    let username = data['username'];
    $("#registered-modal-div").load("/static/html/register/registered-modal.html",
        function () {
            $("#registered-uid").text(uid);
            $("#registered-username").text(username);
            $("#registered-modal").modal("show");
        }
    );
}

function sendCode() {
    let callback = function () {
        $("#send-code-captcha-modal").on('hidden.bs.modal', function () {
            $(this).remove();
        }).modal('hide');
        let email = $("#email").val();
        if (email) {$("#send-email-code").prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> 获取中');
            if (!isEmail(email)) {
                $('#email-error').html(error + ' 邮箱格式错误');
            } else {
                let intervalId = null;
                let countdown = 60;
                $.post('/static/php/register.php', {
                    'action': 'send_register_code', 'email': email
                }, function (data) {
                    if (data['success']) {
                        $prompt.success("验证码发送成功");
                        $("#code-error").html('');
                        $("#code-success").html(success + ' 验证码已发送, 可能会有延迟, 请耐心等待');
                        intervalId = setInterval(function () {
                            countdown--;
                            $("#send-email-code").html(countdown + '秒后重试');
                            if (countdown <= 0) {
                                countdown = 60;
                                clearInterval(intervalId);
                                $("#send-email-code").html('').html("获取验证码").prop('disabled', false);
                            }
                        }, 1000);
                        $("#send-email-code").html('获取验证码');
                    } else {
                        $prompt.error("验证码发送失败\n" + data['message']);
                        $("#sent-code").html('');
                        $("#code-error").html(error + ' 发送失败');
                        $("#send-email-code").html('获取验证码').prop('disabled', false);
                    }
                }, 'json');
            }
        } else {
            $('#email-error').html(error + ' 邮箱不可为空');
        }
    }
    if (checkEmail()) {
        $.post('/static/php/public.php', {
                'action': 'check_email_exist', 'email': $("#email").val()
            }, function (data) {
                if (data['success']) {
                    if (!data['exist']) {
                        $('#email-error').html('');
                        $.captcha({
                            callback: callback,
                            modalId: 'send-code-captcha-modal',
                            title: '请完成安全验证',
                            center: true,
                            appkey: 'FFFF0N0000000000B42D',
                            scene: 'nc_register'
                        })
                    } else $('#email-error').html(error + ' 邮箱已被绑定');
                } else $prompt.error("服务器错误");
            }, 'json'
        );
    }
}

function checkUsername() {
    let username = $("#username").val()
    if (username) {
        if (!isUsername(username)) {
            $('#username-error').html(error + ' 用户名格式错误');
            return false;
        } else {
            if (!checkUsernameExist(username)) {
                $('#username-error').html('');
                return true;
            } else {
                $('#username-error').html(error + ' 用户名已存在');
                return false;
            }
        }
    } else {
        $('#username-error').html(error + ' 用户名不可为空');
        return false;
    }
}

function checkPassword() {
    let password = $("#password").val()
    if (password) {
        if (!isPassword(password)) {
            $('#password-error').html(error + ' 密码格式错误');
            return false;
        } else {
            $('#password-error').html('');
            return true;
        }
    } else {
        $('#password-error').html(error + ' 密码不可为空');
        return false;
    }
}

function checkEmail() {
    let email = $("#email").val();
    if (email) {
        if (!isEmail(email)) {
            $('#email-error').html(error + ' 邮箱格式错误');
            return false;
        } else {
            if (!checkEmailExist(email)) {
                $('#email-error').html('');
                return true;
            } else {
                $('#email-error').html(error + ' 邮箱已被绑定');
                return false;
            }
        }
    } else {
        $('#email-error').html(error + ' 邮箱不可为空');
        return false;
    }
}

function checkCode() {
    let code = $("#email-code").val()
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
        $('#agree-error').html(error + ' 请先阅读并同意服务条约和隐私政策');
        return false;
    }
}

