<?php
/**
 * Created by PhpStorm.
 * User: nicholas
 * Date: 16-3-12
 * Time: 下午10:12
 */

namespace NEUQer\Extensions;


use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use NEUQer\UserToken;

class AppTokenGuard implements Guard
{
    use GuardHelpers;

    /** @var  Request */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }
        $this->user = $this->getUserByToken($this->getTokenForRequest());
        return $this->user;
    }

    public function getTokenForRequest() {
        $token = null;
        $token = $this->request->header('token');
        return $token;
    }

    public function getUserByToken($token) {
        $userToken = UserToken::where('token', '=', $token)->first();
        if ($userToken == null) {
            return null;
        }
        return $userToken->user;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        return $this->getUserByToken($credentials['token']) != null;
    }
}