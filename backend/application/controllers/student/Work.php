<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Work extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->lang->load('courses', $language);
        $this->load->model("users_m");
        $this->load->model("signin_m");
        $this->load->model("sclass_m");
        $this->load->model("problemset_m");
        $this->load->model("wrongset_m");
        $this->load->model("teacherwork_m");
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function index($site_id = '')
    {
        if ($this->signin_m->loggedin() == FALSE) {
            redirect(base_url('student/signin'));
        } else {
            $this->data["subview"] = "student/work";
            $this->data['parentView'] = 'classroom/pinyin/'.$site_id;
            $this->data['site_id'] = $site_id;
            $this->data['taskList'] = $this->output_task_content($this->getTaskList(
                $this->session->userdata('loginuserID'),
                $this->session->userdata('user_class'),
                $site_id
            ));
            $this->load->view('_layout_student', $this->data);
        }
    }

    public function getTaskList($user_id = '0', $class_name = '', $site_id = '')
    {
        $ret = [
            'status' => 'fail',
            'data' => ''
        ];
        if (!$_POST && $user_id == '0') {
            $ret['data'] = '参数无效';
            echo json_encode($ret);
            return;
        }
        if ($user_id == '0') {
            $user_id = $_POST['user_id'];
            $class_name = $_POST['class_name'];
        }
        if($class_name=='') return array();
        $user_status = $this->users_m->get_single_user($user_id);
        if(count($user_status)<=0) return array();
        $user_status = $user_status->user_status;
        if($user_status == 0) return array();
        $class_id = $this->sclass_m->get_where(array('class_name' => $class_name))[0]->id;
        $taskList = $this->teacherwork_m->get_where(array(
            'class_id' => $class_id,
            'answer_type' => '0'
        ));
        foreach ($taskList as $item) {
            $myItem = $this->teacherwork_m->get_where(array(
                'teacher_id' => $item->id,
                'student_id' => $user_id
            ));
            if (count($myItem) > 0) continue;
            $item->teacher_id = $item->id;
            $item->id = null;
            $item->student_id = $user_id;
            $item->answer_type = '1';
            $answer_info = $this->problemset_m->getProblemSet(json_decode($item->problem_info));
            $item->answer_info = json_encode($answer_info);
            $this->teacherwork_m->add($item);
        }
        $taskList = $this->db->query('select *
            from tbl_teacher_work
            where student_id = '.$user_id.' and class_id = '.$class_id.' and site_id = '.$site_id.' 
            order by end_time desc')->result();
        return $taskList;
    }

    public function saveRecordedAudio()
    {
        $ret = [
            'status' => 'fail',
            'data' => ''
        ];
        if (!$_POST) {
            $ret['data'] = 'Wrong request';
            echo json_encode($ret);
            return;
        }
        if (!isset($_POST['tId'])) {
            $ret['data'] = 'Task id invalid.';
            echo json_encode($ret);
            return;
        }
        if (!isset($_POST['pId'])) {
            $ret['data'] = 'Problem id invalid.';
            echo json_encode($ret);
            return;
        }
        $taskId = $_POST['tId'];
        $probId = $_POST['pId'];
        $probId = str_replace("\r", "", $probId);
        $probId = str_replace("\n", "", $probId);

        $upload_root = "uploads/problem_set/answer/";
        $config['upload_path'] = $upload_root;
        $config['allowed_types'] = '*';
        $this->load->library('upload', $config);

        $fields = 'answer_mp3';
        $audio = '';

        $type = explode('.', $_FILES[$fields]["name"]);
        $type = $type[count($type) - 1];
        if ($_FILES[$fields]["name"] != '') {
            //image uploading
            $config['upload_path'] = $upload_root;
            $config['file_name'] = $taskId . '_' . $probId . '_' . $fields . '.' . $type;
            $this->upload->initialize($config, TRUE);
            if (file_exists($upload_root . $config['file_name']))
                unlink($upload_root . $config['file_name']);
            if ($this->upload->do_upload($fields)) {
                $data = $this->upload->data();
                $audio = $upload_root . $config['file_name'];
            } else {///show error message
                $ret['data'] = $this->upload->display_errors();
                $ret['status'] = 'fail';
                echo json_encode($ret);
                return;
            }
        } else {
            $ret['data'] = 'Audio data invalid.';
            echo json_encode($ret);
            return;
        }

        $taskItem = $this->teacherwork_m->get_where(array('id' => $taskId))[0];
        if (count($taskItem) == 0) {
            $ret['data'] = 'Test data is not exist.';
            echo json_encode($ret);
            return;
        }
        $problems = json_decode($taskItem->answer_info);
        $j = -1;
        $param = array();
        foreach ($problems as $item) {
            $j++;
            if ($j == $probId) {
                $item->ans_audio = $audio;
            }
            array_push($param, $item);
        }
        $param = array('answer_info' => json_encode($param));

        $this->teacherwork_m->edit($param, $taskId);
        $ret['status'] = 'success';
        $ret['data'] = $audio;
        echo json_encode($ret);
    }

    public function updateWork()
    {
        $ret = [
            'status' => 'fail',
            'data' => ''
        ];
        if (!$_POST) {
            $ret['data'] = 'Wrong request';
            echo json_encode($ret);
            return;
        }
        $id = $_POST['id'];
        $taskItem = $this->teacherwork_m->get_where(array('id' => $id))[0];
        $probs = $_POST['answer_info'];
        $spent_time = $_POST['spent_time'];
        $param = array(
            'answer_info' => $probs,
            'student_mark' => $_POST['student_mark'],
            'answer_type' => $_POST['answer_type'],
            'worked_time' => date('Y-m-d H:i:s'),
            'spent_time' => $taskItem->spent_time + $spent_time,
        );
        $solvedCount = 0;
        foreach (json_decode($probs) as $item) {
            if (isset($item->answer_cnt))
                $solvedCount++;
        }
        if ($solvedCount == count(json_decode($probs)) && $taskItem->first_mark == '6')
            $param['first_mark'] = $_POST['student_mark'];

        $taskList = $this->teacherwork_m->edit($param, $id);
        $taskItem = $this->teacherwork_m->get_where(array('id' => $id))[0];
        $problems = json_decode($_POST['answer_info']);

        foreach ($problems as $item) {
            if (!isset($item->result) || $item->result == 1) continue;
            $res = $this->wrongset_m->get_where(array('student_id' => $taskItem->student_id, 'sort_num' => $item->sort_num));
            $item->student_id = $taskItem->student_id;
            $item->create_time = date('Y-m-d H:i:s');
            unset($item->id);
            unset($item->answer_cnt);
            unset($item->result);
            unset($item->student_first_answer);
            unset($item->student_first_result);
//            unset($item->student_answer);
            if (count($res) > 0)
                $this->wrongset_m->edit($item, $res[0]->id);
            else
                $this->wrongset_m->add($item);
        }

        $ret['data'] = $param;
        $ret['status'] = 'success';
        echo json_encode($ret);
    }

    public function output_task_content($lists)
    {
        $content_html = '';
        $status_str = ['开始作业', '补做作业', '订正作业'];
        $status_id = 0;
        foreach ($lists as $item) {
            if ($item->student_mark == 5) continue;
            if ($item->answer_type == 1) $status_id = 0;
            else {
                $problem_info = json_decode($item->answer_info);
                $cnt = 0;
                foreach ($problem_info as $info) {
                    if (isset($info->result))
                        $cnt++;
                }
                if ($cnt < count($problem_info)) $status_id = 1;
                else $status_id = 2;
            }
            $content_html .= '<div class="task-item">'
                . '<div class="task-info" item_col="1">' . $item->task_name . '</div>';
            if ($status_id != 2)
                $content_html .= '<div class="task-info" item_col="2">预计用时' . $item->period_time . '分钟</div>';
            else
                $content_html .= '<div class="task-info" item_col="2"></div>';

            $content_html .= '<div class="task-info" item_col="3">' . $item->end_time . '</div>'
                . '<div class="task-info" item_col="4" item_hover="1"'
                . ' item_id=\'' . $item->id . '\' '
                . ' item_student_mark=\'' . $item->first_mark . '\' '
                . ' item_content=\'' . $item->answer_info . '\'>';

            $content_html .= $status_str[$status_id] . '</div>'
                . '</div>';
        }
        return $content_html;
    }

    public function history($site_id = '')
    {
        if ($this->signin_m->loggedin() == FALSE) {
            redirect(base_url('student/signin'));
        } else {
            $this->data["subview"] = "student/workhistory";
            $this->data['parentView'] = 'classroom/pinyin/'.$site_id;
            $this->data['site_id'] = $site_id;
            $this->data['taskList'] = $this->output_history_content($this->getTaskList(
                $this->session->userdata('loginuserID'),
                $this->session->userdata('user_class'),
                $site_id
            ));
            $this->load->view('_layout_student', $this->data);
        }
    }

    public function output_history_content($lists)
    {
        $content_html = '';
        $status_str = ['未批改', '已批改'];
        $status_id = 0;
        foreach ($lists as $item) {
            if ($item->answer_type == 1) continue;
            if ($item->student_mark != 5) continue;
            $problem_info = json_decode($item->answer_info);
            $cnt = 0;
            foreach ($problem_info as $info) {
                if (isset($info->answer_cnt) && $info->answer_cnt > 1) {
                    $cnt++;
                    break;
                }
            }
            if ($item->read_status == '1') $status_id = 1;
            else $status_id = 0;
            $content_html .= '<div class="task-item">'
                . '<div class="task-info" item_col="1" item_hover="1"'
                . ' item_id=\'' . $item->id . '\' '
                . ' item_content=\'' . $item->answer_info . '\'>'
                . $item->task_name . '</div>'
                . '<div class="task-info" item_col="2">' . $item->end_time . '</div>'
                . '<div class="task-info" item_col="3">';
            for ($j = 0; $j < 5; $j++) {
                if ($j < intval($item->first_mark))
                    $content_html .= '<div class="star-item" item_type="1"></div>';
                else
                    $content_html .= '<div class="star-item" item_type="0"></div>';
            }
            $content_html .= '</div>'
                . '<div class="task-info" item_col="4" >';
            $content_html .= $status_str[$status_id] . '</div>'
                . '</div>';
        }
        return $content_html;
    }

    public function wrong($site_id = '')
    {
        if ($this->signin_m->loggedin() == FALSE) {
            redirect(base_url('student/signin'));
        } else {
            $this->data["subview"] = "student/workwrong";
            $this->data['parentView'] = 'classroom/pinyin/'.$site_id;

            $this->data['site_id'] = $site_id;
            $this->data['taskList'] = $this->output_wrong_content($this->wrongset_m->get_where(array('site_id' => $site_id)));
            $this->load->view('_layout_student', $this->data);
        }
    }

    public function updateWrongProblem()
    {
        $ret = [
            'status' => 'fail',
            'data' => ''
        ];
        if (!$_POST) {
            $ret['data'] = 'Wrong request';
            echo json_encode($ret);
            return;
        }
        $id = $_POST['id'];
        $ans_info=json_decode($_POST['answer_info'])[0];
//        var_dump($ans_info);
        $param = array(
            'student_answer'=>$ans_info->student_answer,
            'student_mark' => '5',
            'update_time' => date('Y-m-d H:i:s')
        );

//        $wrongList = $this->wrongset_m->delete($id);
        $wrongList = $this->wrongset_m->edit($param, $id);

        $ret['data'] = json_encode($wrongList);
        $ret['tbl_content'] = $this->output_wrong_content($wrongList);
        $ret['status'] = 'success';
        echo json_encode($ret);

    }

    public function output_wrong_content($lists)
    {
        $statusStr=["进入练习","进入练习"];
        $content_html = '';
        foreach ($lists as $item) {
            if ($item->student_id != $this->session->userdata('loginuserID')) continue;
            $st = 0;
            if($item->student_mark=='5') $st=1;
            $content_html .= '<div class="task-item">'
                . '<div class="task-info" item_col="2">' . $item->name . '</div>'
                . '<div class="task-info" item_col="1" item_hover="1" '
                . ' item_id=\'' . $item->id . '\' '
                . ' item_content=\'' . json_encode($item) . '\'>'
                . $item->prob_name . '</div>'
                . '<div class="task-info" item_col="3">';
            $content_html .= $item->create_time;
            $content_html .= '</div>'
                . '<div class="task-info" item_col="4">';
            if (is_null($item->update_time)) $item->update_time = '';
            $content_html .= $item->update_time . '</div>'
                . '<div class="task-info" item_col="5" item_hover="1" '
                . ' item_id=\'' . $item->id . '\' '
                . ' item_content=\'' . json_encode($item) . '\'>'
                . $statusStr[$st];
            $content_html .= '</div>'
                . '</div>';
        }
        return $content_html;
    }
}

?>