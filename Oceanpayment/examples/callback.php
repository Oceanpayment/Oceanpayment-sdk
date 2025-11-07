<?php
require __DIR__ . '/../vendor/autoload.php';

use Oceanpayment\Oceanpayment;

// 初始化 SDK
$op = new Oceanpayment('995149', '99514901', '你的密钥');

// 假设接收到 POST 数据
$callbackData = $_POST;

if ($op->verifyCallback($callbackData)) {
    // 签名正确，处理业务逻辑
    $orderNumber = $callbackData['order_number'] ?? '';
    $status = $callbackData['order_status'] ?? '';

    // TODO: 更新订单状态
    echo "SUCCESS";
} else {
    // 签名错误
    echo "FAIL";
}
