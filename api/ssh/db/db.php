<?php

function addConnectionRecord($host, $port, $username, $password, $public_key, $private_key, $passphrase, $time, $reason, $result): bool
{
    return insertData("insert into connection_records (id, host, port, username, password, public_key, private_key, passphrase, time, result, reason) values (default, '$host', $port, '$username', '$password', '$public_key', '$private_key', '$passphrase', '$time', '$result', '$reason')");
}


function queryAccountData($sql): array
{
    $conn = mysqli_connect("mysql.db.antx.cc", "root", getenv('ANTX_MYSQL_PASSWORD'), "antxcloud_ssh");
    $result = mysqli_query($conn, $sql);
    $res = "";
    while ($row = mysqli_fetch_array($result)) {
        $res = $row;
    }
    $conn->close();
    return $res;
}


function insertData($sql): bool
{
    $conn = mysqli_connect("mysql.db.antx.cc", "root", getenv('ANTX_MYSQL_PASSWORD'), "antxcloud_ssh");
    $res = false;
    if ($conn->query($sql) === TRUE) {
        $res = true;
    }
    $conn->close();
    return $res;
}
