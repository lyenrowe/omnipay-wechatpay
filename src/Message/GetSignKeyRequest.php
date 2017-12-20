<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\Common\Message\ResponseInterface;
use Omnipay\WechatPay\Helper;

/**
 * Class CreateOrderRequest
 *
 * @package Omnipay\WechatPay\Message
 * @link    https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_1
 * @method  CreateOrderResponse send()
 */
class GetSignKeyRequest extends BaseAbstractRequest
{
    //real url https://api.mch.weixin.qq.com/sandboxnew/pay/getsignkey
    protected $endpoint = 'https://api.mch.weixin.qq.com/pay/getsignkey';


    /**
     * Get the raw data array for this message. The format of this varies from gateway to
     * gateway, but will usually be either an associative array, or a SimpleXMLElement.
     *
     * @return mixed
     */
    public function getData()
    {
        $this->validate(
            'mch_id'
        );

        $tradeType = strtoupper($this->getTradeType());

        if ($tradeType == 'JSAPI') {
            $this->validate('open_id');
        }

        $data = [
            'mch_id'           => $this->getMchId(),
            'nonce_str'        => md5(uniqid()),//*
        ];

        $data = array_filter($data);

        $data['sign'] = Helper::sign($data, $this->getApiKey());

        return $data;
    }

    /**
     * Send the request with specified data
     *
     * @param  mixed $data The data to send
     *
     * @return ResponseInterface
     */
    public function sendData($data)
    {
        $responseData = $this->post($data);

        return $this->response = new GetSignKeyResponse($this, $responseData);
    }
}
