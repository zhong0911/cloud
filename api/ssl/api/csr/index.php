<?php
/**
 * @Author: zhong
 * @Email: i@antx.cc
 * @Date: 2023-6-10 10:12:07
 */


error_reporting(0);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: https://ssl.console.cloud.antx.cc');
header("Content-type:application/json; charset=utf-8");
date_default_timezone_set("Asia/Shanghai");
session_set_cookie_params(0, '/', '.antx.cc');
session_start();

use SSL\csr;

require_once '../../src/csr.php';
require_once '../../db/db.php';

$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
if ($REQUEST_METHOD === "GET" || $REQUEST_METHOD === "POST") {
    if (!getLoginStatus())  die(json_encode(['success' => false, 'code' => 'ConsoleNeedLogin', 'message' => 'You need login to use this api', 'login_url' => 'https://passport.cloud.antx.cc/login'], JSON_UNESCAPED_SLASHES));
    $params = ($REQUEST_METHOD === "GET") ? $_GET : $_POST;
    $action = $params['action'] ?? '';
    if ($action) {
        switch (strtolower($action)) {
            case  "generatecsr":
            {
                echo json_encode(csr::generateCSR($params), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                break;
            }
            case  "describecsrrecords":
            {
                echo json_encode(csr::describeCSRRecords($params), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                break;
            }
            case  "describecsrrecordinfo":
            {
                echo json_encode(csr::describeCSRRecordInfo($params), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
                break;
            }
            default:
            {
                echo json_encode(array('success' => false, "message" => 'No such acton'), true);
                break;
            }
        }
    } else {
        echo json_encode(array('success' => false, "message" => 'Action cannot be empty'), true);

    }
} else {
    echo json_encode(array('success' => false, "message" => 'No POST or GET method'), true);
}
