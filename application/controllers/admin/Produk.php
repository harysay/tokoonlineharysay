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

		$valid->set_rules('nama_produk','Nama Produk','required',
			array('required' =>'%s harus diisi'));

		$valid->set_rules('kode_produk','Kode Produk','required|is_unique[produk.kode_produk]',
			array(	'required' =>'%s harus diisi',
					'is_unique'=>'%s sudah ada. Buat kode produk baru'));

		if($valid->run()){
			$config['upload_path'] 		= './assets/upload/image/';
			$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
			$config['max_size']  		= '2400';//dalam KB
			$config['max_width']  		= '2024';
			$config['max_height']  		= '2024';
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('gambar')){ //gambar sesuai dengan name di inputannya
			
				$data = array(	'title' => 'Tambah Produk',
								'kategori' => $kategori,
								'error'	=> $this->upload->display_errors(),
								'isi'	=>	'admin/produk/tambah'
						);
				$this->load->view('admin/layout/wrapper', $data, FALSE);
				// echo "failed1";
				//Masuk database
			}else{
				$upload_gambar = array('upload_data' => $this->upload->data());
				//create thumbnail gambar
				$config_2['image_library'] 	= 'gd2';
				// $config['source_image'] 	= base_url('assets/upload/image/2019-03-18_094510.jpg');
				$config_2['source_image'] 	= 'assets/upload/image/'.$upload_gambar['upload_data']['file_name'];
				//lokasi folder thumbnail
				$config_2['new_image']		= './assets/upload/image/thumbs/'; //lokasi file image thumnail nya
				$config_2['create_thumb'] 	= TRUE;
				$config_2['thumb_marker'] 	= '';
				$config_2['maintain_ratio'] 	= TRUE;
				$config_2['width']         	= 250;//pixel
				$config_2['height']       	= 250;//pixel

				$this->load->library('image_lib', $config_2);

				$this->image_lib->resize();
				//end create thumbnail
				
				$i = $this->input;
				//slug produk
				$slug_produk = url_title($this->input->post('nama_produk').'-'.$this->input->post('kode_produk'),'dash',TRUE);
				$data = array(	'id_user'			=> $this->session->userdata('id_user'),
								'id_kategori'		=> $i->post('id_kategori'), 
								'kode_produk'		=> $i->post('kode_produk'),
								'nama_produk'		=> $i->post('nama_produk'),
								'slug_produk'		=> $slug_produk,
								'keterangan'		=> $i->post('keterangan'),
								'keywords'			=> $i->post('keywords'),
								'harga'				=> $i->post('harga'),
								'stok'				=> $i->post('stok'),
								'gambar'			=> $upload_gambar['upload_data']['file_name'],
								'berat'				=> $i->post('berat'),
								'ukuran'			=> $i->post('ukuran'),
								'status_produk'		=> $i->post('status_produk'),
								'tanggal_post'		=> date('Y-m-d H:i:s')
							);

				
				$this->produk_model->tambah($data); //memanggil method tambah di Produk_model.php
				$this->session->flashdata('sukses','Data telah ditambah');
				redirect(base_url('admin/produk'),'refresh');
			}
		}
			//end database
			$data = array(	'title' 	=> 'Tambah Produk',
							'kategori' 	=> $kategori,
							'isi'		=>	'admin/produk/tambah'
						);
			$this->load->view('admin/layout/wrapper', $data, FALSE);
	}

	//ubah produk
	public function edit($id_produk)
	{
		//Ambil data kategori
		$kategori = $this->kategori_model->listing();
		//Ambil data produk yang akan diedit
		$produk = $this->produk_model->detail($id_produk);

		//validasi input
		$valid = $this->form_validation;

		$valid->set_rules('nama_produk','Nama Produk','required',
			array('required' =>'%s harus diisi'));

		$valid->set_rules('kode_produk','Kode Produk','required',
			array(	'required' =>'%s harus diisi'));

		if($valid->run()){
			// Cek jik gambar diganti
			if(!empty($_FILES['gambar']['name'])){

			$config['upload_path'] 		= './assets/upload/image/';
			$config['allowed_types'] 	= 'gif|jpg|png|jpeg';
			$config['max_size']  		= '2400';//dalam KB
			$config['max_width']  		= '2024';
			$config['max_height']  		= '2024';
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload('gambar')){ //gambar sesuai dengan name di inputannya
			
				$data = array(	'title' 	=> 'Edit Produk: '.$produk->nama_produk,
								'kategori' 	=> $kategori,
								'produk'	=> $produk,
								'error'		=> $this->upload->display_errors(),
								'isi'		=>	'admin/produk/edit'
						);
				$this->load->view('admin/layout/wrapper', $data, FALSE);
				// echo "failed1";
				//Masuk database
			}else{
				$upload_gambar = array('upload_data' => $this->upload->data());
				//create thumbnail gambar
				$config_2['image_library'] 	= 'gd2';
				// $config['source_image'] 	= base_url('assets/upload/image/2019-03-18_094510.jpg');
				$config_2['source_image'] 	= 'assets/upload/image/'.$upload_gambar['upload_data']['file_name'];
				//lokasi folder thumbnail
				$config_2['new_image']		= './assets/upload/image/thumbs/'; //lokasi file image thumnail nya
				$config_2['create_thumb'] 	= TRUE;
				$config_2['thumb_marker'] 	= '';
				$config_2['maintain_ratio'] 	= TRUE;
				$config_2['width']         	= 250;//pixel
				$config_2['height']       	= 250;//pixel

				$this->load->library('image_lib', $config_2);

				$this->image_lib->resize();
				//end create thumbnail
				
				$i = $this->input;
				//slug produk
				$slug_produk = url_title($this->input->post('nama_produk').'-'.$this->input->post('kode_produk'),'dash',TRUE);
				$data = array(	'id_produk'			=> $id_produk,
								'id_user'			=> $this->session->userdata('id_user'),
								'id_kategori'		=> $i->post('id_kategori'), 
								'kode_produk'		=> $i->post('kode_produk'),
								'nama_produk'		=> $i->post('nama_produk'),
								'slug_produk'		=> $slug_produk,
								'keterangan'		=> $i->post('keterangan'),
								'keywords'			=> $i->post('keywords'),
								'harga'				=> $i->post('harga'),
								'stok'				=> $i->post('stok'),
								'gambar'			=> $upload_gambar['upload_data']['file_name'],
								'berat'				=> $i->post('berat'),
								'ukuran'			=> $i->post('ukuran'),
								'status_produk'		=> $i->post('status_produk'),
								'tanggal_update'	=> date('Y-m-d H:i:s'),
								'diubah_oleh'		=> $this->session->userdata('id_user')
							);
				$this->produk_model->edit($data); //memanggil method edit di Produk_model.php
				$this->session->flashdata('sukses','Data telah diubah');
				redirect(base_url('admin/produk'),'refresh');
			}
		}else{
			//edit produk tanpa ganti gambar
			$i = $this->input;
				//slug produk
				$slug_produk = url_title($this->input->post('nama_produk').'-'.$this->input->post('kode_produk'),'dash',TRUE);
				$data = array(	'id_produk'			=> $id_produk,
								'id_user'			=> $this->session->userdata('id_user'),
								'id_kategori'		=> $i->post('id_kategori'), 
								'kode_produk'		=> $i->post('kode_produk'),
								'nama_produk'		=> $i->post('nama_produk'),
								'slug_produk'		=> $slug_produk,
								'keterangan'		=> $i->post('keterangan'),
								'keywords'			=> $i->post('keywords'),
								'harga'				=> $i->post('harga'),
								'stok'				=> $i->post('stok'),
								// 'gambar'			=> $upload_gambar['upload_data']['file_name'],
								'berat'				=> $i->post('berat'),
								'ukuran'			=> $i->post('ukuran'),
								'status_produk'		=> $i->post('status_produk'),
								'tanggal_update'	=> date('Y-m-d H:i:s'),
								'diubah_oleh'		=> $this->session->userdata('id_user')
							);
				$this->produk_model->edit($data); //memanggil method edit di Produk_model.php
				$this->session->flashdata('sukses','Data telah diubah');
				redirect(base_url('admin/produk'),'refresh');
		}}
			//end database
			$data = array(	'title' 	=> 'Edit Produk'.$produk->nama_produk,
							'kategori' 	=> $kategori,
							'produk'	=> $produk,
							'isi'		=>	'admin/produk/edit'
						);
			$this->load->view('admin/layout/wrapper', $data, FALSE);
	}

	//Deleta produk
	public function delete($id_produk){
		//Proses hapus gambar
		$produk = $this->produk_model->detail($id_produk);
		unlink('./assets/upload/image/'.$produk->gambar);
		unlink('./assets/upload/image/thumbs/'.$produk->gambar);
		//end proses hapus gambar
		$data = array('id_produk' => $id_produk);
		$this->produk_model->delete($data); //memanggil method delete di Produk_model.php
		$this->session->flashdata('sukses','Data telah dihapus');
		redirect(base_url('admin/produk'),'refresh');
	}

}

/* End of file Produk.php */
/* Location: ./application/controllers/admin/Produk.php */