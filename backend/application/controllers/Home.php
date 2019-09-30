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
        $this->load->model("banner_m");
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function index()
    {
        $this->data["banners"] = $this->banner_m->getItems();
        $this->data["sites"] = $this->sites_m->getItems();
        $this->data['errMsg'] = '';
        if ($this->signin_m->loggedin() == TRUE) { // loggedin
            $codeInfo = $this->activationcodes_m
                ->get_where(array(
                    'user_id' => $this->session->userdata('loginuserID'),
                    'used_status' => 1,
                    'status' => 1
                ));
            if (count($codeInfo) <= 0) { // user activation code expired
                $this->data['errMsg'] = '授权码无效或者被禁用了';
                $this->data["subview"] = "signin/activation";
            } else { // user activation code available
                $this->data["subview"] = "home/index";
            }
            $this->load->view('_layout_main', $this->data);
        } else { // not loggedin
            $this->data["subview"] = "home/index";
            $this->load->view('_layout_main', $this->data);
        }
    }

    public function activation()
    {
        $this->data["banners"] = $this->banner_m->getItems();
        $userInfo = $this->users_m->get_where(array('user_account' => $this->session->userdata('user_account')));
        $this->data['errMsg'] = '';
        $this->data["subview"] = "signin/activation";
        if ($_POST) {
            if (count($userInfo) <= 0) {
                $this->data['errMsg'] = '账号不存在';
                $this->load->view('_layout_main', $this->data);
                return;
            }

            $code = $_POST['code'];
            $usableCodes = $this->activationcodes_m->get_where(array(
                'code' => $code, 'status' => 1, 'used_status' => 0, 'user_type' => $userInfo[0]->user_type
            ));
            if (count($usableCodes) <= 0) {
                $this->data['errMsg'] = '授权码无效';
                $this->load->view('_layout_main', $this->data);
                return;
            }

            $arr = array(
                'user_id' => $userInfo[0]->id,
                'used_status' => 1,
                'activate_time' => date('Y-m-d H:i:s'),
                'expire_time' => date("Y-m-d H:i:s", strtotime('+1 years')),
                'update_time' => date('Y-m-d H:i:s'),
            );
            $this->activationcodes_m->edit($arr, $usableCodes[0]->id);
            if ($userInfo[0]->user_type == '1') { // if teacher
                $this->data["subview"] = "home/index";
            } else if ($userInfo[0]->user_type == '2') { // if student
                redirect(base_url('student/home'));
                return;
            }
        }
        $this->load->view('_layout_main', $this->data);
        return;
    }
}

?>