<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lessons_m extends MY_Model
{

    protected $_table_name = 'tbl_yekt_lessons';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = "tbl_yekt_lessons.sort_order asc";

    function __construct()
    {
        parent::__construct();
    }

    public function getItemsByPage($arr = array(), $pageId, $cntPerPage, $queryStr= '')
    {
        $this->db->select($this->_table_name . '.*');
        $this->db->select('tbl_sites.title as site, tbl_sites.id as site_id');
        $this->db->select('tbl_package.title as package, tbl_package.id as package_id');
        $this->db->select($this->_table_name.'.lesson_status as status');
        $this->db->select($this->_table_name.'.lesson_name as title');

        if ($queryStr != '') {
            $this->db->where(
                '( ' . $this->_table_name . '.title like \'%' . $queryStr . '%\' '
                . 'or tbl_sites.title like \'%' . $queryStr . '%\' '
                . 'or tbl_package.title like \'%' . $queryStr . '%\' ' . ' )'
            );
        }
        $this->db->where($arr)
            ->from($this->_table_name)
            ->join('tbl_package', $this->_table_name . '.package_id = tbl_package.id', 'left')
            ->join('tbl_sites', 'tbl_package.site_id = tbl_sites.id', 'left')
            ->where('tbl_package.status', 1)
            ->where('tbl_sites.status', 1)
            ->order_by($this->_order_by)
            ->limit($cntPerPage, $pageId);

        $query = $this->db->get();
        return $query->result();
    }

    public function get_count($arr = array(), $queryStr = '')
    {
        if ($queryStr != '') {
            $this->db->where(
                '( ' . $this->_table_name . '.title like \'%' . $queryStr . '%\' '
                . 'or tbl_sites.title like \'%' . $queryStr . '%\' '
                . 'or tbl_package.title like \'%' . $queryStr . '%\' ' . ' )'
            );
        }
        $this->db->where($arr)
            ->from($this->_table_name)
            ->join('tbl_package', $this->_table_name . '.package_id = tbl_package.id', 'left')
            ->join('tbl_sites', 'tbl_package.site_id = tbl_sites.id', 'left')
            ->where('tbl_package.status', 1)
            ->where('tbl_sites.status', 1)
            ->order_by($this->_order_by);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getItems()
    {
        $this->db->select('*, tbl_yekt_lessons.id as id')
            ->from('tbl_yekt_lessons')
//            ->join('tbl_yekt_schools', 'tbl_yekt_lessons.school_id = tbl_yekt_schools.id', 'inner')
            ->order_by($this->_order_by);
        $query = $this->db->get();
        return $query->result();
    }

    public function getList($site_id = 1, $user_id = 0)
    {
        $this->db->select($this->_table_name . '.*');
        $this->db->from($this->_table_name)
            ->join('tbl_package', $this->_table_name . '.package_id = tbl_package.id', 'left')
            ->where('tbl_package.site_id', $site_id)
            ->where($this->_table_name.'.owner_type', $user_id)
            ->order_by('tbl_yekt_lessons.lesson_number', 'asc')
            ->order_by($this->_order_by);
        $query = $this->db->get();
        return $query->result();
    }

    public function publish($item_id, $publish_st)//$stop_st==1 then enabled state, $stop_st == 0 then Disabled
    {
        $this->db->set('lesson_status', $publish_st);
        $this->db->where('id', $item_id);
        $this->db->update('tbl_yekt_lessons');
        return true;//$this->get_where(array('site_id' => $this->session->userData('_siteID')));
    }

    public function edit($param, $item_id)
    {
        $this->db->set($param);
        $this->db->where('id', $item_id);
        $this->db->update('tbl_yekt_lessons');
        return $this->getItems();
    }

    public function getLessonNameFromId($item_id)
    {
        $this->db->select('lesson_name')
            ->from('tbl_yekt_lessons')
            ->where('id', $item_id);
        $query = $this->db->get();

        if (count($query->result()) === 0 || $query === null) return '-1';

        $ret = $query->row();

        return $ret->lesson_name;
    }

    public function getLessonNumberFromId($item_id)
    {
        $this->db->select('lesson_number')
            ->from('tbl_yekt_lessons')
            ->where('id', $item_id);
        $query = $this->db->get();

        if (count($query->result()) === 0 || $query === null) return '-1';

        $ret = $query->row();

        return $ret->lesson_number;
    }
    public function getNewLessonNumber($school_id)
    {
        $this->db->select('max(lesson_number) as lesson_number, max(sort_order) as sort_order')
            ->from('tbl_yekt_lessons')
            ->where('school_id', $school_id);
        $query = $this->db->get();

        if (count($query->result()) === 0 || $query === null) return '101';

        $ret = $query->row();

        return $ret;
    }

    public function add($param)
    {
        $this->db->set($param);
        $this->db->insert('tbl_yekt_lessons');
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

    public function delete($item_id)
    {
        $this -> db -> where($this->_primary_key, $item_id);
        $this -> db -> delete($this->_table_name);
        return $this->getItems();
    }

    public function get_all_schools()
    {
        $this->db->select('*')->from('schools');
        $query = $this->db->get();
        return $query->result();
    }


}
