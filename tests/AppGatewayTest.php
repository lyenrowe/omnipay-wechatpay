<?php

namespace Omnipay\WechatPay\Tests;

use Omnipay\Common\Http\Client;
use Omnipay\Omnipay;
use Omnipay\Tests\TestCase;
use Omnipay\WechatPay\AppGateway;
use Omnipay\WechatPay\Message\CloseOrderResponse;
use Omnipay\WechatPay\Message\CompletePurchaseResponse;
use Omnipay\WechatPay\Message\CreateOrderRequest;
use Omnipay\WechatPay\Message\CreateOrderResponse;
use Omnipay\WechatPay\Message\QueryOrderResponse;
use Omnipay\WechatPay\Message\RefundOrderResponse;
use Symfony\Component\HttpFoundation\Request;

class AppGatewayTest extends TestCase
{

    /**
     * @var AppGateway $gateway
     */
    protected $gateway;

    protected $options;

    protected $fuckTimeout = false;


    public function setUp()
    {
        $this->gateway = new AppGateway();
        $this->options = [
            'app_id' => '123456789',
            'mch_id' => '123456789',
            'api_key' => 'XXSXXXSXXSXXSX',
        ];
        $this->gateway->initialize($this->options);
    }

    public function testEnv()
    {
        $client = new \Http\Adapter\Guzzle6\Client();
        $request = new Request();
        $req  = new CreateOrderRequest($client, $request);
        $link = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
        $this->assertEquals($link, $req->getEndpoint());
        $req  = new CreateOrderRequest($client, $request);
        $req->setEnv('sandbox');
        $link2 = 'https://api.mch.weixin.qq.com/sandboxnew/pay/unifiedorder';
        $this->assertEquals($link2, $req->getEndpoint());
        $req->setEnv('nothing');
        $this->assertEquals($link, $req->getEndpoint());
    }

    public function testParams()
    {
        $this->assertEquals($this->options['app_id'], $this->gateway->getAppId());
        $this->assertEquals($this->options['api_key'], $this->gateway->getApiKey());
        $this->assertEquals($this->options['mch_id'], $this->gateway->getMchId());
        $this->assertEquals('', $this->gateway->getCurrency());
        $this->assertEquals('WechatPay App', $this->gateway->getName());
        $this->assertEquals('APP', $this->gateway->getTradeType());
    }

    public function testPurchase()
    {
        if ($this->fuckTimeout) {
            return;
        }

        $order = array(
            'notify_url' => 'http://example.com/notify',
            'trade_type' => 'APP',
            'body'             => 'test', //body
            'out_trade_no'     => date('YmdHis'), //order no
            'total_fee'        => '0.01', // money
            'spbill_create_ip' => '114.119.110.120', //Order client IP
        );

        /**
         * @var CreateOrderResponse $response
         */
        $response = $this->gateway->purchase($order)->send();
        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
    }


    public function testCompletePurchase()
    {
        if ($this->fuckTimeout) {
            return;
        }

        $options = array(
            'request_params' => array(
                'result_code' => 'SUCCESS'
            ),
        );

        /**
         * @var CompletePurchaseResponse $response
         */
        $response = $this->gateway->completePurchase($options)->send();
        $this->assertFalse($response->isSuccessful());
    }


    public function testQuery()
    {
        if ($this->fuckTimeout) {
            return;
        }

        $options = array(
            'transaction_id' => '3474813271258769001041842579301293446',
        );

        /**
         * @var QueryOrderResponse $response
         */
        $response = $this->gateway->query($options)->send();
        $this->assertFalse($response->isSuccessful());
    }


    public function testClose()
    {
        if ($this->fuckTimeout) {
            return;
        }

        $options = array(
            'out_trade_no' => '1234567891023',
        );

        /**
         * @var CloseOrderResponse $response
         */
        $response = $this->gateway->query($options)->send();
        $this->assertFalse($response->isSuccessful());
    }


    public function testRefund()
    {
        if ($this->fuckTimeout) {
            return;
        }

        $options = array(
            'transaction_id' => '1234567891023',
            'out_refund_no'  => '1234567891023',
            'total_fee'      => '100',
            'refund_fee'     => '100',
        );

        /**
         * @var RefundOrderResponse $response
         */
        $response = $this->gateway->query($options)->send();
        $this->assertFalse($response->isSuccessful());
    }


    public function testQueryRefund()
    {
        if ($this->fuckTimeout) {
            return;
        }

        $options = array(
            'transaction_id' => '1234567891023',
        );

        /**
         * @var RefundOrderResponse $response
         */
        $response = $this->gateway->query($options)->send();
        $this->assertFalse($response->isSuccessful());
    }
}
