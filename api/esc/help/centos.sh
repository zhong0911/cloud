docker network create --subnet=192.168.0.0/16 mynet
docker run -itd --name centos --cpus=2 --ip=192.168.0.2 --memory=2g --network=mynet --device-read-bps=/dev/sda:1mb --device-write-bps=/dev/sda:1mb centos:7.9.2009 /bin/bash