<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Users extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->lang->load('courses', $language);
//        $this->load->model('contents_m');
        $this->load->model('schools_m');
        $this->load->model('activationcodes_m');
        $this->load->model('users_m');
        $this->load->model('sclass_m');
        $this->load->model('signin_m');
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function profile($user_id)
    {
        $this->data['parentView'] = 'home/index';
        if ($this->signin_m->loggedin()) {///if user logged in the the site =>
            $this->data['user_id'] = $user_id;///current student id;
            $loggedIn_user_id = $this->session->userdata('loginuserID');
            $user_type = $this->session->userdata('user_type');
            if ($loggedIn_user_id == $user_id) {
                if ($user_type == 1) {///*********************************current user is teacher
                    $teacherInfo = $this->users_m->get_single_user($user_id);
                    $classInfo = $this->sclass_m->getUserClass($user_id);

                    $this->data['userClass'] = $classInfo;
                    $this->data['teacher'] = $teacherInfo;
                    $this->data['parentView'] = 'back';
                    $this->data["subview"] = "users/teacher";
                    $this->load->view('_layout_main', $this->data);
                    return;
                } else {///********************************************current user is student
                    $studentInfo = $this->users_m->get_single_user($user_id);
                    $classInfo = array();
                    if($studentInfo->user_class) {
                        $classInfo = $this->sclass_m->get_where(array('class_name' => $studentInfo->user_class))[0];
                        $studentInfo->user_school = $this->users_m->get_single_user($classInfo->teacher_id)->user_school;
                    }
                    $this->data['student'] = $studentInfo;

                    $this->data['parentView'] = 'student/home';

                    $this->data["subview"] = "users/student";
                    $this->load->view('_layout_student_nonav', $this->data);
                    return;
                }
            }
        }
        //*****************************************************current user is visistor
        redirect(base_url('signin'));
    }

    public function add()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $arr = array(
                'user_account' => $_POST['user_account']
            );
            $userInfo = $this->users_m->get_where($arr);
            if (count($userInfo) > 0) {
                $ret['data'] = "此账号已存在";
                echo json_encode($ret);
                return;
            }
//            $tmp = array(
//                'code' => $_POST['code']
//            );
//            $userInfo = $this->users_m->get_where($tmp);
//            if (count($userInfo) == 0) {
//                $ret['data'] = "授权码不存在";
//                echo json_encode($ret);
//                return;
//            }
//            if ($userInfo[0]->user_account != '') {
//                $ret['data'] = "此授权码已使用中";
//                echo json_encode($ret);
//                return;
//            }
            $arr['user_name'] = $_POST['user_name'];
            $arr['password'] = $this->users_m->hash($_POST['password']);
//            $arr['user_school'] = $_POST['user_school'];
//            $arr['user_city'] = $_POST['user_city'];
//            $arr['user_address'] = $_POST['user_address'];
//            $arr['user_class'] = '';
            $arr['user_phone'] = $_POST['user_account'];
            $arr['site_id'] = '1';
//            $arr['user_email'] = $_POST['user_email'];
            $arr['user_type'] = $_POST['user_type'];
//            $arr['activate_status'] = '0';
            $arr['user_status'] = '1';
            $arr['create_time'] = date('Y-m-d H:i:s');
            $this->users_m->insert($arr);
            $ret['data'] = $this->users_m->get_where(array('user_account'=>$arr['user_account']));
            $ret['data'] = $ret['data'][0];
            $this->signin_m->signin($arr['user_account'], $arr['user_type'], $arr['password']);
            $ret['status'] = 'success';
        }

        echo json_encode($ret);
    }

    public function add_student()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $arr = array(
                'user_account' => $_POST['user_account']
            );
            $userInfo = $this->users_m->get_where($arr);
            if (count($userInfo) > 0) {
                $ret['data'] = "此账号已存在";
                echo json_encode($ret);
                return;
            };
//            $tmp = array(
//                'class_code' => $_POST['code']
//            );
//            $classInfo = $this->sclass_m->get_where($tmp);
//            if (count($classInfo) == 0) {
//                $ret['data'] = "Class code is not exist.";
//                echo json_encode($ret);
//                return;
//            }
            $arr['user_name'] = $_POST['user_name'];
            $arr['password'] = $this->users_m->hash($_POST['password']);
