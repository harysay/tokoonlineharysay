<?php
//notifikasi error
echo validation_errors('<div class="alert alert-warning">','</div>');

//form open
echo form_open(base_url('admin/produk/edit/'.$produk->id_produk),' class="form-horizontal"');
?>

<div class="form-group">
  <label for="inputEmail3" class="col-md-2 control-label">Nama Pengguna</label>

  <div class="col-md-5">
    <input type="text" name="nama" class="form-control" id="inputEmail3" placeholder="Nama Pengguna" value="<?php echo $produk->nama ?>" required>
  </div>
</div>
<div class="form-group">
  <label for="inputEmail3" class="col-md-2 control-label">Email</label>

  <div class="col-md-5">
    <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Alamat Email" value="<?php echo $produk->email ?>" required>
  </div>
</div>
<div class="form-group">
  <label for="inputProdukname" class="col-md-2 control-label">Produkname</label>
  <div class="col-md-5">
    <input type="text" name="produkname" class="form-control" id="inputProdukname" placeholder="Produkname" value="<?php echo $produk->produkname ?>" readonly>
  </div>
</div>
<div class="form-group">
  <label for="inputPassword" class="col-md-2 control-label">Password</label>
  <div class="col-md-5">
    <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" value="<?php echo $produk->password ?>" required>
  </div>
</div>
<div class="form-group">
  <label for="inputPassword" class="col-md-2 control-label">Level Hak Akses</label>
  <div class="col-md-5">
    <select name="akses_level" class="form-control">
    	<option value="Admin">Admin</option>
    	<option value="Pelanggan"<?php if($produk->akses_level=="Pelanggan"){echo "selected";}?>>Pelanggan</option>
    	<option value="Pembali" <?php if($produk->akses_level=="Pembeli"){echo "selected";}?>>Pembeli</option>
    	option
    </select>
  </div>
</div>
<div class="form-group">
  <label class="col-md-2 control-label"></label>
  <div class="col-md-5">
  	<button class="btn btn-success btn-lg" name="submit" type="submit">
  		<i class="fa fa-save"></i> Simpan
  	</button>
  	<button class="btn btn-info btn-lg" name="reset" type="reset">
  		<i class="fa fa-times"></i> Riset
  	</button>
  </div>
</div>
<?php echo form_close(); ?>