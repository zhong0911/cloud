<?php

/**
 * @Author: zhong
 * @Email: i@antx.cc
 * @Date: 2023-6-10 10:12:07
 */


use DNS\Domain;

error_reporting(0);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: https://dns.console.cloud.antx.cc');
header("Content-type:application/json; charset=utf-8");
date_default_timezone_set("Asia/Shanghai");
session_set_cookie_params(0, '/', '.antx.cc');
session_start();

require_once '../../db/db.php';
require_once '../../src/Domain.php';
require_once '../../autoload.php';

$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];

if ($REQUEST_METHOD === "GET" || $REQUEST_METHOD === "POST") {
    if (!getLoginStatus())  die(json_encode(['success' => false, 'code' => 'ConsoleNeedLogin', 'message' => 'You need login to use this api', 'login_url' => 'https://passport.cloud.antx.cc/login'], JSON_UNESCAPED_SLASHES));
    $params = ($REQUEST_METHOD === "GET") ? $_GET : $_POST;
    $action = strtolower($params['action'] ?? '');
    $domainName = $params['domainName'] ?? '';
    if ($action) {
        switch ($action) {
            case"adddomain":
            {
                if ($domainName) {
                    echo json_encode(Domain::addDomain($params), true);
                } else {
                    echo json_encode(array('success' => false, "message" => 'Domain name cannot be empty'), true);
                    break;
                }
                break;
            }
            case"describedomains":
            {
                echo json_encode(Domain::describeDomains($params), true);
                break;
            }
            case"deletedomain":
            {
                if ($domainName) {
                    echo json_encode(Domain::deleteDomain($params), true);
                } else {
                    echo json_encode(array('success' => false, "message" => 'Domain name cannot be empty'), true);
                    break;
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
