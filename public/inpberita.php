
<form method="post" action="<?php if(count($data)>0) echo '/test_app/index.php/updateBerita/'.$data['id']; else echo '/test_app/index.php/simpanBerita' ?>" >
	Judul
	<input type="text" value="<?php if(count($data)>0) echo $data['judul']; ?>" name="judul"><br>
	Kategori
	<select name="kat">
		<option value="">---Pilih Kategori---</option>
		<?php foreach ($kat as $val) { ?>
				<option value="<?php echo $val['id']; ?>" 
					<?php if ( count( $data ) > 0 ) {
						if ($data['id_kat'] == $val['id']) echo 'selected';
					} ?> >
					<?php echo $val['kategori']; ?>
				</option>
		<?php } ?>
	</select><br>
	Isi
	<textarea cols="50" rows="5" name="isi"><?php if(count($data)>0) echo $data['isi']; ?></textarea><br>
	<button type="submit" >Simpan</button>
</form>

