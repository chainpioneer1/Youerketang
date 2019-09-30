<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Reference_m extends MY_Model
{

    protected $_table_name = 'tbl_yekt_reference';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = "tbl_yekt_reference.course_id asc";

    function __construct()
    {
        parent::__construct();
        parent::__construct();
    }

    public function getItemsByPage($arr = array(), $pageId, $cntPerPage, $queryStr)
    {
        $this->db->select($this->_table_name . '.*');
        $this->db->select('tbl_sites.title as site, tbl_sites.id as site_id');

        if ($queryStr != '') {
            $this->db->where(
                '( ' . $this->_table_name . '.title like \'%' . $queryStr . '%\' '
                . 'or tbl_sites.title like \'%' . $queryStr . '%\' '
                . 'or tbl_package.title like \'%' . $queryStr . '%\' ' . ' )'
            );
        }
        $this->db->like($arr)
            ->from($this->_table_name)
            ->join('tbl_sites', $this->_table_name.'.site_id = tbl_sites.id', 'left')
            ->where('tbl_sites.status', 1)
            ->order_by($this->_order_by)
            ->limit($cntPerPage, $pageId);

        $query = $this->db->get();
        return $query->result();
    }

    public function get_count($arr = array())
    {
        $this->db->like($arr)
            ->from($this->_table_name)
            ->join('tbl_sites', $this->_table_name . '.site_id = tbl_sites.id', 'left')
            ->where('tbl_sites.status', 1)
            ->order_by($this->_order_by);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getCourses()
    {
        $query = $this->db->get($this->_table_name);
        return $query->result();
    }

    public function getItems()
    {
        $this->db->select($this->_table_name.'*, tbl_sites.title as site_name')
            ->from($this->_table_name)
            ->join('tbl_sites', $this->_table_name.'.site_id = tbl_sites.id', 'left')
            ->order_by($this->_order_by);
        $query = $this->db->get();
        return $query->result();
    }

    public function getCourseFromLesson($courses)
    {
        $this->db->select('*')
            ->from('tbl_yekt_courses');
        if (count($courses) == 0) {
            return array();
        } else {
            foreach ($courses as $item) {
                $this->db->or_where('id', $item);
            }
        }
        $query = $this->db->get();
        return $query->result();
    }

    public function getOwnerCourses($owner_type = 0)
    {
        $this->db->select('*')
            ->from('tbl_yekt_courses')
            ->where('owner_type', $owner_type);
        $query = $this->db->get();
        return $query->result();
    }

    public function clearUnusedCourses()
    {
        $allMyCourses = $this->getCourses();
        $allMyLessons = $this->lessons_m->getItems();
        $userID = $this->session->userdata('loginuserID');
        foreach ($allMyCourses as $item) {
            if ($item->owner_type != $userID) continue;
            $isExist = false;
            foreach ($allMyLessons as $item_less) {
                if ($item_less->owner_type != $userID) continue;
                $lesson_info = json_decode($item_less->lesson_info);
                foreach ($lesson_info as $unit) {
                    if ($item->id == $unit) {
                        $isExist = true;
                        break;
                    }
                }
                if ($isExist) break;
            }
            if (!$isExist) $this->delete_course($item->id, 1);
        }
    }

    public function getDetailItems($site_id = 1)
    {
        $this->db->select($this->_table_name . '.*');
        $this->db->select('tbl_sites.title as site_name');
        $this->db->from($this->_table_name)
            ->join('tbl_package', $this->_table_name.'.site_id = tbl_sites.id', 'inner')
            ->where('tbl_package.site_id', $site_id)
            ->order_by($this->_order_by);
        $query = $this->db->get();
        return $query->result();
    }

    public function publish($item_id, $publish_st, $site_id = 1)
    {
        $this->db->set('status', $publish_st);
        $this->db->where('id', $item_id);
        $this->db->update($this->_table_name);
        return $item_id;
    }


    public function edit($param, $item_id, $site_id = 1)
    {
        $this->db->set($param);
        $this->db->where('id', $item_id);
        $this->db->update($this->_table_name);
        return $item_id;
    }

    public function add($param)
    {
        $this->db->set($param);
        $this->db->insert($this->_table_name);
        return $this->db->insert_id();

    }

    public function get($id, $single = FALSE)
    {
        return parent::get($id, $single); // TODO: Change the autogenerated stub
    }

    public function get_where($array = NULL)
    {
        return parent::get_where($array); // TODO: Change the autogenerated stub
    }

    public function delete_course($item_id, $site_id)
    {
        $this->db->where('id', $item_id);
        $this->db->delete($this->_table_name);
        return $item_id;
    }

    function get_all_courses()
    {
        return parent::get(NULL);
    }

}
