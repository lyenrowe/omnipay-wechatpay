<?php

namespace Omnipay\WechatPay;

/**
 * 小程序支付
 * Class LiteGateway
 * @package Omnipay\WechatPay
 */
class LiteGateway extends BaseAbstractGateway
{
    public function getName()
    {
        return 'WechatPay Lite';
    }


    public function getTradeType()
    {
        return 'JSAPI';
    }
}
