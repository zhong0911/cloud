<?php
/**
 * @Author: zhong
 * @Email: i@antx.cc
 * @Date: 2023-5-26 10:12:07
 */

namespace DNS;

use Exception;
use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\SDK\Alidns\V20150109\Alidns;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeSupportLinesRequest;

class Line
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
            // 必填，您的 AccessKey Secret
            "accessKeySecret" => $accessKeySecret
        ]);
        $config->endpoint = "alidns.cn-hangzhou.aliyuncs.com";
        return new Alidns($config);
    }

    /**
     * @param $params
     * @return array
     */
    public static function describeSupportLines($params): array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $describeSupportLinesRequest = new DescribeSupportLinesRequest($params);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode($client->describeSupportLinesWithOptions($describeSupportLinesRequest, $runtime), true), true);
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
