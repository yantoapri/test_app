<?php 
namespace Jogjacamp\Belajar;


class Berita extends Aplikasi
{	

	function retriveAll()
	{
		
		try {
			//cek di cache dulu, ada tidak
			$cek_cache = $this->redis->get('semua_berita2');

			//kalo belum ada, query ke database
			if (empty($cek_cache)) {
				$sql = $this->DB
						    ->select('n.id, n.judul, n.isi, k.kategori')
						    ->from('news','n')
						    ->innerJoin('n','kategori','k','n.id_kat = k.id');

				$data = $this->conn->fetchAll($sql);

				//simpan dicache hasilnya
				$this->redis->setEx('semua_berita2', 60 * 2, json_encode($data));

				return $data;
			}
			else {
				return json_decode($cek_cache, 1);
			}
			
		}
		catch (Exception $e) {
		    die ($e->getMessage());
		}
	}

	function retriveKategoriAll()
	{
		
		try {
			//cek di cache dulu, ada tidak
			$cek_cache = $this->redis->get('semua_kategori');

			//kalo belum ada, query ke database
			if (empty($cek_cache)) {
				$sql = $this->DB
						    ->select('*')
						    ->from('kategori');

				$data = $this->conn->fetchAll($sql);

				//simpan dicache hasilnya
				$this->redis->setEx('semua_kategori', 60 * 2, json_encode($data));

				return $data;
			}
			else {
				return json_decode($cek_cache, 1);
			}
			
		}
		catch (Exception $e) {
		    die ($e->getMessage());
		}
	}

	public function apiCreate($judul , $id_kat, $isi)
	{

		$this->gump->validation_rules(array(
			'judul'  => 'required|alpha_space|max_len,100|min_len,6',
			'isi'    => 'required|max_len,10000|min_len,6',
			'id_kat' => 'required|exact_len,1'
			
		));

		$this->gump->filter_rules(array(
			'judul'  => 'trim',
			'isi'    => 'trim',
			'id_kat' => 'trim'
		
		));
		
		$validated_data = $this->gump->run(array(
			'judul'  => $judul,
			'id_kat' => $id_kat,
			'isi'    => $isi
		));

		if (!$validated_data) {
			return $this->gump->get_readable_errors(true);
		} else {
			$sim=$this->dbInsert($judul, $id_kat, $isi);
			if($sim){
				$this->redis->del('semua_berita2');
				return 'Success';
			}else return 'Failed';
		}
				
	}
	
	private function dbInsert($judul, $id_kat, $isi)
	{
		return $this->conn->insert( "news", array(
			"judul"  => $judul,
			"id_kat" => $id_kat,
			"isi"    => $isi
		));
	}
		
	public  function apiRetrive($id)
	{
		$cek_cache = $this->redis->get('berita_id:'.$id);
		if ( empty($cek_cache) ){
			$sql = $this->DB
				    ->select( '*' )
				    ->from('news')
				    ->where("news.id = $id");

			$data = $this->conn->fetchAssoc($sql);
			$this->redis->setEx('berita_id:'.$id, 60 * 2, json_encode($data));
			return $data;

		} else {
			return json_decode($cek_cache);
		}
	}
	
	public function apiUpdate($id, $judul , $id_kat, $isi)
	{

		$this->gump->validation_rules(array(
			'judul'  => 'required|alpha_space|max_len,100|min_len,6',
			'isi'    => 'required|max_len,10000|min_len,6',
			'id_kat' => 'required|exact_len,1'
			
		));

		$this->gump->filter_rules(array(
			'judul'  => 'trim',
			'isi'    => 'trim',
			'id_kat' => 'trim'
		
		));
		
		$validated_data = $this->gump->run(array(
			'judul'  => $judul,
			'id_kat' => $id_kat,
			'isi'    => $isi
		));
		if ( !$validated_data ) {
			return $this->gump->get_readable_errors(true);
		} else {
			$this->dbUpdate($id, $judul, $id_kat, $isi);
			$this->redis->del('semua_berita2');
			$this->redis->del('berita_id:'.$id);
			return true;
		}
				
	}
	public function dbUpdate($id, $judul, $id_kat, $isi)
	{
		$this->conn->update( 'news', array(
				'judul'  => $judul,
				'id_kat' => $id_kat,
				'isi'    => $isi
		), array('id' => $id));

	}
	
	public function dbDelete($i)
	{
		return $this->conn->delete('news', array('id' => $i));
	}

	public function apiDelete($id)
	{
		$this->dbDelete($id);
		$this->redis->del('semua_berita2');
		return true;
	}

	

}

 ?>