<?php
namespace App\Validators;
use GuzzleHttp\Client;

class ReCaptcha
{
    public function validate($attribute, $value, $parameters, $validator)
    {
        $client = new Client;
        $recaptcha_secret = has_option('apikeys', 'recaptcha_secret');
        $response = $client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => ['secret' => $recaptcha_secret, 'response' => $value]
        ]);
        $body = json_decode((string)$response->getBody());
        return $body->success;
    }
}