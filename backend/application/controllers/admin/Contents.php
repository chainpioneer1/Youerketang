<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Contents extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();
        $language = 'chinese';
        $this->load->model("schools_m");
        $this->load->model("categories_m");
        $this->load->model("lessons_m");
        $this->lang->load('courses', $language);
        $this->load->library("pagination");
    }

    public function index($site_id = 1)
    {

        $this->data['items'] = $this->schools_m->getItems($site_id);
        $this->data["subview"] = "admin/community/contents";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data["tbl_content"] = $this->output_content($this->data['items']);
        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function output_content($items)
    {
        $output = '';
        $deleteStr = $this->lang->line('Delete');
        $status_str = [$this->lang->line('status_stopped'), $this->lang->line('status_normal')];
        $j = 0;
        foreach ($items as $unit):
            $j++;
            $status = [];
            $output .= '<tr>';
            $output .= '<td>' . $j . '</td>';
            $output .= '<td>' . $unit->school_name . '</td>';
            $output .= '<td>';
            $output .= '<button style="width:70px;" class="btn btn-sm btn-warning" onclick = "delete_content(this);" content_id = ' . $unit->id . '>' . $deleteStr . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
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

    public function category($site_id = 1)
    {
        $this->data['schools'] = $this->schools_m->getItems($site_id);
        $this->data['items'] = $this->categories_m->getItems($site_id);
        $this->data["site_id"] = $site_id;
        $this->data["subview"] = "admin/contents/categories";
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
            if ($unit->category_status == '1') {
                $Editable = false;
                $btn_str[2] = $this->lang->line('disable');
            }
            $image_corner = ($unit->image_corner == null) ? '' : (base_url() . $unit->image_corner);
            $image_icon = ($unit->image_icon == null) ? '' : (base_url() . $unit->image_icon);
            $image_icon_hover = ($unit->image_icon_hover == null) ? '' : (base_url() . $unit->image_icon_hover);
            $output .= '<tr>';
            $output .= '<td>' . $j . '</td>';
            $output .= '<td>' . $unit->category_name . '</td>';
            $output .= '<td>' . $unit->school_name . '</td>';
            $output .= '<td><span><div class="image_corner" item_id="' . $unit->id . '"'
                . ' src="' . $image_corner . '" '
                . ' alt="" style="width:50px; height:45px;display:inline-block;border-radius:5px;'
                . ' background:url(' . $image_corner . ');background-size:210% 230%!important;">'
                . '</div></span></td>';
            $output .= '<td><img class="image_icon" item_id="' . $unit->id . '"'
                . ' src="' . $image_icon . '" '
                . ' alt="" style="width:70px; height:auto;"/></td>';
            $output .= '<td><img class="image_icon_hover" item_id="' . $unit->id . '"'
                . ' src="' . $image_icon_hover . '" '
                . ' alt="" style="width:70px; height:auto;"/></td>';
            $output .= '<td>' . $status_str[$unit->category_status] . '</td>';
            $output .= '<td>';
            $output .= '<button class="btn btn-sm ' . (!$Editable ? 'disabled' : 'btn-success') . '"'
                . ' onclick = "' . ($Editable ? 'update_item(this);' : '') . '"'
                . ' item_name="' . $unit->category_name . '" '
                . ' item_school="' . $unit->school_id . '" '
                . ' item_id ="' . $unit->id . '">' . $btn_str[0] . '</button>';
//            $output .= '<button class="btn btn-sm ' . (!$Editable ? 'disabled' : 'btn-danger') . '"'
//                . ' onclick = "' . ($Editable ? 'delete_item(this);' : '') . '"'
//                . ' item_id ="' . $unit->id . '">' . $btn_str[1] . '</button>';
            $output .= '<button class="btn btn-sm ' . ($Editable ? 'btn-default' : 'btn-warning') . '"'
                . ' onclick = "publish_item(this);" '
                . ' item_status="' . $unit->category_status . '"'
                . ' item_id = ' . $unit->id . '>' . $btn_str[2] . '</button>';
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
            $items = $this->categories_m->publish($item_id, $publish_st, $site_id);
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
        $upload_root = "uploads/web/mainpage/images/main/";
        $config['upload_path'] = $upload_root;
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);

        if ($_POST) {
            $item_id = $this->input->post('item_id');
            $item_name = $this->input->post('item_name');
            $school_id = $this->input->post('school_id');

            if ($item_id == '') {
                $item_info = $this->categories_m->getNewCategoryNumber($school_id);
                if($item_info=='')
                    $item_info = [
                        'category_number'=>'100',
                        'sort_order'=>'0'
                    ];
                $param = array(
                    'category_number' => intval($item_info->category_number) + 1,
                    'category_name' => $item_name,
                    'school_id' => $school_id,
                    'category_status' => 0,
                    'sort_order' => intval($item_info->sort_order) + 1,
                    'create_time' => date('Y-m-d H:i:s')
                );
                $item_id = $this->categories_m->add($param);
            }
            $item_number = $this->categories_m->getCategoryNumberFromId($item_id);
            if ($item_number == '-1') {
                $ret['data'] = 'Category is not exist.';
                echo json_encode($ret);
                return;
            }

            $image_corner = $school_id . $item_number . '.png';
            $image_icon = 'nav' . $school_id . $item_number . '.png';
            $image_icon_hover = 'nav' . $school_id . $item_number . '_hover.png';

            $param = array(
                'category_name' => $item_name,
                'school_id' => $school_id,
                'update_time' => date('Y-m-d H:i:s')
            );
            if ($_FILES["item_icon_file1"]["name"] != '') {
                //image uploading
                $config['upload_path'] = $upload_root . 'category/';
                $config['file_name'] = $image_corner;
                $this->upload->initialize($config, TRUE);
                if (file_exists($upload_root . 'category/' . $image_corner))
                    unlink($upload_root . 'category/' . $image_corner);
                if ($this->upload->do_upload('item_icon_file1')) {
                    $data = $this->upload->data();
                    $param['image_corner'] = $upload_root . 'category/' . $image_corner;
                } else {///show error message
                    $ret['data'] = $this->upload->display_errors();
                    $ret['status'] = 'fail';
                    echo json_encode($ret);
                    return;
                }
            }
            if ($_FILES["item_icon_file2"]["name"] != '') {
                //image uploading
                $config['upload_path'] = $upload_root;
                $config['file_name'] = $image_icon;
                $this->upload->initialize($config, TRUE);

                if (file_exists($upload_root . $image_icon))
                    unlink($upload_root . $image_icon);

                if ($this->upload->do_upload('item_icon_file2')) {
                    $data = $this->upload->data();
                    $param['image_icon'] = $upload_root . $image_icon;
                } else {///show error message
                    $ret['data'] = $this->upload->display_errors();
                    $ret['status'] = 'fail';
                    echo json_encode($ret);
                    return;
                }
            }
            if ($_FILES["item_icon_file3"]["name"] != '') {
                //image uploading
                $config['upload_path'] = $upload_root;
                $config['file_name'] = $image_icon_hover;
                $this->upload->initialize($config, TRUE);
                if (file_exists($upload_root . $image_icon_hover))
                    unlink($upload_root . $image_icon_hover);
                if ($this->upload->do_upload('item_icon_file3')) {
                    $data = $this->upload->data();
                    $param['image_icon_hover'] = $upload_root . $image_icon_hover;
                } else {///show error message
                    $ret['data'] = $this->upload->display_errors();
                    $ret['status'] = 'fail';
                    echo json_encode($ret);
                    return;
                }
            }
//            var_dump($ncw_sn);
            $items = $this->categories_m->edit($param, $item_id);
            $ret['data'] = $this->category_output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function lesson($site_id = 1)
    {
        $this->data['schools'] = $this->schools_m->getItems($site_id);
        $this->data['items'] = $this->lessons_m->getItems($site_id);
        $this->data["site_id"] = $site_id;
        $this->data["subview"] = "admin/contents/lessons";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data["tbl_content"] = $this->lesson_output_content($this->data['items']);
        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function lesson_output_content($items)
    {
        $output = '';
        $status_str = [$this->lang->line('status_disabled'), $this->lang->line('status_normal')];

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
            if ($unit->lesson_status == '1') {
                $Editable = false;
                $btn_str[2] = $this->lang->line('disable');
            }
            $image_corner = ($unit->image_corner == null) ? '' : (base_url() . $unit->image_corner);
            $image_icon = ($unit->image_icon == null) ? '' : (base_url() . $unit->image_icon);
            $image_icon_hover = ($unit->image_icon_hover == null) ? '' : (base_url() . $unit->image_icon_hover);

            $output .= '<tr>';
            $output .= '<td>' . $j . '</td>';
            $output .= '<td>' . $unit->lesson_name . '</td>';
            $output .= '<td>' . $unit->school_name . '</td>';
            $output .= '<td><span><div class="image_corner" item_id="' . $unit->id . '"'
                . ' src="' . $image_corner . '" '
                . ' alt="" style="width:50px; height:45px;display:inline-block;border-radius:5px;'
                . ' background:url(' . $image_corner . ');background-size:210% 230%!important;">'
                . '</div></span></td>';
            $output .= '<td><img class="image_icon" item_id="' . $unit->id . '"'
                . ' src="' . $image_icon . '" '
                . ' alt="" style="width:90px; height:auto;"/></td>';
            $output .= '<td><img class="image_icon_hover" item_id="' . $unit->id . '"'
                . ' src="' . $image_icon_hover . '" '
                . ' alt="" style="width:90px; height:auto;"/></td>';
            $output .= '<td>' . $status_str[$unit->lesson_status] . '</td>';
            $output .= '<td>';
            $output .= '<button class="btn btn-sm ' . (!$Editable ? 'disabled' : 'btn-success') . '"'
                . ' onclick = "' . ($Editable ? 'update_item(this);' : '') . '"'
                . ' item_name="' . $unit->lesson_name . '" '
                . ' item_school="' . $unit->school_id . '" '
                . ' item_id ="' . $unit->id . '">' . $btn_str[0] . '</button>';
//            $output .= '<button class="btn btn-sm ' . (!$Editable ? 'disabled' : 'btn-danger') . '"'
//                . ' onclick = "' . ($Editable ? 'delete_item(this);' : '') . '"'
//                . ' item_id ="' . $unit->id . '">' . $btn_str[1] . '</button>';
            $output .= '<button class="btn btn-sm ' . ($Editable ? 'btn-default' : 'btn-warning') . '"'
                . ' onclick = "publish_item(this);" '
                . ' item_status="' . $unit->lesson_status . '"'
                . ' item_id = ' . $unit->id . '>' . $btn_str[2] . '</button>';
            $output .= '</td>';
            $output .= '<td>';
            $output .= '<button class="btn btn-sm btn-success btn_order_control"'
                . ' onclick = "update_order(this,-1);"'
                . ' item_order="' . $unit->sort_order . '"'
                . ' item_school="' . $unit->school_id . '" '
                . ' item_id ="' . $unit->id . '">' . $btn_str[3] . '</button>';
            $output .= '<button class="btn btn-sm btn-default"'
                . ' onclick = "update_order(this,1);"'
                . ' item_order="' . $unit->sort_order . '" '
                . ' item_school="' . $unit->school_id . '" '
                . ' item_id ="' . $unit->id . '">' . $btn_str[4] . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    public function publish_lesson()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $item_id = $_POST['item_id'];
            $publish_st = $_POST['publish_state'];
            $site_id = $_POST['site_id'];
            $items = $this->lessons_m->publish($item_id, $publish_st, $site_id);
            $ret['data'] = $this->lesson_output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function update_lesson_order()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $school_id = $_POST['school_id'];
            $arr = $_POST['data'];
            $items = $this->lessons_m->edit($arr[0], $arr[0]['id']);
            $items = $this->lessons_m->edit($arr[1], $arr[1]['id']);
            $ret['data'] = $this->lesson_output_content($items);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function update_lesson()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        $upload_root = "uploads/web/mainpage/images/main/";
        $config['upload_path'] = $upload_root;
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);

        if ($_POST) {
            $item_id = $this->input->post('item_id');
            $item_name = $this->input->post('item_name');
            $school_id = $this->input->post('school_id');

            if ($item_id == '') {
                $item_info = $this->lessons_m->getNewLessonNumber($school_id);
                $param = array(
                    'lesson_number' => intval($item_info->lesson_number) + 1,
                    'lesson_name' => $item_name,
                    'school_id' => $school_id,
                    'lesson_status' => 0,
                    'sort_order' => intval($item_info->sort_order) + 1,
                    'create_time' => date('Y-m-d H:i:s')
                );
                $item_id = $this->lessons_m->add($param);
            }
            $item_number = $this->lessons_m->getLessonNumberFromId($item_id);
            if ($item_number == '-1') {
                $ret['data'] = 'Record item is not exist.';
                echo json_encode($ret);
                return;
            }

            $image_corner = $item_number . '.png';
            $image_icon = 'nav' . $school_id . $item_number . '.png';
            $image_icon_hover = 'nav' . $school_id . $item_number . '_hover.png';

            $param = array(
                'lesson_name' => $item_name,
                'school_id' => $school_id,
                'update_time' => date('Y-m-d H:i:s')
            );
            if ($_FILES["item_icon_file1"]["name"] != '') {
                //image uploading
                $config['upload_path'] = $upload_root . $school_id . '/';
                $config['file_name'] = $image_corner;
                $this->upload->initialize($config, TRUE);
                if (file_exists($upload_root . $school_id . '/' . $image_corner))
                    unlink($upload_root . $school_id . '/' . $image_corner);
                if ($this->upload->do_upload('item_icon_file1')) {
                    $data = $this->upload->data();
                    $param['image_corner'] = $upload_root . $school_id . '/' . $image_corner;
                } else {///show error message
                    $ret['data'] = $this->upload->display_errors();
                    $ret['status'] = 'fail';
                    echo json_encode($ret);
                    return;
                }
            }
            if ($_FILES["item_icon_file2"]["name"] != '') {
                //image uploading
                $config['upload_path'] = $upload_root;
                $config['file_name'] = $image_icon;
                $this->upload->initialize($config, TRUE);
                if (file_exists($upload_root . $image_icon))
                    unlink($upload_root . $image_icon);
                if ($this->upload->do_upload('item_icon_file2')) {
                    $data = $this->upload->data();
                    $param['image_icon'] = $upload_root . $image_icon;
                } else {///show error message
                    $ret['data'] = $this->upload->display_errors();
                    $ret['status'] = 'fail';
                    echo json_encode($ret);
                    return;
                }
            }
            if ($_FILES["item_icon_file3"]["name"] != '') {
                //image uploading
                $config['upload_path'] = $upload_root;
                $config['file_name'] = $image_icon_hover;
                $this->upload->initialize($config, TRUE);
                if (file_exists($upload_root . $image_icon_hover))
                    unlink($upload_root . $image_icon_hover);
                if ($this->upload->do_upload('item_icon_file3')) {
                    $data = $this->upload->data();
                    $param['image_icon_hover'] = $upload_root . $image_icon_hover;
                } else {///show error message
                    $ret['data'] = $this->upload->display_errors();
                    $ret['status'] = 'fail';
                    echo json_encode($ret);
                    return;
                }
            }
//            var_dump($ncw_sn);
            $items = $this->lessons_m->edit($param, $item_id);
            $ret['data'] = $this->lesson_output_content($items);
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
            $contentId = $_POST['content_id'];
            $this->contents_m->delete($contentId);
            $this->data['contents'] = $this->contents_m->get_contents();
            $ret['data'] = $this->output_content($this->data['contents']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
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