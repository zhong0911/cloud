<?php
/**
 * @Author: zhong
 * @Email: i@antx.cc
 * @Date: 2023-6-10 10:12:07
 */

error_reporting(0);
header("Access-Control-Allow-Origin:*");
header("Content-type:application/json; charset=utf-8");
date_default_timezone_set("Asia/Shanghai");

use SSH\ssh;

require_once '../../src/ssh.php';
require_once '../../db/db.php';

$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];
if ($REQUEST_METHOD === "GET" || $REQUEST_METHOD === "POST") {
    $params = ($REQUEST_METHOD === "GET") ? $_GET : $_POST;
    $action = strtolower($params['action'] ?? '');
    $host = $params['host'] ?? $params['hostname'] ?? '';
    $port = $params['port'] ?? '22';
    $username = $params['username'] ?? '';
    $password = $params['password'] ?? '';
    if ($action) {
        switch (strtolower($action)) {
            case"checkpassword" :
            {
                echo json_encode(ssh::checkPassword($params));
                break;
            }
            case "executecommand":
            {
                echo json_encode(ssh::executeCommand($params));
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
