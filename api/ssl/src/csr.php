<?php

namespace SSL;

class csr
{
    public static array $digest_algorithms = ["SHA1", "SHA224", "SHA256", "SHA384", "SHA512"];
    public static array $private_key_types = ["RSA", "DSA", "DH", "EC"];

    /**
     * @param array $params
     * @return array
     */
    public static function generateCSR(array $params): array
    {
        $uid = $_SESSION['uid'] ?? '';
        $csr_name = $params['csr_name'] ?? '';
        $config = isset($params['config']) ? json_decode($params['config'], true) : null;
        $dn = isset($params['distinguished_names']) ? json_decode($params['distinguished_names'], true) : null;
        $digest_alg = $config['digest_alg'] ?? '';
        $private_key_bits = $config['private_key_bits'] ?? '';
        $private_key_type = $config['private_key_type'] ?? '';
        $common_name = $dn['common_name'] ?? '';
        $country_name = $dn['country_name'] ?? '';
        $email_address = $dn['email_address'] ?? '.';
        $locality_name = $dn['locality_name'] ?? '';
        $organization_name = $dn['organization_name'] ?? '';
        $state_or_province_name = $dn['state_or_province_name'] ?? '';
        $organizational_unit_name = $dn['organizational_unit_name'] ?? '';

        if (empty($config)) return ['success' => false, 'message' => 'Config cannot be empty'];
        if (empty($dn)) return ['success' => false, 'message' => 'Distinguished names cannot be empty'];
        if ($digest_alg == '') return ['success' => false, 'message' => 'Digest algorithm cannot be empty'];
        if ($private_key_bits == '') return ['success' => false, 'message' => 'Private key bits cannot be empty'];
        if ($private_key_type == '') return ['success' => false, 'message' => 'Private key type cannot be empty'];
        if ($country_name == '') return ['success' => false, 'message' => 'Country name cannot be empty'];
        if ($state_or_province_name == '') return ['success' => false, 'message' => 'State or province name cannot be empty'];
        if ($locality_name == '') return ['success' => false, 'message' => 'Locality name cannot be empty'];
        if ($organization_name == '') return ['success' => false, 'message' => 'Organization name cannot be empty'];
        if ($organizational_unit_name == '') return ['success' => false, 'message' => 'Organizational unit name cannot be empty'];
        if ($common_name == '') return ['success' => false, 'message' => 'Common name cannot be empty'];
        if (!in_array(strtoupper($digest_alg), self::$digest_algorithms)) return ['success' => false, 'message' => 'No such digest algorithm'];
        if (!in_array(strtoupper($private_key_type), self::$private_key_types)) return ['success' => false, 'message' => 'No such Private key type'];

        $res = openssl_pkey_new([
            'digest_alg' => $digest_alg,
            'private_key_bits' => $private_key_bits,
            'private_key_type' => constant('OPENSSL_KEYTYPE_' . strtoupper($private_key_type))
        ]);
        if (!$res) return [
            'success' => false,
            'message' => 'Failed to generate private key', 'reason' => openssl_error_string()
        ];

        openssl_pkey_export($res, $private_key);
        $csr_config = [
            "countryName" => $country_name,
            "stateOrProvinceName" => $state_or_province_name,
            "localityName" => $locality_name,
            "organizationName" => $organization_name,
            "organizationalUnitName" => $organizational_unit_name,
            "commonName" => $common_name,
            "emailAddress" => $email_address
        ];

        $csr = openssl_csr_new($csr_config, $res, $config);
        if (!$csr) return [
            'success' => false,
            'message' => 'Failed to generate CSR', 'reason' => openssl_error_string()
        ];

        openssl_csr_export($csr, $csr_out);
        addGenerateCSRRecord($uid, $csr_name, date('Y-m-d H:i:s'), $digest_alg, $private_key_type, $private_key_bits, $country_name, $state_or_province_name, $locality_name, $organization_name, $organizational_unit_name, $common_name, $email_address, $csr_out, $private_key);
        return [
            'success' => true,
            'private_key' => $private_key,
            'csr' => $csr_out
        ];
    }


    /**
     * @param array $params
     * @return array
     */
    public static function describeCSRRecords(array $params): array
    {
        $uid = $_SESSION['uid'];
        if ($uid == '') return ['success' => false, 'message' => 'UID cannot be empty'];
        return ['success' => true, 'message' => 'Queried succeeded', 'records' => queryCSRRecords($uid)];
    }

    /**
     * @param array $params
     * @return array
     */
    public static function describeCSRRecordInfo(array $params): array
    {
        $uid = $_SESSION['uid'];
        $csr_id = $params['csr_id'];
        if ($uid == '') return ['success' => false, 'message' => 'UID cannot be empty'];
        if (queryCSRRecordUid($csr_id) != $uid) return ['success' => false, 'message' => "This CSR isn't yours"];
        else  return ['success' => true, 'message' => 'Queried succeeded', 'info' => queryCSRRecordInfo($csr_id)];
    }
}

