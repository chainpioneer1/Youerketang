<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Admins extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $language = 'chinese';
        $this->load->model("admins_m");
        $this->load->model("users_m");
        //$language = $this->session->userdata('lang');
//        $this->lang->load('accounts', $language);
        $this->lang->load('courses', $language);
        $this->load->library("pagination");
    }

    public function index()
    {

        $this->data['admins'] = $this->admins_m->get_admin();
        $this->data["subview"] = "admin/accounts/admins";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data["tbl_content"] = $this->output_content($this->data['admins']);
        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function add()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $fullname = $_POST['add_admin_fullname'];
            $password = $_POST['add_admin_password'];
            $label = $_POST['add_admin_label'];
            $permission = $_POST['permission'];
            $arr = array(
                'admin_name' => $fullname,
                'admin_pass' => $this->admins_m->hash($password),
                'admin_label' => $label,
                'permission' => $permission,
                'create_time' => date('Y-m-d H:i:s')
            );
            $midData = $this->admins_m->add($arr);
            $ret['data'] = $this->output_content($midData);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function output_content($items)
    {
        $admin_id = $this->session->userdata("admin_loginuserID");
        $status_str = [$this->lang->line('status_stopped'), $this->lang->line('status_normal')];
        $isAdmin = ($admin_id == 1) ? true : false; // current logged in account is admin
        $output = '';
        $j = 0;
        foreach ($items as $unit):
            $j++;
            $Editable = false;
            $btn_str = [
                $this->lang->line('role_update'),
                $this->lang->line('role_update'),
                $this->lang->line('enable'),
                $this->lang->line('role_manage')
            ];
            if ($unit->admin_id == $admin_id) {
                $Editable = true;
            }
            if($unit->admin_status=='1')
                $btn_str[2] = $this->lang->line('disable');

            $output .= '<tr>';
            $output .= '<td>' . $j . '</td>';
            $output .= '<td>' . $unit->admin_name . '</td>';
            $output .= '<td hidden>' . $unit->admin_pass . '</td>';
            $output .= '<td>' . $unit->admin_label . '</td>';
            $output .= '<td hidden>' . $unit->permission . '</td>';
            $output .= '<td>';
            $output .= '<button style="width:70px;" '
                . ' class="btn btn-sm ' . (($isAdmin || $Editable) ? 'btn-success' : 'disabled') . '" '
                . ' onclick = "' . (($isAdmin || $Editable) ? 'edit_admin(this);' : '') . '" '
                . ' admin_id = "' . $unit->admin_id . '">'
                . $btn_str[1] . '</button>';
            $output .= '<button style="width:70px;"'
                . ' class="btn btn-sm ' . (($unit->admin_id == 1) ? 'disabled' : (($unit->admin_status=='1') ? 'btn-warning' : 'btn-default')) . '"'
                . ' onclick = "' . ((($isAdmin || $Editable)) ? 'publish_item(this)' : '') . ';"'
                . ' item_status = "' . $unit->admin_status . '"'
                . ' item_id = "' . $unit->admin_id . '">'
                . $btn_str[2] . '</button>';
            $output .= '<button style="width:70px;"'
                . ' class="btn btn-sm ' . (($isAdmin || $Editable) ? 'btn-default' : 'disabled') . '"'
                . ' onclick = "' . (($isAdmin || $Editable) ? 'assign_admin(this);' : '') . '"'
                . ' admin_id = "' . $unit->admin_id . '">'
                . $btn_str[3] . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    public function publish_admin()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $item_id = $_POST['item_id'];
            $publish_st = $_POST['publish_state'];
            $items = $this->admins_m->publish($item_id, $publish_st);
            $ret['data'] = $this->output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function edit()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $admin_id = $_POST['admin_id'];
            $admin_label = $_POST['edit_admin_label'];
            $admin_pass = $_POST['edit_admin_password'];

            $arr = array(
                'admin_pass' => $this->admins_m->hash($admin_pass),///mush encrypt this text
                'admin_label' => $admin_label,
                'update_time' => date('Y-m-d H:i:s')
            );
            $this->data['admins'] = $this->admins_m->edit($arr, $admin_id);
            $ret['data'] = $this->output_content($this->data['admins']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function delete()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $admin_id = $_POST['admin_id'];
            $this->admins_m->delete($admin_id);
            $this->data['admins'] = $this->admins_m->get_admin();
            $ret['data'] = $this->output_content($this->data['admins']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function assign()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $admin_id = $_POST['admin_id'];
            $role_arr = $_POST['role_info'];
            $arr = array(
                'permission' => json_encode($role_arr),
                'update_time' => date('Y-m-d H:i:s')
            );
            $this->data['admins'] = $this->admins_m->edit($arr, $admin_id);
            $ret['data'] = $this->output_content($this->data['admins']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }


    public function login_history()
    {

        $this->data['admins'] = $this->admins_m->get_admin();
        $this->data["subview"] = "admin/accounts/login_history";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data["tbl_content"] = $this->output_content_history($this->data['admins']);
        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function output_content_history($items)
    {
        $admin_id = $this->session->userdata("admin_loginuserID");
        $status_str = [$this->lang->line('status_stopped'), $this->lang->line('status_normal')];
        $isAdmin = ($admin_id == 1) ? true : false; // current logged in account is admin
        $output = '';
        $j = 0;
        foreach ($items as $unit):
            $j++;
            $Editable = false;
            $btn_str = [
                $this->lang->line('edit'),
                $this->lang->line('delete'),
                $this->lang->line('enable'),
                $this->lang->line('update_permission')
            ];
            if ($unit->admin_id == $admin_id) {
                $Editable = true;
            }
            if($unit->admin_status=='1')
                $btn_str[2] = $this->lang->line('disable');

            $output .= '<tr>';
            $output .= '<td>' . $unit->admin_name .'</td>';
            $output .= '<td>' . $unit->login_first_time . '</td>';
            $output .= '<td>' . $unit->login_latest_time . '</td>';
            $output .= '<td hidden>' . $unit->login_count . '</td>';
            /*$output .= '<td>' . $unit->admin_label . '</td>';
            $output .= '<td hidden>' . $unit->permission . '</td>';
            $output .= '<td>' . $status_str[$unit->admin_status] . '</td>';*/
            /*$output .= '<td>';
            $output .= '<button style="width:70px;" '
                . ' class="btn btn-sm ' . (($isAdmin || $Editable) ? 'btn-success' : 'disabled') . '" '
                . ' onclick = "' . (($isAdmin || $Editable) ? 'edit_admin(this);' : '') . '" '
                . ' admin_id = "' . $unit->admin_id . '">'
                . $btn_str[0] . '</button>';
            $output .= '<button style="width:70px;"'
                . ' class="btn btn-sm ' . (($unit->admin_id == 1) ? 'disabled' : (($unit->admin_status=='1') ? 'btn-warning' : 'btn-default')) . '"'
                . ' onclick = "' . (($isAdmin || ($unit->admin_status!='1' && $Editable)) ? 'publish_item(this)' : '') . ';"'
                . ' item_status = "' . $unit->admin_status . '"'
                . ' item_id = "' . $unit->admin_id . '">'
                . $btn_str[2] . '</button>';
            $output .= '<button style="width:70px;"'
                . ' class="btn btn-sm ' . (($isAdmin || $Editable) ? 'btn-default' : 'disabled') . '"'
                . ' onclick = "' . (($isAdmin || $Editable) ? 'assign_admin(this);' : '') . '"'
                . ' admin_id = "' . $unit->admin_id . '">'
                . $btn_str[3] . '</button>';*/
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    function checkRole($id = 40)
    {
        $this->data['roleName'] = $id;
        $permission = $this->session->userdata('admin_user_type');
        if ($permission != NULL) {
            $permissionData = (array)(json_decode($permission));
            $accessInfo = $permissionData['menu_' . $id];
            if ($accessInfo == '1') return true;
            else return false;
        }
        return false;
    }
}

?>