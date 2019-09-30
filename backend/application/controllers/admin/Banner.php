<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Banner extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $language = 'chinese';
        $this->load->model("banner_m");
        $this->lang->load('courses', $language);
        $this->load->library("pagination");
    }

    public function index()
    {
        $this->data['items'] = $this->banner_m->getItems();
        $this->data["subview"] = "admin/banner/banner";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data["tbl_content"] = $this->output_content($this->data['items']);
        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function edit()
    {
        $ret_st = array(
            'data' => '',
            'status' => 'fail'
        );
        $config['upload_path'] = "./uploads/";
        $config['allowed_types'] = '*';
        //$config['max_size'] = '500*8';
        //$config['max_width']  = '300';
        //$config['max_height']  = '700';
        $this->load->library('upload', $config);

        if ($_POST) {
            $unit_image_path = '';
            ///image upload function
            $data = null;
            $data["file_name"] = '';
            if (isset($_FILES["file_name"]["name"]) && $_FILES["file_name"]["name"] != '') {
                if ($this->upload->do_upload('file_name')) {
                    $data = $this->upload->data();
                    $banner_image_path = 'uploads/' . $data["file_name"];
                }
            } else {
                $ret_st['data'] = $this->upload->display_errors();
                echo json_encode($ret_st);
                return;
            }
            $unit_id = $_POST['unit_id'];
            $banner_name = $_POST['banner_name'];
            $course_id = $_POST['course_id'];

            $this->data['items'] = $this->banner_m->edit($unit_id, $banner_name, $course_id, $data["file_name"]);

            $ret_st['status'] = 'success';
            $ret_st['data'] = $this->output_content($this->data['items']);
            echo json_encode($ret_st);
        } else {
            echo json_encode($ret_st);
            return;
        }
    }

    function output_content($items)
    {
        $output = '';
        $modifyStr = $this->lang->line('Modify');
        foreach ($items as $unit):
            $output .= '<tr>';
            $output .= '<td id="itemName' . $unit->id . '">' . $unit->name . '</td>';
            $output .= '<td><iframe id="itemImage' . $unit->id . '"'
                . ' src="' . base_url() . 'uploads/' . $unit->image . '" '
                . 'alt="" style="width:320px; height:181px;outline:none;border:1px solid #eee;border-radius: 10px;object-fit: fill;" frameborder="no"></iframe></td>';
            $output .= '<td>';
            $output .= '<button style="width:70px;" class="btn btn-sm btn-success" '
                . ' onclick= "edit_unit(this);"  unit_id =' . $unit->id . ' linkcourse_id="' . $unit->course_id . '">'
                . $modifyStr
                . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    function checkRole()
    {
        return true;
        $permission = $this->session->userdata('admin_user_type');
        if ($permission != NULL) {
            $permissionData = json_decode($permission);
            $accessInfo = $permissionData[3]->banner_st;
            if ($accessInfo == '1') return true;
            else return false;
        }
        return false;
    }

}
