<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Mainadmin extends CI_Controller {

	function __construct() {
		parent::__construct();

		$language = 'chinese';
		$this->lang->load('frontend', $language);
		$this->load->library("pagination");
		$this->load->library("session");
	}

	public function index(){

        $this->data["subview"] = "admin/signin/index";
        $this->load->view('admin/_layout_signin', $this->data);
        $this->session->sess_destroy();
	}
}
?>