<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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

/* End of file Admin_Controller.php */
/* Location: .//D/xampp/htdocs/school/mvc/libraries/Admin_Controller.php */

?>