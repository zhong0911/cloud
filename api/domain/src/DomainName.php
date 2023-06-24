<?php
/**
 * @Author: zhong
 * @Email: i@antx.cc
 * @Date: 2023-5-26 10:12:07
 */

namespace DomainName;

use Exception;
use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Domain\V20180129\Domain;
use AlibabaCloud\SDK\Domain\V20180129\Models\CheckDomainRequest;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;


class DomainName
{
    /**
     * 使用AK&SK初始化账号Client
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @return Domain Client
     */
    public static function createClient(string $accessKeyId, string $accessKeySecret): Domain
    {
        $config = new Config([
            // 必填，您的 AccessKey ID
            "accessKeyId" => $accessKeyId,
            // 必填，您的 AccessKey Secret
            "accessKeySecret" => $accessKeySecret
        ]);
        // 访问的域名
        $config->endpoint = "domain.aliyuncs.com";
        return new Domain($config);
    }

    /**
     * @param $params
     * @return void
     */
    public static function checkDomain($params):array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $checkDomainRequest = new CheckDomainRequest($params);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode( $client->checkDomainWithOptions($checkDomainRequest, $runtime), true), true);
            return [
                'success' => true,
                'info' => $response['body']
            ];
        } catch (Exception $error) {
            return [
                'success' => false,
                'code' => $error->getCode(),
                'message' => $error->getMessage()
            ];
        }
    }
}


