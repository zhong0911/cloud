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
use AlibabaCloud\SDK\Alidns\V20150109\Models\AddDomainRecordRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeRecordLogsRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DeleteDomainRecordRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\UpdateDomainRecordRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\GetTxtRecordForVerifyRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\SetDomainRecordStatusRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainRecordsRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DeleteSubDomainRecordsRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeDomainRecordInfoRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\DescribeSubDomainRecordsRequest;
use AlibabaCloud\SDK\Alidns\V20150109\Models\UpdateDomainRecordRemarkRequest;
use function Sodium\add;


class Record
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
     * @param $params
     * @return array
     */
    public static function describeDomainRecords($params): array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $describeDomainRecordsRequest = new DescribeDomainRecordsRequest($params);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode($client->describeDomainRecordsWithOptions($describeDomainRecordsRequest, $runtime), true), true);
            return array(
                'success' => true,
                'records' => $response['body']['domainRecords']['record']
            );
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
    public static function describeDomainRecordInfo($params): array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $describeDomainRecordInfoRequest = new DescribeDomainRecordInfoRequest($params);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode($client->describeDomainRecordInfoWithOptions($describeDomainRecordInfoRequest, $runtime), true), true);
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
    public static function deleteDomainRecord($params): array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $deleteDomainRecordRequest = new DeleteDomainRecordRequest($params);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode($client->deleteDomainRecordWithOptions($deleteDomainRecordRequest, $runtime), true), true);
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
    public static function addDomainRecord($params): array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $addDomainRecordRequest = new AddDomainRecordRequest($params);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode($client->addDomainRecordWithOptions($addDomainRecordRequest, $runtime), true), true);
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
    public static function deleteSubDomainRecords($params): array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $deleteSubDomainRecordsRequest = new DeleteSubDomainRecordsRequest($params);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode($client->deleteSubDomainRecordsWithOptions($deleteSubDomainRecordsRequest, $runtime), true), true);
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
    public static function updateDomainRecord($params): array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $updateDomainRecordRequest = new UpdateDomainRecordRequest($params);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode($client->updateDomainRecordWithOptions($updateDomainRecordRequest, $runtime), true), true);
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
     * @return void
     */
    public static function updateDomainRecordRemark($params): array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $updateDomainRecordRemarkRequest = new UpdateDomainRecordRemarkRequest($params);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode($client->updateDomainRecordRemarkWithOptions($updateDomainRecordRemarkRequest, $runtime), true), true);
            return [
                'success' => true,
                'info' => $response['body'],
                'remark' => $params['remark'] ?? ''
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
     * @param $param
     * @return void
     */
    public static function setDomainRecordStatus($param): array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $setDomainRecordStatusRequest = new SetDomainRecordStatusRequest($param);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode($client->setDomainRecordStatusWithOptions($setDomainRecordStatusRequest, $runtime), true), true);
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
    public static function describeRecordLogs($params): array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $describeRecordLogsRequest = new DescribeRecordLogsRequest($params);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode($client->describeRecordLogsWithOptions($describeRecordLogsRequest, $runtime), true), true);
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
     * @return void
     */
    public static function describeSubDomainRecords($params): array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $describeSubDomainRecordsRequest = new DescribeSubDomainRecordsRequest($params);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode($client->describeSubDomainRecordsWithOptions($describeSubDomainRecordsRequest, $runtime), true), true);
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
    public static function getTxtRecordForVerify($params): array
    {
        $client = self::createClient(getenv("ALIBABA_CLOUD_ACCESS_KEY_ID"), getenv('ALIBABA_CLOUD_ACCESS_KEY_SECRET'));
        $getTxtRecordForVerifyRequest = new GetTxtRecordForVerifyRequest($params);
        $runtime = new RuntimeOptions([]);
        try {
            $response = json_decode(json_encode($client->getTxtRecordForVerifyWithOptions($getTxtRecordForVerifyRequest, $runtime), true), true);
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
