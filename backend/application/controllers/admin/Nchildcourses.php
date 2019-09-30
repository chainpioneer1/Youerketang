<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nchildcourses extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->load->model("nchildcourses_m");
        $this->load->model("courses_m");
        $this->load->model("schools_m");
        $this->load->model("users_m");
        $this->lang->load('courses', $language);
        $this->load->library("pagination");

    }

    public function index()
    {
        $this->data['courses'] = $this->courses_m->get_courses(array('course_slug' => 'sandapian'));
        $this->data['nchildcourses'] = $this->nchildcourses_m->get_nchild_courses();
        $this->data["subview"] = "admin/courses/nchildcourses";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data["tbl_content"] = $this->output_content($this->data['nchildcourses']);
        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function publish()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $nccsId = $_POST['nccsId'];
            $publish_cw_st = $_POST['publish_state'];
            $this->data['nccsSets'] = $this->nchildcourses_m->publish($nccsId, $publish_cw_st);
            $ret['data'] = $this->output_content($this->data['nccsSets']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function output_content($nccsSet)
    {
        $output_html = '';
        $sn = 0;
        foreach ($nccsSet as $nccs):
            $sn++;
            $pub = '';
            if ($nccs->childcourse_publish == '1') $pub = $this->lang->line('Disable');
            else $pub = $this->lang->line('Enable');
            $output_html .= '<tr>';
            $output_html .= '<td>' . $nccs->childcourse_number . '</td>';
            $output_html .= '<td>' . $nccs->childcourse_name . '</td>';
            $output_html .= '<td>' . $nccs->course_name . '</td>';
//            $output_html .= '<td>' . $nccs->school_type_name . '</td>';
            $output_html .= '<td>';
            $output_html .= '<button class="btn btn-sm '
                . (($nccs->childcourse_publish == '1') ? 'btn-warning' : 'btn-default')
                . '" '
                . 'onclick = "publish_nccs(this);" nccs_id = ' . $nccs->childcourse_id . '>'
                . $pub . '</button>';
            $output_html .= '<button class="btn btn-sm btn-success"'
                . ' onclick = "edit_nccs(this);"'
                . '" nccs_id = ' . $nccs->childcourse_id
                . '" nccs_sort = ' . $nccs->sort_number
                . '>' . $this->lang->line('SortOrder') . '</button>';
//            $output_html .= '<button class="btn btn-sm btn-warning" onclick = "delete_nccs(this);" nccs_id = ' . $nccs->childcourse_id . '>' . $this->lang->line('Delete') . '</button>';
            $output_html .= '</td>';
            $output_html .= '</tr>';
        endforeach;
        return $output_html;
    }

    ////directory manager and file manager
    function checkRole()
    {

        $permission = $this->session->userdata('admin_user_type');
        if ($permission != NULL) {
            $permissionData = json_decode($permission);
            $accessInfo = $permissionData[0]->cs_pro_st;
            if ($accessInfo == '1') return true;
            else return false;
        }
        return false;
    }


    public function add()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        $config['upload_path'] = "./uploads/images";
        $config['allowed_types'] = 'bmp|gif|jpg|png';
        $this->load->library('upload', $config);

        if (isset($_FILES["add_file_name"]["name"]) && $_POST) {
            $add_nccs_image_path = '';
            //image uploading
            if ($this->upload->do_upload('add_file_name')) {
                $data = $this->upload->data();
                $add_nccs_image_path = 'uploads/images/' . $data["file_name"];
            } else {
                $ret['data'] = $this->upload->display_errors();
                $ret['status'] = 'fail';
                echo json_encode($ret);
                return;
            }
            ///update courseware table
            $add_cs_id = $this->input->post('add_cs_name');
            $add_nccs_name = $this->input->post('add_nccs_name');
            $add_school_type_name = $this->input->post('add_school_type_name');
            $add_school_type_id = $this->schools_m->getSchoolTypeIdFromName($add_school_type_name);
            $isFree = $this->input->post('free_option');

            $param = array(
                'childcourse_name' => $add_nccs_name,
                'course_id' => $add_cs_id,
                'school_type_id' => $add_school_type_id,
                'childcourse_photo' => $add_nccs_image_path,
                'childcourse_publish' => '1',
                'childcourse_isfree' => $isFree
            );
            $this->data['nccsSets'] = $this->nchildcourses_m->add($param);
            $ret['data'] = $this->output_content($this->data['nccsSets']);
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
        $config['upload_path'] = "./uploads/images";
        $config['allowed_types'] = 'bmp|gif|jpg|png';
        //$config['max_size'] = '1024*8';
        //$config['max_width']  = '300';
        //$config['max_height']  = '300';
        $this->load->library('upload', $config);

        $edit_nccs_id = $this->input->post('nccs_id');
        $edit_nccs_sort_number = $this->input->post('edit_nccs_sort_number');

        $param = array(
            'sort_number' => $edit_nccs_sort_number,
        );

        $this->data['nccsSets'] = $this->nchildcourses_m->edit($param, $edit_nccs_id);
        $ret['data'] = $this->output_content($this->data['nccsSets']);
        $ret['status'] = 'success';
        echo json_encode($ret);
    }

    public function delete()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            //At first courseware directory with specified courseware id  in uploads directory
            $nccs_id = $_POST['nccsId'];
            $this->data['nccsSets'] = $this->nchildcourses_m->delete($nccs_id);
            $ret['data'] = $this->output_content($this->data['nccsSets']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

}
