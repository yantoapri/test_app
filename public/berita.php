
<a href="./index.php/newBerita">Create New</a><br>
 <style type="text/css">
 	table{border-collapse: collapse;}
 	table tr,table td{border:1px solid black}
 </style>
<br><br>
 <table >
 	<tr>
 		<td>Judul</td><td>Kategori</td><td>Conten</td><td>Tindakan</td>
 	</tr>

 	<?php foreach ($berita->retriveAll() as $val) {?>
	 	<tr>
	 		<td><?php echo $val['judul']; ?></td><td><?php echo $val['kategori']; ?></td><td><?php echo $val['isi']; ?></td>
	 		<td>
	 			<a href="./index.php/editBerita/<?php echo $val['id']; ?>">Edit</a>
	 			<a href="./index.php/hapusBerita/<?php echo $val['id']; ?>">Hapus</a>
	 		</td>
	 	</tr>
	<?php } ?>

 </table>