//            $arr['user_class'] = $classInfo[0]->class_name;
            $arr['site_id'] = '1';
            $arr['user_type'] = $_POST['user_type'];
//            $arr['activate_status'] = '0';
            $arr['user_status'] = '0';
            $arr['create_time'] = date('Y-m-d H:i:s');
            $userId = $this->users_m->insert($arr);
            $ret['data'] = $this->users_m->get_single_user($userId);
            $ret['status'] = 'success';
        }

        echo json_encode($ret);
    }

    public function update_profile()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $userInfo = $this->users_m->get_single_user($_POST['user_id']);
            $arr = array(
//                'user_name' => $_POST['user_name'],
//                'user_city' => $_POST['user_city'],
                'user_address' => $_POST['user_address'],
                'user_phone' => $_POST['user_phone'],
//                'user_email' => $_POST['user_email'],
                'user_nickname' => $_POST['user_nickname'],
                'user_school' => $_POST['user_school'],
//                'gender' => $_POST['gender'],
                'update_time' => date('Y-m-d H:i:s')
            );
            if (isset($_POST['user_class']))
                $arr['user_class'] = $_POST['user_class'];
            if ($userInfo->user_account != $_POST['user_account']) {
                $ret['data'] = 'User information is invalid.';
                echo json_encode($ret);
                return;
            }
            $this->users_m->update_user($arr, $_POST['user_id']);
            $ret['data'] = $this->users_m->get_single_user($_POST['user_id']);
            $ret['status'] = 'success';
            $this->session->set_userdata(array(
                'user_name' => $ret['data']->user_name,
                'user_school' => $ret['data']->user_school,
            ));
        }
        echo json_encode($ret);
    }

    public function add_class()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $arr = [];

            $user_id = $_POST['user_id'];
            $userInfo = $this->users_m->get_where(array('id' => $user_id));
            if (count($userInfo) == 0) {
                $ret['data'] = 'User is not exist';
                echo json_encode($ret);
                return;
            }
            $class_name = $_POST['user_class'];
            $class_code = $this->generateRandomString(8);
            $class_id = $this->sclass_m->add(array(
                'class_name' => $class_name,
                'teacher_id' => $user_id,
                'class_code' => $class_code
            ));
            $result = $this->sclass_m->get_where(array('teacher_id' => $user_id));
            $ret['data'] = $this->output_class_content($result);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function update_class()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $arr = [];
            $class_id = $_POST['class_id'];
            $class_name = $_POST['class_name'];
            $user_id = $_POST['user_id'];
            $userInfo = $this->users_m->get_where(array('id' => $user_id));
//            $oldClass = $this->sclass_m->get_where(array('teacher_id'=>$user_id));

            if ($class_name == '') {
                $this->sclass_m->delete($class_id);
            } else {
                $this->users_m->update_class($class_name, $class_id);
                $this->sclass_m->update(array('class_name' => $class_name), $class_id);
            }
            $result = $this->sclass_m->get_where(array('teacher_id' => $user_id));
