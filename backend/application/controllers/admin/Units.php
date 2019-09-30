<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Units extends Admin_Controller
{

	function __construct()
	{
		parent::__construct();
		$language = 'chinese';
		$this->load->model("courses_m");
		$this->load->model("units_m");
        $this->load->model("users_m");
        $this->load->model("coursewares_m");
		$this->lang->load('courses',$language);
		$this->load->library("pagination");
	}
	public function index()
	{
        $this->data['units'] = $this->units_m->get_units();
        $this->data["subview"] = "admin/courses/units";
        $this->data["subscript"] = "admin/settings/script";
        $this->data["subcss"] = "admin/settings/css";
        if(!$this->checkRole()){

            $this->load->view('admin/_layout_error', $this->data);

        }else{
            $this->load->view('admin/_layout_main', $this->data);
        }
	}
	public function edit()
	{
		$ret_st = array(
			'data'=>'',
			'status'=>'fail'
		);
        $config['upload_path']="./uploads/images/";
        $config['allowed_types']='bmp|gif|jpg|png';
        //$config['max_size'] = '500*8';
        //$config['max_width']  = '300';
        //$config['max_height']  = '700';
        $this->load->library('upload',$config);

		if($_POST)
		{
            $unit_image_path = '';
            ///image upload function
            if(isset($_FILES["file_name"]["name"])){
                if($this->upload->do_upload('file_name'))
                {
                    $data = $this->upload->data();
                    $unit_image_path = 'uploads/images/'.$data["file_name"];
                }
            }
			$unit_id = $_POST['unit_id'];
			$unit_type_name= $_POST['unit_type_name'];

			$ret_st['status'] = 'success';
			$this->data['units'] = $this->units_m->edit($unit_id,$unit_type_name,$unit_image_path);
			$ret_st['data'] = $this->output_content($this->data['units']);
			echo json_encode($ret_st);
		}
	}
	function output_content($units)
    {
        $output = '';
        $modifyStr = $this->lang->line('Modify');
        foreach($units as $unit):
            $output .= '<tr>';
            $output .= '<td>'.$unit->unit_id.'</td>';
            $output .= '<td>'.$unit->unit_type_name.'</td>';
            $output .= '<td>'.$unit->course_name.'</td>';
            $output .= '<td>'.$unit->school_type_name.'</td>';
            $output .= '<td><img src="'.base_url().$unit->unit_photo.'" alt="" style="width:200px; height:100px;"></td>';
            $output .= '<td>';
            $output .= '<button style="width:70px;" class="btn btn-sm btn-success"  onclick= "edit_unit(this);"  unit_id ='.$unit->unit_id.'>'.$modifyStr.'</button>';
            $output .= '</td>';
            $output .= '</tr>';
        endforeach;
        return $output;
    }
    function checkRole(){

        $permission = $this->session->userdata('admin_user_type');
        if($permission!=NULL)
        {
            $permissionData = json_decode($permission);
            $accessInfo = $permissionData[0]->cs_unit_st;
            if($accessInfo=='1') return true;
            else return false;
        }
        return false;
    }

}
