<?php

namespace Omnipay\WechatPay;

use Omnipay\Common\Http\Client;

/**
 * Class PosGateway
 *
 * @package Omnipay\WechatPay
 */
class GuzzleClient extends Client
{
    public function __construct(array $config)
    {
        $client = \Http\Adapter\Guzzle6\Client::createWithConfig($config);
        parent::__construct($client);
    }
}
