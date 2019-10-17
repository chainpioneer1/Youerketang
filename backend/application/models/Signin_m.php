<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Signin_m extends MY_Model
{

    function __construct()
    {
        parent::__construct();
        $this->db->query('update tbl_activation set used_status=2 where TIME_TO_SEC(TIMEDIFF(tbl_activation.expire_time, now()))<0');
        $this->load->model("users_m");
    }

    public function hash($string)
    {
        return parent::hash($string);
    }

    public function signout()
    {
        //$this->session->sess_destroy();
        $this->session->unset_userdata('loginuserID');
        $this->session->unset_userdata('user_account');
        $this->session->unset_userdata('user_name');
        $this->session->unset_userdata('user_type');
        $this->session->unset_userdata('user_school');
        $this->session->unset_userdata('user_class');
        $this->session->unset_userdata('lang');
        $this->session->unset_userdata('loggedin');
    }

    public function loggedin()
    {
        $isLoggedIn = (bool)$this->session->userdata("loggedin");
        if($isLoggedIn) $this->users_m->update_usage_time();
        return $isLoggedIn;
    }

    public function signin($uaccount = '', $utype = '', $upassword = '')
    {

        $lang = 'chinese';
        $username = $uaccount;
        $user_type = $utype;
        $user_pass = $upassword;
        if ($uaccount == '') {
            $username = $this->input->post('username');
            $user_type = $this->input->post('user_type');
            $user_pass = $this->hash($this->input->post('password'));
        }
        $user_data = '';
        $userInfo = $this->db->get_where('tbl_user',
            array("user_account" => $username, "password" => $user_pass, "user_type" => $user_type));
        $user_data = $userInfo->row();
        if (!empty($user_data)) {
//            if ($user_data->user_status != '1') return FALSE;
            $code = '';
            $codeInfo = $this->activationcodes_m->get_where(array('user_id'=>$user_data->id,'status'=>1,'used_status'=>1));
            if(count($codeInfo)>0) $code = $codeInfo[0]->code;
            $user_schoolSt = '1';//$this->getSchoolStatus($user_data->user_id);
            //$coursePermission = json_decode($user_data->buycourse_arr);
            if ($user_schoolSt != '0') {
                $data = array(
                    "loginuserID" => $user_data->id,
                    "user_account" => $user_data->user_account,
                    "user_name" => $user_data->user_name,
                    "user_type" => $user_data->user_type,
                    "user_school" => $user_data->user_school,
                    "user_class" => $user_data->user_class,
                    "user_code" => $code,
                    "lang" => $lang,
                    "loggedin" => TRUE
                );
                $this->session->set_userdata($data);
                return TRUE;
            } else {
                return FALSE;
            }
        }
        return FALSE;
    }

    public function getSchoolStatus($user_id)
    {
        return false;
        $user_data = array();
        $SQL = 'SELECT  schools.stop FROM tbl_user
                INNER JOIN schools ON users.school_id = schools.school_id WHERE user_id = ' . $user_id . ';';
        $query = $this->db->query($SQL);

        if (count($query->result()) === 0 || $query === Null) return '0';

        $user_data = $query->row();
        if ($user_data != NULL)
            return $user_data->stop;
        else return '0';
    }
}
/* End of file signin_m.php */
/* Location: .//D/xampp/htdocs/school/mvc/models/signin_m.php */
