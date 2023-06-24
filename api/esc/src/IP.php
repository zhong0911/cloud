<?php

namespace ESC;

require_once "../vendor/autoload.php";

class IP
{
    public static function createIP($ip, $gateway, $name): array
    {
        $cmd = "docker network create --driver bridge --subnet $ip --gateway $gateway $name > output.txt 2>&1; echo $?";
        $return_var = 0;
        exec($cmd, $output, $return_var);
        if ($return_var === 0) {
            $network_id = trim(file_get_contents("output.txt"));
            return ["success" => true, "network_id" => $network_id];
        } else {
            $error_message = trim(file_get_contents("output.txt"));
            return ["success" => false, "message" => $error_message];
        }
    }

    /**
     * 获取IP信息
     * @return array
     */
    public static function getIPInfo(): array
    {
        $cmd = "docker network inspect bridge";
        exec($cmd, $output);
        $output = implode("\n", $output);
        return json_decode($output);
    }
}


echo json_encode(IP::createIP("172.19.60.2/16", "172.19.60.1", time()) , JSON_UNESCAPED_UNICODE);

