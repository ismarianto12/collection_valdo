<?php
/*
 * WEBBASE APPLIKASI
 *
 * Copyright (c) 2014
 *
 * file 	: sync.php
  */
/*----------------------------------------------------------*/
class Cek_cdr extends Controller {

	function __construct()
	{
		parent::Controller();
		 
		$this->load->model('m_crud','M_crud');
		date_default_timezone_set("Asia/Bangkok");
	}
	
	//autostop adira
	function index()                       
	{
        set_time_limit(90);
        $where = " Where `status` = 'RUN'";
        $field = "no_kartu,telp,phone1,phone2,phone3,is_phone1,is_phone2,is_phone3,STATUS,company,upload_date";
        $getData = $this->M_crud->proses_select_all(' campains ',$where,$field); 
        
        
         $stVal = "";
        if($getData != "false"){
                  $detail = array();
                  $i = 0;
                      foreach ($getData as $row) {
                          $i++;
                            $no_kartu = $row['no_kartu'];
                            $telp = $row['telp'];
                            $phone1 = $row['phone1'];
                            $phone2 = $row['phone2'];
                            $phone3 = $row['phone3'];
                            $upload_date = $row['upload_date'];
                            
                            
                            $calldate = ""; //
                            $disposition = ""; //
                            
                            if($telp == ""){
                                $where = "where no_kartu = '$no_kartu' and dst = '$telp' order by calldate desc"; //
                            $field = " calldate,disposition ";
                            $rslt_dt = $this->M_crud->proses_select_rows_fields(' cdr ',$where,$field); 
                            
                                    if($rslt_dt != "false")
                                    {
                                            $calldate = $rslt_dt->calldate;                
                                            $disposition = $rslt_dt->$disposition;                
                                    }    
                            }
                            
                            $calldate1 = ""; //
                            $disposition1 = ""; //
                            
                            if($phone1 == ""){
                                $where = "where no_kartu = '$no_kartu' and dst = '$phone1' order by calldate desc "; //
                            $field = " calldate,disposition ";
                            $rslt_dt = $this->M_crud->proses_select_rows_fields(' cdr ',$where,$field); 
                            
                                    if($rslt_dt != "false")
                                    {
                                            $calldate1 = $rslt_dt->calldate;                
                                            $disposition1 = $rslt_dt->$disposition;                
                                    }    
                            }
                            
                            $calldate2 = ""; //
                            $disposition2 = ""; //
                            
                            if($phone2 == ""){
                                $where = "where no_kartu = '$no_kartu' and dst = '$phone2' order by calldate desc "; //
                            $field = " calldate,disposition ";
                            $rslt_dt = $this->M_crud->proses_select_rows_fields(' cdr ',$where,$field); 
                            
                                    if($rslt_dt != "false")
                                    {
                                            $calldate2 = $rslt_dt->calldate;                
                                            $disposition2 = $rslt_dt->$disposition;                
                                    }    
                            }
                            
                            $calldate3 = ""; //
                            $disposition3 = ""; //
                            
                            if($phone3 == ""){
                                $where = "where no_kartu = '$no_kartu' and dst = '$phone3' order by calldate desc "; //
                            $field = " calldate,disposition ";
                            $rslt_dt = $this->M_crud->proses_select_rows_fields(' cdr ',$where,$field); 
                            
                                    if($rslt_dt != "false")
                                    {
                                            $calldate3 = $rslt_dt->calldate;                
                                            $disposition3 = $rslt_dt->$disposition;                
                                    }    
                            }
                            
                            
                          
                          
                            $stVal .=   $i.'|'.
                                        $no_kartu.'|'.
                                        
                                        $telp.'|'.
                                        $calldate.'|'.
                                        $disposition.'|'.
                                        $phone1.'|'.
                                        $calldate1.'|'.
                                        $disposition1.'|'.
                                        $phone2.'|'.
                                        $calldate2.'|'.
                                        $disposition2.'|'.
                                        $phone3.'|'.
                                        $calldate3.'|'.
                                        $disposition3.'|'.
                                        $upload_date.'|'.
                                        
                                        
                                        $stVal .="\r\n";

                      }
        }             
        
        
        echo $stVal;
        
        /*
        $stHeader = "No_Kartu|Telp|calldate|status|phone1|calldate1|status_phone1|phone2|calldate2|status_phone2|phone3|calldate3|status_phone3|tgl_inc";
        $stCnt = $stHeader."\r\n".str_ireplace("'"," ",str_ireplace(","," ",$stVal));
            $filename = "./temp/Cek_".date('YmdHis').".csv";    
            file_put_contents($filename, $stCnt);                        
            
         */

	}
	
 }

/* End of file */