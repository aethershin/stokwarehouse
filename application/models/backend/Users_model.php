<?php
class Users_model extends CI_Model{
/**
* Description of Controller
*
* @author https://aethershin.com
*/	
	
	var $tableuser = 'tbl_user';
	var $column_search_user = array('user_id','user_email','user_name','user_password','user_level','user_status','user_photo'); 
	var $orderuser = array('user_id' => 'desc'); // default order 

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		
		$this->db->from($this->tableuser);
		$i = 0;
		foreach ($this->column_search_user as $item) 
		{
			if($_POST['search']['value']) 
			{
				if($i===0) 
				{	
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				}
				else
				{
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if(count($this->column_search_user) - 1 == $i) 
					$this->db->group_end(); 
			}
			$i++;
		}
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->orderuser;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		
	}
	function get_datatables(){
		$email_super = 'admbiopure.id@gmail.com';
		$dev = 'Zikry';
		$this->db->where_not_in ( 'user_email', $email_super);
		$this->db->where_not_in ( 'user_name', $dev);
		$this->db->order_by('user_id', 'desc');
		
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function count_filtered()
	{
		$this->_get_datatables_query();
		$email_super = 'admbiopure.id@gmail.com';
		$dev = 'Zikry';
		$this->db->where_not_in ( 'user_email', $email_super);
		$this->db->where_not_in ( 'user_name', $dev);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->tableuser);
		$email_super = 'admbiopure.id@gmail.com';
		$dev = 'Zikry';
		$this->db->where_not_in ( 'user_email', $email_super);
		$this->db->where_not_in ( 'user_name', $dev);
		return $this->db->count_all_results();
	}

	

    public function get_by_id($user_id)
	{
		$this->db->from($this->tableuser);
		$this->db->where('user_id',$user_id);
		$query = $this->db->get();
		return $query->row();
	}
	function insert_users($data){
		$insert = $this->db->insert($this->tableuser, $data);
		if($insert){
			return true;
		}
	}
	
	public function update_entry($userid, $data)
    {
        return $this->db->update('tbl_user', $data, array('user_id' => $userid));
    }
	public function single_entry($user_id)
    {
        $this->db->select('*');
        $this->db->from('tbl_user');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
    public function delete_entry($user_id)
    {
        return $this->db->delete('tbl_user', array('user_id' => $user_id));
    }
	
    function validasi_email($email){
		$hsl=$this->db->query("SELECT * FROM tbl_user WHERE user_email='$email'");
		return $hsl;
	}
	public function update_lock($user_id, $data)
    {
        return $this->db->update('tbl_user', $data, array('user_id' => $user_id));
    }

	

	
	
}