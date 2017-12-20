<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\Common\Message\AbstractResponse;

/**
 * Class BaseAbstractResponse
 *
 * @package Omnipay\WechatPay\Message
 */
abstract class BaseAbstractResponse extends AbstractResponse
{

    /**
     * Is the response successful?
     *
     * @return boolean
     */
    public function isSuccessful()
    {
        $data = $this->getData();
        $result = isset($data['result_code']) && $data['result_code'] == 'SUCCESS';
        if ($result) {
            return $result;
        }
        return false;
    }
}
