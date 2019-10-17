<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Classroom extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->lang->load('courses', $language);
        $this->load->model('signin_m');
        $this->load->model('package_m');
        $this->load->model('activationcodes_m');
        $this->load->model('lessons_m');
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function index($site_id = '')
    {
        if ($site_id == '') {
            redirect('home/index');
            return;
        }
        $this->session->set_userdata('_siteID', $site_id);

        $this->data['parentView'] = 'home';

        $user_type = $this->session->userdata("user_type");
        $user_id = $this->session->userdata("loginuserID");
        if ($this->signin_m->loggedin()) { // loggedin
            $this->data['user_type'] = $user_type;
            $this->data['user_id'] = $user_id;
        } else { // not loggedin
            redirect(base_url('signin/signin'));
            return;
        }
        $isUsed = $this->activationcodes_m->get_where(array('user_id' => $user_id, 'site_id' => $site_id, 'used_status' => 1));
        if ($isUsed == null) { // not activated
            redirect('home/index');
            return;
        }
        else { // activated
            $this->data["packageList"] = $this->lessons_m->getList($site_id);
            $this->data["selectedIndex"] = 1;
            $this->data["site_id"] = $site_id;
            $this->data["subview"] = "classroom/index";
        }
        $this->load->view('_layout_main', $this->data);
    }

    public function pinyin($site_id = '')
    {
        $this->data['parentView'] = 'student/home';

        $user_type = $this->session->userdata("user_type");
        $user_id = $this->session->userdata("loginuserID");
        if ($this->signin_m->loggedin()) {
            $this->data['user_type'] = $user_type;
            $this->data['user_id'] = $user_id;
        } else {
            redirect(base_url('student/signin'));
            return;
        }
        $this->data["packageList"] = $this->lessons_m->getList($site_id);
        $this->data["selectedIndex"] = 1;
        $this->data["site_id"] = $site_id;
        $this->data["subview"] = "student/pinyin";
        if($user_type=='1')
        $this->load->view('_layout_main', $this->data);
        else
        $this->load->view('_layout_student', $this->data);
    }

    public function view($site_id = NULL, $id = NULL)
    {
        //whenever this function is called..
        ///we have to add access time and update curseware_access table of database.
//        if ($id != '1' && !($this->signin_m->loggedin())) redirect(base_url('home/index'));
        if (!is_numeric($id) || $id == NULL) {
            show_404();
            return;
        }
        if (!($this->signin_m->loggedin())) redirect(base_url('home/index'));
        $user_type = $this->session->userdata('user_type');
        if ($user_type == '1')
            $this->data['parentView'] = 'back';
        else
            $this->data['parentView'] = 'back';
        $this->data["packageList"] = $this->package_m->get_single_package($id);
        $this->data['class_id'] = $this->data["packageList"]->path . '/package/index.html';
        $this->data["subview"] = "classroom/player";
        if($user_type=='1')
            $this->load->view('_layout_main_resource', $this->data);
        else
            $this->load->view('_layout_student', $this->data);
    }

    public function mylesson()
    {
        //whenever this function is called..
        ///we have to add access time and update curseware_access table of database.
        if (!($this->signin_m->loggedin())) redirect(base_url('home/index'));

        $userId = $this->session->userdata('loginuserID');
        $this->data["lessons"] = $this->ncoursewares_m->get_lesson_courses($userId);
        $this->data["coursewares"] = $this->ncoursewares_m->get_ncw_lesson($userId);
        $this->data["subview"] = "coursewares/mylesson";
        $this->load->view('_layout_main', $this->data);

    }

    public function mylesson_prepare()
    {
        //whenever this function is called..
        ///we have to add access time and update curseware_access table of database.
        if (!($this->signin_m->loggedin())) redirect(base_url('home/index'));

        $userId = $this->session->userdata('loginuserID');
        $this->data["courses"] = $this->ncoursewares_m->get_lesson_courses($userId);
        $this->data["coursewares"] = $this->ncoursewares_m->get_ncw_lesson($userId);
        $this->data["subview"] = "coursewares/mylesson_prepare";
        $this->load->view('_layout_main_notool', $this->data);

    }

    public function getLessonItems()
    {
        $ret = array('status' => 'fail', 'data' => array());
        if (!($this->signin_m->loggedin())) {
            echo json_encode($ret);
            return;
        }
        $userId = $_POST['userId'];
        if ($userId == '') $userId = '0';
        $ret['data']['lessons'] = $this->ncoursewares_m->get_lesson_courses($userId);
        $ret['data']['coursewares'] = $this->ncoursewares_m->get_ncw_lesson($userId);
        $ret['status'] = 'success';
        echo json_encode($ret);
    }

    public function addLessonItem()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $author_id = $_POST['author_id'];
            $lesson_name = $_POST['lesson_name'];

            $lessonItem = [
                'media_userid' => $author_id,
                'media_name' => $lesson_name,
                'media_infos' => '[]',
            ];

            $this->db->trans_start();
            $this->db->insert('new_lesson', $lessonItem);
            $lesson_id = $this->db->insert_id();
            $this->db->trans_complete();

            $ret['status'] = 'success';
            $ret['data'] = $this->ncoursewares_m->get_lesson_courses();
        }
        echo json_encode($ret);
    }

    public function updateLessonItem()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $item_id = $_POST['item_id'];
            $lesson_name = $_POST['lesson_name'];
            $media_infos = $_POST['media_infos'];
            $lessonItem = [
                'title_id' => $item_id,
            ];
            if ($lesson_name != '')
                $lessonItem['media_name'] = $lesson_name;
            if ($media_infos != '')
                $lessonItem['media_infos'] = $media_infos;

            $this->db->set($lessonItem);
            $this->db->where('title_id', $item_id);
            $this->db->update('new_lesson');

            $ret['status'] = 'success';
            $ret['data'] = $this->ncoursewares_m->get_lesson_courses();
        }
        echo json_encode($ret);
    }

    public function removeLessonItem()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $lessonId = $_POST['lessonId'];
            if ($lessonId > 4) {
                $this->db->where('title_id', $lessonId);
                $this->db->delete('new_lesson');

                $this->db->where('ncw_sn', $lessonId);
                $this->db->delete('new_coursewares');

                $ret['status'] = 'success';
                $ret['data'] = $lessonId;
            }
        }
        echo json_encode($ret);
    }

    public function removeLessonCourseware()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $coursewareId = $_POST['coursewareId'];
            if ($coursewareId > 52) {
                $this->db->where('ncw_sn', $coursewareId);
                $this->db->delete('new_coursewares');

                $ret['status'] = 'success';
                $ret['data'] = $coursewareId;
            }
        }
        echo json_encode($ret);
    }

    public function add_lesson_courseware()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        $config['upload_path'] = "./uploads/newunit";
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);
        $this->upload->initialize($config, TRUE);
        if ($_POST) {
            $ncw_name = $this->input->post('upload_ncw_name');
            $ncw_sn = $this->input->post('upload_lesson_id');
            $ncw_type = $this->input->post('upload_ncw_type');;
            $userId = $this->input->post('upload_userId');
            $lessonItem = $this->input->post('upload_lessonItem');
            $ncw_file = '';
            switch ($ncw_type) {
                case 'gif':
                case 'png':
                case 'jpg':
                case 'bmp':
                    ///Image file uploading........
                    if ($this->upload->do_upload('add_file_name')) {
                        $data = $this->upload->data();
                        $ncw_file = 'uploads/newunit/' . $ncw_name . '.' . $ncw_type;
                        $ncw_type = '3';
                    } else {
                        $ret['data'] = 'Select courseware file!';
                        $ret['status'] = 'fail';
                        echo json_encode($ret);
                        return;
                    }
                    break;
                case 'mp4':
                    ///Video file uploading........
                    if ($this->upload->do_upload('add_file_name')) {
                        $data = $this->upload->data();
                        $ncw_file = 'uploads/newunit/' . $ncw_name . '.' . $ncw_type;
                        $ncw_type = '2';
                    } else {
                        $ret['data'] = 'Select courseware file!';
                        $ret['status'] = 'fail';
                        echo json_encode($ret);
                        return;
                    }
                    break;
                case 'docx':
                case 'doc':
                    ///Video file uploading........
                    if ($this->upload->do_upload('add_file_name')) {
                        $data = $this->upload->data();
                        $ncw_file = 'uploads/newunit/' . $ncw_name . '.' . $ncw_type;
                        $ncw_type = '4';
                    } else {
                        $ret['data'] = 'Select courseware file!';
                        $ret['status'] = 'fail';
                        echo json_encode($ret);
                        return;
                    }
                    break;
                case 'pdf':
                    ///Video file uploading........
                    if ($this->upload->do_upload('add_file_name')) {
                        $data = $this->upload->data();
                        $ncw_file = 'uploads/newunit/' . $ncw_name . '.' . $ncw_type;
                        $ncw_type = '5';
                    } else {
                        $ret['data'] = 'Select courseware file!';
                        $ret['status'] = 'fail';
                        echo json_encode($ret);
                        return;
                    }
                    break;
                case 'zip':
                    ///Package file uploading.......
                    if (isset($_FILES['add_file_name']['name'])) {

                        $uploadPath = 'uploads/newunit/' . $ncw_name;
                        if (is_dir($uploadPath)) {
                            $this->rrmdir($uploadPath);
                        }
                        mkdir($uploadPath, 0755, true);
                        $configPackage['upload_path'] = './' . $uploadPath;
                        $configPackage['allowed_types'] = '*';
                        $this->load->library('upload', $configPackage);
                        $this->upload->initialize($configPackage, TRUE);
                        if ($this->upload->do_upload('add_file_name')) {
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
                            $ncw_file = $uploadPath;
                            $ncw_type = '1';
                        } else {
                            $ret['data'] = $this->upload->display_errors();
                            $ret['status'] = 'fail';
                            echo json_encode($ret);
                            return;
                        }
                    }
                    break;
            }
            //At first insert new coureware information to the database table
            $param = array(
                'ncw_name' => $ncw_name . '',
                'ncw_sn' => $ncw_sn . '',
                'nunit_id' => '16',
                'ncw_file' => $ncw_file . '',
                'ncw_type' => $ncw_type . '',
                'ncw_author_id' => $userId . '',
                'ncw_publish' => '1',
                'nfree' => '0',
            );
            $ncwId = $this->ncoursewares_m->add($param);
            $lessonItem = json_decode($lessonItem);
            $mediaInfos = json_decode($lessonItem->media_infos);
            $mediaInfos[count($mediaInfos)] = $ncwId;
            $mediaInfos = json_encode($mediaInfos);
            $lessonItem->media_infos = $mediaInfos;

            $titleId = $this->ncoursewares_m->set_lesson_courses($lessonItem->title_id, $lessonItem);

            $ret['data'] = $this->ncoursewares_m->get_ncw_lesson($userId);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);

    }

    function update_SW_Access()
    {

        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $swTypeId = $_POST['subware_type_id'];
            $arr = array(
                'sw_type_id' => $swTypeId,
                'sw_access_time' => date('Y-m-d H:i:s')
            );
            $this->db->insert('subware_accesses', $arr);
            $ret['status'] = 'success';
            $ret['data'] = 'success';
        }
        echo json_encode($ret);

    }

    function pdfDownLoad()
    {
        if (!empty($_GET)) {
            $pdfUrl = $_GET['pdfUrl'];
            $pdf = new PDF_AutoPrint();///https://stackoverflow.com/questions/33254679/print-pdf-in-firefox
            $pageCnt = $pdf->setSourceFile("uploads/courseware/" . $pdfUrl);

            for ($i = 1; $i <= $pageCnt; $i++) {
                $tplIdx = $pdf->importPage($i, '/MediaBox');
                $pdf->addPage();
                $pdf->useTemplate($tplIdx);
            }
            $pdf->AutoPrint(true);
            $pdf->Output();
        }
    }

    function iosReadTextHandler()
    {

        $ret = array(
            'status' => 'fail',
            'data' => ''
        );
        if (!empty($_GET)) {

            $cur_readText = $_GET['cur_text'];
            $text_id = $_GET['text_id'];

            $this->session->set_userdata('cur_read_text', $cur_readText);
            $this->session->set_userdata('read_text_id', $text_id);

            $ret['status'] = 'success';
            $ret['data'] = 'Transmitted read text to server';
        }
        echo json_encode($ret);
    }

    function iosCheckReadText()
    {

        $ret = array(
            'status' => 'fail',
            'data' => ''
        );
        if (!empty($_POST)) {
            $textID = $_POST['text_id'];
            if (isset($_SESSION['cur_read_text']) && isset($_SESSION['read_text_id'])) {

                $readTxtID = $this->session->userdata('read_text_id');
                if ($readTxtID !== $textID) {

                    $ret['data'] = "Can't find current text information from server!";
                    echo json_encode($ret);
                    return;
                }
                $ret['status'] = 'success';
                $ret['data'] = $this->session->userdata('cur_read_text');
                echo json_encode($ret);
                return;
            }

        }
        echo json_encode($ret);
    }
}

?>