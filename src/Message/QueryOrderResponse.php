<?php

namespace Omnipay\WechatPay\Message;

/**
 * Class QueryOrderResponse
 *
 * @package Omnipay\WechatPay\Message
 * @link    https://pay.weixin.qq.com/wiki/doc/api/app/app.php?chapter=9_2&index=4
 */
class QueryOrderResponse extends BaseAbstractResponse
{
    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        $data = $this->getData();

        return isset($data['result_code']) && $data['result_code'] == 'SUCCESS' && $this->getTradeState()  == 'SUCCESS';
    }

    public function isPaying()
    {
        return $this->getTradeState() == 'USERPAYING';
    }

    public function getTradeState()
    {
        $data = $this->getData();

        return isset($data['trade_state']) ? $data['trade_state'] : '';
    }
}
