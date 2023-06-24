<?php

/**
 * @Author: zhong
 * @Date: 2023-06-18 10-42-00
 * @LastEditors: zhong
 */

namespace SSH;

class ssh
{

    /**
     * 检查密码是否正确
     * @param array $params
     * @return void
     */
    public static function checkPassword(array $params): array
    {
        $host = $params['host'] ?? $params['hostname'] ?? '';
        $port = $params['port'] ?? '22';
        $username = $params['username'] ?? $params['user'] ?? '';
        $password = $params['password'] ?? $params['pass'] ?? '';
        if ($host !== '') {
            if (0 <= $port && $port <= 65535) {
                if ($username !== '') {
                    if ($password !== '') {
                        $connection = ssh2_connect($host, $port);
                        if ($connection) {
                            if (ssh2_auth_password($connection, $username, $password)) {
                                addConnectionRecord($host, $port, $username, $password, '', '', '', date('Y-m-d H:i:s'), 'check password', 'Connected successfully');
                                return ['success' => true, 'message' => 'Connected successfully'];
                            } else {
                                addConnectionRecord($host, $port, $username, $password, '', '', date('Y-m-d H:i:s'), '', 'check password', 'Permission denied');
                                return ['success' => false, 'message' => "Permission denied"];
                            }
                        } else {
                            addConnectionRecord($host, $port, $username, $password, '', '', '', date('Y-m-d H:i:s'), 'check password', 'Connection timed out');
                            return ['success' => false, 'message' => "Connect to host $host port $port: Connection timed out"];
                        }
                    } else {
                        return ['success' => false, 'message' => 'Password cannot be empty'];
                    }
                } else {
                    return ['success' => false, 'message' => 'Username cannot be empty'];
                }
            } else {
                return ['success' => false, 'message' => 'Port format error'];
            }
        } else {
            return ['success' => false, 'message' => 'Hostname cannot be empty'];
        }
    }


    /**
     * 连接主机并执行命令并返回
     * @param array $params
     * @return array
     */
    public static function executeCommand(array $params): array
    {
        $host = $params['host'] ?? $params['hostname'] ?? '';
        $port = $params['port'] ?? '22';
        $username = $params['username'] ?? $params['user'] ?? '';
        $password = $params['password'] ?? $params['pass'] ?? '';
        if ($host !== '') {
            if (0 <= $port && $port <= 65535) {
                if ($username !== '') {
                    if ($password !== '') {
                        $connection = ssh2_connect($host, $port);
                        if ($connection) {
                            if (ssh2_auth_password($connection, $username, $password)) {
                                addConnectionRecord($host, $port, $username, $password, '', '', '', date('Y-m-d H:i:s'), 'check password', 'Connected successfully');
                                $command = $params['command'] ?? $params['cmd'] ?? '';
                                if ($command === "" || $command === null) return ['success' => false, 'message' => 'Command cannot be empty'];
                                $stream = ssh2_exec($connection, $command);
                                if (!$stream) return ['success' => false, 'message' => 'Unable to execute command'];
                                stream_set_blocking($stream, true);
                                $output = stream_get_contents($stream);
                                fclose($stream);
                                ssh2_disconnect($connection);
                                return ['success' => true, 'message' => 'Executed successfully', 'command' => $command, 'output' => $output];
                            } else {
                                addConnectionRecord($host, $port, $username, $password, '', '', date('Y-m-d H:i:s'), '', 'check password', 'Permission denied');
                                return ['success' => false, 'message' => "Permission denied"];
                            }
                        } else {
                            addConnectionRecord($host, $port, $username, $password, '', '', '', date('Y-m-d H:i:s'), 'check password', 'Connection timed out');
                            return ['success' => false, 'message' => "Connect to host $host port $port: Connection timed out"];
                        }
                    } else {
                        return ['success' => false, 'message' => 'Password cannot be empty'];
                    }
                } else {
                    return ['success' => false, 'message' => 'Username cannot be empty'];
                }
            } else {
                return ['success' => false, 'message' => 'Port format error'];
            }
        } else {
            return ['success' => false, 'message' => 'Hostname cannot be empty'];
        }
    }
}


//echo json_encode(ssh::executeCommand(['host' => 's5.antx.cc', 'user' => 'root', 'pass' => 'zjh0911Linux']));