//            if (count($result) > 0) $result = [];
            $ret['data'] = $this->output_class_content($result);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }
    public function change_class()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $arr = [];
            $class_code = $_POST['classcode'];
            $user_id = $_POST['user_id'];
            $classInfo = $this->sclass_m->get_where(array('class_code'=>$class_code));
            if(count($classInfo)<=0) {
                $ret['data'] = '班级不存在';
                echo json_encode($ret);
                return;
            }
            $this->users_m->edit(array('user_class'=>$classInfo[0]->class_name), $user_id);
            $this->session->set_userdata(array('user_class'=>$classInfo[0]->class_name, 'user_status'=>0));

            $ret['data'] = '加入班级成功';
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function get_class()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $user_id = $_POST['user_id'];
            $userInfo = $this->users_m->get_where(array('id' => $user_id));
            if (count($userInfo) == 0) {
                $ret['data'] = 'User is not exist';
                echo json_encode($ret);
                return;
            }

            $result = $this->sclass_m->get_where(array('teacher_id'=>$user_id));
            $ret['data'] = $this->output_class_content($result);
            $result1 = $this->activationcodes_m->get_where(array('user_id'=>$user_id, 'used_status'=>'1', 'status'=>'1'));
            $ret['data1'] = $this->output_course_content($result1);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function output_class_content($lists)
    {
        $content_html = '';
        foreach ($lists as $item) {
            $cnt = ($this->users_m->get_where_count(array('user_class' => $item->class_name, 'user_type' => '2')));
            $content_html .= '<tr>'
                . '<td width="12%">'
                . '<input class="classitem-title" '
                . ' value="' . $item->class_name . '" '
                . ' item_code="' . $item->class_code . '" '
                . ' disabled="disabled" itemid="' . $item->id . '">'
                . '<div class="classitem-btn" '
                . ' itemid="' . $item->id . '">'
                . '</td>'
                . '<td width="6%">'
                . '<div class="editclass-btn"></div>'
                . '</td>'
                . '<td width="12%"><a class="view-detail"></a></td>'
                . '<td width="30%" style="text-align: center;padding-right: 8%;">' . date_format(date_create($item->create_time), "Y-m-d") . '</td>'
                . '<td width="5%" style="text-align: center;padding-right: 5%;">' . $cnt . '</td>'
                . '</tr>';
        }
        return $content_html;
    }

    public function output_course_content($lists)
    {
        $content_html = '';
        foreach ($lists as $item) {
            $content_html .= '<tr>'
                . '<td width="22%" style="padding-left: 2%;">' . $item->site_name . '</td>'
                . '<td width="12%">' . $item->code . '</td>'
                . '<td width="20%" style="text-align: right; padding-right: 3%;">' . date_format(date_create($item->create_time), "Y-m-d") . '</td>'
                . '<td width="20%" style="text-align: right;">' . date_format(date_create($item->update_time), "Y-m-d") . '</td>'
                . '</tr>';
        }
        return $content_html;
    }

    public function get_students()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $class_id = $_POST['class_id'];
            $result = $this->users_m->get_where(array('user_class' => $class_id, 'user_type' => '2'));

            $ret['data'] = $this->output_students_content($result);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function update_student()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $arr = [];
            $user_id = $_POST['user_id'];
            $user_name = $_POST['user_name'];
            $userInfo = $this->users_m->update_user(array('user_name' => $user_name), $user_id);
            $result = $this->users_m->get_where(array('user_class' => $userInfo->user_class, 'user_type' => '2'));

            $ret['data'] = $this->output_students_content($result);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function publish_student()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $arr = [];
            $user_id = $_POST['user_id'];
            $user_status = $_POST['user_status'];
            $userInfo = $this->users_m->update_user(array(
                'user_status' => $user_status,
                'update_time' => date('Y-m-d H:i:s')
            ), $user_id);
            $result = $this->users_m->get_where(array('user_class' => $userInfo->user_class, 'user_type' => '2'));

            $ret['data'] = $this->output_students_content($result);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function delete_student()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $arr = [];
            $user_id = $_POST['user_id'];
            $userInfo = $this->users_m->get_single_user($user_id);
            $this->users_m->delete($user_id);
            $result = $this->users_m->get_where(array('user_class' => $userInfo->user_class, 'user_type' => '2'));

            $ret['data'] = $this->output_students_content($result);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function output_students_content($lists)
    {
        $content_html = '';

        foreach ($lists as $item) {
            $content_html .= '<tr>'
                . '<td width="20%" style="text-align: center;">'
                . $item->user_account
                . '</td>'
                . '<td width="15%">'
                . '<input class="classitem-title" style="text-align:center;"'
                . ' value="' . $item->user_name . '" '
                . ' disabled="disabled" itemid="' . $item->id . '">'
                . '</td>'
                . '<td style="text-align: left;">'
                . '<div class="editclass-btn" style="width:42%;"></div>'
                . '</td>'
                . '<td width="32%" style="text-align: left;" >' . $item->create_time . '</td>'
                . '<td width="27%">'
                . '<div class="publish-txt" itemid="' . $item->id . '" '
                . ' item_status="' . $item->user_status . '"></div>'
                . '<div class="delete-txt" itemid="' . $item->id . '"></div>'
                . '</td>'
                . '</tr>';
        }
        return $content_html;
    }

    public function update_teacher_class()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $arr = array(
                'class' => ''
            );
            if (isset($_POST['class_arr'])) {
                $arr['class'] = json_encode($_POST['class_arr']);
            }
            $ret['data'] = $this->users_m->update_user($arr, $_POST['user_id']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function update_password()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $realOldPass = $this->users_m->hash($_POST['opassword']);
            $realNewPass = $this->users_m->hash($_POST['npassword']);

            $arr = array(
                'id' => $_POST['user_id'],
                'password' => $realOldPass
            );
            ///at first check of fair(user_id,password)
            $retRecord = $this->users_m->get_where($arr);
            if (count($retRecord) == 0) {
                $ret['data'] = 'Old password is incorrect.';
            } else {
                $new_arr = array(
                    'password' => $realNewPass
                );
                $ret['data'] = $this->users_m->update_user($new_arr, $_POST['user_id']);
                $ret['status'] = 'success';
            }
        }
        echo json_encode($ret);
    }

    public function update_student_password()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $realNewPass = $this->users_m->hash($_POST['npassword']);

            $arr = array(
                'user_account' => $_POST['user_account']
            );
            ///at first check of fair(user_id,password)
            $retRecord = $this->users_m->get_where($arr);
            if (count($retRecord) == 0) {
                $ret['data'] = 'User is not exist.';
            } else {
                $new_arr = array(
                    'password' => $realNewPass
                );
                $ret['data'] = $this->users_m->update_user($new_arr, $retRecord[0]->id);
                $this->signin_m->signin($arr['user_account'], '2', $new_arr['password']);
                $ret['status'] = 'success';
            }
        }
        echo json_encode($ret);
    }

    public function update_student_person()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {

            $arr = array(
                'fullname' => $_POST['fullname'],
                'sex' => $_POST['sex'],
                'class' => $_POST['class'],
                'nickname' => $_POST['nickname'],
                'serial_no' => $_POST['serialno']
            );
            $ret['data'] = $this->users_m->update_user($arr, $_POST['user_id']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function getTeacherList($schoolID, $className)
    {
        $ret = array();
        $candidateRecs = $this->users_m->get_where(array('school_id' => $schoolID, 'user_type_id' => '1'));
        foreach ($candidateRecs as $crec):
            //class string to class label list
            if ($crec->class != '') {
                $classLabelList = $this->convertClassArrToLabel($crec->class);
                if (in_array($className, $classLabelList)) array_push($ret, $crec->user_id);
            }
        endforeach;
        return $ret;
    }

    /**
     * @param $userList : student list
     * @param $user_id : teacher id
     * @return array: contents list
     */
    public function getCheckedContents($userList, $user_id, $isTeacher = TRUE)
    {
        $retArr = array();

        if ($isTeacher) {
            //Get Teacher's contents from user id of teacher
            $teacherCheckedList = $this->contents_m->get_contents(array('content_user_id' => $user_id, 'contents.content_type_id' => '2', 'contents.publish' => '1', 'isDeleted_teacher' => '0'));
            foreach ($teacherCheckedList as $tcItem):
                array_push($retArr, $tcItem);
            endforeach;
            //Get Student Contents
            foreach ($userList as $userID):
                $contentsRecs = $this->contents_m->get_contents(array('content_user_id' => $userID, 'contents.content_type_id' => '3', 'contents.publish' => '1', 'isDeleted_teacher' => '0'));
                foreach ($contentsRecs as $contentRec):
                    array_push($retArr, $contentRec);
                endforeach;
            endforeach;
        } else {
            //Get Student's contents from user id of student
            $studentCheckedList = $this->contents_m->get_contents(array('content_user_id' => $user_id, 'contents.content_type_id' => '3', 'contents.publish' => '1', 'isDeleted_student' => '0'));
            foreach ($studentCheckedList as $stdItem):
                array_push($retArr, $stdItem);
            endforeach;
            //Get Teacher Contents
            foreach ($userList as $userID):
                $contentsRecs = $this->contents_m->get_contents(array('content_user_id' => $userID, 'contents.content_type_id' => '2', 'contents.publish' => '1', 'isDeleted_student' => '0'));
                foreach ($contentsRecs as $contentRec):
                    array_push($retArr, $contentRec);
                endforeach;
            endforeach;
        }

        return $retArr;

    }

    /**
     * @param $classLabelList
     * @param $schoolId
     * @return array
     */
    public function getUserListFromClassArr($classLabelList, $schoolId)
    {
        $userList = array();
        foreach ($classLabelList as $classLabel):
            $tmpUserInfos = $this->users_m->get_where(array('school_id' => $schoolId, 'class' => $classLabel, 'user_type_id' => '2'));
            foreach ($tmpUserInfos as $tmpInfo):
                array_push($userList, $tmpInfo->user_id);
            endforeach;
        endforeach;
        return $userList;

    }

    public function convertClassArrToLabel($class_jsonStr)
    {
        $output = array();
        $classStr = $this->lang->line('Class');
        $gradeStr = $this->lang->line('Grade');
        $classArr = json_decode($class_jsonStr);
        foreach ($classArr as $class_info):
            $gradeNo = $class_info->grade;
            $classNo = $class_info->class;
            $realStr = $this->lang->line($gradeNo - 1);
            $realClassStr = $this->lang->line($classNo - 1);
            $tmpClassName = $realStr . $gradeStr . $realClassStr . $classStr;
            array_push($output, $tmpClassName);
        endforeach;
        return $output;
    }

    ///this function is used in teachers profile page
    public function convertClassArrToHtml($class_jsonStr)
    {
        $output = '';
        $classStr = $this->lang->line('Class');
        $gradeStr = $this->lang->line('Grade');
        $classArr = json_decode($class_jsonStr);
        $classCount = 1;
        foreach ($classArr as $class_info):
            $gradeNo = $class_info->grade;
            $realStr = $this->lang->line($gradeNo - 1);
            for ($i = 1; $i <= $class_info->class; $i++) {

                if ($classCount % 2 == 0) {
                    $output .= '<div class="col-md-12" style="text-align:right">';
                    $realClassStr = $this->lang->line($i - 1);
                    $output .= '<div class="custom-checkbox">';
                    $output .= '<input type="checkbox" class="grade-class-list-chk" id = "' . $gradeNo . '-' . $i . '" >';
                    $output .= '<label for="' . $gradeNo . '-' . $i . '" style="color:#fff">';
                    $output .= $realStr . $gradeStr . $realClassStr . $classStr;
                    $output .= '</label>';
                    $output .= '</div>';
                    $output .= '</div>';
                    $output .= '</div>';

                } else {
                    $output .= '<div class="row" style="width:140px;">';
                    $output .= '<div class="col-md-12" style="text-align:right">';
                    $realClassStr = $this->lang->line($i - 1);
                    $output .= '<div class="custom-checkbox">';
                    $output .= '<input type="checkbox" class="grade-class-list-chk" id = "' . $gradeNo . '-' . $i . '" >';
                    $output .= '<label for="' . $gradeNo . '-' . $i . '" style="color:#fff">';
                    $output .= $realStr . $gradeStr . $realClassStr . $classStr;
                    $output .= '</label>';
                    $output .= '</div>';
                    $output .= '</div>';

                }
                $classCount++;
            }
        endforeach;
        return $output;
    }

    public function output_shared_contents($sharedLists)
    {

        $delStr = $this->lang->line('Delete');
        $output = '';
        foreach ($sharedLists as $content):
            $output .= '<tr>';
            $output .= '<td style="width:60%;text-align: center;">';
            $output .= '<a href="' . base_url() . '/' . $content->file_name . '">';
            $output .= $content->content_title;
            $output .= '</a>';
            $output .= '</td>';
            $output .= '<td style="width:40%;text-align: center;">';
            $output .= '<a href="#" content_id = ' . $content->content_id . ' onclick ="deleteSharedContentShow(this);"' . '>';
            $output .= $delStr . '</a>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }

    function generateRandomString($length = 10)
    {
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}

?>