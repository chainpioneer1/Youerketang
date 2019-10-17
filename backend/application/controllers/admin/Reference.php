<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reference extends Admin_Controller
{

    protected $mainModel;

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->load->model("sites_m");
        $this->load->model("reference_m");
        $this->lang->load('courses', $language);
        $this->load->library("pagination");
        $this->load->library("session");

        $this->mainModel = $this->reference_m;
    }

    public function index()
    {
        $this->data['title'] = '参考资料管理';
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";

        $filter = array();
        if ($this->uri->segment(SEGMENT) == '') $this->session->unset_userdata('filter');
        $keyword = '';
        if ($_POST) {
            $this->session->unset_userdata('filter');
            $_POST['search_keyword'] != '' && $filter['tbl_yekt_coruses.title'] = $_POST['search_keyword'];
            $_POST['search_course'] != '' && $filter['tbl_sites.id'] = $_POST['search_course'];
            $_POST['search_keyword'] != '' && $keyword = $_POST['search_keyword'];
            $this->session->set_userdata('filter', $filter);
        }
        $this->session->userdata('filter') != '' && $filter = $this->session->userdata('filter');

        $this->data['perPage'] = $perPage = PERPAGE;
        $this->data['cntPage'] = $cntPage = $this->mainModel->get_count($filter);
        $ret = $this->paginationCompress('admin/reference/index', $cntPage, $perPage, 4);
        $this->data['curPage'] = $curPage = $ret['pageId'];
        $this->data["list"] = $this->mainModel->getItemsByPage($filter, $ret['pageId'], $ret['cntPerPage'], $keyword);

        $this->data["tbl_content"] = $this->output_content($this->data['list']);

        $this->data["courseList"] = $this->sites_m->getItems();

        $this->data["subview"] = "admin/contents/reference";

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
            if ($unit->image_path != null && $unit->image_path != '') $iconPath = base_url() . $unit->image_path;
            $iconPath_m = '';
            if ($unit->image_path != null && $unit->image_path != '') $iconPath_m = base_url() . $unit->image_path;
            $contentPath = '';
            if ($unit->course_path != null && $unit->course_path != '') $contentPath = base_url() . $unit->course_path;

            $output .= '<tr>';
            $output .= '<td>' . $unit->course_id . '</td>';
            $output .= '<td>' . $unit->course_name . '</td>';
            $output .= '<td>' . $unit->site . '</td>';
            $output .= '<td>' .
                ($iconPath != '' ? ('<img src="' . $iconPath . '" style="height: 25px;">') : '') .
                '</td>';
//            $output .= '<td>' .
//                ($iconPath_m!=''?('<img src="'.$iconPath_m.'" style="height: 25px;">'):'') .
//                '</td>';
            $output .= '<td>';
            $output .= '<button'
                . ' class="btn btn-sm ' . ($editable ? 'btn-success' : 'disabled') . '" '
                . ' onclick = "' . ($editable ? 'editItem(this);' : '') . '" '
                . ' data-id = "' . $unit->id . '" '
                . ' data-course_id = "' . $unit->site_id . '" '
                . ' data-content_path = "' . $contentPath . '" '
                . ' data-icon_path_m = "' . $iconPath_m . '" '
                . ' data-icon_path = "' . $iconPath . '">'
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
            $id = $_POST['id'];
            $no = $_POST['no'];
            $no = str_replace(' ', '', $no);
            $title = $_POST['title'];
            $site_id = $_POST['course_id'];

            if($no=='' || $title==''){
                $ret['data']= '编码，名称信息错误';
                echo json_encode($ret);
                return;
            }

            $icon_format = $this->input->post('icon_format');
            $icon_format_m = $this->input->post('icon_format_m');
            $content_format = $this->input->post('content_format');

            $config['upload_path'] = "./uploads/reference";
            if (!is_dir($config['upload_path'])) mkdir($config['upload_path']);
            $config['allowed_types'] = '*';
            $tt = $no;
            $filename = $no . $tt;
            $this->load->library('upload', $config);

            $icon_path = '';
            if ($_FILES["item_icon_file4"]["name"] != '') {
                $nameSuffix = 'nr_icon';
                $config['file_name'] = $filename . $nameSuffix . '.' . $icon_format;
                if(file_exists(substr($config['upload_path'],2) .'/'. $config['file_name'])){
                    unlink(substr($config['upload_path'],2) .'/'. $config['file_name']);
                }
                $this->upload->initialize($config, TRUE);
                switch ($icon_format) {
                    case 'gif':
                    case 'png':
                    case 'jpg':
                    case 'jpeg':
                    case 'bmp':
                        ///Image file uploading........
                        if ($this->upload->do_upload('item_icon_file4')) {
                            $data = $this->upload->data();
                            $icon_path = substr($config['upload_path'],2) .'/'. $config['file_name'];
                        } else {
                            $ret['data'] = '缩略图上传错误' . $this->upload->display_errors();
                            $ret['status'] = 'fail';
                            echo json_encode($ret);
                            return;
                        }
                        break;
                }
            }

            $icon_path_m = '';
            if ($_FILES["item_icon_file7"]["name"] != '') {
                $nameSuffix = 'nr_icon_m';
                $config['file_name'] = $filename . $nameSuffix . '.' . $icon_format_m;
                if(file_exists(substr($config['upload_path'],2) .'/'. $config['file_name'])){
                    unlink(substr($config['upload_path'],2) .'/'. $config['file_name']);
                }
                $this->upload->initialize($config, TRUE);
                switch ($icon_format_m) {
                    case 'gif':
                    case 'png':
                    case 'jpg':
                    case 'jpeg':
                    case 'bmp':
                        ///Image file uploading........
                        if ($this->upload->do_upload('item_icon_file7')) {
                            $data = $this->upload->data();
                            $icon_path_m = substr($config['upload_path'],2) .'/'. $config['file_name'];
                        } else {
                            $ret['data'] = '移动端封面图上传错误' . $this->upload->display_errors();
                            $ret['status'] = 'fail';
                            echo json_encode($ret);
                            return;
                        }
                        break;
                }
            }

            $content_path = '';
            $content_type_id = 0;
            if ($_FILES["item_icon_file5"]["name"] != '') {
                $nameSuffix = 'nr';
                $config['file_name'] = $filename . $nameSuffix . '.' . $content_format;
                if(file_exists(substr($config['upload_path'],2) .'/'. $config['file_name'])){
                    unlink(substr($config['upload_path'],2) .'/'. $config['file_name']);
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
                            $content_path = substr($config['upload_path'],2) .'/'. $config['file_name'];
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
                            $content_path =substr($config['upload_path'],2) .'/'. $config['file_name'];
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
                            $content_path = substr($config['upload_path'],2) .'/'. $config['file_name'];
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
                            $content_path =substr($config['upload_path'],2) .'/'. $config['file_name'];
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
                            $content_path =substr($config['upload_path'],2) .'/'. $config['file_name'];
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

                            $uploadPath = substr($config['upload_path'],2) .'/' . $filename . $nameSuffix;
                            if (is_dir($uploadPath)) {
                                $this->rrmdir($uploadPath);
                            }
                            mkdir($uploadPath, 0755, true);
                            $configPackage['upload_path'] = './' . $uploadPath;
                            $configPackage['allowed_types'] = '*';
                            $configPackage['file_name'] = $config['file_name'];
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
                        }else {
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
            }

            $arr = array(
                'course_id' => $no,
                'course_name' => $title,
                'site_id' => $site_id,
                'status' => 0,
                'update_time' => date('Y-m-d H:i:s')
            );
            if ($icon_path != '') $arr['image_path'] = $icon_path;
            if (false && $icon_path_m != '') $arr['icon_path_m'] = $icon_path_m;
            if ($content_path != '') $arr['course_path'] = $content_path;

            if ($id == 0) {
                $arr['create_time'] = date('Y-m-d H:i:s');
                $id = $this->mainModel->add($arr);
            } else {
                $id = $this->mainModel->edit($arr, $id);
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

    function checkRole($id = 32)
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