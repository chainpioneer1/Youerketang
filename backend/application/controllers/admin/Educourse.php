<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Educourse extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $language = 'chinese';
        $this->load->model("schools_m");
        $this->load->model("educourses_m");
        $this->load->model("educourses_main_m");

        $this->load->model("courses_m");
        $this->lang->load('courses', $language);
        $this->load->library("pagination");
    }

    public function school($site_id = 2)
    {
        $this->data['items'] = $this->schools_m->getItems($site_id);
        $this->data["site_id"] = $site_id;
        $this->data["subview"] = "admin/courses/eduschools";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data["tbl_content"] = $this->school_output_content($this->data['items']);
        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function school_output_content($items)
    {
        $output = '';
        $deleteStr = $this->lang->line('Delete');
        $status_str = [$this->lang->line('status_stopped'), $this->lang->line('status_normal')];

        $j = 0;
        foreach ($items as $unit):
            $j++;
            $Editable = true;
            $btn_str = [$this->lang->line('update'), $this->lang->line('delete'), $this->lang->line('enable')];
            if ($unit->school_status == '1') {
                $Editable = false;
                $btn_str[2] = $this->lang->line('disable');
            }
            $output .= '<tr>';
            $output .= '<td>' . $j . '</td>';
            $output .= '<td>' . $unit->school_name . '</td>';
            $output .= '<td>' . $status_str[$unit->school_status] . '</td>';
            $output .= '<td>';
            $output .= '<button class="btn btn-sm ' . (!$Editable ? 'disabled' : 'btn-success') . '"'
                . ' onclick = "' . ($Editable ? 'update_item(this);' : '') . '"'
                . ' item_name="' . $unit->school_name . '" '
                . ' item_id ="' . $unit->id . '">' . $btn_str[0] . '</button>';
//            $output .= '<button class="btn btn-sm ' . (!$Editable ? 'disabled' : 'btn-danger') . '"'
//                . ' onclick = "' . ($Editable ? 'delete_item(this);' : '') . '"'
//                . ' item_id ="' . $unit->id . '">' . $btn_str[1] . '</button>';
            $output .= '<button class="btn btn-sm ' . ($Editable ? 'btn-default' : 'btn-warning') . '"'
                . ' onclick = "publish_item(this);" item_status="' . $unit->school_status . '"'
                . ' item_id = ' . $unit->id . '>' . $btn_str[2] . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    public function publish_school()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $item_id = $_POST['item_id'];
            $publish_st = $_POST['publish_state'];
            $site_id = $_POST['site_id'];
            $items = $this->schools_m->publish($item_id, $publish_st, $site_id);
            $ret['data'] = $this->school_output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function update_school()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $item_id = $_POST['item_id'];
            $item_name = $_POST['item_name'];
            $site_id = $_POST['site_id'];
            $items = $this->schools_m->edit($item_id, $item_name, $site_id);
            $ret['data'] = $this->school_output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function category($site_id = 2)
    {
        $this->data['schools'] = $this->schools_m->getItems($site_id);
        $this->data['items'] = $this->educourses_m->getItems($site_id);
        $this->data["site_id"] = $site_id;
        $this->data["subview"] = "admin/courses/educourse";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data["tbl_content"] = $this->category_output_content($this->data['items']);
        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function category_output_content($items)
    {
        $output = '';
        $status_str = [$this->lang->line('status_disabled'), $this->lang->line('status_normal')];

        $j = 0;
        foreach ($items as $unit):
            $j++;
            $Editable = true;
            $btn_str = [$this->lang->line('update'), $this->lang->line('delete'), $this->lang->line('enable')];
            if ($unit->edu_course_status == '1') {
                $Editable = false;
                $btn_str[2] = $this->lang->line('disable');
            }
            $course_image = ($unit->edu_path == null) ? '' : (base_url() . $unit->edu_path);
            $UploadString = ($unit->edu_path == null) ? '' : $this->lang->line('education_course_upload');
            $output .= '<tr>';
            $output .= '<td>' . $j . '</td>';
            $output .= '<td>' . $unit->course_name . '</td>';
            $output .= '<td>' . $unit->school_name . '</td>';
            $output .= '<td>' . $UploadString . '</td>';
            $output .= '<td>' . $status_str[$unit->edu_course_status] . '</td>';
            $output .= '<td>';
            $output .= '<button class="btn btn-sm ' . (!$Editable ? 'disabled' : 'btn-success') . '"'
                . ' onclick = "' . ($Editable ? 'update_item(this);' : '') . '"'
                . ' item_name="' . $unit->course_name . '" '
                . ' item_school="' . $unit->school_id . '" '
                . ' item_path="' . $course_image . '" '
                . ' item_id ="' . $unit->id . '">' . $btn_str[0] . '</button>';
            $output .= '<button class="btn btn-sm ' . ($Editable ? 'btn-default' : 'btn-warning') . '"'
                . ' onclick = "publish_item(this);" '
                . ' item_status="' . $unit->edu_course_status . '"'
                . ' item_id = "' . $unit->id . '">' . $btn_str[2] . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    public function publish_category()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $item_id = $_POST['item_id'];
            $publish_st = $_POST['publish_state'];
            $site_id = $_POST['site_id'];
            $items = $this->educourses_m->publish($item_id, $publish_st, $site_id);
            $ret['data'] = $this->category_output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function update_category()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        $upload_root = "uploads/web_sh/packages_exp/";
        $config['upload_path'] = $upload_root;
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);

        if ($_POST) {
            $item_id = $this->input->post('item_id');

            $edu_path =  $_FILES["item_icon_file1"]["name"];

            $param = array(
                'update_time' => date('Y-m-d H:i:s')
            );
            if ($_FILES["item_icon_file1"]["name"] != '') {
                //image uploading
                $config['upload_path'] = $upload_root;
                $config['file_name'] = $edu_path;
                $this->upload->initialize($config, TRUE);
                if (file_exists($upload_root  . $edu_path))
                    unlink($upload_root  . $edu_path);
                if ($this->upload->do_upload('item_icon_file1')) {
                    $data = $this->upload->data();
                    $param['edu_path'] = $upload_root  . $edu_path;
                } else {///show error message
                    $ret['data'] = $this->upload->display_errors();
                    $ret['status'] = 'fail';
                    echo json_encode($ret);
                    return;
                }
            }
//            var_dump($ncw_sn);
            $items = $this->educourses_m->edit($param, $item_id);
            $ret['data'] = $this->category_output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    //Course Management...

    public function course($site_id = 2)
    {
        $this->data['site_id'] = $site_id;
        $this->data['schools'] = $this->schools_m->getItems($site_id);
        $this->data['items'] = $this->educourses_main_m->getDetailItems($site_id);
        $this->data["subview"] = "admin/courses/educourses_main";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data["tbl_content"] = $this->course_output_content($this->data['items']);
        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function course_output_content($items)
    {
        $output = '';
        $status_str = [$this->lang->line('status_stopped'), $this->lang->line('status_normal')];

        $j = 0;
        foreach ($items as $unit):
            $j++;
            $Editable = true;
            $btn_str = [
                $this->lang->line('update'),
                $this->lang->line('delete'),
                $this->lang->line('enable'),
                $this->lang->line('move2up'),
                $this->lang->line('move2down')
            ];
            if ($unit->course_status == '1') {
                $Editable = false;
                $btn_str[2] = $this->lang->line('disable');
            }
            $course_image = ($unit->image_path == null) ? '' : (base_url() . $unit->image_path);
            $course_upload_status = ($unit->course_path == null) ? '' : $this->lang->line('status_uploaded');
            $output .= '<tr>';
            $output .= '<td>' . $j . '</td>';
            $output .= '<td>' . $unit->course_name . '</td>';
            $output .= '<td>' . $unit->school_name . '</td>';

            $output .= '<td><span><div class="image_icon" item_id="' . $unit->id . '"'
                . ' src="' . $course_image . '" '
                . ' style="width:25px; height:25px;display:inline-block;border-radius:5px;'
                . ' background:url(' . $course_image . ');background-size:100% 100%!important;">'
                . '</div></span></td>';
            $output .= '<td>' . $course_upload_status . '</td>';
            $output .= '<td>' . $status_str[$unit->course_status] . '</td>';
            $output .= '<td>';
            $output .= '<button class="btn btn-sm ' . (!$Editable ? 'disabled' : 'btn-success') . '"'
                . ' onclick = "' . ($Editable ? 'update_item(this);' : '') . '"'
                . ' item_name="' . $unit->course_name . '" '
                . ' item_school="' . $unit->school_id . '" '
                . ' item_course="' . $unit->course_path . '" '
                . ' item_id ="' . $unit->id . '">' . $btn_str[0] . '</button>';
            $output .= '<button class="btn btn-sm ' . (!$Editable ? 'disabled' : 'btn-danger') . '"'
                . ' onclick = "' . ($Editable ? 'delete_item(this);' : '') . '"'
                . ' item_id ="' . $unit->id . '">' . $btn_str[1] . '</button>';
            $output .= '<button class="btn btn-sm ' . ($Editable ? 'btn-default' : 'btn-warning') . '"'
                . ' onclick = "publish_item(this);" '
                . ' item_status="' . $unit->course_status . '"'
                . ' item_id = ' . $unit->id . '>' . $btn_str[2] . '</button>';
            $output .= '</td>';
            $output .= '<td>';
            $output .= '<button class="btn btn-sm btn-success btn_order_control"'
                . ' onclick = "update_order(this,-1);"'
                . ' item_school="' . $unit->school_id . '"'
                . ' item_order="' . $unit->sort_order . '"'
                . ' item_id ="' . $unit->id . '">' . $btn_str[3] . '</button>';
            $output .= '<button class="btn btn-sm btn-default"'
                . ' onclick = "update_order(this,1);"'
                . ' item_school="' . $unit->school_id . '"'
                . ' item_order="' . $unit->sort_order . '" '
                . ' item_id ="' . $unit->id . '">' . $btn_str[4] . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    public function publish_course()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $item_id = $_POST['item_id'];
            $publish_st = $_POST['publish_state'];
            $site_id = $_POST['site_id'];
            $items = $this->educourses_main_m->publish($item_id, $publish_st, $site_id);
            $ret['data'] = $this->course_output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function update_course_order()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $site_id = $_POST['site_id'];
            $arr = $_POST['data'];
            $items = $this->educourses_main_m->edit($arr[0], $arr[0]['id'], $site_id);
            $items = $this->educourses_main_m->edit($arr[1], $arr[1]['id'], $site_id);
            $ret['data'] = $this->course_output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function update_course()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        $upload_root = "uploads/web_sh/packages/";
        $config['upload_path'] = $upload_root;
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);

        if ($_POST) {
            $site_id = $this->input->post('site_id');
            $item_id = $this->input->post('item_id');
            $item_name = $this->input->post('item_name');
            $school_id = $this->input->post('school_id');
            $icon_name = $this->input->post('icon_name');
            $package_name = $this->input->post('package_name');
            if ($item_id == '') {
                $item_info = $this->educourses_main_m->getNewLessonNumber($school_id);
                if ($item_info == '')
                    $item_info = [
                        'course_number' => '100',
                    ];
                $param = array(
                    'course_name' => $item_name,
                    'site_id' => $site_id,
                    'school_id' => $school_id,
                    'course_count' => 0,
                    'course_status' => 0,
                    'edu_course_status' => 0,
                    'course_number' => intval($item_info->course_number) + 1,
                    'sort_order' => intval($item_info->course_number) + 1,
                    'create_time' => date('Y-m-d H:i:s')
                );
                $item_id = $this->educourses_main_m->add($param);
            }
            $item_number = $this->educourses_main_m->getLessonNumberFromId($item_id);
            if ($item_number == '-1') {
                $ret['data'] = 'Record item is not exist.';
                echo json_encode($ret);
                return;
            }

            $param = array(
                'course_name' => $item_name,
                'school_id' => $school_id,
                'update_time' => date('Y-m-d H:i:s')
            );
            if ($_FILES["item_icon_file4"]["name"] != '') {
                //image uploading
                $config['upload_path'] = $upload_root;
                $config['file_name'] = $icon_name;
                $this->upload->initialize($config, TRUE);
                if (file_exists($upload_root . $icon_name))
                    unlink($upload_root . $icon_name);
                if ($this->upload->do_upload('item_icon_file4')) {
                    $data = $this->upload->data();
                    $param['image_path'] = $upload_root . $icon_name;
                } else {///show error message
                    $ret['data'] = $this->upload->display_errors();
                    $ret['status'] = 'fail';
                    echo json_encode($ret);
                    return;
                }
            }
            $old_item = $this->educourses_main_m->get($item_id);
            $oldPath = $old_item->course_path;
            $newPath = $upload_root . $package_name;
            $uploadFile = $_FILES["item_icon_file5"]["name"];
            if ($uploadFile != '') {
//                var_dump(filetype($oldPath), filetype($newPath));
                if ($oldPath != $newPath && is_dir($oldPath))
                    $this->rrmdir($oldPath);
                else if (is_dir($newPath))
                    $this->rrmdir($newPath);

                mkdir($newPath, 0755, true);

                $config['upload_path'] = './' . $newPath;
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);
                $this->upload->initialize($config, TRUE);
                if (stristr($uploadFile, '.mp4') == false) {
                    if ($this->upload->do_upload('item_icon_file5'))///this process is success then we have to move current subware to new position
                    {
                        ///---1----. At first New zip file upload and Extract
                        $zipdata = $this->upload->data();
                        $zip = new ZipArchive;
                        $file = $zipdata['full_path'];
                        chmod($file, 0755);
                        if ($zip->open($file) === TRUE) {
                            $zip->extractTo($config['upload_path']);
                            $zip->close();
                            unlink($file);
                            $param['course_path'] = $newPath;
                        } else {
                            $ret['data'] = 'can not extract zip file ';
                            $ret['status'] = 'fail';
                            echo json_encode($ret);
                            return;
                        }
                    } else {///show error message
                        $ret['data'] = $this->upload->display_errors();
                        $ret['status'] = 'fail';
                        echo json_encode($ret);
                        return;
                    }
                } else {
                    if ($this->upload->do_upload('item_icon_file5')) {
                        $data = $this->upload->data();
                        $param['course_path'] = $newPath . '/' . $data["file_name"];
                    } else {
                        $ret['data'] = $this->upload->display_errors();
                        $ret['status'] = 'fail';
                        echo json_encode($ret);
                        return;
                    }
                }
            }

            $items = $this->educourses_main_m->edit($param, $item_id, $site_id);
            $ret['data'] = $this->course_output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function delete_course()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $item_id = $_POST['item_id'];
            $site_id = $_POST['site_id'];
            $old_item = $this->educourses_main_m->get($item_id);
            if (is_dir($old_item->course_path))
                $this->rrmdir($old_item->course_path);
            $items = $this->educourses_main_m->delete_course($item_id, $site_id);
            $ret['data'] = $this->course_output_content($items);
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

    //Course Management End..
    function checkRole()
    {
        $permission = $this->session->userdata('admin_user_type');
        if ($permission != NULL) {
            $permisData = json_decode($permission);
            $communityInfo = $permisData->menu_40;
            if ($communityInfo == '1') return true;
            else return false;
        }
        return false;
    }
}

?>