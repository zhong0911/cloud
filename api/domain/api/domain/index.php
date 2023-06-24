<?php
/**
 * @Author: zhong
 * @Email: i@antx.cc
 * @Date: 2023-6-10 10:12:07
 */

//error_reporting(0);
header("Access-Control-Allow-Origin:*");
header("Content-type:application/json; charset=utf-8");
date_default_timezone_set("Asia/Shanghai");

use DomainName\DomainName;

require_once '../../src/DomainName.php';
require_once '../../vendor/autoload.php';

$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];

if ($REQUEST_METHOD === "GET" || $REQUEST_METHOD === "POST") {
    $params = ($REQUEST_METHOD === "GET") ? $_GET : $_POST;
    $action = strtolower($params['action'] ?? '');
    $domainName = $params['domainName'] ?? '';
    if ($action) {
        switch ($action) {
            case"checkdomain":
            {
                if ($domainName) {
                    echo json_encode(DomainName::checkDomain($params), true);
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
