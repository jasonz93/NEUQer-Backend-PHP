<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-23
 * Time: 下午8:22
 */

namespace NEUQer\Services;


use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\GuzzleClient;

class TuringService
{
    private $httpClient;
    private $key;

    public function __construct($key)
    {
        $this->httpClient = new Client();
        $this->key = $key;
    }

    public function send($content, $username) {
        $request = [
            'key' => $this->key,
            'info' => $content,
            'userid' => $username
        ];
        \Log::info('Ask turing:');
        \Log::info(print_r($request, true));
        $response = $this->httpClient->get('http://www.tuling123.com/openapi/api', [
            'query' => $request
        ]);
        if ($response->getStatusCode() !== 200) {
            return null;
        }
        $data = json_decode($response->getBody(), true);
        \Log::info('Turing response:');
        \Log::info(print_r($data, true));
        switch ($data['code']) {
            case 100000:
                return $this->handleText($data);
            default:
                return null;
        }
    }

    private function handleText(array $data) {
        return [
            'type' => 'text',
            'content' => $data['text']
        ];
    }
}