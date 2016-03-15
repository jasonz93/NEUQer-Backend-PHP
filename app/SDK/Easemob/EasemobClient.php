<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-14
 * Time: 下午5:02
 */

namespace NEUQer\SDK\Easemob;


use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\Description;
use GuzzleHttp\Command\Guzzle\GuzzleClient;

/**
 * Class EasemobClient
 * @package NEUQer\SDK\Easemob
 * @method array getAccessToken()
 * @method array getUser(array $params)
 */
class EasemobClient extends GuzzleClient
{
    private $clientId;
    private $clientSecret;

    public function __construct($orgName, $appName, $clientId, $clientSecret)
    {
        $client = new Client();
        $description = new Description([
            'baseUrl' => "http://a1.easemob.com",
            'operations' => [
                'getAccessToken' => [
                    'httpMethod' => 'POST',
                    'uri' => "/{orgName}/{appName}/token",
                    'responseModel' => 'accessToken',
                    'parameters' => [
                        'orgName' => [
                            'type' => 'string',
                            'default' => $orgName,
                            'location' => 'uri'
                        ],
                        'appName' => [
                            'type' => 'string',
                            'default' => $appName,
                            'location' => 'uri'
                        ],
                        'grant_type' => [
                            'type' => 'string',
                            'default' => 'client_credentials',
                            'static' => true,
                            'location' => 'json'
                        ],
                        'client_id' => [
                            'type' => 'string',
                            'default' => $clientId,
                            'static' => true,
                            'location' => 'json'
                        ],
                        'client_secret' => [
                            'type' => 'string',
                            'default' => $clientSecret,
                            'static' => true,
                            'location' => 'json'
                        ]
                    ]
                ],
                'getUser' => [
                    'httpMethod' => 'GET',
                    'uri' => '/{orgName}/{appName}/users/{username}',
                    'responseModel' => 'user',
                    'parameters' => [
                        'orgName' => [
                            'type' => 'string',
                            'default' => $orgName,
                            'location' => 'uri'
                        ],
                        'appName' => [
                            'type' => 'string',
                            'default' => $appName,
                            'location' => 'uri'
                        ],
                        'username' => [
                            'type' => 'string',
                            'location' => 'uri'
                        ],
                        'token' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'Authorization'
                        ]
                    ]
                ],
                'batchAddUsers' => [
                    'httpMethod' => 'POST',
                    'uri' => '/{orgName}/{appName}/users',
                    'responseModel' => 'common',
                    'parameters' => [
                        'orgName' => [
                            'type' => 'string',
                            'default' => $orgName,
                            'location' => 'uri'
                        ],
                        'appName' => [
                            'type' => 'string',
                            'default' => $appName,
                            'location' => 'uri'
                        ],
                        'token' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'Authorization'
                        ],
                        'users' => [
                            'type' => 'string',
                            'location' => 'body'
                        ]
                    ]
                ],
                'batchDeleteUsers' => [
                    'httpMethod' => 'DELETE',
                    'uri' => '/{orgName}/{appName}/users',
                    'responseModel' => 'common',
                    'parameters' => [
                        'orgName' => [
                            'type' => 'string',
                            'default' => $orgName,
                            'location' => 'uri'
                        ],
                        'appName' => [
                            'type' => 'string',
                            'default' => $appName,
                            'location' => 'uri'
                        ],
                        'limit' => [
                            'type' => 'number',
                            'location' => 'query'
                        ],
                        'token' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'Authorization'
                        ]
                    ]
                ]
            ],
            'models' => [
                'common' => [
                    'type' => 'object',
                    'additionalProperties' => [
                        'location' => 'json'
                    ]
                ],
                'user' => [
                    'type' => 'object',
                    'additionalProperties' => [
                        'location' => 'json'
                    ]
                ],
                'accessToken' => [
                    'type' => 'object',
                    'properties' => [
                        'accessToken' => [
                            'type' => 'string',
                            'location' => 'json',
                            'sentAs' => 'access_token'
                        ],
                        'expiresIn' => [
                            'type' => 'number',
                            'location' => 'json',
                            'sentAs' => 'expires_in'
                        ],
                        'application' => [
                            'type' => 'string',
                            'location' => 'json'
                        ]
                    ]
                ]
            ]
        ]);
        parent::__construct($client, $description);
    }

}