<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	//Listing all produk
	public function listing(){
		$this->db->select('produk.*,users.nama,kategori.nama_kategori,kategori.slug_kategori');
		$this->db->from('produk');
		//JOIN
		$this->db->join('users', 'users.id_user = produk.id_user', 'left');
		$this->db->join('kategori', 'kategori.id_kategori = produk.id_kategori', 'left');
		//END JOIN
		$this->db->order_by('id_produk', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	//Detail produk
	public function detail($id_produk){
		$this->db->select('*');
		$this->db->from('produk');
		$this->db->where('id_produk', $id_produk);
		$this->db->order_by('id_produk', 'desc');
		$query = $this->db->get();
		return $query->row();
	}

	//Login produk
	public function login($produkname,$password){
		$this->db->select('*');
		$this->db->from('produk');
		$this->db->where(array(	'produkname' => $produkname,
								'password'=> sha1($password)));
		$this->db->order_by('id_produk', 'desc');
		$query = $this->db->get();
		return $query->row();
	}

	//tambah produk
	public function tambah($data){
		$this->db->insert('produk', $data);
	}

	//edit produk
	public function edit($data){
		$this->db->where('id_produk', $data['id_produk']);
		$this->db->update('produk', $data);

	}

	//delete produk
	public function delete($data){
		$this->db->where('id_produk', $data['id_produk']);
		$this->db->delete('produk', $data);

	}

}

/* End of file Produk_model.php */
/* Location: ./application/models/Produk_model.php */