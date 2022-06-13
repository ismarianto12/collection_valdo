<?php
class M_crud extends Model{ 
    function __construct()
    {
        parent :: Model();

    }

               
        
   function proses_insert($table,$field,$value) {
 
        $sql = "Insert IGNORE into $table ($field) values($value)";
        $query = $this->db->query($sql);
        
        return $query;
        $this->db->close();
         
    }
    
    function proses_stag_insert($table,$field,$value) {
        
        
        $sql = "Insert into $table ($field) values($value)";
        
        $query = $this->stag->query($sql);
        
        return $query;
        $this->stag->close();
         
    }
    
    
       function proses_update($table,$field_value,$where) {
 
        $sql = "Update $table set $field_value $where";
        $query = $this->db->query($sql);
        
        return $query;
        $this->db->close();
         
    }
    
    
       public function proses_select_rows($table,$where){
        $sql = "select * from $table $where";
        $query = $this->db->query($sql);
        
 
                
        if($query->num_rows() < 1){
         
               return "false"; 
            
        } else {                          
        return $query->row();    
        //return $query->result_array(); 
        }
        
        $this->db->close();
    }
    
 function proses_select_all($table,$where){
        $this->ems = $this->load->database('ems',true);
        $sql = "select * from $table $where";
        $query = $this->ems->query($sql);
         //echo  $this->db->last_query();exit; 
         return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
         
         $this->ems->close();
         
     }
    
    
    
    function getDtMember($idMember)
{
    // [Hardcoded Games list]:
    $getDtMember = array(
        array(
            'id' => 'Killzone: Shadow Fall',
            'first_name' => 'test desc ',
            'surname' => '49.99'
        ),
        array(
            'id' => 'Battlefield',
            'first_name' => 'blah blah',
            'surname' => '54.99'
        )
    );

    return $getDtMember;
} 
    
    
       public function cek_data($table,$where){
        $sql = "select * from $table $where";
        $query = $this->db->query($sql);
        
 
                
        if($query->num_rows() < 1){
         
               return 0; 
            
        } else {                          
                return 1;    
        //return $query->result_array(); 
        }
        
        $this->db->close();
    } 
    
    
     public function cek_data_stag($table,$where){
        $sql = "select * from $table $where";
        $query = $this->stag->query($sql);
        
 
                
        if($query->num_rows() < 1){
         
               return 0; 
            
        } else {                          
                return 1;    
        //return $query->result_array(); 
        }
        
        $this->stag->close();
    }   
   
    
       function get_time_proses($file_fax){
        $sql = "select tgl_inc - INTERVAL 60 MINUTE as tgl_inc,tgl_proses,tgl_close ,TIMESTAMPDIFF(MINUTE,tgl_proses,tgl_close) as duration from monitor_data where file_fax = '$file_fax' limit 1";
        $query = $this->db->query($sql);
        
        
                
                if($query->num_rows() > 0){
                         $data =  $query->row_array(); 
                                     
                }  else {
                $data = array('tgl_inc'=>'Manual',
                              'tgl_proses'=>'-',
                              'tgl_close'=>'-',
                              'duration'=>'-'
                                );              

                //return $query->result_array(); 
                }

                return $data;
    }
    
    
           function get_cancel($kode,$groups){
        $sql = "select keterangan from  t_kode_parameter where kode = '$kode' and groups = '$groups' limit 1";
        $query = $this->db->query($sql);
        
        
                
                if($query->num_rows() > 0){
                         $data =  $query->row_array(); 
                                     
                }  else {
                $data = array( 
                              'keterangan'=>'-' 
                                );              

                //return $query->result_array(); 
                }

                return $data;
    }   
    

     public function get_details($table,$no_apl,$ap_index){
        $sql = "select * from $table where  no_aplikasi = '$no_apl' and SUBSTRING_INDEX(ap_index, '\\\', -1) = '$ap_index' ";
        $query = $this->db->query($sql);
         
                
        if($query->num_rows() < 1){
        $no_data = 'no_data';
        return $no_data; 
        } else {
        return $query->result_array(); 
        }
	}
    
    public function get_details_where($table,$field,$where){
        $sql = "select $field from $table $where ";
        $query = $this->db->query($sql);
         
                
        if($query->num_rows() < 1){
        $no_data = 'no_data';
        return $no_data; 
        } else {
        return $query->result_array(); 
        }
    }	
		
	 public function proses_select_rows_field($table,$where,$field,$sort){
        $sql = "select $field from $table $where $sort limit 1";
        $query = $this->db->query($sql);
        
 
                
        if($query->num_rows() < 1){
         
               return "false"; 
            
        } else {                          
        return $query->row();    
        //return $query->result_array(); 
        }
        
        $this->db->close();
    }
	
    public function proses_select_rows_fields($table,$where,$field){
        $this->ems = $this->load->database('ems',true);
        $sql = "select $field from $table $where limit 1";
        $query = $this->ems->query($sql);
        
 
                
        if($query->num_rows() < 1){
         
               return "false"; 
            
        } else {                          
        return $query->row();    
        //return $query->result_array(); 
        }
        
        $this->ems->close();
    }
    
 public function proses_select_rows_fields_dc($table,$where,$field){
      
        $sql = "select $field from $table $where limit 1";
        $query = $this->db->query($sql);
        
 
                
        if($query->num_rows() < 1){
         
               return "false"; 
            
        } else {                          
        return $query->row();    
        //return $query->result_array(); 
        }
        
        $this->ems->close();
    }   
    
  public function proses_select_rows_fields_confin($table,$where,$field){
      $this->confins = $this->load->database('confins',true);        
      
        $sql = "select TOP 1 $field from $table $where";
        $query = $this->confins->query($sql);
        
 
                
        if($query->num_rows() < 1){
         
               return "false"; 
            
        } else {                          
        return $query->row();    
        //return $query->result_array(); 
        }
        
        $this->confins->close();
    }        
    
    
      
}
// END RiskIssue_model Class

/* End of file RiskIssue_model.php */
/* Location: ./application/models/RiskIssue_model.php */
?>