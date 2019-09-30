<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Errors extends Admin_Controller {

	function __construct() {
		parent::__construct();

		$language = $this->session->userdata('lang');
		$this->lang->load('errors', $language);
	}
	public function error_404(){
		$this->data["subview"] = "admin/errors/404";
		$this->data["subscript"] = "admin/errors/script";
		$this->data["subcss"] = "admin/errors/css";
		$this->load->view('admin/_layout_main', $this->data);
	}
	public function error_403(){
		$this->data["subview"] = "admin/errors/403";
		$this->data["subscript"] = "admin/errors/script";
		$this->data["subcss"] = "admin/errors/css";
		$this->load->view('admin/_layout_main', $this->data);
	}
}


?>