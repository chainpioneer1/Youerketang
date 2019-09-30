<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Methods: GET, OPTIONS");

class MY_Controller extends CI_Controller {
/*
| -----------------------------------------------------
| PRODUCT NAME: 	INILABS SCHOOL MANAGEMENT SYSTEM
| -----------------------------------------------------
| AUTHOR:			INILABS TEAM
| -----------------------------------------------------
| EMAIL:			info@inilabs.net
| -----------------------------------------------------
| COPYRIGHT:		RESERVED BY INILABS IT
| -----------------------------------------------------
| WEBSITE:			http://inilabs.net
| -----------------------------------------------------
*/
	public $data = array();

	public function __construct() {
		parent::__construct();
		$this->data['errors'] = array();
	}

}

/* End of file MY_Controller.php */
/* Location: .//D/xampp/htdocs/school/mvc/core/MY_Controller.php */

define("PERPAGE", 20);

class Admin_Controller extends MY_Controller {
/*
| -----------------------------------------------------
| PRODUCT NAME: 	INILABS SCHOOL MANAGEMENT SYSTEM
| -----------------------------------------------------
| AUTHOR:			INILABS TEAM
| -----------------------------------------------------
| EMAIL:			info@inilabs.net
| -----------------------------------------------------
| COPYRIGHT:		RESERVED BY INILABS IT
| -----------------------------------------------------
| WEBSITE:			http://inilabs.net
| -----------------------------------------------------
*/

	function __construct () {

		parent::__construct();
		$this->load->model("adminsignin_m");
		$this->load->model("admins_m");

		$this->load->library("session");
		$this->load->helper('language');
		$this->load->helper('date');
		$this->load->helper('form');
		$this->load->helper('security');
		$this->load->library('form_validation');

		$language = $this->session->userdata('lang');

		$exception_uris = array(
			"admin/signin/index",
			"admin/signin/signout"
		);

		if(in_array(uri_string(), $exception_uris) == FALSE) {
			if($this->adminsignin_m->loggedin() == FALSE) {
				redirect(base_url("admin/signin/index"));
			}
		}
	}
}
