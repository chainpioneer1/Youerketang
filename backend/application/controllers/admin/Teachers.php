<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Teachers extends Admin_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->load->model("activationcodes_m");
        $this->load->model("users_m");
        $this->load->model("sclass_m");
        $this->load->model("sites_m");
        $this->lang->load('courses', $language);
        $this->load->library("pagination");
        $this->load->library("session");

        $this->mainModel = $this->users_m;

    }

    public function index()
    {
        $this->prepareUserInfo();
        $this->data['items'] = $this->users_m->get_users();
//        $this->data['user_areas'] = $this->users_m->getAreas();
//        $this->data['user_class'] = $this->users_m->getSchools();
        $this->data["subview"] = "admin/users/index";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data["tbl_content"] = $this->output_content($this->data['items']);
        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    function prepareUserInfo()
    {
        $users = $this->users_m->getUnusedItems();
    }

    function output_content($items)
    {
        $output_html = '';
        $j = 0;
//        for ($i = 0; $i < 10; $i++)
        foreach ($items as $unit):
            $j++;
            $gender = '';
            if ($unit->gender == '1') $gender = $this->lang->line('male');
            else if ($unit->gender == '2') $gender = $this->lang->line('female');
            $user_type = '';
            if ($unit->user_type == '1') $user_type = $this->lang->line('teacher');
            else if ($unit->user_type == '2') $user_type = $this->lang->line('student');

            $userInfo = json_decode($unit->user_info);
            $output_html .= '<tr item_id="' . $unit->id . '">';
            $output_html .= '<td>' . $unit->user_account . '</td>';
            $output_html .= '<td>' . $unit->code . '</td>';
            $output_html .= '<td>' . $unit->user_name . '</td>';
            $output_html .= '<td>' . $gender . '</td>';
            $output_html .= '<td>' . $unit->user_class . '</td>';
            $output_html .= '<td>' . $unit->user_address . '</td>';
            $output_html .= '<td>' . $unit->user_school . '</td>';
            $output_html .= '<td>' . $user_type . '</td>';
            if ($unit->user_type == '1')
                $output_html .= '<td>' . $unit->user_phone . '</td>';
            else if ($unit->user_type == '2')
                $output_html .= '<td>' . $unit->user_account . '</td>';
            $output_html .= '<td>' . $unit->create_time . '</td>';
            $output_html .= '<td>';
            $output_html .= '<button style="width:70px;" '
                . ' class="btn btn-sm btn-success" '
                . ' onclick = "update_item(this);" '
                . ' item_info = \'' . json_encode($unit) . '\' '
                . ' item_id = "' . $unit->id . '">'
                . $this->lang->line('update') . '</button>';
            $output_html .= '<button style="width:70px;"'
                . ' class="btn btn-sm btn-danger"'
                . ' onclick = "delete_item(this);"'
                . ' item_id = "' . $unit->id . '">'
                . $this->lang->line('delete') . '</button>';
            $output_html .= '</td>';
            $output_html .= '</tr>';
        endforeach;
        return $output_html;
    }

    public function register_status()
    {
        $this->data['items'] = $this->users_m->get_users();
        $this->data['main_sites'] = $this->sites_m->getItems();
        $this->data["subview"] = "admin/users/register_status";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data["tbl_content"] = $this->register_status_content($this->data['items']);
        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    function register_status_content($items)
    {
        $output_html = '';
        $j = 0;
//        for ($i = 0; $i < 10; $i++)
        foreach ($items as $unit):
            $j++;
//            $userInfo = json_decode($unit->user_info);
            $user_type = '';
            if ($unit->user_type == 1) $user_type = $this->lang->line('teacher');
            else if ($unit->user_type == 2) $user_type = $this->lang->line('student');
            $output_html .= '<tr>';
            $output_html .= '<td>' . $j . '</td>';
            $output_html .= '<td>' . $unit->user_account . '</td>';
            $output_html .= '<td>' . $unit->site_name . '</td>';
            $output_html .= '<td>' . $user_type . '</td>';
            $output_html .= '<td>' . $unit->activate_time . '</td>';
            $output_html .= '<td>' . $unit->register_time . '</td>';
            $output_html .= '<td>' . $unit->register_count . '</td>';
            $output_html .= '</tr>';
        endforeach;
        return $output_html;
    }

    public function course_status()
    {
        $this->calculate_course_usage();
        $this->data['items'] = $this->courses_m->getItems();
        $this->data['main_sites'] = $this->sites_m->getItems();
        $this->data["subview"] = "admin/users/course_status";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        $this->data["tbl_content"] = $this->course_status_content($this->data['items']);
        if (!$this->checkRole()) {
            $this->load->view('admin/_layout_error', $this->data);
        } else {
            $this->load->view('admin/_layout_main', $this->data);
        }
    }

    function calculate_course_usage()
    {
        $all_users = $this->activationcodes_m->getItems();
        $total_cnts = array();
        foreach ($all_users as $user_info) {
            if ($user_info->site_id != '1') continue;
            if ($user_info->usage_info == null) continue;
            $usage_infos = json_decode($user_info->usage_info);
            if (isset($usage_infos->lesson_history)) {
                $lesson_history = $usage_infos->lesson_history;
                foreach ($lesson_history as $val) {
                    $key = $val[6];
                    if (!isset($total_cnts['a' . $key])) {
                        $total_cnts['a' . $key] = array(
                            'course_count' => 0,
                            'course_time' => "2018-01-01",
                            'video_count' => 0,
                            'video_time' => "2018-01-01",
                            'game_count' => 0,
                            'game_time' => "2018-01-01"
                        );
//                        continue;
                    }
                    $total_cnts['a' . $key]['course_count'] += intval($val[0]);
                    if (strtotime($val[1]) > strtotime($total_cnts['a' . $key]['course_time']))
                        $total_cnts['a' . $key]['course_time'] = $val[1];
                    $total_cnts['a' . $key]['video_count'] += intval($val[2]);
                    if (strtotime($val[3]) > strtotime($total_cnts['a' . $key]['video_time']))
                        $total_cnts['a' . $key]['video_time'] = $val[3];
                    $total_cnts['a' . $key]['game_count'] += intval($val[4]);
                    if (strtotime($val[5]) > strtotime($total_cnts['a' . $key]['game_time']))
                        $total_cnts['a' . $key]['game_time'] = $val[5];
                }
            }
            if (isset($usage_infos->expand_history)) {
                $expand_history = $usage_infos->expand_history;
            }
        }
        $this->courses_m->setUsageInfos($total_cnts);

        $total_cnts = array();
        foreach ($all_users as $user_info) {
            if ($user_info->site_id != '2') continue;
            if ($user_info->usage_info == null) continue;
            $usage_infos = json_decode($user_info->usage_info);
            if (isset($usage_infos->lesson_history)) {
                $lesson_history = $usage_infos->lesson_history;
                foreach ($lesson_history as $val) {
                    $key = $val[6];
                    if (!isset($total_cnts['a' . $key])) {
                        $total_cnts['a' . $key] = array(
                            'course_count' => 0,
                            'course_time' => "2018-01-01",
                            'video_count' => 0,
                            'video_time' => "2018-01-01",
                            'game_count' => 0,
                            'game_time' => "2018-01-01"
                        );
//                        continue;
                    }
                    $total_cnts['a' . $key]['course_count'] += intval($val[0]);
                    if (strtotime($val[1]) > strtotime($total_cnts['a' . $key]['course_time']))
                        $total_cnts['a' . $key]['course_time'] = $val[1];
                }
            }
            if (isset($usage_infos->expand_history)) {
                $expand_history = $usage_infos->expand_history;
            }
        }
        $this->educourses_m->setUsageInfos($total_cnts);
    }

    function course_status_content($items)
    {
        $output_html = '';
        $j = 0;
        $clicked_content = [
            $this->lang->line('learning'),
            $this->lang->line('video'),
            $this->lang->line('game'),
            $this->lang->line('teach_design')
        ];
        foreach ($items as $unit):
            for ($i = 0; $i < 3; $i++) {
                $j++;
                $cont = $clicked_content[$i];
                $last = $unit->course_time;
                $cnt = $unit->course_count;
                switch ($i) {
                    case 1:
                        $last = $unit->video_time;
                        $cnt = $unit->video_count;
                        break;
                    case 2:
                        if ($unit->site_id > 1)
                            $cont = $clicked_content[3];
                        $last = $unit->game_time;
                        $cnt = $unit->game_count;
                        break;
                }
                if (is_null($last) || $cnt == 0) {
                    $last = '';
                }

                $output_html .= '<tr>';
                $output_html .= '<td>' . $j . '</td>';
                $output_html .= '<td>' . $unit->course_name . '</td>';
                $output_html .= '<td>' . $cont . '</td>';
                $output_html .= '<td>' . $unit->site_name . '</td>';
                $output_html .= '<td>' . $last . '</td>';
                $output_html .= '<td>' . $cnt . '</td>';
                $output_html .= '</tr>';
            }
        endforeach;
        return $output_html;
    }

    public function update_user()
    {

        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $user_id = $_POST['user_id'];
            $arr = $_POST;
            unset($arr['user_id']);
            unset($arr['cpassword']);
            if ($arr['password'] == '') {
                unset($arr['password']);
            } else {
                $arr['password'] = $this->users_m->hash($arr['password']);
            }
            $result = $this->users_m->edit($arr, $user_id);

            $ret['data'] = $this->output_content($result);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    public function delete_user()
    {
        $ret = array(
            'data' => '',
            'status' => 'fail'
        );
        if ($_POST) {
            $arr = [];
            $user_id = $_POST['user_id'];
            $result = $this->users_m->deleteItem($user_id);

            $ret['data'] = $this->output_content($result);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }

    function generateRandomString($length = 10)
    {
        $characters = '23456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    function checkRole()
    {
        $permission = $this->session->userdata('admin_user_type');
        if ($permission != NULL) {
            $permissionData = json_decode($permission);
            $accessInfo = $permissionData->menu_20;
            if ($accessInfo == '1') return true;
            else return false;
        }
        return false;
    }

}
