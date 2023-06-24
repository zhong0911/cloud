<?php
$dn = array(
    "country_name" => 'CN',
    "state_or_province_name" => 'BJ',
    "locality_name" => 'BJ',
    "organization_name" => 'ca',
    "organizational_unit_name" => 'shuai',
    "common_name" => 'ca',
    "email_address" => 'ca@a.com'
);
$config = array(
    "digest_alg" => "sha256",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
);
echo json_encode($config);
//
//
//foreach ($dn as $k => $v) {
//    //        if ($private_key_type == '') return ['success' => false, 'message' => 'Private key type cannot be empty'];
//    $str="if (\$$k == '') return ['success' => false, 'message' => '$k cannot be empty'];\n";
////    $str="\$$k=\$params['$k']??'';\n";
//    echo $str;
//}
//
//
//
//public static function gen($params): array
//{
//    $config = json_decode($params['config']) ?? '';
//    $distinguished_names = json_decode($params['config']) ?? '';
//    $digest_alg = $params['digest_alg'] ?? '';
//    $private_key_bits = $params['private_key_bits'] ?? '';
//    $private_key_type = $params['private_key_type'] ?? '';
//    $common_name = $distinguished_names['common_name'] ?? '';
//    $country_name = $distinguished_names['country_name'] ?? '';
//    $email_address = $distinguished_names['email_address'] ?? '';
//    $locality_name = $distinguished_names['locality_name'] ?? '';
//    $organization_name = $distinguished_names['organization_name'] ?? '';
//    $state_or_province_name = $distinguished_names['state_or_province_name'] ?? '';
//    $organizational_unit_name = $distinguished_names['organizational_unit_name'] ?? '';
//    if ($config == '') return ['success' => false, 'message' => 'Config cannot be empty'];
//    if ($digest_alg == '') return ['success' => false, 'message' => 'Digest algorithm cannot be empty'];
//    if ($private_key_bits == '') return ['success' => false, 'message' => 'Private key bits cannot be empty'];
//    if ($private_key_type == '') return ['success' => false, 'message' => 'Private key type cannot be empty'];
//    if ($country_name == '') return ['success' => false, 'message' => 'Country name cannot be empty'];
//    if ($state_or_province_name == '') return ['success' => false, 'message' => 'State or province name cannot be empty'];
//    if ($locality_name == '') return ['success' => false, 'message' => 'Locality name cannot be empty'];
//    if ($organization_name == '') return ['success' => false, 'message' => 'Organization name cannot be empty'];
//    if ($organizational_unit_name == '') return ['success' => false, 'message' => 'Organizational unit name cannot be empty'];
//    if ($common_name == '') return ['success' => false, 'message' => 'Common name cannot be empty'];
//    if ($email_address == '') return ['success' => false, 'message' => 'Email address cannot be empty'];
//    return ['success' => true, 'message' => 'Generated successfully', 'distinguished_names' => '$distinguished_names', 'config' => $config];
//}
//public static function gedn($params): array
//{
//    $config = json_decode($params['config']) ?? '';
//    $dn = json_decode($params['distinguished_names']) ?? '';
//    $digest_alg = $params['digest_alg'] ?? '';
//    $private_key_bits = $params['private_key_bits'] ?? '';
//    $private_key_type = $params['private_key_type'] ?? '';
//    $common_name = $dn->common_name ?? '';
//    $country_name = $dn->country_name ?? '';
//    $email_address = $dn->email_address ?? '';
//    $locality_name = $dn->locality_name ?? '';
//    $organization_name = $dn->organization_name ?? '';
//    $state_or_province_name = $dn->state_or_province_name ?? '';
//    $organizational_unit_name = $dn->organizational_unit_name ?? '';
//
//    if ($config == '') return ['success' => false, 'message' => 'Config cannot be empty'];
//    if ($digest_alg == '') return ['success' => false, 'message' => 'Digest algorithm cannot be empty'];
//    if ($private_key_bits == '') return ['success' => false, 'message' => 'Private key bits cannot be empty'];
//    if ($private_key_type == '') return ['success' => false, 'message' => 'Private key type cannot be empty'];
//    if ($country_name == '') return ['success' => false, 'message' => 'Country name cannot be empty'];
//    if ($state_or_province_name == '') return ['success' => false, 'message' => 'State or province name cannot be empty'];
//    if ($locality_name == '') return ['success' => false, 'message' => 'Locality name cannot be empty'];
//    if ($organization_name == '') return ['success' => false, 'message' => 'Organization name cannot be empty'];
//    if ($organizational_unit_name == '') return ['success' => false, 'message' => 'Organizational unit name cannot be empty'];
//    if ($common_name == '') return ['success' => false, 'message' => 'Common name cannot be empty'];
//
//    // Generate private key
//    $private_key = openssl_pkey_new([
//        'private_key_bits' => $private_key_bits,
//        'private_key_type' => $private_key_type,
//    ]);
//
//    // Generate CSR
//    $csr = openssl_csr_new([
//        "country_name" => $country_name,
//        "stateOrProvince_name" => $state_or_province_name,
//        "locality_name" => $locality_name,
//        "organization_name" => $organization_name,
//        "organizationalUnit_name" => $organizational_unit_name,
//        "common_name" => $common_name,
//        "emailAddress" => $email_address,
//    ], $private_key, [
//        'digest_alg' => $digest_alg,
//        'config' => $config,
//    ]);
//
//    // Get CSR and private key
//    openssl_csr_export($csr, $csr_out);
//    openssl_pkey_export($private_key, $private_key_out);
//
//    return [
//        'success' => true,
//        'csr' => $csr_out,
//        'private_key' => $private_key_out,
//    ];
//}
///**
// * @param $type
// * @return int|null
// */
//private
//static function getPrivateKeyType($type): ?int
//{
//    switch (strtoupper($type)) {
//        case "DSA":
//        {
//            $type = OPE_nSSL_KEYTYPE_DSA;
//            break;
//        }
//        case "EC":
//        {
//            $type = OPE_nSSL_KEYTYPE_EC;
//            break;
//        }
//        case "DH":
//        {
//            $type = OPE_nSSL_KEYTYPE_DH;
//            break;
//        }
//        case "RSA":
//        {
//            $type = OPE_nSSL_KEYTYPE_RSA;
//            break;
//        }
//        default:
//        {
//            $type = null;
//        }
//    }
//    return $type;
//}
