<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Resource extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->lang->load('courses', $language);
        $this->load->model('signin_m');
        $this->load->model('package_m');
        $this->load->model('lessons_m');
        $this->load->model('reference_m');
        $this->load->model('courses_m');
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function index()
    {
        $this->education();
    }

    public function previewPlayer($site_id = 0, $id = 0)
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));
//        $this->data['parentView'] = 'back';
        $this->data['parentView'] = 'classroom';
        $this->data["lessonItem"] = $this->lessons_m->get_where(array('id' => $id));
        $courselists = json_decode($this->data['lessonItem'][0]->lesson_info);
        $this->data["courseList"] = $this->courses_m->getCourseFromLesson($courselists);
        $this->data["title"] = $this->data["lessonItem"][0]->lesson_name;

        $this->data["subview"] = "resource/previewplayer";
        $this->load->view('_layout_main', $this->data);
    }

    public function warePreviewPlayer($id = 0, $lesson_info = NULL)
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));
        $this->data['parentView'] = 'back';
        $courselists = explode("_", $lesson_info);
        if (count($courselists) > 0) $this->data["courseList"] = $this->courses_m->getCourseFromLesson($courselists);
        else $this->data["courseList"] = '';
        $this->data["title"] = "_";
        $this->data["subview"] = "resource/previewplayer";
        $this->load->view('_layout_main', $this->data);
    }

    public function referencePlayer($id = 0)
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));
        $this->data['parentView'] = 'back';
        $this->data["courseList"] = $this->reference_m->get_where(array('id'=>$id));
        $this->data["title"] = "_";
        $this->data["subview"] = "resource/previewplayer";
        $this->load->view('_layout_main', $this->data);
    }

    public function education($id = 0)
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('signin/signin'));

        $this->session->set_userdata('_siteID', $id);
        $this->data['parentView'] = 'home/index';
//        $this->data["packageList"] = $this->lessons_m->getItems();
        $this->data["packageList"] = $this->reference_m->get_where(array('site_id' => $id));
        $this->data["selectedIndex"] = 0;
        $this->data["site_id"] = $id;
        $this->data["subview"] = "resource/index";
        $this->load->view('_layout_main', $this->data);
//        $this->load->view('_layout_main_resource', $this->data);

    }

    public function courselist($id = NULL)
    {
        if (!is_numeric($id) || $id == NULL) {
            show_404();
            return;
        }
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));

        $this->data['parentView'] = 'back';
        $this->data["courseList"] = $this->courses_m->get_where(['lesson_id' => $id]);
        $this->data["courseList_content"] = $this->courselist_output_content($this->data["courseList"]);
        $this->data['lessonItem'] = $this->lessons_m->get_where(['id' => $id])[0];
        $this->data["selectedIndex"] = 0;
        $this->data["subview"] = "resource/courselist";
        $this->load->view('_layout_main_resource', $this->data);


    }

    public function courselist_output_content($items)
    {
        $output = '';
        $j = 0;
        foreach ($items as $unit):
            $j++;
            $output .= '<tr>';
            $output .= '<td>' . $unit->course_name . '</td>';
            $output .= '<td>&nbsp;&nbsp;&nbsp;' . $unit->information . '</td>';
            $output .= '<td>'
                . '<img src="' . base_url($unit->image_path) . '">'
                . '<div class="play-btn" src="' . base_url('assets/images/frontend/resource/play-btn.png') . '" '
                . ' onclick="showVideoPlayer(' . $unit->id . ');">'
                . '</td>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    public function lessonware($id = 0)
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));

        $this->session->set_userdata('_siteID', $id);
        $this->data['parentView'] = 'home/index';
        $user_id = $this->session->userdata('loginuserID');
        $this->data['lessonList'] = $this->lessons_m->getList($id, $user_id);
        $this->data["lessonList_content"] = $this->lessonware_output_content($this->data["lessonList"]);
        $this->data["selectedIndex"] = 1;
        $this->data["site_id"] = $id;
        $this->data["subview"] = "resource/lessonware";
        $this->load->view('_layout_main', $this->data);
