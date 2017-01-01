<?php

namespace atans\weibo;

use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\httpclient\Client;

class ShortUrl extends Component
{
    /**
     * @var string Api host
     */
    public $apiHost = 'http://api.t.sina.com.cn';

    /**
     * @var string
     */
    public $apiShorten = 'short_url/shorten';

    /**
     * @var string
     */
    public $apiExpand = 'short_url/expand';

    /**
     * Response format
     *
     * @var string
     */
    public $format = 'json';

    /**
     * App key
     *
     * @var string
     */
    public $appKey;

    /**
     * 将一个或多个长链接转换成短链接
     *
     * @param string|array $urlLong
     * @return array|mixed
     */
    public function shorten($urlLong)
    {
        $httpQuery = $this->buildHttpQuery([
            'source' => $this->appKey,
            'url_long' => $urlLong
        ]);

        $response = $this->getClient()
            ->get($this->apiShorten . '.' . $this->format .'?' . $httpQuery)
            ->send()
            ->getData();

        return $response;
    }

    /**
     * 将一个或多个短链接还原成原始的长链接
     *
     * @param string $urlShort
     * @return array
     */
    public function expand($urlShort)
    {
        $httpQuery = $this->buildHttpQuery([
            'source' => $this->appKey,
            'url_short' => $urlShort
        ]);

        $response = $this->getClient()
            ->get($this->apiExpand . '.' . $this->format .'?' . $httpQuery)
            ->send()
            ->getData();

        return $response;
    }

    /**
     * Build http query for sina api
     *
     * @param string $data
     * @return string
     */
    public function buildHttpQuery($data)
    {
        // url_long[]=http://... to url_long=http://...
        return preg_replace(
            '/(.+)('. rawurlencode('[').')\d+('. rawurlencode(']').')/',
            '$1',
            http_build_query($data)
        );
    }

    /**
     * Get client
     *
     * @return Client
     * @throws InvalidConfigException
     */
    public function getClient()
    {
        if (! $this->appKey) {
            throw new InvalidConfigException(sprintf('%s: Config appKey must be set', __METHOD__));
        }

        $format = strtolower($this->format) == 'json' ? Client::FORMAT_JSON : Client::FORMAT_XML;

        return new Client([
            'baseUrl' => $this->apiHost,
            'responseConfig' => ['format' => $format],
        ]);
    }
}