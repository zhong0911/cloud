<?php
/**
 * @Author: zhong
 * @Date: 2023-06-19 15-16-37
 * @LastEditors: zhong
 */

function getLoginStatus(): bool
{
    $username = $_SESSION['username'] ?? '';
    $password = $_SESSION['password'] ?? '';
    $conn = mysqli_connect("mysql.db.antx.cc", "root", getenv('ANTX_MYSQL_PASSWORD'), "antxcloud");
    $result = mysqli_query($conn, "select password from account where username='$username'");
    $row = mysqli_fetch_array($result);
    return ($row && $password === $row['password']);
}
