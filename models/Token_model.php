<?
class Token_model extends CI_Model {

	
/* =================================================================
* 지갑 정보
================================================================= */

	function GetList() {
		$this->db->select('*');
		$this->db->from('m_point_out');
		$this->db->where('kind','Pending');
		// 
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	function GetList2() {
		$this->db->select('*');
		$this->db->from('m_point_out_copy');
		$this->db->where('tx_id','false');

		
		// 
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	function Update( $point_no, $state) {
		$query = array(
			'state' => $state,
		);
		$this->db->where('point_no', $point_no);
		$this->db->update('m_point_out', $query);
	}


	function ErrSendcnt( $point_no, $tx_id) {
		
		$sql = '
			UPDATE
				m_point_out
			SET 
				state = `state`+ 1
			where 
				point_no ='.$point_no
		;
		$this->db->query($sql);
	
		//히스토
		
		$sql = '
			INSERT INTO
				m_token_err_hash 
			SET 
				point_no = "'.$point_no.'"
				,tx_id = "'.$tx_id.'"
			';
		$this->db->query($sql);
	
	


	}
}

?>