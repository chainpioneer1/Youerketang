<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lessons extends Admin_Controller
{

    protected $mainModel;

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->load->model("sites_m");
        $this->load->model("package_m");
        $this->load->model("courses_m");
        $this->load->model("lessons_m");
        $this->lang->load('courses', $language);
        $this->load->library("pagination");
        $this->load->library("session");

        $this->mainModel = $this->lessons_m;
    }

    public function index()
    {
        $this->data['title'] = '课件管理';
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";

        $this->data['siteList'] = $this->sites_m->getItems();
        $this->data['packageList'] = $this->package_m->getItems();

        $filter = array();
        if ($this->uri->segment(SEGMENT) == '') $this->session->unset_userdata('filter');
        $queryStr = '';

        if ($_POST) {
            $this->session->unset_userdata('filter');
            $_POST['search_title'] != '' && $queryStr = $_POST['search_title'];
            $_POST['search_site'] != '' && $filter['tbl_sites.id'] = $_POST['search_site'];
            $_POST['search_package'] != '' && $filter['tbl_package.id'] = $_POST['search_package'];
            $this->session->set_userdata('filter', $filter);
        }
        $this->session->userdata('filter') != '' && $filter = $this->session->userdata('filter');
        $filter['tbl_yekt_lessons.owner_type'] = 0;
        $this->data['queryStr'] = $queryStr;
        $this->data['perPage'] = $perPage = PERPAGE;
        $this->data['cntPage'] = $cntPage = $this->mainModel->get_count($filter);
        $ret = $this->paginationCompress('admin/lessons/index', $cntPage, $perPage, 4);
        $this->data['curPage'] = $curPage = $ret['pageId'];
        $this->data["list"] = $this->mainModel->getItemsByPage($filter, $ret['pageId'], $ret['cntPerPage']);

        $this->data["tbl_content"] = $this->output_content($this->data['list']);

        $this->data["subview"] = "admin/contents/lessons";

        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function output_content($items)
    {
        $admin_id = $this->session->userdata("admin_loginuserID");
        $output = '';
        $btn_str = ['启用', '禁用', '修改', '删除'];
        foreach ($items as $unit):
            $editable = $unit->status == 0;

            $iconPath = '';
            if ($unit->image_icon != null && $unit->image_icon != '') $iconPath = base_url() . $unit->image_icon;

            $output .= '<tr>';
            $output .= '<td>' . $unit->lesson_number . '</td>';
            $output .= '<td>' . $unit->title . '</td>';
            $output .= '<td>' . $unit->site . '</td>';
            $output .= '<td>' . $unit->package . '</td>';
            $output .= '<td><div style="width: 35px;height:25px;position: relative;display: inline-block;">'
                . (($iconPath != '') ? ('<img src="' . $iconPath . '" style="position:absolute;height:100%;width:100%;left:0;top:0;">') : '')
                . '</div></td>';
            $output .= '<td>' . $unit->update_time . '</td>';
            $output .= '<td>';
            $icon_path = $unit->image_icon;
            if ($icon_path == null || $icon_path == '') $icon_path = '';
            else $icon_path = base_url() . $icon_path;
            $output .= '<button'
                . ' class="btn btn-sm ' . ($editable ? 'btn-success' : 'disabled') . '" '
                . ' onclick = "' . ($editable ? 'editItem(this);' : '') . '" '
                . ' data-id = "' . $unit->id . '" '
                . ' data-site = "' . $unit->site_id . '" '
                . ' data-package = "' . $unit->package_id . '" '
                . ' data-icon_path = "' . $icon_path . '" '
                . ' data-content = "' . $unit->information . '" '
                . ' data-lessons = \'' . $unit->lesson_info . '\'> '
                . $btn_str[2] . '</button>';
            $output .= '<button'
                . ' class="btn btn-sm ' . ($editable ? 'btn-danger' : 'disabled') . '"'
                . ' onclick = "' . ($editable ? 'deleteItem(this);' : '') . '"'
                . ' data-id = "' . $unit->id . '">'
                . $btn_str[3] . '</button>';
            $output .= '<button'
                . ' class="btn btn-sm ' . ($editable ? 'btn-default' : 'btn-warning') . '"'
                . ' onclick = "publishItem(this);"'
                . ' data-status = "' . $unit->status . '"'
                . ' data-id = "' . $unit->id . '">'
                . $btn_str[$unit->status] . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    public function getContentsFromLessonInfo()
    {
        $ret = array(
            'data' => '操作失败',
            'status' => 'fail'
        );
        if ($_POST) {
            if (!$this->adminsignin_m->loggedin()) {
                echo json_encode($ret);
                return;
            }
            $lesson_info = json_decode($_POST['lesson_info']);
            $result = $this->courses_m->get_where_in('id', $lesson_info);
            $ret['data'] = $result;
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
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
            $id = $this->input->post('id');
            $id = str_replace(' ', '', $id);
            $param = array();
//            $param['lesson_name'] = $this->input->post('lesson_name');
            $param['package_id'] = $this->input->post('package_id');
            $packageItem = $this->package_m->get_where(array('id' => $param['package_id']));

            $param['lesson_name'] = $packageItem[0]->title;
            $param['lesson_number'] = $packageItem[0]->no;
            $param['owner_type'] = 0;
            $param['lesson_info']  = $this->input->post('lesson_info');

            $config['upload_path'] = "./uploads/lessons";
            if (!is_dir($config['upload_path'])) {
                mkdir($config['upload_path']);
            }
            $config['allowed_types'] = '*';
            $tt = date('0ymdHis0') . rand(1000, 9999);
            $filename = 'qd' . $id . $tt;
            $this->load->library('upload', $config);

            $icon_format = $this->input->post('icon_format');
            $content_format = $this->input->post('content_format');

            $icon_path = '';
            if ($_FILES["item_icon_file4"]["name"] != '') {
                $config['file_name'] = $filename . '_icon' . '.' . $icon_format;
                if (file_exists(substr($config['upload_path'], 2) . '/' . $config['file_name'])) {
                    unlink(substr($config['upload_path'], 2) . '/' . $config['file_name']);
                }
                $this->upload->initialize($config, TRUE);
                switch ($icon_format) {
                    case 'gif':
                    case 'png':
                    case 'jpg':
                    case 'bmp':
                        ///Image file uploading........
                        if ($this->upload->do_upload('item_icon_file4')) {
                            $data = $this->upload->data();
                            $icon_path = substr($config['upload_path'], 2) . '/' . $config['file_name'];
                        } else {
                            $ret['data'] = '缩略图片上传错误' . $this->upload->display_errors();
                            $ret['status'] = 'fail';
                            echo json_encode($ret);
                            return;
                        }
                        break;
                }
            }

            if ($_FILES["item_icon_file5"]["name"] != '') {
                $nameSuffix = 'nr';
                $config['file_name'] = $filename . $nameSuffix . '.' . $content_format;
                if (file_exists(substr($config['upload_path'], 2) . '/' . $config['file_name'])) {
                    unlink(substr($config['upload_path'], 2) . '/' . $config['file_name']);
                }
                $this->upload->initialize($config, TRUE);
                //.zip,.png,.jpg,.bmp,.gif,.jpeg,.mp4,.mp3,.pdf,.html,.htm,.doc,.docx,.ppt,.pptx
                switch ($content_format) {
                    case 'gif':
                    case 'png':
                    case 'jpg':
                    case 'jpeg':
                    case 'bmp':
                        ///Image file uploading........
                        if ($this->upload->do_upload('item_icon_file5')) {
                            $data = $this->upload->data();
                            $content_path = substr($config['upload_path'], 2) . '/' . $config['file_name'];
                            $content_type_id = '3';
                        } else {
                            $ret['data'] = '内容图片上传错误' . $this->upload->display_errors();
                            $ret['status'] = 'fail';
                            echo json_encode($ret);
                            return;
                        }
                        break;
                    case 'mp3':
                    case 'wav':
                    case 'mp4':
                        ///Video file uploading........
                        if ($this->upload->do_upload('item_icon_file5')) {
                            $data = $this->upload->data();
                            $content_path = substr($config['upload_path'], 2) . '/' . $config['file_name'];
                            $content_type_id = '2';
                        } else {
                            $ret['data'] = '音频或视频上传错误' . $this->upload->display_errors();
                            $ret['status'] = 'fail';
                            echo json_encode($ret);
                            return;
                        }
                        break;
                    case 'doc':
                    case 'docx':
                    case 'ppt':
                    case 'pptx':
                        ///Video file uploading........
                        if ($this->upload->do_upload('item_icon_file5')) {
                            $data = $this->upload->data();
                            $content_path = substr($config['upload_path'], 2) . '/' . $config['file_name'];
                            $content_type_id = '4';
                        } else {
                            $ret['data'] = 'OFFICE文档上传错误' . $this->upload->display_errors();
                            $ret['status'] = 'fail';
                            echo json_encode($ret);
                            return;
                        }
                        break;
                    case 'pdf':
                        ///Video file uploading........
                        if ($this->upload->do_upload('item_icon_file5')) {
                            $data = $this->upload->data();
                            $content_path = substr($config['upload_path'], 2) . '/' . $config['file_name'];
                            $content_type_id = '5';
                        } else {
                            $ret['data'] = 'PDF文档上传错误' . $this->upload->display_errors();
                            $ret['status'] = 'fail';
                            echo json_encode($ret);
                            return;
                        }
                        break;
                    case 'html':
                    case 'htm':
                        ///Video file uploading........
                        if ($this->upload->do_upload('item_icon_file5')) {
                            $data = $this->upload->data();
                            $content_path = substr($config['upload_path'], 2) . '/' . $config['file_name'];
                            $content_type_id = '6';
                        } else {
                            $ret['data'] = 'HTML文档上传错误' . $this->upload->display_errors();
                            $ret['status'] = 'fail';
                            echo json_encode($ret);
                            return;
                        }
                        break;
                    case 'zip':
                        ///Package file uploading.......
                        if ($this->upload->do_upload('item_icon_file5')) {

                            $uploadPath = substr($config['upload_path'], 2) . '/' . $filename . $nameSuffix;
                            if (is_dir($uploadPath)) {
                                $this->rrmdir($uploadPath);
                            }
                            mkdir($uploadPath, 0755, true);
                            $configPackage['upload_path'] = './' . $uploadPath;
                            $configPackage['allowed_types'] = '*';
                            $configPackage['file_name'] = $filename . $nameSuffix . '.' . $content_format;
                            $this->load->library('upload', $configPackage);
                            $this->upload->initialize($configPackage, TRUE);
                            if ($this->upload->do_upload('item_icon_file5')) {
                                $zipData = $this->upload->data();
                                $zip = new ZipArchive;
                                $file = $zipData['full_path'];
                                chmod($file, 0777);
                                if ($zip->open($file) === TRUE) {
                                    $zip->extractTo($configPackage['upload_path']);
                                    $zip->close();
//                                unlink($file);
                                } else {
                                    $ret['data'] = 'H5包解压错误' . $this->upload->display_errors();
                                    echo json_encode($ret); // failed
                                }
                                $content_path = $uploadPath;
                                $content_type_id = '1';
                            } else {
                                $ret['data'] = $this->upload->display_errors();
                                echo json_encode($ret);
                                return;
                            }
                        } else {
                            $ret['data'] = 'H5包上传错误' . $this->upload->display_errors();
                            $ret['status'] = 'fail';
                            echo json_encode($ret);
                            return;
                        }
                        break;
                    default:
                        $ret['data'] = '文档格式错误';
                        echo json_encode($ret);
                        return;
                        break;
                }

                $param['information'] = $content_path;
            }
            //At first insert new coureware information to the database table
            $old = $this->mainModel->get_single(array('id' => $id));

            if ($old != null) {
                $param['update_time'] = date("Y-m-d H:i:s");
                if ($icon_path != '') $param['image_icon'] = $icon_path;
                $contentId = $this->mainModel->edit($param, $id);
            } else {
                $param['lesson_status'] = 0;
                $param['create_time'] = date("Y-m-d H:i:s");
                $param['update_time'] = date("Y-m-d H:i:s");
                $param['image_icon'] = '';
                if ($icon_path != '') $param['image_icon'] = $icon_path;
                if ($param['image_icon'] == '') {
                    $ret['data'] = '请上传缩略图';
                    echo json_encode(($ret));
                    return;
                }
                $contentId = $this->mainModel->add($param);
            }

            $ret['data'] = '上传成功';
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
            if ($id < 0) {
                $filter = array();
                $this->session->userdata('filter') != null && $filter = $this->session->userdata('filter');
                $pageId = 0;
                if (isset($_POST['pageId'])) $pageId = $_POST['pageId'];
                $perPage = PERPAGE;
                $lists = $this->mainModel->getItemsByPage($filter, $pageId, $perPage);
                foreach ($lists as $item) $this->mainModel->publish($item->id, $status);
            } else {
                $this->mainModel->publish($id, $status);
            }
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
        if ($_POST) {
            if (!$this->adminsignin_m->loggedin()) {
                echo json_encode($ret);
                return;
            }
            $id = $_POST['id'];
            $list = $this->mainModel->delete($id);
            $ret['data'] = '操作成功';//$this->output_content($list);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    function checkRole($id = 31)
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