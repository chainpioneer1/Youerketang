<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Activation extends Admin_Controller
{
    protected $mainModel;

    function __construct()
    {
        parent::__construct();
        $language = 'chinese';
        $this->load->model("sites_m");
        $this->load->model("activationcodes_m");
        $this->load->model("courses_m");
        $this->lang->load('courses', $language);
        $this->load->library("pagination");

        $this->mainModel = $this->activationcodes_m;
    }

    public function index()
    {
        $this->data['title'] = '激活码管理';
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";

        $filter = array();
        if ($this->uri->segment(SEGMENT) == '') $this->session->unset_userdata('filter');
        if ($_POST) {
            $this->session->unset_userdata('filter');
            $_POST['search_code'] != '' && $filter['tbl_activation.code'] = $_POST['search_code'];
            $_POST['search_status'] != '' && $filter['tbl_activation.used_status'] = $_POST['search_status'];
            $_POST['search_course'] != '' && $filter['tbl_sites.title'] = $_POST['search_course'];
            $this->session->set_userdata('filter', $filter);
        }
        $this->session->userdata('filter') != '' && $filter = $this->session->userdata('filter');

        $this->data['perPage'] = $perPage = PERPAGE;
        $this->data['cntPage'] = $cntPage = $this->mainModel->get_count($filter);
        $ret = $this->paginationCompress('admin/activation/index', $cntPage, $perPage, 4);
        $this->data['curPage'] = $curPage = $ret['pageId'];
        $this->data["list"] = $this->mainModel->getItemsByPage($filter, $ret['pageId'], $ret['cntPerPage']);

        $this->data["tbl_content"] = $this->output_content($this->data['list']);

        $this->data['statusList'] = ['未激活', '已激活', '已过期'];
        $this->data['courseList'] = $this->sites_m->get_where();

        $this->data["subview"] = "admin/activation/index";

        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    function output_content($items)
    {
        $output_html = '';
        $j = 0;
        $status_activation = [$this->lang->line('status_unactivated'), $this->lang->line('status_activated'), '已过期'];
        $status_user = [$this->lang->line('status_disabled'), $this->lang->line('status_using')];
        foreach ($items as $unit):
            $j++;
            $editable = $unit->status == 0;
            $isDisabled = true;
            $btn_str = ['启用', '禁用', '修改', '删除'];
            if ($unit->code == '') continue;
            $userType = ["无", "教师", "学生"];
            $output_html .= '<tr>';
            $output_html .= '<td>' . $j . '</td>';
            $output_html .= '<td style="-webkit-user-select: auto!important;-moz-user-select: auto!important;'
                . '-ms-user-select: auto!important;user-select: auto!important;">'
                . $unit->code . '</td>';
            $output_html .= '<td>' . $unit->site . '</td>';
            $output_html .= '<td>' . $status_activation[$unit->used_status] . '</td>';
            $output_html .= '<td>' . $unit->user_account . '</td>';
            $output_html .= '<td>' . $unit->create_time . '</td>';
            $output_html .= '<td>' . $unit->activate_time . '</td>';
            $output_html .= '<td>' . $unit->expire_time . '</td>';
            $output_html .= '<td>';

            $output_html .= '<button'
                . ' class="btn btn-sm ' . ($editable ? 'btn-danger' : 'disabled') . '"'
                . ' onclick = "' . ($editable ? 'deleteItem(this);' : '') . '"'
                . ' data-id = "' . $unit->id . '">'
                . $btn_str[3] . '</button>';
            $output_html .= '<button'
                . ' class="btn btn-sm ' . ($editable ? 'btn-default' : 'btn-warning') . '"'
                . ' onclick = "publishItem(this);"'
                . ' data-status = "' . $unit->status . '"'
                . ' data-id = "' . $unit->id . '">'
                . $btn_str[$unit->status] . '</button>';
            $output_html .= '</td>';
            $output_html .= '</tr>';
        endforeach;
        return $output_html;
    }

    public function updateItem()
    {
        $ret = array(
            'data' => '操作失败',
            'status' => 'fail'
        );
        if (!$this->adminsignin_m->loggedin()) {
            echo json_encode($ret);
            return;
        }
        if ($_POST) {
            $count = $_POST['count'];
            $courseId = $_POST['course'];

            for ($i = 0; $i < $count; $i++) {
                $param = array(
                    'code' => $this->generateRandomString(8),
                    'status' => 0,
                    'used_status' => 0,
                    'site_id' => $courseId,
                    'create_time' => date('Y-m-d H:i:s')
                );
                $this->activationcodes_m->add($param);
            }

            $ret['data'] = '操作成功';//$this->output_content($this->mainModel->getItems());
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function publishItem()
    {
        $ret = array(
            'data' => '操作失败',
            'status' => 'fail'
        );
        if (!$this->adminsignin_m->loggedin()) {
            echo json_encode($ret);
            return;
        }
        if ($_POST) {
            $id = $_POST['id'];
            $status = $_POST['status'];
            $items = $this->mainModel->publish($id, $status);
            $ret['data'] = $ret['data'] = '操作成功';//$this->output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function deleteItem()
    {
        $ret = array(
            'data' => '操作失败',
            'status' => 'fail'
        );
        if (!$this->adminsignin_m->loggedin()) {
            echo json_encode($ret);
            return;
        }
        if ($_POST) {
            $id = $_POST['id'];
            $list = $this->mainModel->delete($id);
            $ret['data'] = $ret['data'] = '操作成功';//$this->output_content($list);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    function generateRandomString($length = 10)
    {
        $characters = '23456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function checkRole()
    {
        $permission = $this->session->userdata('admin_user_type');
        if ($permission != NULL) {
            $permissionData = json_decode($permission);
            $accessInfo = $permissionData->menu_10;
            if ($accessInfo == '1') return true;
            else return false;
        }
        return false;
    }

}
