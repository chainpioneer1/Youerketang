<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
header('Access-Control-Allow-Origin: *');

class Api extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $language = 'chinese';
        $this->lang->load('courses', $language);
        $this->load->model('activationcodes_m');
        $this->load->model('categories_m');
        $this->load->model('lessons_m');
        $this->load->model('courses_m');
        $this->load->model('courses_exp_m');
        $this->load->model('schools_m');
        $this->load->model('educourses_m');
        $this->load->model('educourses_main_m');
        $this->load->library("pagination");
        $this->load->library("session");
    }

    public function request_register()
    {
        $ret = array(
            'status' => 'fail',
            'data' => '注册失败.'
        );

        $codes = $this->activationcodes_m->getUnusedCodeItems();

        $retCodes = array();
        foreach ($codes as $item) {
            array_push($retCodes, $item->code);
        }
        $ret['data'] = $retCodes;
        $ret['status'] = 'success';
        echo json_encode($ret);
        return;

        $user_info = json_decode($_POST['user_info']);
        $param = array(
            'site_id' => $user_info->site_id,
            'user_name' => $user_info->school_name,
            'user_area_id' => $user_info->area_id,
            'user_address' => $user_info->address_detail
        );
        $registered_info = $this->activationcodes_m->getItemFromArray($param);
        $param['user_info'] = json_encode(
            array(
                'school1' => $user_info->school1,
                'school2' => $user_info->school2,
                'school3' => $user_info->school3
            )
        );
        $param['update_time'] = date('Y-m-d H:i:s');
        $param['activate_status'] = 1;
        if (count($registered_info) == 0) {
            $param['activate_time'] = date('Y-m-d H:i:s');
            $param['register_time'] = date('Y-m-d H:i:s');
            $param['register_count'] = 1;
            $param['user_status'] = 1;
            $registered_info = $this->activationcodes_m->getNewRegisterItem($param);
//            if ($registered_info->user_status == '0') {
//                $ret['data'] = '您的请求被申请了到服务器. 请联系网站管理员以使用此应用程序.';
//                echo json_encode($ret);
//                return;
//            }
        } else {
            $param['register_time'] = date('Y-m-d H:i:s');
            $registered_info = $this->activationcodes_m->getOldRegisterItem($param, $registered_info->id);
            if ($registered_info->user_status == '0') {
                $ret['data'] = '您的帐户已禁用了被网站管理员.';
                echo json_encode($ret);
                return;
            }
        }
        $ret['status'] = 'success';
        $ret['data'] = $registered_info->code;
        $ret['user_id'] = $registered_info->id;
        $ret['register_count'] = $registered_info->register_count;
        if ($registered_info->usage_info == null) $registered_info->usage_info = "{}";
        $ret['usage_info'] = json_decode($registered_info->usage_info);
        $ret['lesson_list'] = $this->courses_m->getList();
        $ret['expand_list'] = $this->courses_exp_m->getList();
        $ret['categories'] = array(
            $this->categories_m->getList(),
            $this->lessons_m->getList(),
            array(array(), array(), array()),
            array(array(), array(), array()),
            array(array(), array(), array()),
        );
        echo json_encode($ret);
    }

    public function send_history_info()
    {
        $ret = array(
            'status' => 'fail',
            'data' => '数据发送失败.'
        );

        if (!isset($_POST['register_info']) ||
            !isset($_POST['lesson_history_info']) ||
            !isset($_POST['expand_history_info'])) {
            $ret['data'] = '信息无效.';
            echo json_encode($ret);
            return;
        }

        $user_info = json_decode($_POST['register_info']);
        $lesson_history_info = json_decode($_POST['lesson_history_info']);
        $expand_history_info = json_decode($_POST['expand_history_info']);

        $param = array(
            'code' => $user_info->activation_code
        );

        $registered_info = $this->activationcodes_m->getItemFromArray($param);

        if (count($registered_info) == 0) {
            $ret['data'] = '激活码不存在.';
            echo json_encode($ret);
            return;
        }

//        if ($registered_info->user_status == '0') {
//            $ret['data'] = '您的帐户已禁用了被网站管理员.';
//            echo json_encode($ret);
//            return;
//        }

        $param = array(
            'site_id' => $user_info->site_id,
            'user_name' => $user_info->school_name,
            'user_area_id' => $user_info->area_id,
            'user_address' => $user_info->address_detail,
            'user_info' => json_encode(array(
                    'school1' => $user_info->school1,
                    'school2' => $user_info->school2,
                    'school3' => $user_info->school3
                )
            ),
            'activate_status' => '1',
            'register_count' => $user_info->register_count,
            'update_time' => date('Y-m-d H:i:s')
        );

        if ($registered_info->activate_status == '0') {

            $param['activate_time'] = date('Y-m-d H:i:s');
            $param['register_time'] = date('Y-m-d H:i:s');
            $param['register_count'] = 1;
            $param['user_status'] = 1;

        } else {
            $param['register_time'] = date('Y-m-d H:i:s');
            if ($registered_info->user_status == '0') {
                $ret['data'] = '您的帐户已禁用了被网站管理员.';
                echo json_encode($ret);
                return;
            }
        }

        if ($lesson_history_info != null && $expand_history_info != null) {
            $param['usage_info'] = json_encode(array(
                'lesson_history' => $lesson_history_info,
                'expand_history' => $expand_history_info
            ));
        } else if ($lesson_history_info != null) {
            $param['usage_info'] = json_encode(array(
                'lesson_history' => $lesson_history_info
            ));
        } else if ($expand_history_info != null) {
            $param['usage_info'] = json_encode(array(
                'expand_history' => $expand_history_info
            ));
        }

        $registered_info = $this->activationcodes_m->getOldRegisterItem($param, $user_info->activation_code);
        $ret['status'] = 'success';
        $ret['data'] = $registered_info->code;
        if($user_info->site_id =='1') {
            $ret['lesson_list'] = $this->courses_m->getList();
            $ret['expand_list'] = $this->courses_exp_m->getList();
            $ret['categories'] = array(
                $this->categories_m->getList(),
                $this->lessons_m->getList(),
                array(array(), array(), array()),
                array(array(), array(), array()),
                array(array(), array(), array()),
            );
        }else{
            $ret['lesson_list'] = $this->educourses_m->getList();
            $ret['expand_list'] = $ret['lesson_list'];
            $ret['categories'] = array(
                $this->schools_m->getList(2),
                array(array(), array(), array()),
                array(array(), array(), array()),
                array(array(), array(), array()),
                array(array(), array(), array()),
            );
        }
        echo json_encode($ret);
    }

    public function user_login()
    {
        $ret = array(
            'status' => 'error',
            'data' => ''
        );
        if (!empty($_POST)) {
            if (empty($_POST['nickName'])) {
                $ret['data'] = 'nickname empty!';///nickName empty
                echo json_encode($ret);
                return;
            }
            if (empty($_POST['userName'])) {
                $ret['data'] = 'username empty!';///username empty
                echo json_encode($ret);
                return;
            }
            if (empty($_POST['password'])) {
                $ret['data'] = 'password empty!';///password empty
                echo json_encode($ret);
                return;
            }
            if (empty($_POST['schoolName'])) {
                $ret['data'] = 'school information empty!';///full name empty
                echo json_encode($ret);
                return;
            } else {

                $schoolId = $this->schools_m->getSchoolIdFromName($_POST['schoolName']);
                if ($schoolId !== '-1') {
                    $schoolInfo = $this->schools_m->get($schoolId, TRUE);
                    if ($schoolInfo->stop !== '1') {
                        $ret['data'] = 'School has been blocked by admin!';
                        return;
                    }

                } else {
                    $ret['data'] = "You can't find school information";///full name empty
                    echo json_encode($ret);
                    return;
                }

            }

            $userType = (isset($_POST['userType'])) ? $_POST['userType'] : '2';

            ////1.check user has account in kebenju site
            $user_token = $this->checkUserInfo($_POST, $userType);
            if ($user_token === 'PASSWORD_INVALID') {
                $ret['data'] = "Password Incorrect, Please input correct password!";///full name empty
                echo json_encode($ret);
                return;
            }
            $ret['status'] = 'success';
            $ret['data'] = $user_token;
            echo json_encode($ret);
            return;

        }
        echo json_encode($ret);

    }

    function checkUserInfo($post_data, $userType)
    {

        $userName = $post_data['userName'];
        $password = $post_data['password'];
        $user_pass = $this->signin_m->hash($password);
        $user_token = $this->generateRandomString(16);
        $schoolId = $this->schools_m->getSchoolIdFromName($post_data['schoolName']);

        $userInfo = $this->db->get_where('users', array("username" => $userName));
        if (count($userInfo->result()) != 0) {
            if ($user_pass !== $userInfo->row()->password) return 'PASSWORD_INVALID';
            $this->users_m->update_user(array('user_token' => $user_token), $userInfo->row()->user_id);
        } else {
            $sex_name = $this->lang->line('Male');
            $dt = new DateTime();
            $currentTime = $dt->format('Y-m-d H:i:s');
            $userData = array(
                'fullname' => $post_data['nickName'],
                'nickname' => $post_data['nickName'],
                'username' => $userName,
                'password' => $this->users_m->hash($password),
                'school_id' => $schoolId,
                'sex' => $sex_name,
                'user_type_id' => $userType,
                'class' => '',
                'reg_time' => $currentTime,
                'buycourse_arr' => '{"kebenju":0,"sandapian":1}',
                'publish' => '1',
                'user_token' => $user_token
            );
            $this->users_m->insert($userData);
        }
        return $user_token;
    }

    public function generateRandomString($length = 10)
    {
        $characters = '23456789abcdefghijkmnopqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function uploadImgData()
    {
        $request = $_POST;
        if (!isset($request['imageData'])) {
            $this->response(array('status' => false, 'data' => 'Image Data is none.'), 400);
            return;
        }
        $imgdata = $request['imageData'];
        $imgdata = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imgdata));

        //$imgdata = base64_decode($data);

        $imageName = 'class' . rand(10000, 99999) . '.png';
        if (file_put_contents('uploads/codes/' . $imageName, $imgdata))
            echo json_encode(array('status' => true, 'data' => base_url() . 'uploads/codes/' . $imageName));
        else
            echo json_encode(array('status' => false, 'data' => 'Image uploading failed.'));
    }

    public function sandapian_content_upload()
    {
        ///get from POST Request
        $ret = array(
            'status' => 'fail',
            'data' => ''
        );
        if (isset($_POST)) {
            $required = array('userName', 'contentLink', 'contentTitle', 'belongTitle', 'contentType');
            $error = false;
            foreach ($required as $field) {
                if (empty($_POST[$field])) {
                    $error = true;
                }
            }
            if ($error) {
                $ret['status'] = 'fail';
                $ret['data'] = 'All fields are required.';
                echo json_encode($ret);
                return;
            }
            $userName = $_POST['userName'];
            ///check user existing with $userName
            $userInfo = $this->db->get_where('users', array("username" => $userName));
            $user_data = $userInfo->row();
            if (!empty($user_data)) {
                if ($user_data->publish != '1') {
                    $ret['status'] = 'fail';
                    $ret['data'] = 'Your account has been blocked by adminstrator!';
                    echo json_encode($ret);
                    return;
                } else {

                    $dt = new DateTime("now", new DateTimeZone('Asia/Hong_Kong'));
                    $data = array(
                        'ncontent_title' => $_POST['contentTitle'],
                        'ncontent_type_id' => $_POST['contentType'],
                        'ncontent_user_id' => $user_data->user_id,
                        'ncontent_ncwid' => '0',
                        'ncontent_belong_title' => $_POST['belongTitle'],///new added part on 2017.11.30
                        'ncontent_local' => '1',
                        'ncontent_cloud' => '1',
                        'ncontent_file' => $_POST['contentLink'],
                        'ncontent_createtime' => $dt->format('Y:m:d'),
                    );
                    $this->ncontents_m->insert_ncontents($data);
                    $ret['status'] = 'success';
                    $ret['data'] = '';
                    echo json_encode($ret);
                    return;
                }

            } else {
                $ret['status'] = 'fail';
                $ret['data'] = 'Your account has been not registered on this site!';
                echo json_encode($ret);
                return;
            }

        }
        echo json_encode($ret);

    }

    public function get_course_audio()
    {
        $ret = array(
            'StudentRecords' => ''
        );
        if (!empty($_POST)) {
            $schoolName = (isset($_POST['SchoolName'])) ? $_POST['SchoolName'] : '';
            $studentAccounts = (isset($_POST['StudentAccount'])) ? $_POST['StudentAccount'] : '';
            if ($schoolName == '') {
                echo json_encode($ret);
                return;
            }
            if ($studentAccounts == '') {
                echo json_encode($ret);
                return;
            }
            $schoolId = $this->schools_m->getSchoolIdFromName($schoolName);
            $accountList = json_decode($studentAccounts);
            $retRecordList = array();
            foreach ($accountList as $st):
                $userList = $this->users_m->get_where(array('username' => $st));
                if (count($userList) === 0) continue;
                if ($userList[0]->school_id != $schoolId) continue;
                $stRecords = $this->ncontents_m->searchStudentRecords($userList[0]->user_id);
                if (count($stRecords) != 0) {
                    foreach ($stRecords as $sr):
                        $tmpArr = array();
                        $tmpArr['Account'] = $st;
                        $tmpArr['Url'] = base_url($sr->ncontent_file);
                        $tmpArr['Time'] = $sr->ncontent_createtime;
                        $tmpArr['CourseName'] = $sr->ncw_name;
                        $tmpArr['CourseType'] = $sr->childcourse_name;

                        array_push($retRecordList, $tmpArr);
                    endforeach;
                }
            endforeach;
            $ret['StudentRecords'] = $retRecordList;
            echo json_encode($ret);
            return;
        }
        echo json_encode($ret);
    }

    function get_course_link_info()
    {

        $ret = array(
            'CoverLink' => '',
            'CourseTypeLink' => array(),
            'CourseIdLink' => array()
        );
        $ret['CoverLink'] = "https://kebenju.hulalaedu.com/assets/images/taiyang/home/sandapian.png";
        ///Get Course Type Link from nchildcourses_m
        $csTypes = $this->nchildcourses_m->get_nchild_courses();
        foreach ($csTypes as $cst):
            array_push($ret['CourseTypeLink'], base_url() . $cst->childcourse_photo);
        endforeach;
        ///Get courseware image link
        $csIds = $this->ncoursewares_m->get_ncw();
        foreach ($csIds as $csId):
            array_push($ret['CourseIdLink'], base_url() . $csId->ncw_photo);
        endforeach;

        echo json_encode($ret);
    }


    public function http($url, $method = '', $postfields = null, $headers = array(), $user_id, $debug = false)
    {
        $ci = curl_init();

        $fileUrl = $url;

        $destFile = 'uploads/qr/fqb' . $user_id;
        exec('rm ' . $destFile . '.*');
        $saveTo = $destFile . '.png';   //The path & filename to save to.

        $fp = fopen($saveTo, 'w+'); //Open file handler.

        if ($fp === false) {    //If $fp is FALSE, something went wrong.
            return ('Could not open: ' . $saveTo);
        }

        /* Curl settings */
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ci, CURLOPT_TIMEOUT, 30);
//        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ci, CURLOPT_FILE, $fp);    //Pass our file handle to cURL.

        switch ($method) {
            case 'POST':
                curl_setopt($ci, CURLOPT_POST, true);
                if (!empty($postfields)) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                    $this->postdata = $postfields;
                }
                break;
        }
        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);

        $response = curl_exec($ci);
        $http_code = curl_getinfo($ci, CURLINFO_HTTP_CODE);

        if ($debug) {
            echo "=====post data======\r\n";
//            var_dump($postfields);

            echo '=====info=====' . "\r\n";
            print_r(curl_getinfo($ci));

            echo '=====$response=====' . "\r\n";
            print_r($response);
        }
        curl_close($ci);
        return $saveTo;
    }

	public function getTransactionDetail(){
		$txid = $_GET['txid'];
		$url = 'https://chain.so/api/v2/get_tx_inputs/BTC/'.$txid;
//		echo json_encode($this->http_general($url));		
		$this->http_general($url);
	}
	
    public function http_general($url, $method = '', $postfields = null, $headers = array(), $debug = false)
    {
        $ci = curl_init();

        /* Curl settings */
        curl_setopt($ci, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ci, CURLOPT_TIMEOUT, 30);
//        curl_setopt($ci, CURLOPT_RETURNTRANSFER, true);

        switch ($method) {
            case 'POST':
                curl_setopt($ci, CURLOPT_POST, true);
                if (!empty($postfields)) {
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postfields);
                    $this->postdata = $postfields;
                }
                break;
        }
        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ci, CURLINFO_HEADER_OUT, true);

        $response = curl_exec($ci);

		$response = substr($response, -5);

        if ($debug) {
            echo "=====post data======\r\n";
//            var_dump($postfields);

            echo '=====info=====' . "\r\n";
            print_r(curl_getinfo($ci));

            echo '=====$response=====' . "\r\n";
            print_r($response);
        }
        curl_close($ci);
        return $response;
    }



}

?>