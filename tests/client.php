<?php

require '../vendor/autoload.php';

$client = new GuzzleHttp\Client();

$url1 = 'http://httpbin.org/post';
$url2 = 'http://localhost:8080/index.php/login/check';

$r = $client->request('POST', $url2, [
    'form_params' => [  'user' => 'admin@caracol',
                        'pwd' => '123456']
]);

$res = $r->getBody();

print_r($res->getContents());
