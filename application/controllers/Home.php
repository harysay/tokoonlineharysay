<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	// halaman utama website toko tampak user
	public function index()
	{
		$data = array(	'title' => 'Harysay - Toko Online',
						'isi' => 'home/list'
						 );
		$this->load->view('layout/wrapper', $data, FALSE);
	}

}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */