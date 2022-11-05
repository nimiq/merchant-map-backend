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

/**
 * Simplifies the information of a Shop to only the necessary data.
 * This function exists the database contains a lot of unnecessary
 * data. To reduce the size of the response, we only want to return
 * the data that is actually needed.
 *
 * @param Shop $shop
 * @return array - of all pickups
 */
function simplifyShop(App\Models\Shop $shop) {
     // We only want to provide currencies' symbol, the rest is just noise
    $shop->currencies->transform(function ($currency) {
        return $currency->symbol;
    });


    $res = [];
    foreach ($shop->pickups as $pickup) {
        $placeInformation = $pickup->place_information;
        $placeInformation = stripslashes(html_entity_decode($placeInformation));
        $placeInformation = json_decode($placeInformation);
        $res[] = [
            'id' => $shop->id,
            'place_id' => $pickup->place_id,
            'name' => $shop->label,
            'photo_reference' => $placeInformation->photos[0]->photo_reference ?? null,
            'category' => null,
            'type' => $placeInformation->types[0] ?? "Miscellaneous",
            'rating' => $placeInformation->rating ?? null,
            'address' => $shop->address_line_1,
            'gmaps_url' => $placeInformation->url ?? null,
            'geo_location' => [
                'lng' => $pickup->geo_location->getLng(),
                'lat' => $pickup->geo_location->getLat(),
            ],
            'currencies' => $shop->currencies,
        ];
    }
    return $res;
}