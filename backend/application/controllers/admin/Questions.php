<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Questions extends Admin_Controller
{
    function __construct()
    {
        parent::__construct();
        $language = 'chinese';
        $this->load->model("schools_m");
        $this->load->model("lessons_m");
        $this->load->model("courses_m");
        $this->load->model("package_m");
        $this->load->model("problemset_m");
        $this->lang->load('courses', $language);
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function index($site_id = 1)
    {
        $this->workmanage($site_id);
    }

    public function workmanage($site_id = 1)
    {
        $this->data['packages'] = $this->package_m->get_package();
        $this->data['items'] = $this->problemset_m->getItems();
        $this->data["subview"] = "admin/contents/workmanage";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data["tbl_content"] = $this->work_output_content($this->data['items']);
        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function work_output_content($items)
    {
        $output = '';
        $type_str = [
            $this->lang->line('problem_option'),
            $this->lang->line('problem_yesno'),
            $this->lang->line('problem_norecog'),
            $this->lang->line('problem_recog')
        ];

        $j = 0;
        foreach ($items as $unit):
            $j++;
            $Editable = true;
            $btn_str = [
                $this->lang->line('update'),
                $this->lang->line('enable'),
                $this->lang->line('delete')
            ];
            if ($unit->prob_status == '1') {
                $Editable = false;
                $btn_str[1] = $this->lang->line('disable');
            }
            $output .= '<tr>';
            $output .= '<td>' . $unit->sort_num . '</td>';
            $output .= '<td>' . $unit->prob_name . '</td>';
            $output .= '<td>' . $type_str[$unit->prob_type - 1] . '</td>';
            $output .= '<td>' . $unit->name . '</td>';
            $output .= '<td>' . $unit->site_name . '</td>';
            $output .= '<td>';
            $output .= '<button class="btn btn-sm ' . (!$Editable ? 'disabled' : 'btn-success') . '"'
                . ' onclick = "' . ($Editable ? 'update_item(this);' : '') . '"'
                . ' item_info = \'' . ($Editable ? json_encode($unit) : '') . '\''
                . ' item_id ="' . $unit->id . '">' . $btn_str[0] . '</button>';
            $output .= '<button class="btn btn-sm ' . ($Editable ? 'btn-default' : 'btn-warning') . '"'
                . ' onclick = "publish_item(this);" '
                . ' item_status="' . $unit->prob_status . '"'
                . ' item_id = ' . $unit->id . '>' . $btn_str[1] . '</button>';
            $output .= '<button class="btn btn-sm ' . (!$Editable ? 'disabled' : 'btn-danger') . '"'
                . ' onclick = "' . ($Editable ? 'delete_item(this);' : '') . '"'
                . ' item_id ="' . $unit->id . '">' . $btn_str[2] . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    public function publish_problem()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $item_id = $_POST['item_id'];
            $publish_st = $_POST['publish_state'];
            $site_id = $_POST['site_id'];
            $items = $this->problemset_m->publish($item_id, $publish_st, $site_id);
            $ret['data'] = $this->work_output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function update_expand_order()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $site_id = $_POST['site_id'];
            $arr = $_POST['data'];
            $items = $this->courses_exp_m->edit($arr[0], $arr[0]['id'], $site_id);
            $items = $this->courses_exp_m->edit($arr[1], $arr[1]['id'], $site_id);
            $ret['data'] = $this->expand_output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function update_problem()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        $upload_root = "uploads/problem_set/";
        $config['upload_path'] = $upload_root;
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);
        $param = array();
        $item_id = '0';
        $sort_num = '0';
        if ($_POST) {
            $sort_num = $this->input->post('sort_num');
            $item_id = $this->input->post('item_id');

            $param = array(
                'prob_name' => $this->input->post('prob_name'),
                'site_id' => '1',
                'package_id' => $this->input->post('package_id'),
                'sort_num' => $sort_num,
                'prob_type' => $this->input->post('prob_type'),
                'prob_answer' => $this->input->post('prob_answer'),
                'ans_txt' => $this->input->post('ans_txt')
            );
            if ($item_id == '') {
                $param['prob_status'] = '0';
                $param['create_time'] = date('Y-m-d H:i:s');
                $item_id = $this->problemset_m->add($param);
            }
            $item = $this->problemset_m->get_where(array('id' => $item_id))[0];
            if (count($item) <= 0) {
                $ret['data'] = 'Record item is not exist.';
                echo json_encode($ret);
                return;
            }
            $item_id = $item->id;
            $fields = ['prob_img', 'prob_sound', 'ans_img1', 'ans_img2', 'ans_img3', 'ans_img4'];

            for ($j = 0; $j < 6; $j++) {
                $type = explode('.', $_FILES[$fields[$j]]["name"]);
                $type = $type[count($type) - 1];
                if ($_FILES[$fields[$j]]["name"] != '') {
                    //image uploading
                    $config['upload_path'] = $upload_root;
                    $config['file_name'] = $sort_num . '_' . $fields[$j] . '.' . $type;
                    $this->upload->initialize($config, TRUE);
                    if (file_exists($upload_root . $config['file_name']))
                        unlink($upload_root . $config['file_name']);
                    if ($this->upload->do_upload($fields[$j])) {
                        $data = $this->upload->data();
                        $param[$fields[$j]] = $upload_root . $config['file_name'];
                    } else {///show error message
                        $ret['data'] = $this->upload->display_errors();
                        $ret['status'] = 'fail';
                        echo json_encode($ret);
                        return;
                    }
                }
            }
            $items = $this->problemset_m->edit($param, $item_id);
            $ret['data'] = $this->work_output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function delete_problem()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $item_id = $_POST['item_id'];
            $site_id = $_POST['site_id'];
            $old_item = $this->problemset_m->get($item_id);
            if (is_file($old_item->prob_img))
                unlink($old_item->prob_img);
            if (is_file($old_item->prob_sound))
                unlink($old_item->prob_sound);
            if (is_file($old_item->ans_img1))
                unlink($old_item->ans_img1);
            if (is_file($old_item->ans_img2))
                unlink($old_item->ans_img2);
            if (is_file($old_item->ans_img3))
                unlink($old_item->ans_img3);
            if (is_file($old_item->ans_img4))
                unlink($old_item->ans_img4);
            $items = $this->problemset_m->delete($item_id);
            $ret['data'] = $this->work_output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function rrmdir($dir)
    {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file)
                if ($file != "." && $file != "..") $this->rrmdir("$dir/$file");
            rmdir($dir);
        } else if (file_exists($dir)) unlink($dir);
    }

    // Function to Copy folders and files
    public function rcopy($src, $dst)
    {
        if (file_exists($dst))
            $this->rrmdir($dst);
        if (is_dir($src)) {
            mkdir($dst);
            $files = scandir($src);
            foreach ($files as $file)
                if ($file != "." && $file != "..") {
                    $this->rcopy("$src/$file", "$dst/$file");

                }

        } else if (file_exists($src)) {
            copy($src, $dst);
        }
    }

    function checkRole()
    {
        $permission = $this->session->userdata('admin_user_type');
        if ($permission != NULL) {
            $permisData = json_decode($permission);
            $communityInfo = $permisData->menu_30;
            if ($communityInfo == '1') return true;
            else return false;
        }
        return false;
    }

}

?>