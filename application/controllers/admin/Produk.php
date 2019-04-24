<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends CI_Controller {

	// Load model
	public function __construct()
	{
		parent::__construct();
		$this->load->model('produk_model');
		$this->load->model('kategori_model');
		//Proteksi halaman admin dengan fungsi cek_login yang ada di Simple_login
		$this->simple_login->cek_login();
	}
	public function index()
	{
		$produk = $this->produk_model->listing(); //memanggil method listing di Produk_model.php
		$data = array(	'title' => 'Data Produk',
						'produk' 	=>	$produk,
						'isi'	=>	'admin/produk/list'
					);
		$this->load->view('admin/layout/wrapper', $data, FALSE);
	}

	//tambah produk
	public function tambah()
	{
		//Ambil data kategori
		$kategori = $this->kategori_model->listing();
		//validasi input
		$valid = $this->form_validation;
		$valid->set_rules('namapengguna','Nama lengkap','required',
			array('required' =>'%s harus diisi'));
		$valid->set_rules('email','Email','required|valid_email',
			array(	'required' =>'%s harus diisi',
					'valid_email' =>'%s tidak valid'));
		$valid->set_rules('produkname','Produkname','required|min_length[6]|max_length[32]|is_unique[produks.produkname]',
			array(	'required' =>'%s harus diisi',
					'min_length' =>'%s minimal 6 karakter',
					'max_length' =>'%s maksimal 32 karakter',
					'is_unique' =>'%s sudah ada. Coba produkname lain.'));
		$valid->set_rules('password','Password','required|min_length[6]',
			array(	'required' =>'%s harus diisi',
					'min_length' =>'%s minimal 6 karakter'));

		if($valid->run()===FALSE){
			$data = array(	'title' => 'Tambah Produk',
							'kategori' => $kategori,
							'isi'	=>	'admin/produk/tambah'
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
							'produkname'		=> $i->post('produkname'),
							'password'		=> sha1($i->post('password')),//$create_pass,
							'salt'			=> $options['salt'],
							'kuncen'		=> $i->post('password'),
							'akses_level'	=> $i->post('akses_level'));
			$this->produk_model->tambah($data); //memanggil method tambah di Produk_model.php
			$this->session->flashdata('sukses','Data telah ditambah');
			redirect(base_url('admin/produk'),'refresh');
		}
		
	}

	//ubah produk
	public function edit($id_produk)
	{
		$produk = $this->produk_model->detail($id_produk);
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
			$data = array(	'title' => 'Edit Produk',
							'produk'	=> $produk,
							'isi'	=> 'admin/produk/edit'
					);
		$this->load->view('admin/layout/wrapper', $data, FALSE);
		//Masuk database
		}else{
			$i = $this->input;
			$data = array(	'id_produk'		=> $id_produk,
							'nama'			=> $i->post('nama'),
							'email'			=> $i->post('email'),
							'produkname'		=> $i->post('produkname'),
							'password'		=> SHA1($i->post('password')),
							'akses_level'	=> $i->post('akses_level'));
			$this->produk_model->edit($data); //memanggil method edit di Produk_model.php
			$this->session->flashdata('sukses','Data telah diedit');
			redirect(base_url('admin/produk'),'refresh');
		}
		
	}

	//Deleta produk
	public function delete($id_produk){
		$data = array('id_produk' => $id_produk);
		$this->produk_model->delete($data); //memanggil method delete di Produk_model.php
		$this->session->flashdata('sukses','Data telah dihapus');
		redirect(base_url('admin/produk'),'refresh');
	}

}

/* End of file Produk.php */
/* Location: ./application/controllers/admin/Produk.php */