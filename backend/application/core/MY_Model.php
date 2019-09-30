<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class MY_Model extends CI_Model {



	protected $_table_name = '';

	protected $_primary_key = '';

	protected $_primary_filter = 'intval';

	protected $_order_by = '';

	public $rules = array();

	function __construct() {

		parent::__construct();

		$this->load->database();

	}
	public function get($id, $single = FALSE){

		if ($id != NULL) {
			$filter = $this->_primary_filter;
			$id = $filter($id);
			$this->db->where($this->_primary_key, $id);
			$method = 'row';
		}
		elseif($single == TRUE) {
			$method = 'row';
		}
		else {
			$method = 'result';
		}
		//if (!count($this->db->order_by($this->_order_by))) {

			$this->db->order_by($this->_order_by);

		//}
		return $this->db->get($this->_table_name)->$method();
	}
	function get_where($array=NULL) {

		if($array != NULL) {
			$this->db->select()->from($this->_table_name)->where($array);
			$query = $this->db->get();
			return $query->result();

		} else {

			$this->db->select()->from($this->_table_name);

			$query = $this->db->get();

			return $query->result();

		}

	}
	function get_like($array=NULL) {

		if($array != NULL) {

			$this->db->select()->from($this->_table_name)->like($array);
			$query = $this->db->get();

			return $query->result();

		} else {

			$this->db->select()->from($this->_table_name);

			$query = $this->db->get();

			return $query->result();

		}

	}
	function get_order_by($array=NULL) {

		if($array != NULL) {

			$this->db->select()->from($this->_table_name)->where($array)->order_by($this->_order_by);
			$query = $this->db->get();

			return $query->result();

		} else {

			$this->db->select()->from($this->_table_name)->order_by($this->_order_by);

			$query = $this->db->get();

			return $query->result();

		}

	}
	function get_single($array=NULL) {

		if($array != NULL) {

			$this->db->select()->from($this->_table_name)->where($array);

			$query = $this->db->get();

			return $query->row();

		} else {

			$this->db->select()->from($this->_table_name)->order_by($this->_order_by);

			$query = $this->db->get();

			return $query->result();

		}

	}

	function insert($array) {

		$this->db->insert($this->_table_name, $array);

		$id = $this->db->insert_id();

		return $id;
	}

	function update($data, $id = NULL) {

		$filter = $this->_primary_filter;

		$id = $filter($id);

		$this->db->set($data);

		$this->db->where($this->_primary_key, $id);

		$this->db->update($this->_table_name);

	}
	public function delete($id){

		$filter = $this->_primary_filter;
		$id = $filter($id);
		if (!$id) {

			return FALSE;

		}
		$this->db->where($this->_primary_key, $id);
		$this->db->limit(1);
		$this->db->delete($this->_table_name);

	}
	public function delete_where($array=NULL){
		if (!$array) {
			return FALSE;
		}
		$this->db->where($array);
		$this->db->delete($this->_table_name);

	}
	public function delete_like($array=NULL){

		if (!$array) {

			return FALSE;

		}

		$this->db->like($array);

		$this->db->delete($this->_table_name);

	}

	public function delete_where_like($array_where, $array_like){
		if ( empty($array_where) || empty($array_like)) {
			return FALSE;
		}
		$this->db->where($array_where);

		$this->db->like($array_like);

		$this->db->delete($this->_table_name);
	}


	public function hash($string) {

		return hash("sha512", $string . config_item("encryption_key"));

	}

}



/* End of file MY_Model.php */

/* Location: .//D/xampp/htdocs/school/mvc/core/MY_Model.php */

