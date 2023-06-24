<?php
/**
 * @Author: zhong
 * @Email: i@antx.cc
 * @Date: 2023-6-10 10:12:07
 */

namespace DNS;

class Query
{
    public static function getRecords($params): array
    {
        $domainName = $params['domainName'] ?? $params['domain'] ?? '';
        if ($domainName) {
            $type = $params['type'];
            $dns_type = null;
            if ($type) {
                switch ($type) {
                    case "A":
                        $dns_type = DNS_A;
                        break;
                    case "AAAA":
                        $dns_type = DNS_AAAA;
                        break;
                    case "NS":
                        $dns_type = DNS_NS;
                        break;
                    case "TXT":
                        $dns_type = DNS_TXT;
                        break;
                    case "ALL":
                        $dns_type = DNS_ALL;
                        break;
                    case "CAA":
                        $dns_type = DNS_CAA;
                        break;
                    case "SRV":
                        $dns_type = DNS_SRV;
                        break;
                    case "MX":
                        $dns_type = DNS_MX;
                        break;
                    default:
                    {
                        return ['success' => false, 'message' => "Type does not exist"];
                    }
                }
            } else {
                $dns_type = DNS_ALL;
            }
            $records = dns_get_record($domainName, $dns_type);
            $result = [];
            foreach ($records as $record) {
                $result[] = $record;
            }
            return ['success' => true, 'records' => $result];
        } else {
            return ['success' => false, 'message' => "Domain name cannot br empty"];
        }
    }
}
