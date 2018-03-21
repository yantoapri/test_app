<?php 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('views');
$twig   = new Twig_Environment($loader);
$app    = new \Slim\App; 
$client = new \GuzzleHttp\Client(['auth'=>['apri','123']]);

$app->get('/berita', function (Request $request, Response $response) 
{
	global $twig,$client;
	
	$res    = $client->request('GET', 'http://localhost/test_app/api.php/berita');
	$data['data'] = json_decode($res->getBody());
	// echo $twig->render('index.html', $data);
	print_r($data['data']);
});
$app->get('/about', function (Request $request, Response $response) 
{
	global $twig;
	$data['title'] = 'About';
	echo $twig->render('about.html', $data);
});
$app->get('/latihan', function (Request $request, Response $response) 
{
	global $twig;
	$data['title'] = 'Latihan';
	echo $twig->render('latihan.html', $data);
});
$app->run();
 