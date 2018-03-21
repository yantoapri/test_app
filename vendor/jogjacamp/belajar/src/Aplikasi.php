<?php 
namespace Jogjacamp\Belajar;
use Predis\Client;

class Aplikasi 
{
	public $DB;
	public $conn;
	public $gump ;
	public $redis;

	public function __construct()
	{
		$connectionParams = array(
			    'dbname'   => 'projeku',
			    'user'     => 'root',
			    'password' => 'root',
			    'host'     => 'localhost',
			    'driver'   => 'pdo_mysql'
			);
		$config     = new \Doctrine\DBAL\Configuration();
		$this->conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
		$this->DB   = $this->conn->createQueryBuilder();
		$this->gump = new \GUMP();
        $this->redis = new Client(
                [
                     'scheme' => 'tcp',
                     'host'   => '127.0.0.1',
                     'port'   => 6379,
                 ]
            );    
	}

  

}
 ?>