<?php

namespace AndPhone\CurrencyExchange\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class CurrencyExchangeIndex extends Template
{
    private const EXCHANGE_RATE_URL = 'https://portal.vietcombank.com.vn/Usercontrols/TVPortal.TyGia/pXML.aspx?b=68';

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function getCurrencyExchangeRate(): ?array
    {
        $curl = curl_init();

        try {
            curl_setopt_array($curl, [
                CURLOPT_URL => self::EXCHANGE_RATE_URL,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
            ]);

            $result = curl_exec($curl);

            if ($result === false) {
                throw new \Exception('Curl error: ' . curl_error($curl));
            }

            $xml = simplexml_load_string($result);

            if ($xml === false) {
                throw new \Exception('Error: Cannot parse XML.');
            }

            return json_decode(json_encode((array)$xml), true);
        } catch (\Exception $e) {
            return null;
        } finally {
            curl_close($curl);
        }
    }
}
