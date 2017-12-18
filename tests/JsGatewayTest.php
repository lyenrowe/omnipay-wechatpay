<?php

namespace Omnipay\WechatPay\Tests;

use Omnipay\Tests\TestCase;
use Omnipay\WechatPay\JsGateway;
use Omnipay\WechatPay\Message\CloseOrderResponse;
use Omnipay\WechatPay\Message\CompletePurchaseResponse;
use Omnipay\WechatPay\Message\CreateOrderResponse;
use Omnipay\WechatPay\Message\CreateOrderRequest;
use Omnipay\WechatPay\Message\QueryOrderResponse;
use Omnipay\WechatPay\Message\RefundOrderResponse;
use Symfony\Component\HttpFoundation\Request;

class JsGatewayTest extends TestCase
{

    /**
     * @var JsGateway $gateway
     */
    protected $gateway;

    protected $options;

    protected $fuckTimeout = false;


    public function setUp()
    {
        $this->gateway = new JsGateway();
        $this->options = [
            'app_id'  => '123456789',
            'mch_id'  => '123456789',
            'api_key' => 'XXSXXXSXXSXXSX',
        ];
        $this->gateway->initialize($this->options);
    }

    public function testParams()
    {
        $this->assertEquals($this->options['app_id'], $this->gateway->getAppId());
        $this->assertEquals($this->options['api_key'], $this->gateway->getApiKey());
        $this->assertEquals($this->options['mch_id'], $this->gateway->getMchId());
        $this->assertEquals('', $this->gateway->getCurrency());
        $this->assertEquals('WechatPay JS API/MP', $this->gateway->getName());
        $this->assertEquals('JSAPI', $this->gateway->getTradeType());
    }

    public function testPurchase()
    {
        if ($this->fuckTimeout) {
            return;
        }

        $order = [
            'notify_url'       => 'http://example.com/notify',
            'trade_type'       => 'APP',
            'open_id'          => '1234',
            'body'             => 'test', //body
            'out_trade_no'     => date('YmdHis'), //order no
            'total_fee'        => '0.01', // money
            'spbill_create_ip' => '114.119.110.120', //Order client IP
        ];
        /**
         * @var CreateOrderRequest $request
         */
        $request = $this->gateway->purchase($order);
        $this->assertEquals($order['open_id'], $request->getOpenId());

        /**
         * @var CreateOrderResponse $response
         */
        $response = $request->send();

        $this->assertFalse($response->isSuccessful());
        $this->assertFalse($response->isRedirect());
    }


    public function testCompletePurchase()
    {
        if ($this->fuckTimeout) {
            return;
        }

        $options = [
            'request_params' => [
                'result_code' => 'SUCCESS'
            ],
        ];

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

        $options = [
            'transaction_id' => '3474813271258769001041842579301293446',
        ];

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

        $options = [
            'out_trade_no' => '1234567891023',
        ];

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

        $options = [
            'transaction_id' => '1234567891023',
            'out_refund_no'  => '1234567891023',
            'total_fee'      => '100',
            'refund_fee'     => '100',
        ];

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

        $options = [
            'transaction_id' => '1234567891023',
        ];

        /**
         * @var RefundOrderResponse $response
         */
        $response = $this->gateway->query($options)->send();
        $this->assertFalse($response->isSuccessful());
    }
}
