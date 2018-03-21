<?php 

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';
$loader = new Twig_Loader_Filesystem('views');
$twig   = new Twig_Environment($loader);
$client = new \GuzzleHttp\Client(['auth'=>['apri','123']]);
$app    = new \Slim\App(); 

$app->get('/add', function (Request $request, Response $response) 
{
	global $twig,$client;
	$data['title']    = 'Create News';
	$res              = $client->request('GET', 'http://localhost/test_app/api.php/kategori');
	$data['kategori'] = json_decode($res->getBody());
	echo $twig->render('add.html', $data);
});
$app->post('/simpan', function (Request $request, Response $response) 
{
	global $twig,$client;
	$res    = $client->request('POST', 'http://localhost/test_app/api.php/berita',['json' =>[
			'judul' => $_POST['judul'],
			'kat'   => $_POST['kat'],
			'isi'   => $_POST['isi']
	] ]);
	return $response->withRedirect('/test_app/index.php/berita', 301);
});
$app->get('/edit/{id}', function (Request $request, Response $response,$args) 
{
	global $twig,$client;
	$id               = $args['id'];
	$res              = $client->request('GET', 'http://localhost/test_app/api.php/berita/'.$id);
	$data['title']    = "Edit News";
	$data['data']     = json_decode($res->getBody());
	$data['id']       = $id;
	$res              = $client->request('GET', 'http://localhost/test_app/api.php/kategori');
	$data['kategori'] = json_decode($res->getBody());
	echo $twig->render('add.html', $data);
	
});
$app->post('/update/{id}', function (Request $request, Response $response,$args) 
{
	global $twig,$client;
	$id     = $args['id'];
	$res    = $client->request('PUT', 'http://localhost/test_app/api.php/berita/'.$id,['json' =>[
			'judul' => $_POST['judul'],
			'kat'   => $_POST['kat'],
			'isi'   => $_POST['isi']
	]]);
	return $response->withRedirect('/test_app/index.php/berita', 301);
});
$app->get('/delete/{id}', function (Request $request, Response $response,$args) 
{
	global $twig,$client;
	$id     = $args['id'];
	$res    = $client->request('DELETE', 'http://localhost/test_app/api.php/berita/'.$id);
	return $response->withRedirect('/test_app/index.php/berita', 301);
});
$app->run();
 