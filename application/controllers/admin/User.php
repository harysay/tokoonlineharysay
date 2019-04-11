<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	// Load model
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
		//Proteksi halaman admin dengan fungsi cek_login yang ada di Simple_login
		$this->simple_login->cek_login();
	}
	public function index()
	{
		$user = $this->user_model->listing(); //memanggil method listing di User_model.php
		$data = array(	'title' => 'Data Pengguna',
						'user' 	=>	$user,
						'isi'	=>	'admin/user/list'
					);
		$this->load->view('admin/layout/wrapper', $data, FALSE);
	}

	//tambah user
	public function tambah()
	{
		//validasi input
		$valid = $this->form_validation;
		$valid->set_rules('namapengguna','Nama lengkap','required',
			array('required' =>'%s harus diisi'));
		$valid->set_rules('email','Email','required|valid_email',
			array(	'required' =>'%s harus diisi',
					'valid_email' =>'%s tidak valid'));
		$valid->set_rules('username','Username','required|min_length[6]|max_length[32]|is_unique[users.username]',
			array(	'required' =>'%s harus diisi',
					'min_length' =>'%s minimal 6 karakter',
					'max_length' =>'%s maksimal 32 karakter',
					'is_unique' =>'%s sudah ada. Coba username lain.'));
		$valid->set_rules('password','Password','required|min_length[6]',
			array(	'required' =>'%s harus diisi',
					'min_length' =>'%s minimal 6 karakter'));

		if($valid->run()===FALSE){
			$data = array(	'title' => 'Tambah Pengguna',
							'isi'	=>	'admin/user/tambah'
					);
		$this->load->view('admin/layout/wrapper', $data, FALSE);
		//Masuk database
		}else{
			$i = $this->input;
			$password    = md5($i->post('password',TRUE));
			$options     = array("cost" => 12, "salt" => md5(rand()));
			//$create_pass = password_hash($password, PASSWORD_BCRYPT, $options);
			$data = array(	'nama'			=> $i->post('namapengguna'), //namapengguna harus sama dengan name= di view nya
							'email'			=> $i->post('email'),
							'username'		=> $i->post('username'),
							'password'		=> sha1($i->post('password')),//$create_pass,
							'salt'			=> $options['salt'],
							'kuncen'		=> $i->post('password'),
							'akses_level'	=> $i->post('akses_level'));
			$this->user_model->tambah($data); //memanggil method tambah di User_model.php
			$this->session->flashdata('sukses','Data telah ditambah');
			redirect(base_url('admin/user'),'refresh');
		}
		
	}

	//ubah user
	public function edit($id_user)
	{
		$user = $this->user_model->detail($id_user);
		//validasi input
		$valid = $this->form_validation;
		$valid->set_rules('nama','Nama lengkap','required',
			array('required' =>'%s harus diisi'));
		$valid->set_rules('email','Email','required|valid_email',
			array(	'required' =>'%s harus diisi',
					'valid_email' =>'%s tidak valid'));
		$valid->set_rules('password','Password','required|min_length[6]',
			array(	'required' =>'%s harus diisi',
					'min_length' =>'%s minimal 6 karakter'));
		if($valid->run()===FALSE){
			$data = array(	'title' => 'Edit Pengguna',
							'user'	=> $user,
							'isi'	=> 'admin/user/edit'
					);
		$this->load->view('admin/layout/wrapper', $data, FALSE);
		//Masuk database
		}else{
			$i = $this->input;
			$data = array(	'id_user'		=> $id_user,
							'nama'			=> $i->post('nama'),
							'email'			=> $i->post('email'),
							'username'		=> $i->post('username'),
							'password'		=> SHA1($i->post('password')),
							'akses_level'	=> $i->post('akses_level'));
			$this->user_model->edit($data); //memanggil method edit di User_model.php
			$this->session->flashdata('sukses','Data telah diedit');
			redirect(base_url('admin/user'),'refresh');
		}
		
	}

	//Deleta user
	public function delete($id_user){
		$data = array('id_user' => $id_user);
		$this->user_model->delete($data); //memanggil method delete di User_model.php
		$this->session->flashdata('sukses','Data telah dihapus');
		redirect(base_url('admin/user'),'refresh');
	}

}

/* End of file User.php */
/* Location: ./application/controllers/admin/User.php */