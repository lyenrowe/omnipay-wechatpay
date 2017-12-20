<?php

namespace Omnipay\WechatPay\Message;

use Omnipay\Common\Message\AbstractRequest;
use Omnipay\WechatPay\GuzzleClient;
use Omnipay\WechatPay\Helper;

/**
 * Class BaseAbstractRequest
 *
 * @package Omnipay\WechatPay\Message
 */
abstract class BaseAbstractRequest extends AbstractRequest
{

    protected $endpoint;
    protected $env = null;

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->getParameter('app_id');
    }


    /**
     * @param mixed $appId
     */
    public function setAppId($appId)
    {
        $this->setParameter('app_id', $appId);
    }


    /**
     * @return mixed
     */
    public function getApiKey()
    {
        return $this->getParameter('api_key');
    }


    /**
     * @param mixed $apiKey
     */
    public function setApiKey($apiKey)
    {
        $this->setParameter('api_key', $apiKey);
    }


    /**
     * @return mixed
     */
    public function getMchId()
    {
        return $this->getParameter('mch_id');
    }


    /**
     * @param mixed $mchId
     */
    public function setMchId($mchId)
    {
        $this->setParameter('mch_id', $mchId);
    }

    public function setEnv($env)
    {
        $this->env = ($env == 'sandbox' ? 'sandbox' : null);
    }

    public function getEnv()
    {
        return $this->env;
    }

    public function getEndpoint()
    {
        if ($this->getEnv() == 'sandbox') {
            $this->endpoint = str_replace('api.mch.weixin.qq.com', 'api.mch.weixin.qq.com/sandboxnew', $this->endpoint);
        } else {
            $this->endpoint = str_replace('api.mch.weixin.qq.com/sandboxnew', 'api.mch.weixin.qq.com', $this->endpoint);
        }

        return $this->endpoint;
    }

    public function post($data)
    {
        $response = $this->httpClient->post($this->getEndpoint(), [], Helper::array2xml($data));

        return Helper::xml2array($response->getBody());
    }

    public function setSSLClient()
    {
        $options = [
            'curl' => [
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_SSLCERTTYPE    => 'PEM',
                CURLOPT_SSLKEYTYPE     => 'PEM',
                CURLOPT_SSLCERT        => $this->getCertPath(),
                CURLOPT_SSLKEY         => $this->getKeyPath(),
            ]
        ];

        $this->httpClient = new GuzzleClient($options);
    }
}
