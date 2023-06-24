<?php
/**
 * @Author: zhong
 * @Date: 2023-06-18 14-48-58
 * @LastEditors: zhong
 */

$api_keys = ['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'];

foreach ($api_keys as $api_key) {

    // 设置API密钥
//    $api_key = 'YOUR_API_KEY';
    echo '正在检查: ' . $api_key . "\n";
    // 设置请求URL和参数
    $url = 'https://api.openai.com/v1/engines/davinci-codex/completions';
    $data = array(
        'prompt' => 'Hello, my name is',
        'max_tokens' => 5,
        'temperature' => 0.5
    );

    // 发送HTTP POST请求
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Authorization: Bearer ' . $api_key
    ));
    $response = curl_exec($ch);
    curl_close($ch);

    // 解析响应并输出结果
    $result = json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    echo "响应结果: " . $result . "\n\n";
}
