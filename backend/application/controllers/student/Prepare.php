<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Prepare extends CI_Controller {

	function __construct() {
		parent::__construct();

		$language = 'chinese';
		$this->lang->load('courses', $language);
        $this->load->model('banner_m');
 		$this->load->library("pagination");
		$this->load->library("session");
	}

	public function index(){
        $this->data["subview"] = "";
        $this->load->view('student/prepare', $this->data);
	}

}
?>