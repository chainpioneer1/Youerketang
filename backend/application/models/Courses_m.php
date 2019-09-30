<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Courses_m extends MY_Model
{

    protected $_table_name = 'tbl_yekt_courses';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = "tbl_yekt_courses.course_id asc";

    function __construct()
    {
        parent::__construct();
        parent::__construct();
    }

    public function getItemsByPage($arr = array(), $pageId, $cntPerPage, $queryStr)
    {
        $this->db->select($this->_table_name . '.*');
        $this->db->select('tbl_sites.title as site, tbl_sites.id as site_id');
        $this->db->select('tbl_package.title as package, tbl_package.id as package_id');

        if ($queryStr != '') {
            $this->db->where(
                '( ' . $this->_table_name . '.title like \'%' . $queryStr . '%\' '
                . 'or tbl_sites.title like \'%' . $queryStr . '%\' '
                . 'or tbl_package.title like \'%' . $queryStr . '%\' ' . ' )'
            );
        }
        $this->db->like($arr)
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

    public function get_count($arr = array())
    {
        $this->db->like($arr)
            ->from($this->_table_name)
            ->join('tbl_package', $this->_table_name . '.package_id = tbl_package.id', 'left')
            ->join('tbl_sites', 'tbl_package.site_id = tbl_sites.id', 'left')
            ->where('tbl_package.status', 1)
            ->where('tbl_sites.status', 1)
            ->order_by($this->_order_by);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getCourses()
    {
        $this->db->where('status',1);
        $this->db->from($this->_table_name);
        $query = $this->db->get();
        return $query->result();
    }

    public function getItems()
    {
        $this->db->select('*, tbl_yekt_courses.id as id, 
            tbl_yekt_courses.information as information, 
            tbl_yekt_lessons.information as lessonInfo, ' .
            'tbl_yekt_courses.sort_order as sort_order')
            ->from('tbl_yekt_courses')
            ->join('tbl_sites', 'tbl_yekt_courses.site_id = tbl_sites.id', 'inner')
            ->join('tbl_yekt_lessons', 'tbl_yekt_lessons.id = tbl_yekt_courses.lesson_id', 'inner')
            ->order_by('tbl_yekt_courses.course_id', 'asc')
            ->order_by('tbl_yekt_courses.site_id', 'asc')
            ->order_by('tbl_yekt_lessons.sort_order', 'asc')
            ->order_by('tbl_yekt_courses.sort_order', 'asc');
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
        $this->db->select('tbl_package.site_id as site_id');
        $this->db->from('tbl_yekt_courses')
            ->join('tbl_package', $this->_table_name.'.package_id = tbl_package.id', 'inner')
            ->join('tbl_sites', 'tbl_package.site_id = tbl_sites.id', 'inner')
            ->where('tbl_package.site_id', $site_id)
            ->order_by('tbl_yekt_courses.course_id', 'asc')
            ->order_by('tbl_yekt_courses.sort_order', 'asc')
            ->order_by('tbl_yekt_courses.package_id', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function setUsageInfos($usage_infos)
    {
        $all_courses = $this->getItems();
        foreach ($all_courses as $item) {
            if (isset($usage_infos['a' . $item->id])) {
                $this->db->set($usage_infos['a' . $item->id]);
                $this->db->where('id', $item->id);
                $this->db->update('tbl_yekt_courses');
            }
        }
    }

    public function getList($site_id = 1)
    {
        $this->db->select(
            'tbl_yekt_courses.id as id, ' .
            'tbl_yekt_courses.school_id as school, ' .
            'tbl_yekt_categories.category_number as category, ' .
            'tbl_yekt_lessons.lesson_number as lesson, ' .
            'tbl_yekt_courses.game_number as package_name, ' .
            'tbl_yekt_courses.image_path as icon_path, ' .
            'tbl_yekt_courses.course_path as package_path, ' .
            'tbl_yekt_courses.game_status as game_status, ' .
            'tbl_yekt_courses.course_status as status'
        )
            ->from('tbl_yekt_courses')
            ->join('tbl_yekt_schools', 'tbl_yekt_schools.id = tbl_yekt_courses.school_id', 'inner')
            ->join('tbl_yekt_categories', 'tbl_yekt_categories.id = tbl_yekt_courses.category_id', 'inner')
            ->join('tbl_yekt_lessons', 'tbl_yekt_lessons.id = tbl_yekt_courses.lesson_id', 'inner')
            ->where('tbl_yekt_courses.site_id', $site_id)
            ->where('tbl_yekt_courses.course_status', '1')
            ->order_by('tbl_yekt_courses.site_id', 'asc')
            ->order_by('tbl_yekt_courses.school_id', 'asc')
            ->order_by('tbl_yekt_lessons.sort_order', 'asc')
            ->order_by('tbl_yekt_courses.sort_order', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function getGameItems($site_id = 1)
    {
        $this->db->select('*, tbl_yekt_courses.id as id, tbl_yekt_courses.image_corner as image_corner ')
            ->from('tbl_yekt_courses')
            ->join('tbl_yekt_schools', 'tbl_yekt_schools.id = tbl_yekt_courses.school_id', 'inner')
            ->join('tbl_yekt_categories', 'tbl_yekt_categories.id = tbl_yekt_courses.category_id', 'inner')
            ->join('tbl_yekt_lessons', 'tbl_yekt_lessons.id = tbl_yekt_courses.lesson_id', 'inner')
            ->where('tbl_yekt_courses.site_id', $site_id)
            ->order_by('tbl_yekt_courses.site_id', 'asc')
            ->order_by('tbl_yekt_courses.school_id', 'asc')
            ->order_by('tbl_yekt_courses.game_order', 'asc');
        $query = $this->db->get();
        return $query->result();
    }

    public function publish($item_id, $publish_st, $site_id = 1)
    {
        $this->db->set('status', $publish_st);
        $this->db->where('id', $item_id);
        $this->db->update($this->_table_name);
        return $this->getDetailItems($site_id);
    }

    public function publish_game($item_id, $publish_st, $site_id = 1)
    {
        $this->db->set('game_status', $publish_st);
        $this->db->where('id', $item_id);
        $this->db->update($this->_table_name);
        return $this->getGameItems($site_id);
    }

    public function edit($param, $item_id, $site_id = 1)
    {
        $this->db->set($param);
        $this->db->where('id', $item_id);
        $this->db->update($this->_table_name);
        return $this->getDetailItems($site_id);
    }

    public function edit_game($param, $item_id, $site_id = 1)
    {
        $this->db->set($param);
        $this->db->where('id', $item_id);
        $this->db->update($this->_table_name);
        return $this->getGameItems($site_id);
    }

    public function getLessonNumberFromId($item_id)
    {
        $this->db->select('sort_order')
            ->from($this->_table_name)
            ->where('id', $item_id);
        $query = $this->db->get();

        if (count($query->result()) === 0 || $query === null) return '-1';

        $ret = $query->row();

        return $ret->sort_order;
    }

    public function getGameNumberFromId($item_id)
    {
        $this->db->select('game_number')
            ->from($this->_table_name)
            ->where('id', $item_id);
        $query = $this->db->get();

        if (count($query->result()) === 0 || $query === null) return '-1';

        $ret = $query->row();

        return $ret->game_number;
    }

    public function getNewLessonNumber($lesson_id)
    {
        $this->db->select('max(game_number) as game_number,max(sort_order) as sort_order')
            ->from($this->_table_name)
            ->where('lesson_id', $lesson_id);
        $query = $this->db->get();

        if (count($query->result()) === 0 || $query === null) return '';

        $ret = $query->row();

        return $ret;
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
        return $this->getDetailItems($site_id);
    }


    function get_all_courses()
    {
        return parent::get(NULL);
    }

}
