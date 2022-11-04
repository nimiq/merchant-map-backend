<?php

/**
* Verifies if the token is valid
*
* @param string $token
* @return boolean
*/
function verifyToken($token)
{
    try {
        $url = 'https://www.google.com/recaptcha/api/siteverify';

        $data = ['secret'  => env('GOOGLE_CAPTCHA_SECRET'), 'response' => $token];
        // We could use `remoteip` as well, it is optional. Should be user's IP, not server's!

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            ]
        ];

        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        return json_decode($result)->success;
    }
    catch (Exception $e) {
        return null;
    }
}