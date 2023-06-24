<?php
/**
 * @Author: zhong
 * @Email: i@antx.cc
 * @Date: 2023-5-26 10:12:07
 */

namespace DNS;

use AlibabaCloud\SDK\Alidns\V20150109\Models\DeleteDomainRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainsRequest;
use Exception;
use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Alidns\V20150109\Alidns;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use AlibabaCloud\SDK\Alidns\V20150109\Models\AddDomainRequest;


class Domain
{

    /**
     * 使用AK&SK初始化账号Client
     * @param string $accessKeyId
     * @param string $accessKeySecret
     * @return Alidns Client
     */
    public static function createClient(string $accessKeyId, string $accessKeySecret): Alidns
    {
        $config = new Config([
            "accessKeyId" => $accessKeyId,
            "accessKeySecret" => $accessKeySecret
        ]);
        $config->endpoint = "alidns.cn-hangzhou.aliyuncs.com";
        return new Alidns($config);
    }


    /**
     * @param $param
     * @return array
     */
    public static function addDomain($params): array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $addDomainRequest = new AddDomainRequest($params);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode($client->addDomainWithOptions($addDomainRequest, $runtime), true), true);
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

    /**
     * @param $params
     * @return array
     */
    public static function describeDomains($params): array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $describeDomainsRequest = new DescribeDomainsRequest($params);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode($client->describeDomainsWithOptions($describeDomainsRequest, $runtime), true), true);
            return [
                'success' => true,
                'domains' => $response['body']['domains']['domain']
            ];
        } catch (Exception $error) {
            return [
                'success' => false,
                'code' => $error->getCode(),
                'message' => $error->getMessage()
            ];
        }
    }


    /**
     * @param $params
     * @return array
     */
    public static function deleteDomain($params): array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $deleteDomainRequest = new DeleteDomainRequest($params);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode($client->deleteDomainWithOptions($deleteDomainRequest, $runtime), true), true);
        return [
            'success' => true,
            'domains' => $response['body']['domains']['domain']
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
