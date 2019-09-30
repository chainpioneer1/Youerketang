<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->lang->load('courses', $language);
        $this->load->model("activationcodes_m");
        $this->load->model("users_m");
        $this->load->model("signin_m");
        $this->load->model("sites_m");
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function index()
    {
        $this->data["sites"] = $this->sites_m->getItems();
        $this->data['errMsg'] = '';
        if ($this->signin_m->loggedin() == TRUE) {
            $codeInfo = $this->activationcodes_m
                ->get_where(array(
                    'user_id' => $this->session->userdata('loginuserID'),
                    'used_status' => 1,
                    'status' => 1
                ));
            if (count($codeInfo) <= 0) {
                $this->data['errMsg'] = '授权码无效或者被禁用了';
                $this->data["subview"] = "signin/activation";
                $this->load->view('_layout_main', $this->data);
                return;
            }

            $this->data["codeInfo"] = $codeInfo;
            $this->data["subview"] = "student/home";
            $this->load->view('_layout_student', $this->data);
        } else {
            redirect(base_url('student/signin'));
        }
    }
}

?>