<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kategori extends CI_Controller {

	// Load model
	public function __construct()
	{
		parent::__construct();
		$this->load->model('kategori_model');
		//Proteksi halaman admin dengan fungsi cek_login yang ada di Simple_login
		$this->simple_login->cek_login();
	}
	public function index()
	{
		$kategori = $this->kategori_model->listing(); //memanggil method listing di Kategori_model.php
		$data = array(	'title' => 'Data Kategori Produk',
						'kategori' 	=>	$kategori,
						'isi'	=>	'admin/kategori/list'
					);
		$this->load->view('admin/layout/wrapper', $data, FALSE);
	}

	//tambah kategori
	public function tambah()
	{
		//validasi input
		$valid = $this->form_validation;
		$valid->set_rules('nama_kategori','Nama kategori','required|is_unique[kategori.nama_kategori]',
			array(	'required' =>'%s harus diisi',
					'is_unique'=> '%s sudah ada. Buat kategori baru!'));
		
		if($valid->run()===FALSE){
			$data = array(	'title' => 'Tambah Kategori Produk',
							'isi'	=>	'admin/kategori/tambah'
					);
		$this->load->view('admin/layout/wrapper', $data, FALSE);
		//Masuk database
		}else{
			$i = $this->input;
			$slug_kategori = url_title($this->input->post('nama_kategori'),'dash', TRUE);//berasal dari user_guide CodeIgniter bagian slug

			$password    = md5($i->post('password',TRUE));
			$options     = array("cost" => 12, "salt" => md5(rand()));
			//$create_pass = password_hash($password, PASSWORD_BCRYPT, $options);
			$data = array(	'nama_kategori'		=> $i->post('nama_kategori'), //nama_kategori harus sama dengan name= di view nya
							'slug_kategori'		=> $slug_kategori,
							'urutan'			=> $i->post('urutan'));
			$this->kategori_model->tambah($data); //memanggil method tambah di Kategori_model.php
			$this->session->flashdata('sukses','Data telah ditambah');
			redirect(base_url('admin/kategori'),'refresh');
		}
		
	}

	//ubah kategori
	public function edit($id_kategori)
	{
		$kategori = $this->kategori_model->detail($id_kategori);
		//validasi input
		$valid = $this->form_validation;
		$valid->set_rules('nama_kategori','Nama kategori','required',
			array('required' =>'%s harus diisi'));

		if($valid->run()===FALSE){
			$data = array(	'title' => 'Edit Kategori Produk',
							'kategori'	=> $kategori,
							'isi'	=> 'admin/kategori/edit'
					);
		$this->load->view('admin/layout/wrapper', $data, FALSE);
		//Masuk database
		}else{
			$i = $this->input;
			$slug_kategori = url_title($this->input->post('nama_kategori'),'dash', TRUE);//berasal dari user_guide CodeIgniter bagian slug
			
			$data = array(	'id_kategori'		=> $id_kategori,
							'nama_kategori'		=> $i->post('nama_kategori'), //nama_kategori harus sama dengan name= di view nya
							'slug_kategori'		=> $slug_kategori,
							'urutan'			=> $i->post('urutan'));
			$this->kategori_model->edit($data); //memanggil method edit di Kategori_model.php
			$this->session->flashdata('sukses','Data telah diedit');
			redirect(base_url('admin/kategori'),'refresh');
		}
		
	}

	//Deleta kategori
	public function delete($id_kategori){
		$data = array('id_kategori' => $id_kategori);
		$this->kategori_model->delete($data); //memanggil method delete di Kategori_model.php
		$this->session->flashdata('sukses','Data telah dihapus');
		redirect(base_url('admin/kategori'),'refresh');
	}

}

/* End of file Kategori.php */
/* Location: ./application/controllers/admin/Kategori.php */