<?php

namespace IP;

use Docker\Docker;
use Docker\API\Model\NetworksCreatePostBody;
use Docker\API\Model\NetworksCreatePostResponse201;
use function League\Uri\create;

require_once "../vendor/autoload.php";

class IP
{
    /**
     * 创建一个IP bridge
     *
     * @param string $name 网络名称
     * @param string $subnet 子网
     * @param string $gateway 网关
     * @return string 网络ID
     */
    /**
     * 创建一个Docker IP
     *
     * @param string $name 网络名称
     * @param string $subnet 子网
     * @param string $gateway 网关
     * @return string 网络ID
     */
    public static function createDockerIP(string $name, string $subnet, string $gateway): string
    {
        $docker = new DockerClient();
        $networkCreateOptions = [
            'Name' => $name,
            'Driver' => 'bridge',
            'IPAM' => [
                'Config' => [
                    [
                        'Subnet' => $subnet,
                        'Gateway' => $gateway
                    ]
                ]
            ]
        ];
        $network = $docker->networkCreate($networkCreateOptions);
        return $network->getId();
    }
}

IP::createDockerIP('asdsa', '192.168.0.163/24', '192.168.0.1');