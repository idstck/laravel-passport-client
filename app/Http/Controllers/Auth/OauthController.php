<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OauthController extends Controller
{
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

    public function callback()
    {

    }
}
