<?php
/**
 * @Author: zhong
 * @Date: 2023-06-21 21-12-54
 * @LastEditors: zhong
 */


// 定义变量
$containerName = "centos";
$imageName = "centos:7.9.2009";
$ipAddress = "192.168.88.88";
$dnsServer = "8.8.8.8";
$sshPort = 22;
$cpuShares = 512;
$diskSize = "10G";
$password = "zjh0911Linux";

// 构建Docker命令
$dockerCommand = "docker run -d --name $containerName --ip $ipAddress --dns $dnsServer -p $sshPort:22 --cpu-shares $cpuShares --memory 512m --memory-swap 512m --memory-swappiness 0 --restart always -v /data:/data -e PASSWORD=$password $imageName";

// 执行Docker命令
exec($dockerCommand);