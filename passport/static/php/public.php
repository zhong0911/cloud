<?php
require './php/Account.php';
require './php/Utils.php';
require './php/Mailer.php';

require_once "../../vendor/autoload.php";

error_reporting(0);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: *');
header("Content-type:application/json; charset=utf-8");
date_default_timezone_set("Asia/Shanghai");
session_set_cookie_params(0, '/', '.antx.cc');
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $posts = $_POST;
    foreach ($posts as $key => $value) {
        $posts[$key] = trim($value);
    }
    $action = $posts['action'] ?? '';
    switch ($action) {
        case "check_username_exist" :
        {
            $username = $posts['username'] ?? '';
            if ($username) {
                if (getUsernameExists($username)) {
                    echo json_encode(
                        array(
                            'success' => true,
                            'message' => 'Query successful',
                            'exist' => true
                        ),
                        true
                    );
                } else {
                    echo json_encode(
                        array(
                            'success' => true,
                            'message' => 'Query successful',
                            'exist' => false
                        ),
                        true
                    );
                }
            } else {
                echo json_encode(
                    array(
                        'success' => false,
                        'message' => 'Username is empty'
                    ),
                    true
                );
            }
            break;
        }
        case "check_email_exist" :
        {
            $email = $posts['email'] ?? '';
            if ($email) {
                if (getEmailExists($email)) {
                    echo json_encode(
                        [
                            'success' => true,
                            'message' => 'Query successful',
                            'exist' => true
                        ],
                        true
                    );
                } else {
                    echo json_encode(
                        array(
                            'success' => true,
                            'message' => 'Query successful',
                            'exist' => false
                        ),
                        true
                    );
                }
            } else {
                echo json_encode(
                    array(
                        'success' => false,
                        'message' => 'Email is empty'
                    ),
                    true
                );
            }
            break;
        }
        case "get_login_status":
        {
            $username = $_SESSION['username'] ?? '';
            $password = $_SESSION['password'] ?? '';
            $correct_password = getAccountPassword($username);
            if ($username && $password && $correct_password && ($correct_password == $password)) {
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => 'Logged in'
                    ),
                    true
                );
            } else {
                echo json_encode(
                    array(
                        'success' => false,
                        'message' => 'Not logged in'
                    ),
                    true
                );
            }
            break;
        }
        case "get_account_status":
        {
            $username = $_SESSION['username'] ?? '';
            $correct_password = getAccountPassword($username);
            if ($username) {
                if (getAccountStatus($username)) {
                    echo json_encode(['success' => true, 'status' => true, 'message' => 'Queried successfully'], true);
                } else {
                    echo json_encode(['success' => true, 'status' => false, 'message' => 'Queried successfully'], true);
                }
            } else {
                echo json_encode(['success' => false, 'message' => 'Username cannot be empty'], true);
            }
            break;
        }
        case "get_user_info":
        {
            $username = $_SESSION['username'] ?? '';
            if ($username) {
                $uid = getAccountUid($username);
                $email = getAccountEmail($username);
                $nickname = getAccountNickname($username);
                $avatar = getAccountAvatar($username);
                $age = getAccountAge($username);
                $birthday = getAccountBirthday($username);
                $gender = getAccountGender($username);
                echo json_encode(
                    array(
                        'success' => true,
                        'message' => 'Query successfully',
                        'uid' => $uid,
                        'email' => $email,
                        'username' => $username,
                        'nickname' => $nickname,
                        'avatar' => $avatar,
                        'gender' => $gender,
                        'birthday' => $birthday,
                        'age' => $age
                    ),
                    true
                );
            } else {
                echo json_encode(array(
                    'success' => false,
                    'message' => 'Username is empty'
                ), true);
            }
            break;
        }
        default :
            echo json_encode(
                array(
                    'success' => false,
                    'message' => 'No such option'
                ),
                true
            );
    }
} else {
    echo json_encode(
        array(
            'success' => false,
            'message' => 'No post request'
        ),
        true
    );
}