<?php
use PHPUnit\Framework\TestCase;
use \Jogjacamp\Belajar\Berita;
class TestBerita extends TestCase
{
	function testNews()
	{

		$src_handle = new  Berita();
		$src_berita = new \Jogjacamp\Belajar\Berita;
		
		$hasil = $src_berita->retriveAll();
		$this->assertNotEmpty($hasil);
		echo $hasil;
	}

	function testCreate(){
		$src_handle = new  Berita();
		$src_berita = new \Jogjacamp\Belajar\Berita;

		
		$semua = $src_berita->retriveAll();
		echo "sebelum ditambah";
		print_r($semua);

		$hasil_tambah = $src_berita->apiCreate('cobajudulbaruaja', '1', 'isidfdfdf' . rand());
		//$this->assertTrue($hasil_tambah);

		$hasil = $src_berita->retriveAll();
		$this->assertNotEmpty($hasil);
		echo "setelah ditambah";
		print_r($hasil);

	}

	function testUpdateBerita(){
		$src_handle = new  Berita();
		$src_berita = new \Jogjacamp\Belajar\Berita;

		$semua = $src_berita->retriveAll();
		echo "sebelum diupdate";
		print_r($semua);

		$hasil_update = $src_berita->apiUpdate('23','updatecobajudul', '1', 'isidfdfdf' . rand());
		$this->assertTrue($hasil_update);

		$hasil = $src_berita->retriveAll();
		$this->assertNotEmpty($hasil);
		echo "setelah diupdate";
		print_r($hasil);
	
	}

	function testDeleteBerita(){
		$src_handle = new  Berita();
		$src_berita = new \Jogjacamp\Belajar\Berita;

		$semua = $src_berita->retriveAll();
		echo "sebelum didelete";
		print_r($semua);

		$hasil_update = $src_berita->apiDelete('34');
		$this->assertTrue($hasil_update);

		$hasil = $src_berita->retriveAll();
		$this->assertNotEmpty($hasil);
		echo "setelah didelete";
		print_r($hasil);
	}

	function testID(){
		$src_handle = new  Berita();
		$src_berita = new \Jogjacamp\Belajar\Berita;

		$ambil=$src_berita->apiRetrive('2');
		$this->assertNotEmpty($ambil);
		print_r($ambil);
	}
}
