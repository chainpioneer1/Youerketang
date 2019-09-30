<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Teacher_work extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->lang->load('courses', $language);
        $this->load->model('signin_m');
        $this->load->model('package_m');
        $this->load->model('lessons_m');
        $this->load->model('courses_m');
        $this->load->model('teacherwork_m');
        $this->load->model('activationcodes_m');
        $this->load->model('problemset_m');
        $this->load->model('sclass_m');
        $this->load->model('users_m');
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function index($id = '')
    {
        $this->session->set_userdata('_siteID', $id);
        $this->testing($id);
    }

    public function deliver()
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));
        $this->data['parentView'] = 'back';
        $user_id = $this->session->userdata('loginuserID');
        $this->data['class_list'] = $this->sclass_m->get_where(array('teacher_id' => $user_id));
        $this->data["subview"] = "teacher_work/deliver_index";
        $this->load->view('_layout_main_resource', $this->data);
    }

    public function getProblem()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $packageIDList = $_POST['package_id_list'];
            $this->data['problem_set'] = $this->problemset_m->getProblemSetFromPackage($packageIDList);
            $ret['data'] = $this->data['problem_set'];
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function addTeacherWork()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );

        if ($_POST) {
            $teacher_id = $_POST['teacher_id'];
            $class_id = $_POST['class_id'];
            $site_id = $this->session->userData('_siteID');
            $problem_info = $_POST['problem_info'];
            $period_time = $_POST['period_time'];
            $task_name = $_POST['task_name'];
            $end_time = $_POST['end_time'];
            for ($i = 0; $i < count($teacher_id); $i++) {
                $teacherWorkItem = [
                    'teacher_id' => $teacher_id[$i],
                    'class_id' => $class_id[$i],
                    'site_id' => $site_id,
                    'problem_info' => $problem_info,
                    'period_time' => $period_time,
                    'task_name' => $task_name,
                    'work_status' => 1,
                    'answer_type' => 0,
                    'end_time' => $end_time

                ];
                $this->teacherwork_m->add($teacherWorkItem);
            }
            $ret['status'] = 'success';
            $ret['data'] = 'added';
        }
        echo json_encode($ret);
    }

    public function updateCheckingState()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );

        if ($_POST) {

            $teacher_id = $_POST['id'];
            $task_id = $_POST['id_array'];
            $end_time = '';
            $site_id = $this->session->userdata('_siteID');
            if (isset($_POST['end_time']))
                $end_time = $_POST['end_time'];
            if ($teacher_id != '') {
                $taskList = $this->teacherwork_m->get_where(array('teacher_id' => $teacher_id, 'site_id' => $site_id));
                foreach ($taskList as $item) {
                    $this->teacherwork_m->edit(array('read_status' => 2), $item->id);
                }
            } else {
                $this->teacherwork_m->edit(array('read_status' => 2, 'end_time' => $end_time), $task_id);
                $taskList = $this->teacherwork_m->get_where(array('teacher_id' => $task_id, 'site_id' => $site_id));
                foreach ($taskList as $item) {
                    $this->teacherwork_m->edit(array('read_status' => 2), $item->id);
                }
            }
            $ret['status'] = 'success';
            $ret['data'] = $this->teacherwork_m->get_where(array('teacher_id' => $teacher_id, 'site_id' => $site_id));
        }
        echo json_encode($ret);
    }

    public function testing($site_id = 0)
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('signin/signin'));
        $this->data['parentView'] = 'home/index';
        $user_id = $this->session->userdata('loginuserID');
        $this->data['class_list'] = $this->sclass_m->get_where(array('teacher_id' => $user_id));
        $this->data['checkList'] = $this->teacherwork_m->get_where(array('teacher_id' => $user_id, 'site_id' => $site_id));
        $this->data["site_id"] = $site_id;
        $this->data["subview"] = "teacher_work/testing_index";
        $this->load->view('_layout_main', $this->data);
    }

    public function testing_report($test_id)
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));
        $this->data['parentView'] = 'teacher_work/testing_details/'.$test_id.'/2';
        $user_id = $this->session->userdata('loginuserID');
        $this->data['test_id'] = $test_id;
        $this->data['endTime'] = $this->teacherwork_m->get_where(array('id' => $test_id))[0]->end_time;
        $this->setTaskList($test_id);
        $this->data['checkDetailedList'] = $this->teacherwork_m->getCheckListDetail($user_id, $test_id);
        $this->data["subview"] = "teacher_work/work_report";
        $this->load->view('_layout_main', $this->data);
    }

    public function testing_report_student($test_id, $problem_id)
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));

        $students = $this->teacherwork_m->get_where(array('teacher_id' => $test_id));
        $return_list = '';

        foreach ($students as $item) {
            $problems = json_decode($item->answer_info);
            $err = 0;

            if (!isset($problems[$problem_id]->student_first_result)) continue;
            else if ($problems[$problem_id]->student_first_result == '1') continue;

            $name = $this->users_m->get_where(array('id' => $item->student_id))[0]->user_name;
            $return_list .= '<div class="student-item">' . $name . '</div>';

        }

        $this->data['student_list'] = $return_list;

        $this->data["subview"] = "teacher_work/work_report_student";
        $this->load->view('_layout_main', $this->data);
    }

    public function testing_details($test_id, $isChecked = 1)
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));
        $this->data['parentView'] = 'teacher_work';
        $this->data['test_id'] = $test_id;
        $this->data['isChecked'] = $isChecked;
        $this->data['endTime'] = $this->teacherwork_m->get_where(array('id' => $test_id))[0]->end_time;
        $this->setTaskList($test_id);
        $this->data['checkDetailedList'] = $this->teacherwork_m->getCheckListDetail(
            $this->session->userdata('loginuserID'), $test_id);
        $this->data["subview"] = "teacher_work/testing_details";
        $this->load->view('_layout_main', $this->data);
    }

    public function setTaskList($test_id)
    {
        $ret = [
            'status' => 'fail',
            'data' => ''
        ];
        $taskItem = $this->teacherwork_m->get_single_package($test_id);
        $class_name = $this->sclass_m->get_where(array('id' => $taskItem->class_id))[0]->class_name;
        $allUsers = $this->users_m->get_where(array('user_class' => $class_name));
        $taskId = $taskItem->id;
        foreach ($allUsers as $user) {
            $user_id = $user->id;
            $item = $taskItem;
            $myItem = $this->teacherwork_m->get_where(array(
                'teacher_id' => $taskId,
                'student_id' => $user_id
            ));
            if (count($myItem) > 0) continue;
            $item->teacher_id = $taskId;
            $item->id = null;
            $item->student_id = $user_id;
            $item->answer_type = '1';
            $answer_info = $this->problemset_m->getProblemSet(json_decode($item->problem_info));
            $item->answer_info = json_encode($answer_info);
            $this->teacherwork_m->add($item);
        }
    }

    public function testing_problem()
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));
        $this->data['parentView'] = 'back';
        $this->data["subview"] = "teacher_work/testing_problem";
        $this->load->view('_layout_main', $this->data);
    }

    public function viewProblemSet($problem_info)
    { //this function is called after clicking problemset name.

        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));
        $this->data['parentView'] = 'back';
        $data = $this->teacherwork_m->problemSet($problem_info);
        $this->data['problem_set'] = $data;
        $this->data["subview"] = "teacher_work/problem_set";
        $this->load->view('_layout_main', $this->data);
    }

    public function viewAnswerInfo($id)
    { //this function is called after clicking user's anwser information.
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));
        $this->data['parentView'] = 'back';
        $singlePackage = $this->teacherwork_m->get_single_package($id);
        $this->data['endTime'] = $singlePackage->end_time;
        $this->data['answer_info'] = $singlePackage->answer_info;
        $this->data["subview"] = "teacher_work/answer_info";
        $this->load->view('_layout_main', $this->data);
    }

    public function viewProblemInfo($id)
    { //this function is called after clicking user's anwser information.
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));
        $this->data['parentView'] = 'back';
        $userID = $this->session->userdata('loginuserID');
        $ids = $this->teacherwork_m->get_item_problem_info($id, $userID);
        $id_array = json_decode($ids[0]->problem_info);
        $timeIds = $this->teacherwork_m->get_item_end_time($id, $userID);
        $this->data['endTime'] = $timeIds[0]->end_time;
        $prob_info = $this->problemset_m->getProblemSet($id_array);
        $this->data['problem_info'] = $prob_info;
        $this->data["subview"] = "teacher_work/problem_info";
        $this->load->view('_layout_main', $this->data);
    }

    public function previewPlayer($id = 0)
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));
        $this->data['parentView'] = 'back';
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

    public function education()
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));

        $this->data['parentView'] = 'home/index';
        $this->data["packageList"] = $this->lessons_m->getItems();
        $this->data["selectedIndex"] = 0;
        $this->data["subview"] = "resource/index";
        $this->load->view('_layout_main_resource', $this->data);

    }

    public function courselist($id = NULL)
    {
        if (!is_numeric($id) || $id == NULL) {
            show_404();
            return;
        }
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));

        $this->data['parentView'] = 'resource';
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
                . ' onclick="showVideoPlayer(' . $unit->id . ')">'
                . '</td>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    public function userplayerview()
    {

    }

    public function lessonware()
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));

        $this->data['parentView'] = 'home/index';
        $this->data['lessonList'] = $this->lessons_m->getItems();
        $this->data["lessonList_content"] = $this->lessonware_output_content($this->data["lessonList"]);
        $this->data["selectedIndex"] = 1;
        $this->data["subview"] = "resource/lessonware";
        $this->load->view('_layout_main_resource', $this->data);
    }

    public function lessonware_home($id = Null, $title = Null)
    {
        $this->signin_m->loggedin() == TRUE || redirect(base_url('home/index'));
        if ($id != 0) {
            $title = $this->lessons_m->getLessonNameFromId($id);
        }

        $this->data['parentView'] = 'back';
        $this->data['lessonList'] = $this->lessons_m->getItems();
        $this->data['courseList'] = $this->courses_m->getCourses();
        $this->data['processIndex'] = $id;
        $this->data["selectedIndex"] = 1;
        $this->data['title'] = $title;
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
                $output .= '<tr>';
                $output .= '<td class ="lesson_td" onclick="showVideo(this)" item_id="' . $unit->id . '" width="25%">' . $unit->lesson_name . '</td>';
                $output .= '<td width="30%">' . $unit->create_time . '</td>';
                $output .= '<td width="45%" class="lessonware_operation">'
                    . '<div class="publish-btn" '
                    . ' onclick="publish_lw(this)" publish_status = '
                    . $publish_status . ' item_id=' . $unit->id . '></div>'
                    . '<div class="edit-btn" '
                    . ' onclick="edit_lw(this)" item_id=' . $unit->id . '></div>'
                    . '<div class="delete-btn" '
                    . ' onclick="delete_lw(this)" item_id=' . $unit->id . '></div>'
                    . '</td>';
                $output .= '</td>';
                $output .= '</tr>';
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
            $lesson_id = $_POST['lesson_id'];
            $lesson_info = $_POST['lesson_info'];
            $lesson_name = $_POST['lesson_name'];
            $lessonItem = [
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
            $lessonItem = [
                'lesson_info' => $lesson_info,
                'lesson_name' => $lesson_name,
                'owner_type' => $owner_type,
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
                        $ncw_file = 'uploads/course_work/' . $ncw_name . '.' . $ncw_type;
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
}

?>