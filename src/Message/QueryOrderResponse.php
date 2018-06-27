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
    public function isWaitPay()
    {
        return $this->getTradeStatus() == 'USERPAYING';
    }

    public function isPaid()
    {
        return  $this->getTradeStatus()  == 'SUCCESS';
    }

    /**
     * @return string
     */
    public function getTradeStatus()
    {
        $data = $this->getData();

        return isset($data['trade_state']) ? $data['trade_state'] : '';
    }

    public function isClosed()
    {
        return ($this->getTradeStatus() == 'CLOSED' || $this->getTradeStatus() == 'REVOKED');
    }
}
