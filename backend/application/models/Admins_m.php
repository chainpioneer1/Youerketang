<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admins_m extends MY_Model
{

    protected $_table_name = 'admins';
    protected $_primary_key = 'admin_id';
    protected $_primary_filter = 'intval';
    protected $_order_by = "admin_id asc";

    function __construct()
    {
        parent::__construct();
    }

    public function update_usage_time()
    {
        $loginUserId = $this->session->userdata('admin_loginuserID');
        $userInfo = array('update_time' => date('Y-m-d H:i:s'));
        $this->edit($userInfo, $loginUserId);
    }

    function get_admin()
    {
        $query = $this->db->get('admins');
        return $query->result();
    }

    function add($arr)
    {

        $arr['admin_pass'] = $this->hash($arr['admin_pass']);
        $this->db->insert('admins', $arr);
        return $this->get_admin();
    }

    function get_single_admin($item_id)
    {
        $arr = array(
            'admin_id' => $item_id
        );
        return parent::get_single($arr);
    }

    public function delete($item_id)
    {
        $this->db->where('admin_id', $item_id);
        $this->db->delete('admins');
    }

    public function publish($item_id, $publish_st, $site_id = 1)
    {
        $this->db->set('admin_status', $publish_st);
        $this->db->where('admin_id', $item_id);
        $this->db->update('admins');
        return $this->get_admin();
    }

    function edit($arr, $item_id)
    {
        $this->db->where('admin_id', $item_id);
        $this->db->update('admins', $arr);
        return $this->get_admin();
    }

    public function hash($string)
    {
        return parent::hash($string);
    }
}

?>