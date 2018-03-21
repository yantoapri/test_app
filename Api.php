<?php 
/**
* Routing
*/
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require 'vendor/autoload.php';

$app    = new \Slim\App; 
$berita = new \Jogjacamp\Belajar\Berita;
//----------------------------
//------API BERITA------------
//---------------------------
$app->add(new Tuupola\Middleware\HttpBasicAuthentication([
    //"path"    => ['/views'],
    //"ignore"  => ['/views/add'],
    "realm"   => "Protected",
    "secure"  => true,
    "relaxed" => ["localhost"],
    "users"   => [
        "apri" => "123"
    ]
]));
$app->get('/berita', function (Request $request, Response $response) 
{

	global $berita;
 	return $response->withJson($berita->retriveAll());
    //echo $berita->retriveAll();
});
$app->get('/kategori', function (Request $request, Response $response) 
{
	global $berita;
 	return $response->withJson($berita->retriveKategoriAll());
    //echo $berita->retriveAll();
});
$app->get('/berita/{id}', function (Request $request, Response $response, $args) 
{
	global $berita;
	return $response->withJson($berita->apiRetrive($args['id']));
});

$app->post('/berita', function (Request $request, Response $response) 
{
	global $berita;
	$data=$request->getParsedBody();;

	$judul = isset($data['judul']) ? $data['judul'] : "";
	$kat   = isset($data['kat']) ? $data['kat'] : "";
	$isi   = isset($data['isi']) ? $data['isi'] : "";

	try {
		$result    = $berita->apiCreate($judul, $kat, $isi);
		if($result == "Success") return $response->withJson($data); else return $result;
		
	} catch (\Exception $e) {
		return $response->withJson(array("errors" => $e->getMessage()));
	}
});

$app->put('/berita/{id}', function (Request $request, Response $response, $args)
 {
	global $berita;
	$data  = $request->getParsedBody();
	$judul = isset($data['judul']) ? $data['judul'] : "";
	$kat   = isset($data['kat']) ? $data['kat'] : "";
	$isi   = isset($data['isi']) ? $data['isi'] : "";

	try {
		$result    = $berita->apiUpdate($args['id'], $judul, $kat, $isi);
		if($result == "") return $response->withJson($data); else return $result;
		
	} catch (\Exception $e) {
		return $response->withJson(array("errors" => $e->getMessage()));
	}

});

$app->delete('/berita/{id}', function (Request $request, Response $response,$args) 
{
	global $berita;
    $result = $berita->apiDelete($args['id']);
    if($result)return $response->withJson(array('status' => 'Success')); else return $response->withJson(array('status' => 'Failed'));
    
});

$app->run();
 ?>