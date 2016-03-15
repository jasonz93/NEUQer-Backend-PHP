<?php

/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-14
 * Time: 下午5:28
 */
class EasemobTests extends TestCase
{
    /**
     * @var \NEUQer\SDK\Easemob\EasemobClient
     */
    private $client;

    public function setUp()
    {
        parent::setUp();
        $this->client = new \NEUQer\SDK\Easemob\EasemobClient('hrsoft', 'neuqer', 'YXA61xHGUCxqEeWfHD9P3b7bWw', 'YXA6wxe3W5He6KqK-W7dxTpVjzkinQM');
    }

    public function testGetAccessToken() {
        $result = $this->client->getAccessToken();
        var_dump($result);
        return $result['accessToken'];
    }
//
//    /**
//     * @param $token
//     * @depends testGetAccessToken
//     */
//    public function testGetUser($token) {
//        $result = $this->client->getUser([
//            'username' => 'neuqer',
//            'token' => "Bearer $token"
//        ]);
//        var_dump($result);
//    }

    /**
     * @param $token
     * @depends testGetAccessToken
     */
    public function testDeleteUsers($token) {
        $result = $this->client->batchDeleteUsers([
            'limit' => 10,
            'token' => "Bearer $token"
        ]);
        var_dump($result);
    }
}