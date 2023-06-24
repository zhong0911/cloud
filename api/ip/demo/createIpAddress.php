<?php
/**
 * @Author: zhong
 * @Date: 2023-06-22 14-19-10
 * @LastEditors: zhong
 */

$ip = "192.168.1.188";
$command = "docker network create --subnet=$ip/24 $ip";
$output = array();
exec($command, $output);
$result = implode("\n", $output);
echo $result;