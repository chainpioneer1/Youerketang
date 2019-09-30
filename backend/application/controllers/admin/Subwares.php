<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Subwares extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();

		$language = 'chinese';
        $this->load->model("subwares_m");
        $this->load->model("coursewares_m");
        $this->load->model("users_m");
		$this->lang->load('courses',$language);
		$this->load->library("pagination");

	}
	public function index()
	{
        $this->data['subwares'] = $this->subwares_m->get_sw();
        $this->data['subware_type_names'] = $this->subwares_m->getSWTypeNames();
        $this->data['cwsets'] = $this->coursewares_m->get_cw();
        $this->data["subview"] = "admin/courses/subwares";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        if(!$this->checkRole()){

            $this->load->view('admin/_layout_error', $this->data);

        }else{
            $this->load->view('admin/_layout_main', $this->data);
        }
	}
    public function publish()
    {
        $ret = array(
            'data'=>'',
            'status'=>'fail'
        );
        if($_POST)
        {
            $publish_sw_id = $_POST['publish_sw_id'];
            $publish_sw_st = $_POST['publish_state'];
            $this->data['swsets'] = $this->subwares_m->publish($publish_sw_id,$publish_sw_st);
            //$ret['data'] = $this->output_content($this->data['swsets']);
            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }
    public function output_content($swsets)
    {
        $output= '';
        foreach( $swsets as $sw):
            $pub = '';
            if($sw->publish=='1')  $pub = $this->lang->line('UnPublish');
            else   $pub = $this->lang->line('Publish');
            $output .= '<tr>';
            $output .= '<td align="center">'.$sw->courseware_num.'</td>';
            $output .= '<td align="center">'.$sw->subware_type_name.'</td>';
            $output .= '<td align="center">'.$sw->course_name.'</td>';
            $output .= '<td align="center">'.$sw->unit_type_name.'</td>';
            $output .= '<td align="center">'.$sw->courseware_name.'</td>';
            $output .= '<td align="center">'.$sw->school_type_name.'</td>';
            $output .= '<td align="center">';
            $output .=  '<button class="btn btn-sm btn-success" onclick = "edit_sw(this);" sw_id = '.$sw->subware_id.'>'.$this->lang->line('Modify').'</button>';
            $output .=  '<button class="btn btn-sm btn-warning" onclick = "delete_sw(this);" sw_id = '.$sw->subware_id.'>'.$this->lang->line('Delete').'</button>';
            $output .=  '<button style="width:70px;" class="btn btn-sm btn-danger" onclick = "publish_sw(this);" sw_id = '.$sw->subware_id.'>'.$pub.'</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }
    ////directory manager and file manager
    public function rrmdir($dir) {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file)
                if ($file != "." && $file != "..") $this->rrmdir("$dir/$file");
            rmdir($dir);
        }
        else if (file_exists($dir)) unlink($dir);
    }

    // Function to Copy folders and files
    public function rcopy($src, $dst) {
        if (file_exists ( $dst ))
            $this->rrmdir ( $dst );
        if (is_dir ( $src )) {
            mkdir ( $dst );
            $files = scandir ( $src );
            foreach ( $files as $file )
                if ($file != "." && $file != ".."){
                    $this->rcopy ( "$src/$file", "$dst/$file" );

                }

        } else if (file_exists ( $src )){
            copy ( $src, $dst );
        }
    }
    public function  add()
    {
        $ret = array(
            'data'=>'I am ajax function.',
            'status'=>'success'
        );
        if($_POST)
        {
            ///update courseware table
            $add_cw_name = $this->input->post('add_sw_cw_name');
            $add_sw_type_name = $this->input->post('add_sw_type_name');
            $add_sw_unit_type_name = $this->input->post('add_sw_unit_type_name');
            $add_sw_course_name = $this->input->post('add_sw_course_name');
            $add_sw_school_type_name = $this->input->post('add_sw_school_type_name');

            $add_sw_cw_id = $this->subwares_m->getCWIdFromName($add_cw_name);

            $fileSlug = $this->subwares_m->getSWTypeSlugFromName($add_sw_type_name);
            ///getSWTypeSlugFromName
            $add_sw_file_path = '';
            if(isset($_FILES["file_name"]["name"])){
                $uploadPath = 'courseware/'.$add_sw_cw_id.'/'.$fileSlug;
                $dirPath = 'uploads/'.$uploadPath;
                if(!is_dir($dirPath))
                {
                    mkdir($dirPath,0755, true);
                }
                $config['upload_path']='./uploads/'.$uploadPath.'/';
                $config['allowed_types']='zip';
                $this->load->library('upload',$config);

                //***************************file uploading**************************//
                if($this->upload->do_upload('file_name'))
                {
                    ///$data["file_name"];
                    $data = array('sw_data' => $this->upload->data());
                    $zip = new ZipArchive;
                    $file = $data['sw_data']['full_path'];
                    chmod($file,0777);
                    if ($zip->open($file) === TRUE) {
                        $zip->extractTo($config['upload_path']);
                        $zip->close();
                        unlink($file);
                    } else {
                        echo 'failed';
                    }
                    $add_sw_file_path = $dirPath;
                }else{///show error message

                    $error = array('error' => $this->upload->display_errors());
                }
                //***************************file uploading**************************//
            }
            $param = array(
                'cw_name'=>$add_cw_name,
                'sw_type_name'=>$add_sw_type_name,
                'sw_unit_type_name'=>$add_sw_unit_type_name,
                'sw_course_name'=>$add_sw_course_name,
                'sw_school_type_name'=>$add_sw_school_type_name,
                'sw_file_path'=>$add_sw_file_path
            );
            $this->data['swsets'] = $this->subwares_m->add($param);
            $ret['data']  = $this->output_content($this->data['swsets']);;
            $ret['status'] = 'success';

        }
        echo json_encode($ret);

        //var_dump($this->data['swsets']);

    }
    public function edit()
    {
        $ret = array(
            'data'=>'I am ajax function.',
            'status'=>'success'
        );
        if($_POST)
        {
            $sw_id = $this->input->post('sw_id');
            $cw_name = $this->input->post('sw_cw_name');
            $sw_type_name = $this->input->post('sw_type_name');
            $sw_unit_type_name = $this->input->post('sw_unit_type_name');
            $sw_course_name = $this->input->post('sw_course_name');
            $sw_school_type_name = $this->input->post('sw_school_type_name');

            $sw_cw_id = $this->subwares_m->getCWIdFromName($cw_name);
            $fileSlug = $this->subwares_m->getSWTypeSlugFromName($sw_type_name);

            $oldSubware = $this->subwares_m->get_single(array('subware_id'=>$sw_id));
            $oldSWPath = $oldSubware->subware_file;

            $param = array(
                'sw_id'=>$sw_id,
                'cw_name'=>$cw_name,
                'sw_type_name'=>$sw_type_name,
                'sw_unit_type_name'=>$sw_unit_type_name,
                'sw_course_name'=>$sw_course_name,
                'sw_school_type_name'=>$sw_school_type_name,
                /*'sw_file_path'=>''*/
            );

            $sw_file_path = '';
            //file uploading
            $uploadPath = 'courseware/'.$sw_cw_id.'/'.$fileSlug;

            //echo $uploadPath;

            $newdirPath = 'uploads/'.$uploadPath;

            $config['upload_path']='./uploads/'.$uploadPath.'/';
            $config['allowed_types']='zip';
            $this->load->library('upload',$config);

            $uploadFile = $_FILES["file_name"]["name"];
            if($uploadFile==''){

                if($oldSWPath!=$newdirPath){
                    $this->rrmdir($newdirPath);
                    mkdir($newdirPath,0755, true);
                    $this->rcopy($oldSWPath,$newdirPath);
                    $this->rrmdir($oldSWPath);
                    $param['sw_file_path'] = $newdirPath;
                }
                $this->data['swsets'] = $this->subwares_m->edit($param);;
                $ret['data']  = $this->output_content($this->data['swsets']);;
                $ret['status'] = 'success';
                echo json_encode($ret);

            } else{
                $this->rrmdir($oldSWPath);
                mkdir($newdirPath,0755, true);

                if($this->upload->do_upload('file_name'))///this process is success then we have to move current subware to new position
                {

                    ///---1----. At first New zip file upload and Extract

                    $data = array('sw_data' => $this->upload->data());
                    $zip = new ZipArchive;
                    $file = $data['sw_data']['full_path'];
                    chmod($file,0777);
                    if ($zip->open($file) === TRUE) {
                        $zip->extractTo($config['upload_path']);
                        $zip->close();
                        unlink($file);
                    } else {
                        echo 'failed';
                    }
                    ///---2---- Next, Delete Old Subware Directory

                    $param['sw_file_path'] = $newdirPath;
                    $this->data['swsets'] = $this->subwares_m->edit($param);
                    $ret['data']  = $this->output_content($this->data['swsets']);;
                    $ret['status'] = 'success';
                    echo json_encode($ret);


                }else{///show error message

                    $ret['data'] = $this->upload->display_errors();
                    $ret['status']='fail';
                    echo json_encode($ret);
                }
            }
        }

    }
    public function delete()
    {
        $ret = array(
            'data'=>'',
            'status'=>'fail'
        );
        if($_POST)
        {
            $delete_sw_id = $_POST['delete_sw_id'];

            $oldSubware = $this->subwares_m->get_single(array('subware_id'=>$delete_sw_id));
            $oldSWPath = $oldSubware->subware_file;
            $this->rrmdir($oldSWPath);

            $this->data['swsets'] = $this->subwares_m->delete($delete_sw_id);

            $ret['data'] = $this->output_content($this->data['swsets']);

            $ret['status'] = 'success';
        }
        echo json_encode($ret);
    }
    function checkRole(){

        $permission = $this->session->userdata('admin_user_type');
        if($permission!=NULL)
        {
            $permissionData = json_decode($permission);
            $accessInfo = $permissionData[0]->unit_sub_st;
            if($accessInfo=='1') return true;
            else return false;
        }
        return false;
    }

}
