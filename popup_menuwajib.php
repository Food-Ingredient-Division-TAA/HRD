<?php
 include('koneksi.php');?>
<form action="menu.php" method="post" enctype="multipart/form-data">	
	<div class="form-group">
		<input class="btn btn-default" width="10%" value="KODE MENU" />
		<input type="hidden" name="week" value="<?php echo $_POST['tweek'];?>" />
		<input type="hidden" name="jenis" value="<?php echo $_POST['type'];?>" />
		<input class="form-control" type="number" title="Kode Menu" placeholder="Menu Code (Max 5 Digit)" max="99999" min="1" id="kode" name="kode" required/>
	</div>
	<div class="form-group">
		<input class="btn btn-default" width="10%" value="NAMA MENU" />
		<input class="form-control" type="text" title="Nama Menu" placeholder="Judul Menu" id="nama" name="nama" required/>
	</div>
	<div class="form-group">
		<input class="btn btn-default" width="10%" value="JUMLAH QUOTA" />
		<input class="form-control" type="number" title="Nama Menu" placeholder="Judul Menu" id="quota" max="99999" min="1" name="quota" required/>
	</div>
	<span class="float-right">&nbsp;
		<input class="btn btn-success" type="submit" name="setmenu" value="Save" />
	</span>
</form>