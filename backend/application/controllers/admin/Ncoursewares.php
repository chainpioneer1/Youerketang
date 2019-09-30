<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Ncoursewares extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';

        $this->load->model("nchildcourses_m");
        $this->load->model("nunits_m");
        $this->load->model("ncoursewares_m");
        $this->load->model("users_m");
        $this->lang->load('courses', $language);
        $this->load->library("pagination");

    }

    public function index()
    {
        $this->data['ncwSets'] = $this->ncoursewares_m->get_ncw();
        $this->data['nccsSets'] = $this->nchildcourses_m->get_nchild_courses();
        $this->data['nunitSets'] = $this->nunits_m->get_nunits();
        $this->data["subview"] = "admin/courses/ncoursewares";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data["tbl_content"] = $this->output_content($this->data['ncwSets']);
        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    public function delete()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            //At first courseware directory with specified courseware id  in uploads directory
            $delete_ncw_id = $_POST['delete_ncw_id'];
            $ncwInfo = $this->ncoursewares_m->get_single(array('ncw_id' => $delete_ncw_id));
            $ncwPath = $ncwInfo->ncw_file;
            $this->rrmdir($ncwPath);
            $ncwSets = $this->ncoursewares_m->delete($delete_ncw_id);
            $ret['data'] = $this->output_content($ncwSets);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function publish()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $ncw_id = $_POST['ncw_id'];
            $publish_ncw_st = $_POST['publish_state'];
            $ncwSets = $this->ncoursewares_m->publish($ncw_id, $publish_ncw_st);
            $ret['data'] = $this->output_content($ncwSets);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function output_content($ncwsets)
    {
        $output = '';

        foreach ($ncwsets as $ncw):
            $pub = $this->lang->line('Enable');
            $Editable = true;
            if ($ncw->ncw_publish == '1') {
                $pub = $this->lang->line('Disable');
                $Editable = false;
            }
            $output .= '<tr>';
            $output .= '<td>' . $ncw->ncw_sn . '</td>';
            $output .= '<td>' . $ncw->ncw_name . '</td>';
            $output .= '<td>' . $ncw->nunit_name . '</td>';
            $output .= '<td>' . $ncw->childcourse_name . '</td>';
            $output .= '<td>' . $ncw->course_name . '</td>';
            $output .= '<td>';
            $output .= '<button class="btn btn-sm ' . (!$Editable ? 'disabled' : 'btn-success') . '"'
                . ' onclick = "' . ($Editable ? 'edit_ncw(this);' : '') . '"'
                . ' ncw-free="' . $ncw->nfree . '" ncw_photo = "' . $ncw->ncw_photo . '"'
                . ' ncw_file="' . $ncw->ncw_file . '"'
                . ' ncw_id = ' . $ncw->ncw_id . '>' . $this->lang->line('Modify') . '</button>';
            $output .= '<button class="btn btn-sm ' . (!$Editable ? 'disabled' : 'btn-danger') . '"'
                . ' onclick = "' . ($Editable ? 'delete_ncw(this);' : '') . '"'
                . ' ncw_id = ' . $ncw->ncw_id . '>' . $this->lang->line('Delete') . '</button>';
            $output .= '<button class="btn btn-sm ' . ($Editable ? 'btn-default' : 'btn-warning')
                . '" onclick = "publish_ncw(this);" ncw_id = ' . $ncw->ncw_id . '>' . $pub . '</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
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

    public function add()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        $config['upload_path'] = "./uploads/images";
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);
        if ($_POST) {
            $ncw_name = $this->input->post('add_ncw_name');
            $ncw_sn = $this->input->post('add_ncw_sn');
            $nunit_sn = substr($ncw_sn, 0, count($ncw_sn) - 3);
            $isFree = $this->input->post('free_option');
            $nunit_id = $this->ncoursewares_m->get_nunitIdBySN($nunit_sn);
            $add_ncw_image_path = '';
            $add_ncw_package_path = '';
            $ncwId = $this->ncoursewares_m->get_ncwIdBySN($ncw_sn);

            $newNcwInfo = $this->ncoursewares_m->get_single(array('ncw_id' => $ncwId));
            if ($newNcwInfo->ncw_publish != 0) {
                $ret['data'] = 'Courseware is being used now.';
                echo json_encode($ret);
                return;
            }

            //image uploading
            if ($this->upload->do_upload('add_file_name')) {
                $data = $this->upload->data();
                $add_ncw_image_path = 'uploads/images/' . $data["file_name"];
            } else {
                $ret['data'] = 'Select image file!';
                $ret['status'] = 'fail';
                echo json_encode($ret);
                return;
            }
            //At first insert new coureware information to the database table
            $param = array(
                'ncw_sn' => $ncw_sn,
                'ncw_name' => $ncw_name,
                'nunit_id' => $nunit_id,
                'ncw_photo' => $add_ncw_image_path,
                'nfree' => $isFree
            );
            if ($ncwId == 0) $ncwId = $this->ncoursewares_m->add($param);
            else $this->ncoursewares_m->edit($param, $ncwId);
            $ncw_type = '1';
            ///Package file uploading.......
            $uploadFile = $_FILES["add_package_file_name"]["name"];
            if ($uploadFile != '') {

                $uploadPath = 'uploads/newunit/' . $ncw_sn;
                if (is_dir($uploadPath)) {
                    $this->rrmdir($uploadPath);
                }
                mkdir($uploadPath, 0755, true);
                $configPackage['upload_path'] = './' . $uploadPath;
                $configPackage['allowed_types'] = '*';
                $this->load->library('upload', $configPackage);
                $this->upload->initialize($config, TRUE);
                if (stristr($uploadFile, 'mp4') == false) {
                    if ($this->upload->do_upload('add_package_file_name')) {
                        $zipData = $this->upload->data();
                        $zip = new ZipArchive;
                        $file = $zipData['full_path'];
                        chmod($file, 0777);
                        if ($zip->open($file) === TRUE) {
                            $zip->extractTo($configPackage['upload_path']);
                            $zip->close();
                            unlink($file);
                        } else {
                            echo json_encode($ret); // failed
                        }
                        $add_ncw_package_path = $uploadPath;
                    } else {
                        $ret['data'] = $this->upload->display_errors();
                        $ret['status'] = 'fail';
                        echo json_encode($ret);
                        return;
                    }
                } else {
                    if ($this->upload->do_upload('add_package_file_name')) {
                        $data = $this->upload->data();
                        $add_ncw_package_path = $uploadPath . '/' . $data["file_name"];
                        $ncw_type = '2';
                    } else {
                        $ret['data'] = 'Select courseware file!';
                        $ret['status'] = 'fail';
                        echo json_encode($ret);
                        return;
                    }
                }
            }
            $ncwsets = $this->ncoursewares_m->edit(array('ncw_file' => $add_ncw_package_path, 'ncw_type' => $ncw_type), $ncwId);
            $ret['data'] = $this->output_content($ncwsets);
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
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);

        if ($_POST) {
            $ncw_id = $this->input->post('ncw_id');
            $ncw_name = $this->input->post('edit_ncw_name');
            $ncw_sn = $this->input->post('edit_ncw_sn');
            $nunit_sn = substr($ncw_sn, 0, count($ncw_sn) - 3);
            $isFree = $this->input->post('free_option');
            $nunit_id = $this->ncoursewares_m->get_nunitIdBySN($nunit_sn);
            $oldNcwInfo = $this->ncoursewares_m->get_single(array('ncw_id' => $ncw_id));

            $ncw_id = $this->ncoursewares_m->get_ncwIdBySN($ncw_sn);

            $newNcwInfo = $this->ncoursewares_m->get_single(array('ncw_id' => $ncw_id));
            if ($newNcwInfo->ncw_publish != 0) {
                $ret['data'] = 'Courseware is being used now.';
                echo json_encode($ret);
                return;
            }
            $ncw_image_path = '';
            $param = array(
                'ncw_sn' => $ncw_sn,
                'ncw_name' => $ncw_name,
                'nunit_id' => $nunit_id,
                'nfree' => $isFree,
                'ncw_photo' => $oldNcwInfo->ncw_photo,
                'ncw_file' => $oldNcwInfo->ncw_file,
            );
            if ($_FILES["edit_file_name"]["name"] != '') {
                //image uploading
                if ($this->upload->do_upload('edit_file_name')) {
                    $data = $this->upload->data();
                    $ncw_image_path = 'uploads/images/' . $data["file_name"];
                } else {///show error message
                    $ret['data'] = $this->upload->display_errors();
                    $ret['status'] = 'fail';
                    echo json_encode($ret);
                    return;
                }
            }
            if ($ncw_image_path != '') $param['ncw_photo'] = $ncw_image_path;

            //$oldNcwInfo = $this->ncoursewares_m->get_single(array('ncw_id' => $ncw_id));
            $oldPath = $oldNcwInfo->ncw_file;
            $newPath = 'uploads/newunit/' . $ncw_sn;
            $uploadFile = $_FILES["edit_package_file_name"]["name"];
            if ($uploadFile == '') {
                if ($oldPath != $newPath) {
                    $this->rrmdir($newPath);
                    mkdir($newPath, 0777, true);
                    $this->rcopy($oldPath, $newPath);
                    //$this->rrmdir($oldPath);
                    $param['ncw_file'] = $newPath;
                }
            } else {
                if ($oldNcwInfo->ncw_id == $ncw_id)
                    $this->rrmdir($newPath);
                else
                    $this->rrmdir($oldPath);
                mkdir($newPath, 0777, true);

                $config['upload_path'] = './' . $newPath;
                $config['allowed_types'] = '*';
                $this->load->library('upload', $config);
                $this->upload->initialize($config, TRUE);
                if (stristr($uploadFile, '.mp4') == false) {
                    if ($this->upload->do_upload('edit_package_file_name'))///this process is success then we have to move current subware to new position
                    {
                        ///---1----. At first New zip file upload and Extract
                        $zipdata = $this->upload->data();
                        $zip = new ZipArchive;
                        $file = $zipdata['full_path'];
                        chmod($file, 0777);
                        if ($zip->open($file) === TRUE) {
                            $zip->extractTo($config['upload_path']);
                            $zip->close();
                            unlink($file);
                            $param['ncw_file'] = $newPath;
                            $param['ncw_type'] = '1';
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
                    if ($this->upload->do_upload('edit_package_file_name')) {
                        $data = $this->upload->data();
                        $param['ncw_file'] = $newPath . '/' . $data["file_name"];
                        $param['ncw_type'] = '2';
                    } else {
                        $ret['data'] = $this->upload->display_errors();
                        $ret['status'] = 'fail';
                        echo json_encode($ret);
                        return;
                    }
                }
            }
//            var_dump($ncw_sn);
            $ncwsets = $this->ncoursewares_m->edit($param, $ncw_id);
            $ret['data'] = $this->output_content($ncwsets);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    function checkRole()
    {
        $permission = $this->session->userdata('admin_user_type');
        if ($permission != NULL) {
            $permissionData = json_decode($permission);
            $accessInfo = $permissionData[0]->unit_sub_st;
            if ($accessInfo == '1') return true;
            else return false;
        }
        return false;
    }
}
