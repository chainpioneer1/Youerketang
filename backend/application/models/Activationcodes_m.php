<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Activationcodes_m extends MY_Model
{

    protected $_table_name = 'tbl_activation';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_order_by = "tbl_activation.activate_time desc";

    function __construct()
    {
        parent::__construct();
    }

    public function getItemsByPage($arr = array(), $pageId, $cntPerPage)
    {
        $this->db->select($this->_table_name . '.*, 
              tbl_sites.title as site, tbl_user.user_account as user_account');
        $this->db->like($arr)
            ->from($this->_table_name)
            ->join('tbl_sites', $this->_table_name . '.site_id = tbl_sites.id', 'left')
            ->join('tbl_user', $this->_table_name . '.user_id = tbl_user.id', 'left')
            ->order_by($this->_table_name . '.status', 'desc')
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
            ->join('tbl_user', $this->_table_name . '.user_id = tbl_user.id', 'left')
            ->order_by($this->_table_name . '.status', 'desc')
            ->order_by($this->_order_by);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getItems()
    {
        $this->db->select($this->_table_name . '.*');
        $this->db->select("tbl_user.user_account");
        $this->db->select('tbl_sites.title');
        $this->db->from($this->_table_name)
            ->join('tbl_user', $this->_table_name . '.user_id = tbl_user.id', 'left')
            ->join('tbl_sites', $this->_table_name . '.site_id = tbl_sites.id', 'left')
            ->order_by('tbl_activation.status', 'desc')
            ->order_by($this->_order_by);
        $query = $this->db->get();
        return $query->result();
    }

    public function add($arr)
    {
        $this->db->insert($this->_table_name, $arr);
        return $this->db->insert_id();
    }

    public function get_single($arr = array())
    {
        $array = array();
        foreach ($arr as $key => $value) {
            $array[$this->_table_name . '.' . $key] = $value;
        }
        $this->db->select($this->_table_name . '.*');
        $this->db->select("tbl_user.user_account");
        $this->db->select('tbl_sites.title as site_name');
        $this->db->from($this->_table_name)
            ->join('tbl_user', $this->_table_name . '.user_id = tbl_user.id', 'left')
            ->join('tbl_sites', $this->_table_name . '.site_id = tbl_sites.id', 'left');
        $this->db->where($array);
        $query = $this->db->get();
        return $query->row();
    }

    public function get_where($arr = array())
    {
        $array = array();
        foreach ($arr as $key => $value) {
            $array[$this->_table_name . '.' . $key] = $value;
        }
        $this->db->select($this->_table_name . '.*');
        $this->db->select("tbl_user.user_account");
        $this->db->select('tbl_sites.title as site_name');
        $this->db->from($this->_table_name)
            ->join('tbl_user', $this->_table_name . '.user_id = tbl_user.id', 'left')
            ->join('tbl_sites', $this->_table_name . '.site_id = tbl_sites.id', 'left');
        $this->db->where($array);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_where_in($key, $arr = array())
    {
        $ids = $arr;
        if (count($ids) == 0) return array();
        if (!$this->adminsignin_m->loggedin())
            $this->db->where($this->_table_name . '.status', 1);
        $this->db->select($this->_table_name . '.*');
        $this->db->select("tbl_user.user_account");
        $this->db->select('tbl_sites.title as site_name');
        $this->db->from($this->_table_name)
            ->join('tbl_user', $this->_table_name . '.user_id = tbl_user.id', 'left')
            ->join('tbl_sites', $this->_table_name . '.site_id = tbl_sites.id', 'left')
            ->order_by('tbl_activation.status', 'desc')
            ->order_by($this->_order_by);
        $this->db->where_in($this->_table_name . '.' . $key, $ids);
        $query = $this->db->get();
        $contents = $query->result();
        return $contents;
    }

    public function delete($item_id)
    {
        $this->db->where($this->_primary_key, $item_id);
        $this->db->delete($this->_table_name);
        return $this->getItems();
    }

    public function publish($item_id, $publish_st, $site_id = 1)
    {
        $this->db->set('status', $publish_st);
        $this->db->where($this->_primary_key, $item_id);
        $this->db->update($this->_table_name);
        return $this->getItems();
    }

    public function edit($arr, $item_id)
    {
        $this->db->where($this->_primary_key, $item_id);
        $this->db->update($this->_table_name, $arr);
        return $item_id;
    }

    public function addItems($param)
    {
        foreach ($param as $item) {
            $this->insert($item);
        }
        return $this->getCodeItems();
    }

    function getCodeItems()
    {
        return $this->getItems();
    }

    function getUnusedCodeItems()
    {
        $this->db->select('code');
        $this->db->from($this->_table_name);
        $this->db->where('used_status', '0');
        $query = $this->db->get();
        return $query->result();
    }

    function getItemFromArray($param)
    {
        return $this->get_single($param);
    }

    function getNewRegisterItem($param)
    {
        $this->db->select('*');
        $this->db->from($this->_table_name);
        $this->db->where('activate_status', '0');
        $query = $this->db->get();
        $item = $query->row();
        $this->db->set($param);
        $this->db->where('id', $item->id);
        $this->db->update($this->_table_name);

        return $item;
    }

    function getOldRegisterItem($param, $item_code)
    {
        $this->db->set($param);
        $this->db->where('code', $item_code);
        $this->db->update($this->_table_name);

        $this->db->select('*');
        $this->db->from($this->_table_name);
        $this->db->where('code', $item_code);
        $query = $this->db->get();
        return $query->row();
    }

    public function deleteItem($item_id)
    {
        $this->db->where('id', $item_id);
        $this->db->delete($this->_table_name);
        return $this->getItems();
    }

    public function hash($string)
    {
        return parent::hash($string);
    }
}
