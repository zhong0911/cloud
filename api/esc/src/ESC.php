<?php
/**
 * @Author: zhong
 * @Date: 2023-06-22 16-26-16
 * @LastEditors: zhong
 */

namespace ESC;


class ESC
{
    public static function createSystem($image, $name)
    {
        exec("docker run -itd --name $name $image");
    }
}


ESC::createSystem('centos:7.9.2009', '000');