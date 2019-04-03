<?php

namespace App\Http\Controllers\Authentication;

use App\Entities\User;
use App\Exceptions\LoginFailedException;
use App\Http\Requests\LoginRequest;
use App\Ship\Parents\Controller;
use App\Transformers\UserPrivateTransformer;
use Illuminate\Cookie\CookieJar;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpFoundation\Cookie;

class AuthenticationController extends Controller
{
    const AUTH_ROUTE = 'oauth/token';

    /**
     * @param LoginRequest $request
     * @return UserPrivateTransformer
     */
    public function login(LoginRequest $request)
    {
        $result = $this->apiLogin(
            [
                'request' => $request,
                'client_id' => env('CLIENT_WEB_ADMIN_ID'),
                'client_password' => env('CLIENT_WEB_ADMIN_SECRET'),
            ]
        );

        $user = User::where(['email' => $request->email])->first();

        $user['token'] = $result;

        return new UserPrivateTransformer($user);
    }

    protected function apiLogin(array $data)
    {
        list('request' => $request, 'client_id' => $clientId, 'client_password' => $clientPassword) = $data;

        $requestData = [
            'grant_type' => 'password',
            'client_id' => $clientId,
            'client_secret' => $clientPassword,
            'username' => $request->email,
            'password' => $request->password,
            'scope' => ''
        ];

        $responseContent = $this->callOAuthServer($requestData);

        $refreshCookie = $this->makeRefreshCookie($responseContent['refresh_token']);

        return [
            'response-content' => $responseContent,
            'refresh-cookie'   => $refreshCookie,
        ];

    }


    /**
     * @param array $data
     * @return mixed
     * @throws LoginFailedException
     */
    protected function callOAuthServer(array $data)
    {
        $authFullApiUrl = env('APP_URl'). '/' .self::AUTH_ROUTE;

        $headers = ['HTTP_ACCEPT' => 'application/json'];

        $request = Request::create($authFullApiUrl, 'POST', $data, [], [], $headers);

        $response = App::handle($request);

        $content = \GuzzleHttp\json_decode($response->getContent(), true);

        if(!$response->isSuccessful()) {
            throw new LoginFailedException($content['message'] , $response->getStatusCode());
        }

        return $content;
    }

    /**
     * @param string $refreshToken
     * @return CookieJar|Cookie
     */
    protected function makeRefreshCookie(string $refreshToken)
    {
        $refreshCookie = cookie(
            'refreshToken',
            $refreshToken,
            env('API_TOKEN_EXPIRES'),
            null,
            null,
            false,
            true // HttpOnly
        );

        return $refreshCookie;
    }
}