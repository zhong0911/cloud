<?php
/**
 * @Author: zhong
 * @Date: 2023-06-18 10-51-01
 * @LastEditors: zhong
 */

$connection = ssh2_connect('s5.antx.cc', 22);
if (!$connection) {
    die('Unable to connect to SSH server');
}

if (!ssh2_auth_password($connection, 'root', 'zjh0911Linux')) {
    die('Unable to authenticate with SSH server');
}
$stream = ssh2_exec($connection, 'ls');
if (!$stream) {
    die('Unable to execute command');
}
stream_set_blocking($stream, true);
$output = stream_get_contents($stream);
fclose($stream);
ssh2_disconnect($connection);

echo $output;
