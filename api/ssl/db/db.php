<?php

function addGenerateCSRRecord($uid, $csr_name, $generation_time, $digest_alg, $private_key_type, $private_key_bits, $country_name, $state_or_province_name, $locality_name, $organization_name, $organizational_unit_name, $common_name, $email_address, $csr, $private_key): bool
{
    return insertData("
    insert into generate_csr_records
    (id, uid,name, generation_time, digest_alg, private_key_type, private_key_bits, country_name, state_or_province_name, locality_name, organization_name, organizational_unit_name, common_name, email_address, csr, private_key)
    values (default, '$uid','$csr_name', '$generation_time', '$digest_alg', '$private_key_type', '$private_key_bits', '$country_name', '$state_or_province_name', '$locality_name', '$organization_name', '$organizational_unit_name', '$common_name', '$email_address', '$csr', '$private_key')
    ");
}

function queryCSRRecords($uid): array
{
    return queryAccountData("select * from generate_csr_records where uid='$uid'");
}

function queryCSRRecordInfo($id): array
{
    return queryAccountData("select * from generate_csr_records where id=$id");
}

function queryCSRRecordUid($id): string
{
    return queryAccountData("select * from generate_csr_records where id=$id")[0]['uid'];
}

function queryAccountData($sql): array
{
    $conn = mysqli_connect("mysql.db.antx.cc", "root", getenv('ANTX_MYSQL_PASSWORD'), "antxcloud_ssl");
    $result = mysqli_query($conn, $sql);
    $res = array();
    while ($row = mysqli_fetch_array($result)) {
        $res[] = $row;
    }
    $conn->close();
    return $res;
}


function insertData($sql): bool
{
    $conn = mysqli_connect("mysql.db.antx.cc", "root", getenv('ANTX_MYSQL_PASSWORD'), "antxcloud_ssl");
    $res = false;
    if ($conn->query($sql) === TRUE) {
        $res = true;
    }
    $conn->close();
    return $res;
}


function getLoginStatus(): bool
{
    $username = $_SESSION['username'] ?? '';
    $password = $_SESSION['password'] ?? '';
    $conn = mysqli_connect("mysql.db.antx.cc", "root", getenv('ANTX_MYSQL_PASSWORD'), "antxcloud");
    $result = mysqli_query($conn, "select password from account where username='$username'");
    $row = mysqli_fetch_array($result);
    return ($row && $password === $row['password']);
}
