<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Statistics extends Admin_Controller {

	function __construct() {
		parent::__construct();
        $language = 'chinese';
		$this->load->model("statistics_m");
        $this->load->model("users_m");
        $this->load->model('signin_m');
        $this->load->library("session");
		//$language = $this->session->userdata('lang');
		$this->lang->load('accounts', $language);
        $this->lang->load('courses',$language);
		$this->load->library("pagination");
	}
	public function index(){

		$this->data['loginSets'] = $this->statistics_m->get_loginInfo();
		$this->data["subview"] = "admin/accounts/loginstatistics";
		$this->data["subscript"] = "admin/settings/script";
		$this->data["subcss"] = "admin/settings/css";
        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
	}

    function checkRole()
    {

        $permission = $this->session->userdata('admin_user_type');
        if ($permission != NULL) {
            $permissionData = json_decode($permission);
            $accessInfo = $permissionData[1]->logview_st;
            if ($accessInfo == '1') return true;
            else return false;
        }
        return false;
    }

    public function coursewares(){

        $cw_name_value = '';
        $startTime_value = '';
        $endTime_value = '';
        if($_POST)///for search in courseware name and starttime, endtime
        {

            $cw_name   = (empty($_POST['cw_name_search']))? '':$_POST['cw_name_search'];
            $startTime = (empty($_POST['startTime_search']))? '2000-00-00 00:00:00':$_POST['startTime_search'];
            $endTime   = (empty($_POST['endTime_search']))? '3000-00-00 00:00:00':$_POST['endTime_search'];

            $arr = array('courseware_name'=>$cw_name);

            $this->data['cwAccessSets'] = $this->statistics_m->cw_accessInfo_search($arr,$startTime,$endTime);

            $cw_name_value = $cw_name;
            if($startTime=='2000-00-00 00:00:00')  $startTime_value = '';
            else $startTime_value = $startTime;
            if($endTime=='3000-00-00 00:00:00') $endTime_value = '';
            else $endTime_value = $endTime;

        }else{
            $this->data['cwAccessSets'] = $this->statistics_m->get_cwAccessInfo();
        }

        $this->data['cw_name_value'] = $cw_name_value;
        $this->data['startTime_value'] = $startTime_value;
        $this->data['endTime_value'] = $endTime_value;

        $this->data["subview"] = "admin/accounts/coursewarestatistics";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->load->view('admin/_layout_main', $this->data);

    }
    public function subwares()
    {
        $sw_type_name_value = '';
        $startTime_value = '';
        $endTime_value = '';
        if($_POST)///for search in courseware name and starttime, endtime
        {

            $sw_type_name   = (empty($_POST['sw_type_name_search']))? '':$_POST['sw_type_name_search'];
            $startTime = (empty($_POST['startTime_search']))? '2000-00-00 00:00:00':$_POST['startTime_search'];
            $endTime   = (empty($_POST['endTime_search']))? '3000-00-00 00:00:00':$_POST['endTime_search'];

            $arr = array('subware_type_name'=>$sw_type_name);

            $this->data['swAccessSets'] = $this->statistics_m->sw_accessInfo_search($arr,$startTime,$endTime);

            $sw_type_name_value = $sw_type_name;
            if($startTime=='2000-00-00 00:00:00')  $startTime_value = '';
            else $startTime_value = $startTime;
            if($endTime=='3000-00-00 00:00:00') $endTime_value = '';
            else $endTime_value = $endTime;

        }else{
            $this->data['swAccessSets'] = $this->statistics_m->get_swAccessInfo();
        }

        $this->data['sw_type_name_value'] = $sw_type_name_value;
        $this->data['startTime_value'] = $startTime_value;
        $this->data['endTime_value'] = $endTime_value;

        $this->data["subview"] = "admin/accounts/subwarestatistics";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->load->view('admin/_layout_main', $this->data);
    }

}

?>