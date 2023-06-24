<?php
/**
 * @Author: zhong
 * @Email: i@antx.cc
 * @Date: 2023-6-10 10:12:07
 */


use DNS\Record;

error_reporting(0);
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Origin: https://dns.console.cloud.antx.cc');
header("Content-type:application/json; charset=utf-8");
date_default_timezone_set("Asia/Shanghai");
session_set_cookie_params(0, '/', '.antx.cc');
session_start();

require_once '../../db/db.php';
require_once '../../src/Record.php';
require_once '../../autoload.php';

$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];

if ($REQUEST_METHOD === "GET" || $REQUEST_METHOD === "POST") {
    if (!getLoginStatus())  die(json_encode(['success' => false, 'code' => 'ConsoleNeedLogin', 'message' => 'You need login to use this api', 'login_url' => 'https://passport.cloud.antx.cc/login'], JSON_UNESCAPED_SLASHES));
    $params = ($REQUEST_METHOD === "GET") ? $_GET : $_POST;
    $action = strtolower($params['action'] ?? '');
    if ($action) {
        $params['action'] = '';
        $domainName = $params['domainName'] ?? '';
        $subDomain = $params['subDomain'] ?? '';
        $RR = $params['RR'] ?? '';
        $type = $params['type'] ?? '';
        $value = $params['value'] ?? '';
        $recordId = $params['recordId'] ?? '';
        $status = strtolower($params['status'] ?? '');
        switch (strtolower($action)) {
            case "adddomainrecord":
            {
                if ($domainName && $type && $value && ($RR !== '')) {
                    echo json_encode(
                        Record::addDomainRecord($params)
                    );
                } else {
                    echo json_encode(array('success' => false, "message" => 'Domain name, RR, type and value cannot be empty', 'RR' => $RR), true);
                }
                break;
            }
            case "updatedomainrecord":
            {
                if ($recordId && $type && $value && ($RR !== '')) {
                    echo json_encode(
                        Record::updateDomainRecord($params)
                    );
                } else {
                    echo json_encode(array('success' => false, "message" => 'Record Id, RR, type and value cannot be empty'), true);
                }
                break;
            }
            case "describedomainrecords":
            {
                if ($domainName) {
                    echo json_encode(
                        Record::describeDomainRecords($params)
                    );
                } else {
                    echo json_encode(array('success' => false, "message" => 'Domain name cannot be empty'), true);
                }
                break;
            }
            case "describesubdomainrecords":
            {
                if ($subDomain) {
                    echo json_encode(
                        Record::describeSubDomainRecords($params)
                    );
                } else {
                    echo json_encode(array('success' => false, "message" => 'Domain name cannot be empty'), true);
                }
                break;
            }
            case "describedomainrecordinfo":
            {
                if ($recordId) {
                    echo json_encode(
                        Record::describeDomainRecordInfo($params)
                    );
                } else {
                    echo json_encode(array('success' => false, "message" => 'Record Id cannot be empty'), true);
                }
                break;
            }
            case "deletedomainrecord":
            {
                if ($recordId) {
                    echo json_encode(
                        Record::deleteDomainRecord($params)
                    );
                } else {
                    echo json_encode(array('success' => false, "message" => 'Record Id cannot be empty'), true);
                }
                break;
            }
            case "deletesubrecord":
            {
                if (($RR !== '') && $domainName) {
                    echo json_encode(
                        Record::deleteSubDomainRecords($params)
                    );
                } else {
                    echo json_encode(array('success' => false, "message" => 'Domain name and RR cannot be empty'), true);
                }
                break;
            }
            case "updatedomainrecordremark":
            {
                if ($recordId) {
                    echo json_encode(
                        Record::updateDomainRecordRemark($params)
                    );
                } else {
                    echo json_encode(array('success' => false, "message" => 'Record Id cannot be empty'), true);
                }
                break;
            }
            case "setdomainrecordstatus":
            {
                if ($recordId && $status) {
                    if ($status === 'enable' || $status === "disable") {
                        echo json_encode(
                            Record::setDomainRecordStatus($params)
                        );
                    } else {
                        echo json_encode(array('success' => false, "message" => 'No such status'), true);
                    }
                } else {
                    echo json_encode(array('success' => false, "message" => 'Record Id and status cannot be empty'), true);
                }
                break;
            }
            case "describerecordlogs":
            {
                if ($domainName) {
                    echo json_encode(
                        Record::describeRecordLogs($params)
                    );
                } else {
                    echo json_encode(array('success' => false, "message" => 'Domain name cannot be empty'), true);
                }
                break;
            }
            case "gettextrecordforverify":
            {
                if ($domainName && $type) {
                    if (strtoupper($type) === "RETRIEVAL" || strtoupper($type) === "ADD_SUB_DOMAIN") {
                        echo json_encode(
                            Record::getTxtRecordForVerify($params)
                        );
                    } else {
                        echo json_encode(array('success' => false, "message" => 'No such type'), true);
                    }
                } else {
                    echo json_encode(array('success' => false, "message" => 'Domain name and type cannot be empty'), true);
                }
                break;
            }
            default:
            {
                echo json_encode(array('success' => false, "message" => 'No such action'), true);
                break;
            }
        }
    } else {
        echo json_encode(array('success' => false, "message" => 'Action cannot be empty'), true);
    }
} else {
    echo json_encode(array('success' => false, "message" => 'No POST or GET method'), true);
}
