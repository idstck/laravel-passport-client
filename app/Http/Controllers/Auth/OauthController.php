<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client as Guzzle;

class OauthController extends Controller
{
    protected $client;

    public function __construct(Guzzle $client)
    {
        $this->middleware('auth');
        $this->client = $client;
    }

    public function redirect()
    {
        $query = http_build_query([
            'client_id' => '3',
            'redirect_uri' => 'http://passclient.test/auth/passport/callback',
            'response_type' => 'code',
            'scope' => ''
        ]);

        return redirect('http://passport.test/oauth/authorize?' . $query);
    }

    public function callback(Request $request)
    {
        $response = $this->client->post('http://passport.test/oauth/token', [
            'form_params' => [
                'grant_type' => 'authorization_code',
                'client_id' => '3',
                'client_secret' => 'hPThwMipot4kQ18deI5sMko3Mt7cTHObyCahpeyV',
                'redirect_uri' => 'http://passclient.test/auth/passport/callback',
                'code' => $request->code,
            ]
        ]);

        $response = json_decode($response->getBody());

        $request->user()->token()->delete();

        $request->user()->token()->create([
            'access_token' => $response->access_token
        ]);

        return redirect('/home');
    }
}
