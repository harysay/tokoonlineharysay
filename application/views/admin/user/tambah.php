<?php
//notifikasi error
echo validation_errors('<div class="alert alert-warning">','</div>');

//form open
echo form_open(base_url('admin/user/tambah'),' class="form-horizontal"');
?>

<div class="form-group">
  <label for="inputEmail3" class="col-md-2 control-label">Nama Pengguna</label>

  <div class="col-md-5">
    <input type="text" name="namapengguna" class="form-control" id="inputEmail3" placeholder="Nama Pengguna" value="<?php echo set_value('nama') ?>" required>
  </div>
</div>
<div class="form-group">
  <label for="inputEmail3" class="col-md-2 control-label">Email</label>

  <div class="col-md-5">
    <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Alamat Email" value="<?php echo set_value('email') ?>" required>
  </div>
</div>
<div class="form-group">
  <label for="inputUsername" class="col-md-2 control-label">Username</label>
  <div class="col-md-5">
    <input type="text" name="username" class="form-control" id="inputUsername" placeholder="Username" value="<?php echo set_value('username') ?>" required>
  </div>
</div>
<div class="form-group">
  <label for="inputPassword" class="col-md-2 control-label">Password</label>
  <div class="col-md-5">
    <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Password" value="<?php echo set_value('password') ?>" required>
  </div>
</div>
<div class="form-group">
  <label for="inputPassword" class="col-md-2 control-label">Level Hak Akses</label>
  <div class="col-md-5">
    <select name="akses_level" class="form-control">
    	<option value="Admin">Admin</option>
    	<option value="Pelanggan">Pelanggan</option>
    	<option value="Pembali">Pembeli</option>
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