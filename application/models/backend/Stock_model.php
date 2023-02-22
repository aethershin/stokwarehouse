<?php
class Stock_model extends CI_Model{
/**
* Description of Controller
*
* @author https://aethershin.com
*/		
	
	var $tablestock = 'tbl_stock';
	var $tablelog = 'tbl_log';
	var $column_search_stock = array('kategori_material'); 
	var $order = array('id_stock' => 'desc'); // default order 
	

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		//add custom filter here
		if($this->input->post('kategori_material1'))
		{
			$this->db->like('kategori_material', $this->input->post('kategori_material1'));
		}

		
		

		
		$this->db->from($this->tablestock);
		$i = 0;
		foreach ($this->column_search_stock as $item) 
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

				if(count($this->column_search_stock) - 1 == $i) 
					$this->db->group_end(); 
			}
			$column_search_stock[$i] = $item; // set column array variable to order processing
			$i++;
		}
		if(isset($_POST['order'])) // here order processing
		{
			$this->db->order_by($column_search_stock[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
		
		
	}
	function get_datatables(){
		$this->db->join ( 'tbl_kategori', 'tbl_kategori.id_kategori = tbl_stock.kategori_stock' , 'left' );
		$this->db->join ( 'tbl_satuan', 'tbl_satuan.id_satuan = tbl_stock.satuan_stock' , 'left' );
		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_stock.user_id_stock' , 'left' );
		$this->db->order_by('id_stock', 'desc');
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}
	
	public function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}
	
	public function count_all()
	{
		$this->db->from($this->tablestock);
		return $this->db->count_all_results();
	}
	function count_all_stock(){
        $query = $this->db->query("SELECT SUM(nilai_saham) AS stock FROM tbl_stock");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
    }
	function get_all_kategori(){
		$this->db->select('tbl_kategori.*');
		$this->db->from('tbl_kategori');
		
		$this->db->order_by('id_kategori', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_all_satuan(){
		$this->db->select('tbl_satuan.*');
		$this->db->from('tbl_satuan');
		$this->db->order_by('id_satuan', 'DESC');
		$query = $this->db->get();
		return $query;
	}
	function get_new_kode_stock(){
        
        $query = $this->db->query("SELECT max(kode_stock) as maxKode FROM tbl_stock");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $result[] = $data;
            }
            return $result;
        }
                            
    }
   
    public function get_by_id($id_stock)
	{
		$this->db->from($this->tablestock);
		$this->db->join ( 'tbl_user', 'tbl_user.user_id = tbl_stock.user_id_stock' , 'left' );
		$this->db->where('id_stock',$id_stock);
		$query = $this->db->get();
		return $query->row();
	}
	function insert_stock($data){
		$insert = $this->db->insert($this->tablestock, $data);
		if($insert){
			return true;
		}
	}
	function insert_log_stock($data2){
		$insert = $this->db->insert($this->tablelog, $data2);
		if($insert){
			return true;
		}
	}
	public function update_entry($id, $data)
    {
        return $this->db->update('tbl_stock', $data, array('id_stock' => $id));
    }
	public function single_entry($id_stock)
    {
        $this->db->select('*');
        $this->db->from('tbl_stock');
        $this->db->where('id_stock', $id_stock);
        $query = $this->db->get();
        if (count($query->result()) > 0) {
            return $query->row();
        }
    }
    
    public function delete_entry($id_stock)
    {
        return $this->db->delete('tbl_stock', array('id_stock' => $id_stock));
    }
  
	public function delete_multiple($id_stock){        
		$this->db->where_in('id_stock', explode(",", $id_stock));
		$this->db->delete('tbl_stock');
		return true;  
	}

	

}

	
