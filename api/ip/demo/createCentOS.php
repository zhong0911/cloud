<?php
/**
 * @Author: zhong
 * @Date: 2023-06-22 15-08-12
 * @LastEditors: zhong
 */
exec('docker run -it --cpus=2 --ip=192.168.0.188 --memory=2g --storage-opt size=50G --network=bridge --name=mycontainer centos:7.9.2009');