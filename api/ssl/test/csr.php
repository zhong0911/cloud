<?php
function ca()
{
    $dn = array(
        "countryName" => 'CN', //所在国家名称
        "stateOrProvinceName" => 'BJ', //所在省份名称
        "localityName" => 'BJ', //所在城市名称
        "organizationName" => 'ca', //注册人姓名
        "organizationalUnitName" => 'shuai', //组织名称
        "commonName" => 'ca', //公共名称
        "emailAddress" => 'ca@a.com' //邮箱
    );
    $config = array(
        "digest_alg" => "sha256",
        "private_key_bits" => 2048, //字节数 512 1024 2048 4096 等
        "private_key_type" => OPENSSL_KEYTYPE_RSA //加密类型
    );
    $privkey = openssl_pkey_new($config);
    $csr = openssl_csr_new($dn, $privkey);
    $scert = openssl_csr_sign($csr, NULL, $privkey, 365, $config);
    openssl_pkey_export_to_file($privkey, "./private/ca3.pem", NULL, $config);
    openssl_x509_export_to_file($scert, "./ca3.crt");
    openssl_csr_export_to_file($csr, "./ca3.csr");
    var_dump($scert);
}

//ca();

//server();

//client();

function server()
{

    $dn = array(

        "countryName" => 'CN', //所在国家名称

        "stateOrProvinceName" => 'BJ', //所在省份名称

        "localityName" => 'BJ', //所在城市名称

        "organizationName" => 'server', //注册人姓名

        "organizationalUnitName" => 'shuai', //组织名称

        "commonName" => '(ip)或者啥都行', //公共名称

        "emailAddress" => 'server@a.com' //邮箱

    );

    $config = array(

        "digest_alg" => "sha256",

        "private_key_bits" => 2048, //字节数 512 1024 2048 4096 等

        "private_key_type" => OPENSSL_KEYTYPE_RSA //加密类型

    );

    $privkey = openssl_pkey_new($config);

    $csr = openssl_csr_new($dn, $privkey);

    $cacert = file_get_contents("./ca.crt");

    $private = array(file_get_contents("./private/ca.pem"), NULL);

    $scert = openssl_csr_sign($csr, $cacert, $private, 365);

    openssl_pkey_export_to_file($privkey, "./server.key", NULL);

    openssl_x509_export_to_file($scert, "./server.crt");

    openssl_csr_export_to_file($csr, "./server.csr");

    var_dump($scert);

}

function client()
{

    $dn = array(

        "countryName" => 'CN', //所在国家名称

        "stateOrProvinceName" => 'BJ', //所在省份名称

        "localityName" => 'BJ', //所在城市名称

        "organizationName" => 'client', //注册人姓名

        "organizationalUnitName" => 'shuai', //组织名称

        "commonName" => 'client', //公共名称

        "emailAddress" => 'client@a.com' //邮箱

    );

    $config = array(

        "digest_alg" => "sha256",

        "private_key_bits" => 2048, //字节数 512 1024 2048 4096 等

        "private_key_type" => OPENSSL_KEYTYPE_RSA //加密类型

    );

    $privkey = openssl_pkey_new($config);

    $csr = openssl_csr_new($dn, $privkey);

    $cacert = file_get_contents("./ca.crt");

    $private = array(file_get_contents("./private/ca.pem"), NULL);

    $scert = openssl_csr_sign($csr, $cacert, $private, 365);

    $pri = openssl_pkey_get_private($privkey);

    openssl_pkey_export_to_file($privkey, "./client.key", NULL);

    openssl_pkcs12_export_to_file($scert, "./client.p12", $pri, "111111");

    openssl_x509_export_to_file($scert, "./client.crt");

    openssl_csr_export_to_file($csr, "./client.csr");

    var_dump($scert);

}


$dn = array(
    "countryName" => 'CN',
    "stateOrProvinceName" => 'BJ',
    "localityName" => 'BJ',
    "organizationName" => 'ca',
    "organizationalUnitName" => 'shuai',
    "commonName" => 'ca',
    "emailAddress" => 'ca@a.com'
);
$config = array(
    "digest_alg" => "sha256",
    "private_key_bits" => 2048, //字节数 512 1024 2048 4096 等
    "private_key_type" => OPENSSL_KEYTYPE_RSA //加密类型
);
$privkey = openssl_pkey_new($config);
$csr = openssl_csr_new($dn, $privkey);
$scert = openssl_csr_sign($csr, NULL, $privkey, 365, $config);

openssl_pkey_export_to_file($privkey, "./ca/private/ca3.pem", NULL, $config);
openssl_x509_export_to_file($scert, "./ca/ca3.crt");
openssl_csr_export_to_file($csr, "./ca/ca3.csr");

var_dump($scert);
