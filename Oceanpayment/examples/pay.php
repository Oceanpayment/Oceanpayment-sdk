<?php
require __DIR__ . '/../vendor/autoload.php';

use Oceanpayment\Oceanpayment;

$account = '995149';
$terminal = '99514901';
$key = '你的密钥';

$op = new Oceanpayment($account, $terminal, $key);

$data = [
    'noticeUrl' => 'http://www.abc.com/notice.php',
    'order_number' => 'NO12345678',
    'order_currency' => 'USD',
    'order_amount' => '0.01',
    'methods' => 'WeChatPay_Web',
    'billing_firstName' => 'Vergil',
    'billing_lastName' => 'Pan',
    'billing_email' => 'test@gmail.com',
    'billing_phone' => '13800138000',
    'billing_country' => 'US',
    'billing_state' => 'AL',
    'billing_city' => 'Washington D.C.',
    'billing_address' => '705A big Road',
    'billing_zip' => '529012',
    'billing_ip' => '127.0.0.1',
    'ship_firstName' => 'Vergil',
    'ship_lastName' => 'Pan',
    'ship_email' => 'test@gmail.com',
    'ship_phone' => '13800138000',
    'ship_country' => 'US',
    'ship_state' => 'AL',
    'ship_city' => 'Washington D.C.',
    'ship_addr' => '705A big Road',
    'ship_zip' => '529012',
    'productNum' => 1,
    'productName' => 'Red Dress',
    'productSku' => '#001',
    'productPrice' => '0.01'
];

$result = $op->pay($data);

print_r($result);
