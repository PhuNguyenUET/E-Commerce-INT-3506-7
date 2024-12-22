<?php

namespace AndPhone\News\Block;

use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class NewsIndex extends Template
{
    private const NEWS_FEED_URL = 'https://vnexpress.net/rss/kinh-doanh.rss';

    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    public function getNews(): ?array
    {
        $curl = curl_init();

        try {
            curl_setopt_array($curl, [
                CURLOPT_URL => self::NEWS_FEED_URL,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_RETURNTRANSFER => true,
            ]);

            $result = curl_exec($curl);

            if ($result === false) {
                throw new \Exception('Curl error: ' . curl_error($curl));
            }

            $xml = simplexml_load_string($result, null, LIBXML_NOCDATA);

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
