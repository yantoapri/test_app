<?php 
require 'vendor/autoload.php';
$client = new GuzzleHttp\Client();
$res = $client->request('GET', 'http://localhost/test_app/api.php/berita');
//echo $res->getStatusCode();
// "200"
//echo json_encode($res->getHeader('content-type'));
// 'application/json; charset=utf8'
echo $res->getBody();
 ?>