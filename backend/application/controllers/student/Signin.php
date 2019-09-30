<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Signin extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->lang->load('courses', $language);
        $this->load->library("pagination");
        $this->load->model("users_m");
        $this->load->model("activationcodes_m");
        $this->load->model("signin_m");
        $this->load->library("session");
        $this->load->library('form_validation');
    }

    public function index()
    {
        $this->signin_m->loggedin() == FALSE || redirect(base_url('student/home'));

        $this->data['parentView'] = '';
        $this->data['form_validation'] = 'No';
        $this->data["subview"] = "student/login";
        $this->load->view('_layout_student_nonav', $this->data);
    }

    public function signin()
    {
        $this->signin_m->loggedin() == FALSE || redirect(base_url('student/home'));

        $this->data['parentView'] = '';
        $this->data['form_validation'] = 'No';
        if ($_POST) {
            $rules = $this->rules();
            $this->form_validation->set_rules($rules);
            if ($this->form_validation->run() == FALSE) {
                $this->data['form_validation'] = validation_errors();
                $this->data["subview"] = "student/login";
                $this->load->view('_layout_student_nonav', $this->data);
            } else {
                if ($this->signin_m->signin() == TRUE) {
                    $user_id = $this->session->userdata("loginuserID");
                    $arr = array();
                    $arr['register_time'] = date('Y-m-d H:i:s');
                    $arr['information'] = $this->get_client_ip();

                    $this->users_m->update_user($arr, $user_id);
                    $this->users_m->update_user_login_num($user_id);

                    redirect(base_url('student/home'));
                } else {
                    $result = $this->users_m->get_where(
                        array("user_account" => $_POST['username'],
                            "user_type" => $_POST['user_type'],
                            "user_status" => '0'
                        )
                    );
                    if (false && count($result) > 0)
                        $this->data['form_validation'] = "Waiting";
                    else
                        $this->data['form_validation'] = "Incorrect Signin";
                    $this->session->set_flashdata("errors", "That user does not signin");
                    $this->data["subview"] = "student/login";
                    $this->load->view('_layout_student_nonav', $this->data);
                }
            }
        } else {
            $this->data["subview"] = "student/login";
            $this->load->view('_layout_student_nonav', $this->data);
        }
    }

    public function signin_post()
    {
        $ret = [
            'status' => 'fail',
            'data' => ''
        ];

        if ($this->signin_m->signin() != TRUE) {
            $ret['data'] = "Signin failed.";
            echo json_encode($ret);
            return;
        }

        $user_id = $this->session->userdata("loginuserID");
        $arr = array();
        $arr['register_time'] = date('Y-m-d H:i:s');
        $arr['information'] = $this->get_client_ip();

        $this->users_m->update_user($arr, $user_id);
        $this->users_m->update_user_login_num($user_id);

        $ret['status'] = 'success';
        $ret['data'] = $user_id;
        echo json_encode($ret);
    }

    public function signout()
    {
        $this->signin_m->signout();
        redirect(base_url("student/signin"));
    }

    public function forgot()
    {
        $this->signin_m->loggedin() == FALSE || redirect(base_url('student/home'));

        $this->data['parentView'] = 'student/signin';
        $this->data["subview"] = "student/forgot";
        $this->load->view('_layout_student_nonav', $this->data);
    }

    public function signup()
    {
        $this->signin_m->loggedin() == FALSE || redirect(base_url('student/home'));

        $this->data['parentView'] = 'student/signin';
        $this->data["subview"] = "student/signup";
        $this->load->view('_layout_student_nonav', $this->data);
    }

    protected function rules()
    {
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

    public function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}

?>