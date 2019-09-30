<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Banner_m extends MY_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getItems()
    {
        $this->db->select('*');
        $this->db->from('banner');
        $query = $this->db->get();
        return $query->result();
    }

    function edit($item_id, $item_name, $course_id, $item_image_path)
    {
        if ($item_image_path != '') {
            $this->db->set('image', $item_image_path);
        }
        $this->db->set('status', 0);
        $this->db->set('course_id', $course_id);
        $this->db->where('id', $item_id);
        $this->db->update('banner');
        return $this->getItems();
    }
}
