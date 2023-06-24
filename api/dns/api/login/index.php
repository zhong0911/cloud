<?php
/**
 * @Author: zhong
 * @Date: 2023-06-22 13-41-49
 * @LastEditors: zhong
 */


error_reporting(0);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: https://dns.console.cloud.antx.cc');
header("Content-type:application/json; charset=utf-8");
date_default_timezone_set("Asia/Shanghai");
session_set_cookie_params(0, '/', '.antx.cc');
session_start();


require_once '../../db/db.php';

$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
if ($REQUEST_METHOD === "POST") {
    $params = $_POST;
    $action = $params['action'] ?? '';
    if ($action) {
        switch (strtolower($action)) {
            case  "checklogin":
            {
                if (getLoginStatus()) {
                    echo json_encode(['success' => true, 'message' => 'Logged in'], true);
                }else {
                    echo json_encode(['success' => false, 'message' => 'No logged in'], true);
                }
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
