<?php
namespace Oceanpayment;

use GuzzleHttp\Client;

class Oceanpayment
{
    private string $account;
    private string $terminal;
    private string $key; // API 密钥
    private string $endpoint;
    private Client $client;

    public function __construct(string $account, string $terminal, string $key, string $endpoint = 'https://secure.oceanpayment.com/gateway/directservice/pay')
    {
        $this->account = $account;
        $this->terminal = $terminal;
        $this->key = $key;
        $this->endpoint = $endpoint;
        $this->client = new Client([
            'timeout' => 10,
        ]);
    }

    /**
     * 生成支付签名
     * OceanPayment 官方推荐按 key 排序拼接，末尾加密钥，再 SHA256
     */
    public function generateSign(array $params): string
    {
        // 移除已有签名字段
        unset($params['signValue']);

        // 按字母顺序排序
        ksort($params);

        // 拼接 key=value
        $stringToSign = '';
        foreach ($params as $k => $v) {
            $stringToSign .= "$k=$v";
        }

        // 拼接密钥
        $stringToSign .= $this->key;

        return hash('sha256', $stringToSign);
    }

    /**
     * 发起支付
     */
    public function pay(array $data): array
    {
        // 必填字段
        $data['account'] = $this->account;
        $data['terminal'] = $this->terminal;

        // 生成签名
        $data['signValue'] = $this->generateSign($data);

        try {
            $response = $this->client->post($this->endpoint, [
                'form_params' => $data
            ]);

            $body = (string) $response->getBody();

            // OceanPayment 返回一般是 query string 格式
            parse_str($body, $result);

            return $result;
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

    /**
     * 验证回调签名
     */
    public function verifyCallback(array $data): bool
    {
        if (!isset($data['signValue'])) {
            return false;
        }

        $sign = $data['signValue'];
        $generated = $this->generateSign($data);

        return strtolower($sign) === strtolower($generated);
    }
}
