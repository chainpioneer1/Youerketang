<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Nunits extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->load->model("nunits_m");
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
        $this->data['nccsSets'] = $this->nchildcourses_m->get_nchild_courses();
        $this->data['nunitSets'] = $this->nunits_m->get_nunits();
        $this->data["subview"] = "admin/courses/nunits";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data["tbl_content"] = $this->output_content($this->data['nunitSets']);
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
        $config['upload_path'] = "./uploads/images";
        $config['allowed_types'] = 'bmp|gif|jpg|png';
        $this->load->library('upload', $config);

        if (isset($_FILES["add_file_name"]["name"]) && $_POST) {
            $nunit_image_path = '';
            //image uploading
            if ($this->upload->do_upload('add_file_name')) {
                $data = $this->upload->data();
                $nunit_image_path = 'uploads/images/' . $data["file_name"];
            } else {
                //$ret['data']  = $this->upload->display_errors();
                $ret['data'] = 'Select image file!';
                $ret['status'] = 'fail';
                echo json_encode($ret);
                return;
            }
            ///update courseware table
            $nunit_name = $this->input->post('add_nunit_name');
            $nunit_sn = $this->input->post('add_nunit_sn');
            $nchild_id = $this->input->post('add_nchild_name');

            $param = array(
                'nunit_name' => $nunit_name,
                'nunit_sn' => $nunit_sn,
                'childcourse_id' => $nchild_id,
                'nunit_photo' => $nunit_image_path
            );
            $nunitsSets = $this->nunits_m->add($param);
            $ret['data'] = $this->output_content($nunitsSets);
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
        $this->load->library('upload', $config);

        if (isset($_FILES["edit_file_name"]["name"]) && $_POST) {
            $nunit_image_path = '';
            //image uploading
            if ($this->upload->do_upload('edit_file_name')) {
                $data = $this->upload->data();
                $nunit_image_path = 'uploads/images/' . $data["file_name"];
            }
            ///update courseware table
            $unitId = $_POST['nunit_id'];
            $nunit_name = $this->input->post('edit_nunit_name');
            $nunit_sn = $this->input->post('edit_nunit_sn');
            $nchild_id = $this->input->post('edit_nchild_name');

            $param = array(
                'nunit_name' => $nunit_name,
                'nunit_sn' => $nunit_sn,
                'childcourse_id' => $nchild_id,
            );
            if ($nunit_image_path != '') $param['nunit_photo'] = $nunit_image_path;
            $nunitsSets = $this->nunits_m->edit($param, $unitId);
            $ret['data'] = $this->output_content($nunitsSets);
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
            //At first courseware directory with specified courseware id  in uploads directory
            $nunit_id = $_POST['nunit_id'];
            $nunitsSets = $this->nunits_m->delete($nunit_id);
            $ret['data'] = $this->output_content($nunitsSets);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    function publish()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $nunit_id = $_POST['nunit_id'];
            $publish_cw_st = $_POST['publish_state'];
            $nunitsSets = $this->nunits_m->publish($nunit_id, $publish_cw_st);
            $ret['data'] = $this->output_content($nunitsSets);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    function output_content($nunitSet)
    {
        $output_html = '';
        foreach ($nunitSet as $nunit):
            $pub = ($nunit->nunit_publish == '1') ? $this->lang->line('Disable') : $this->lang->line('Enable');
            $output_html .= '<tr>';
            $output_html .= '<td>' . $nunit->nunit_sn . '</td>';
            $output_html .= '<td>' . $nunit->nunit_name . '</td>';
            $output_html .= '<td>' . $nunit->childcourse_name . '</td>';
            $output_html .= '<td>' . $nunit->course_name . '</td>';
//            $output_html .= '<td>'.$nunit->school_type_name.'</td>';
            $output_html .= '<td>';
//            $output_html .=  '<button class="btn btn-sm btn-success" onclick = "edit_nunit(this);" " nunit_photo = "'.$nunit->nunit_photo.'" nunit_id = '.$nunit->nunit_id.'>'.$this->lang->line('Modify').'</button>';
//            $output_html .=  '<button class="btn btn-sm btn-warning" onclick = "delete_nunit(this);" nunit_id = '.$nunit->nunit_id.'>'.$this->lang->line('Delete').'</button>';
            $output_html .= '<button class="btn btn-sm '
                . (($nunit->nunit_publish == '1') ? 'btn-warning' : 'btn-default') . '"'
                . ' onclick = "publish_nunit(this);"'
                . ' nunit_id = ' . $nunit->nunit_id . '>' . $pub . '</button>';
            $output_html .= '</td>';
            $output_html .= '</tr>';
        endforeach;
        return $output_html;
    }

    function checkRole()
    {

        $permission = $this->session->userdata('admin_user_type');
        if ($permission != NULL) {
            $permissionData = json_decode($permission);
            $accessInfo = $permissionData[0]->cs_unit_st;
            if ($accessInfo == '1') return true;
            else return false;
        }
        return false;
    }

}