//        $this->load->view('_layout_main_resource', $this->data);
    }

    public function lessonware_home($site_id = Null, $id = Null, $title = Null)
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));
        if ($id != 0) {
            $title = $this->lessons_m->getLessonNameFromId($id);
        }
        $this->courses_m->clearUnusedCourses();
        $this->data['parentView'] = 'back';
        $this->data['lessonList'] = $this->lessons_m->getItems();
        $this->data['packageList'] = $this->package_m->getItems();
        $this->data['courseList'] = $this->courses_m->getCourses();
        $this->data['processIndex'] = $id;
        $this->data["selectedIndex"] = 1;
        $this->data['title'] = $title;
        $this->data['site_id'] = $site_id;
        $this->data["subview"] = "resource/lessonware_home";
        $this->load->view('_layout_main_resource', $this->data);
    }

    public function lessonware_output_content($items)
    {
        $output = '';
        $j = 0;
        $userID = $this->session->userdata('loginuserID');
        foreach ($items as $unit):
            $j++;
            if ($unit->owner_type === $userID) {
                $publish_status = $unit->lesson_status;
                $publishURL = ($publish_status == '1') ? base_url('assets/images/resource/lessonware/lessonware1/publish.png') : base_url('assets/images/resource/lessonware/lessonware1/unpublish.png');
                $output .= '<div class="lessonware_list">';
                $output .= '<div class ="lessonware_icon" onclick="showVideo(this)" item_id="' . $unit->id . '" style="background:url('.base_url( $unit->image_icon ).');"></div>';
                $output .= '<div class ="lessonware_text" onclick="showVideo(this)" item_id="' . $unit->id . '">' . $unit->lesson_name . '</div>';
                $output .= '<div style="left: 19%; top: 40%; width: 30%; font-size: calc(1.5vw); color: gray;">快乐拼音</div>';
                $output .= '<div class="lessonware_time">' . $unit->create_time . '</div>';
                $output .= '<div class="lessonware_operation">'
                    . '<div class="publish-btn" '
                    . ' onclick="publish_lw(this)" publish_status = '
                    . $publish_status . ' item_id=' . $unit->id . '></div>'
                    . '<div class="edit-btn" '
                    . ' onclick="edit_lw(this)" item_id=' . $unit->id . '></div>'
                    . '<div class="delete-btn" '
                    . ' onclick="delete_lw(this)" item_id=' . $unit->id . '></div>'
                    . '</div>';
                $output .= '</div>';
            }


        endforeach;
        return $output;
    }

    public function updateLessonInfo()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );

        if ($_POST) {
            $site_id = $_POST['site_id'];
            $lesson_id = $_POST['lesson_id'];
            $lesson_info = $_POST['lesson_info'];
            $lesson_name = $_POST['lesson_name'];
            $lessonItem = [
                'site_id' => $site_id,
                'lesson_info' => $lesson_info,
                'lesson_name' => $lesson_name,
                'update_time' => date('Y-m-d H:i:s'),
            ];
            $this->lessons_m->edit($lessonItem, $lesson_id);

            $ret['status'] = 'success';
            $ret['data'] = 'updated';
        }
        echo json_encode($ret);
    }

    public function addLesson()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );

        if ($_POST) {
            $lesson_info = $_POST['lesson_info'];
            $lesson_name = $_POST['lesson_name'];
            $owner_type = $_POST['owner_type'];
            $site_id = $_POST['site_id'];
            $lessonItem = [
                'lesson_info' => $lesson_info,
                'lesson_name' => $lesson_name,
                'owner_type' => $owner_type,
                'site_id' => $site_id,
                'lesson_status' => 1,
                'information' => '我的课件',
                'create_time' => date('Y-m-d H:i:s')
            ];
            $this->lessons_m->add($lessonItem);
            $ret['status'] = 'success';
            $ret['data'] = 'added';
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
            $delete_lw_id = $_POST['delete_lw_id'];
            $this->data['cwsets'] = $this->lessons_m->delete($delete_lw_id);
            $ret['data'] = $this->lessonware_output_content($this->data['cwsets']);
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
            $publish_lw_id = $_POST['publish_lw_id'];
            $publish_lw_st = $_POST['publish_state'];
            $this->data['cwsets'] = $this->lessons_m->publish($publish_lw_id, $publish_lw_st);
            $ret['data'] = $this->lessonware_output_content($this->data['cwsets']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function learning()
    {

        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));
        $this->data['parentView'] = 'home/index';
        $this->data["learningList"] = $this->learning_m->get_learning();
        $this->data["selectedIndex"] = 2;
        $this->data["subview"] = "resource/learning";
        $this->load->view('_layout_main_resource', $this->data);
    }


    public function playerview($id = NULL)
    {
        //whenever this function is called..
        ///we have to add access time and update curseware_access table of database.
        if (!is_numeric($id) || $id == NULL) {
            show_404();
            return;
        }
        $this->data['parentView'] = 'resource/learning';
        $this->data["learningList"] = $this->courses_m->get($id, TRUE);
        $item = $this->data["learningList"];
        $this->data['class_id'] = $item->course_path;
        $course_type = $item->course_type;
        $this->data['title_id'] = $id;
        switch ($course_type) {
            case '2':
                $this->data['title_id'] = $item->course_name;
                $this->data["subview"] = "resource/videoplayer";
                break;
            case '3':
                $this->data['title_id'] = $item->course_name;
                $this->data["subview"] = "resource/imageplayer";
                break;
            case '4':
                $this->data['title_id'] = $item->course_name;
                $this->data["subview"] = "resource/docviewer";
                break;
            case '5':
                $this->data['title_id'] = $item->course_name;
                $this->data["subview"] = "resource/pdfviewer";
                break;
            case '1':
            case '6':
                $this->data['title_id'] = $item->course_name;
                $this->data["subview"] = "resource/player";
                break;
            default:
                $this->data['title_id'] = $item->course_name;
                $this->data["subview"] = "resource/docviewer";
        }
        $this->load->view('_layout_main', $this->data);

    }

    public function learningPlayerView($id = NULL)
    {
        if (!is_numeric($id) || $id == NULL) {
            show_404();
            return;
        }
        $this->data['parentView'] = 'resource/learning';
        $this->data["learningList"] = $this->learning_m->get_single_learning($id);
        $this->data['class_id'] = $this->data["learningList"]->path . '.mp4';
        $this->data['title_id'] = $this->data["learningList"]->name;
        $this->data["subview"] = "resource/videoplayer";
        $this->load->view('_layout_main', $this->data);
    }

    public function view($id = NULL)
    {
        //whenever this function is called..
        ///we have to add access time and update curseware_access table of database.
        if (!is_numeric($id) || $id == NULL) {
            show_404();
            return;
        }
        $this->data['parentView'] = 'back';
        $this->data["packageList"] = $this->package_m->get_package();
        $this->data['class_id'] = $this->data["packageList"][$id]->path . '/package';
        $this->data["subview"] = "resource/player";
        $this->load->view('_layout_main', $this->data);
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


    public function add_lesson_courseware()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        $config['upload_path'] = "./uploads/course_work";
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);
        $this->upload->initialize($config, TRUE);
        if ($_POST) {
            $imgPath = 'assets/images/resource/lessonware/lessonware2/tubiao1.png';
            $ncw_name = $this->input->post('upload_lw_name');
            $ncw_type = $this->input->post('upload_lw_type');;
            $userId = $this->input->post('upload_userId');
            $ncw_file = '';
            switch ($ncw_type) {
                case 'gif':
                case 'png':
                case 'jpg':
                case 'bmp':
                    ///Image file uploading........
                    if ($this->upload->do_upload('add_file_name')) {
                        $data = $this->upload->data();
                        $ncw_file = 'uploads/course_work/' . $ncw_name . '.' . $ncw_type;
                        $ncw_type = '3';
                        $imgPath = 'assets/images/resource/lessonware/lessonware2/tubiao3.png';
                    } else {
                        $ret['data'] = 'Select courseware file!';
                        $ret['status'] = 'fail';
                        echo json_encode($ret);
                        return;
                    }
                    break;
                case 'mp3':
                case 'wav':
                case 'mp4':
                    ///Video file uploading........
                    if ($this->upload->do_upload('add_file_name')) {
                        $data = $this->upload->data();
                        $ncw_file = 'uploads/course_work/' . $ncw_name . '.' . $ncw_type;
                        $imgPath = 'assets/images/resource/lessonware/lessonware2/tubiao2_1.png';
                        if ($ncw_type != 'mp4')
                            $imgPath = 'assets/images/resource/lessonware/lessonware2/tubiao2_2.png';
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
                        $ncw_file = 'uploads/course_work/' . $ncw_name . '.' . $ncw_type;
                        $ncw_type = '4';
                        $imgPath = 'assets/images/resource/lessonware/lessonware2/tubiao4.png';
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
                        $ncw_file = 'uploads/course_work/' . $ncw_name . '.' . $ncw_type;
                        $ncw_type = '5';
                        $imgPath = 'assets/images/resource/lessonware/lessonware2/tubiao5.png';
                    } else {
                        $ret['data'] = 'Select courseware file!';
                        $ret['status'] = 'fail';
                        echo json_encode($ret);
                        return;
                    }
                    break;
                case 'html':
                    ///Video file uploading........
                    if ($this->upload->do_upload('add_file_name')) {
                        $data = $this->upload->data();
                        $ncw_file = 'uploads/course_work/' . $ncw_name . '.' . $ncw_type;
                        $ncw_type = '6';
                        $imgPath = 'assets/images/resource/lessonware/lessonware2/tubiao1.png';
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

                        $uploadPath = 'uploads/course_work/' . $ncw_name;
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
                            $imgPath = 'assets/images/resource/lessonware/lessonware2/tubiao1.png';
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
                'course_name' => $ncw_name . '',
                'lesson_id' => 0,
                'course_path' => $ncw_file . '',
                'course_type' => $ncw_type . '',
                'owner_type' => $userId . '',
                'create_time' => date("Y-m-d H:i:s"),
                'image_path' => $imgPath . '',
                'information' => '我的课件'
            );
            $ncwId = $this->courses_m->add($param);
            $ret['data'] = $this->courses_m->getOwnerCourses($userId);
            $ret['courseList'] = $this->courses_m->getCourses();
            $ret['status'] = 'success';
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

    // added
    public function getContents()
    {
        $ret = array(
            'data' => array(),
            'status' => false
        );
        if ($_POST) {
            $user_id = $_POST['user_id'];
            $package_id = $_POST['package_id'];
            $result = $this->courses_m->get_where(
                array(
                    'package_id' => $package_id,
                    'owner_type' => $user_id,
                    'status' => 1
                )
            );

            $ret['status'] = true;
            $ret['data'] = $result;
        }
        echo json_encode($ret);
    }
}

?>