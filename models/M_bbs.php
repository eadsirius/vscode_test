<?
class M_bbs extends CI_Model {

	
	function bbs_write($bbs_table,$filename) {
		
		$query = array(			
			'category' 	=> $this->input->post('category'),
			'subject' 	=> $this->input->post('subject'),
			'contents' 	=> $this->input->post('contents'),
			'file' 		=> $filename,
			'regdate' 	=> $this->input->post('regdate'),
		);

		$this->db->insert($bbs_table, $query);
	}
	
	function bbs_card($bbs_table,$filename,$member_id,$password) 
	{		
		$count 		= $this->input->post('card');		
		$bank_name 	= $this->input->post('bank_name');
		$post 		= $this->input->post('post');
		$address 	= $this->input->post('address');
		$address1 	= $this->input->post('address1');
		$addr = $address .$address1;

		$query = array(
			'member_id' => $member_id,
			'name' 		=> $bank_name,
			'password' 	=> $password,
			//'email' 	=> $post,						
			'category' 	=> 'apply',
			'subject' 	=> $post,
			'contents' 	=> $addr,
			'file' 		=> $filename,
			'memo' 		=> $count,
		);
		$this->db->set('regdate', 'now()', FALSE);
		$this->db->insert($bbs_table, $query);
	}
	
	
	
	
	
	
	function bbs_in($bbs_table,$filename,$password,$regdate=NULL)
	{
		$member_id 	= $this->input->post('member_id');
		$name 		= $this->input->post('name');
		$email 		= $this->input->post('email');
		
		if ($regdate == NULL) {
			$regdate = nowdate();
		}
		if ($name == NULL) {
			$name = '';
		}
		if ($email == NULL) {
			$email = '';
		}
		
		$query = array(
			'member_id' => $member_id,
			'password' 	=> $password,
			'name' 		=> $name,
			'email' 	=> $email,			
			'category' 	=> $this->input->post('category'),
			'subject' 	=> $this->input->post('subject'),
			'contents' 	=> $this->input->post('contents'),
			'file' 		=> $filename,
			'regdate' 	=> $regdate,
		);

		$this->db->insert($bbs_table, $query);
	}
		
	function bbs_update($bbs_table,$bbs_no,$filename,$regdate=NULL)
	{
		if ($regdate == NULL) {
			$regdate = nowdate();
		}
		
		$query = array(			
			'category' => $this->input->post('category'),
			'subject' => $this->input->post('subject'),
			'contents' => $this->input->post('contents'),
			'file' 		=> $filename,
			'regdate' 	=> $regdate,
		);
      
		$this->db->where('bbs_no', $bbs_no);
		$this->db->update($bbs_table, $query);
		
	}
	
	function qna_update($bbs_table,$bbs_no)
	{
		$count = 1;
		$query = array(
			'memo' => $this->input->post('answer'),
			'secret' => $this->input->post('secret'),
			'comment_count' => $count,
		);
      
		$this->db->where('bbs_no', $bbs_no);
		$this->db->update($bbs_table, $query);
		
	}
	
	function member_update($bbs_table,$bbs_no)
	{
		$query = array(
			'contents' => $this->input->post('contents'),
			'subject' => $this->input->post('subject'),
		);
      
		$this->db->where('bbs_no', $bbs_no);
		$this->db->update($bbs_table, $query);
		
	}
		
	
/* =================================================================
* view 관리
================================================================= */

	function get_bbs_li($table) {
		$this->db->select('*');
		$this->db->from($table);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
	
	function get_bbs_laster($table) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->limit(5);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}
/* =================================================================
* 게시판 관리
================================================================= */

	function get_bbs_views_no($table,$idx) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('bbs_no',$idx);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	function get_bbs_views_my($table,$idx,$member_id) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('bbs_no',$idx);
		$this->db->where('member_id',$member_id);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	function get_bbs($table,$idx) {
		$this->db->select('*');
		$this->db->from($table);
		$this->db->where('bbs_no',$idx);
		$query = $this->db->get();
		$item = $query->row();
		return $item;
	}
	
	function get_bbs_no($table) {
		$this->db->select('bbs_no');
		$this->db->from($table);
		$this->db->order_by("bbs_no", "desc");	
		$query = $this->db->get();
		$item = $query->row();
		return $item->bbs_no;
	}
	

/* =================================================================
* 검색 관리
================================================================= */

	//총 게시물수 가져오기
	function get_total($table_id,$where,$clm,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		//게시물 TOTAL 수
		$this->db->from($table_id);
		if ($where != NULL) {
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where($where2,$clm2);
		}
		if ($where3 != NULL) {
			$this->db->where($where3,$clm3);
		}
		
		if ($where4 != NULL) {
			$this->db->where($where4,$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}
		$item =  $this->db->count_all_results();
		return $item;
	}


	//게시물 리스트 가져오기
	function get_lists($table,$limit,$page,$order_by,$where,$clm,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->join('m_member', 'member_id = member_id','left');
		$this->db->limit($limit,$page);
		if ($where != NULL) {
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where($where2,$clm2);
		}
		if ($where3 != NULL) {
			$this->db->where($where3,$clm3);
		}
		
		if ($where4 != NULL) {
			$this->db->where($where4,$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}
		
		$this->db->order_by($order_by,'desc');
		$query = $this->db->get();
		$item = $query->result();
		return $item;


	}


	//검색 리스트 가져오기
	function get_sc_lists($table,$limit,$page,$order_by,$st,$sc,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		$sc = urldecode($sc);
		$this->db->select('*');
		$this->db->from($table);
		//$this->db->join('m_member', $table.'.member_id = m_member.member_id','inner');
		$this->db->like($st,$sc);

		if ($where != NULL) {
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where($where2,$clm2);
		}
		if ($where3 != NULL) {
			$this->db->where($where3,$clm3);
		}
		
		if ($where4 != NULL) {
			$this->db->where($where4,$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}
		
		
		$this->db->order_by($order_by,'desc');
		$this->db->limit($limit,$page);
		$query = $this->db->get();
		$item = $query->result();
		return $item;
	}

	//검색시 총 게시물수 가져오기
	function get_sc_total($table,$limit,$page,$order_by,$st,$sc,$where=NULL,$clm=NULL,$where2=NULL,$clm2=NULL,$where3=NULL,$clm3=NULL,$where4=NULL,$clm4=NULL,$where5=NULL,$clm5=NULL) {
		$sc = urldecode($sc);
		$this->db->select('*');
		$this->db->from($table);
		$this->db->like($st,$sc);

		
		if ($where != NULL) {
			$this->db->where($where,$clm);
		}
		if ($where2 != NULL) {
			$this->db->where($where2,$clm2);
		}
		if ($where3 != NULL) {
			$this->db->where($where3,$clm3);
		}
		
		if ($where4 != NULL) {
			$this->db->where($where4,$clm4);
		}
		
		if ($where5 != NULL) {
			$this->db->where($where5,$clm5);
		}
		
		
		$this->db->order_by($order_by,'desc');
		$item = $this->db->count_all_results();
		return $item;
	}

}
