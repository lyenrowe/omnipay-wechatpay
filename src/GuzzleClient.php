<?php

namespace Omnipay\WechatPay;

use Omnipay\Common\Http\Client as HttpClient;
use Http\Adapter\Guzzle6\Client;

/**
 * an adapter to guzzle6 http client adapter in omnipay
 * guzzle make http query easy
 * httplug make psr standard on http client
 * omnipay use httplug
 * we fit it
 *
 * @package Omnipay\WechatPay
 */
class GuzzleClient extends HttpClient
{
    public function __construct(array $config)
    {
        $client = Client::createWithConfig($config);
        parent::__construct($client);
    }
}
