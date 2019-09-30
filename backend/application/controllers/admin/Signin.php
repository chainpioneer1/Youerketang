<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signin extends Admin_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model("admins_m");
        $this->load->library("session");
        $data = array(
            "lang" => 'chinese',
        );
        $this->session->set_userdata($data);
        $language = $this->session->userdata('lang');
        $this->lang->load('signin', $language);
    }
    protected function rules() {
        $rules = array(
            array(
                'field' => 'username',
                'label' => "Username",
                'rules' => 'trim|required|max_length[30]'
            ),
            array(
                'field' => 'password',
                'label' => "Password",
                'rules' => 'trim|required|max_length[30]'
            )
        );
        return $rules;
    }

    public function index() {

        $this->adminsignin_m->loggedin() == FALSE || redirect(base_url('admin/activation'));
        $this->data['form_validation'] = 'No';
        if($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->data['form_validation'] = validation_errors();
                $this->load->view('admin/_layout_signin', $this->data);
            } else {
                if($this->adminsignin_m->signin() == TRUE) {
                    redirect(base_url('admin/activation'));
                } else {
                    $this->session->set_flashdata("errors", "That user does not signin");
                    $this->data['form_validation'] = "Incorrect Signin";
                    $this->load->view('admin/_layout_signin', $this->data);
                }
            }
        } else {
            $this->data["subview"] = "admin/signin/index";
            $this->load->view('admin/_layout_signin', $this->data);
            $this->session->sess_destroy();
        }
    }
    public function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    public function cpassword() {
        $this->load->library("session");
        if($_POST) {
            $rules = $this->rules_cpassword();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->data["subview"] = "admin/signin/cpassword";
                $this->load->view('admin/_layout_main', $this->data);
            } else {
                redirect(base_url('admin/signin/cpassword'));
            }
        } else {
            $this->data["subview"] = "admin/signin/cpassword";
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function signout() {
        $this->adminsignin_m->signout();
        redirect(base_url("admin/signin/index"));
    }
    public function loggedin() {
        return (bool) $this->session->userdata("admin_loggedin");
    }
    public function hash($string) {
        return parent::hash($string);
    }
}
?>