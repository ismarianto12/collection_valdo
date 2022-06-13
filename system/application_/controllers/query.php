<?php
//script for crontab use <- Martin [31 Dec 2011]
class Auto_upload extends Controller {

    public function __construct() {
      parent::Controller();
      $this->load->model('hdr_debtor/hdr_debtor_model', 'debtor_model');
      $this->load->model('user/hdr_call_track_model', 'call_track_model');
      $this->load->model('spv/hdr_report_spv_model', 'spv_report_model');
      $this->load->model('admin/hdr_upload_model', 'upload_model');
      
    }

		function link_report1(){
			//die('haha');
			$file_now = "DPD1.txt";
			$sql = "SELECT @no:=@no+1 no, primary_1 AS no_kontrak, LOWER( NAME ) AS nama, IF( cell_phone1 =0, phone_1, cell_phone1 ) AS New_phone, angsuran_ke AS angsuran, substring_index( lower( product ) , '/', 1 ) AS jenis, substring_index( lower( product ) , '/', -1 ) AS merk, police_no AS nopol, due_date AS jatuh_tempo,shift AS minimum, debt_amount AS tagihan, kode_cabang
                FROM hdr_debtor_main, (SELECT @no:= 0) AS NO
                WHERE dpd = '1' and skip='1' and object_group_code in ('001','002') and (cell_phone1 != '-' or phone_1 != '-') and (cell_phone1 != '' or phone_1 != '') and (cell_phone1 != 'TIDAK ADA' or phone_1 != 'TIDAK ADA') and (substr(cell_phone1, 1, 2) != '00' or substr(phone_1, 1, 2) != '00') and substr(cell_phone1, 1, 2) != '+6' and substr(cell_phone1, 1, 2) != '62' and (cell_phone1 != '0' or phone_1 != '0')
                ";
			//and cell_phone1 != '-' and phone_1 != '-' and cell_phone1 != '' and phone_1 != '' and cell_phone1 != 'TIDAK ADA' and phone_1 != 'TIDAK ADA' and substr(cell_phone1, 1, 2) != '00' and substr(cell_phone1, 1, 2) != '+6' and substr(cell_phone1, 1, 2) != '62' and substr(phone_1, 1, 2) != '00' and cell_phone1 != '0' and phone_1 != '0' 
			//and cell_phone1 = '-' or phone_1 != '-' or cell_phone1 != '' or phone_1 != '' or cell_phone1 = 'TIDAK ADA' or phone_1 != 'TIDAK ADA' or substr(cell_phone1, 1, 2) != '00' or substr(cell_phone1, 1, 2) != '+6' or substr(cell_phone1, 1, 2) != '62' or substr(phone_1, 1, 2) != '00' or cell_phone1 != '0' or phone_1 != '0'
			$this->load->dbutil();
			$this->load->helper('download');
			
			$delimiter = "|";
			$newline = "\r\n";
			
			$query = $this->db->query($sql);
			
			$csv_layout = $this->dbutil->csv_from_result($query,$delimiter,$newline);
			$query->free_result();
			$csv_layout = preg_replace('!(")!','',$csv_layout);
			
			force_download($file_now,$csv_layout);

			
			
		}

		function link_report2(){
			$file_now = "DPD-3.txt";
			$sql = "SELECT @no:=@no+1 No, primary_1 AS no_kontrak, LOWER( NAME ) AS nama, IF( cell_phone1 =0, phone_1, cell_phone1 ) AS New_phone, angsuran_ke AS angsuran, substring_index( lower( product ) , '/', 1 ) AS jenis, substring_index( lower( product ) , '/', -1 ) AS merk, police_no AS nopol, due_date AS jatuh_tempo,shift AS minimum, debt_amount AS tagihan, kode_cabang
				FROM `hdr_debtor_main`, (SELECT @no:= 0) AS NO WHERE dpd ='-3' and skip='1' and (cell_phone1 != '-' or phone_1 != '-') and (cell_phone1 != '' or phone_1 != '') and (cell_phone1 != 'TIDAK ADA' or phone_1 != 'TIDAK ADA') and (substr(cell_phone1, 1, 2) != '00' or substr(phone_1, 1, 2) != '00') and substr(cell_phone1, 1, 2) != '+6' and substr(cell_phone1, 1, 2) != '62' and (cell_phone1 != '0' or phone_1 != '0')";
			$q = $this->db->query($sql);
			
			$this->load->dbutil();
			$this->load->helper('download');
			
			$delimiter = "|";
			$newline = "\r\n";
			
			$query = $this->db->query($sql);
			
			$csv_layout = $this->dbutil->csv_from_result($query,$delimiter,$newline);
			$query->free_result();
			$csv_layout = preg_replace('!(")!','',$csv_layout);
			
			force_download($file_now,$csv_layout);
		}


			function link_report3(){
			//die('haha');
			$file_now = "DPD-2.txt";
			$sql = "SELECT @no:=@no+1 No, primary_1 AS no_kontrak, LOWER( NAME ) AS nama, IF( cell_phone1 =0, phone_1, cell_phone1 ) AS New_phone, angsuran_ke AS angsuran, substring_index( lower( product ) , '/', 1 ) AS jenis, substring_index( lower( product ) , '/', -1 ) AS merk, police_no AS nopol, due_date AS jatuh_tempo,shift AS minimum, debt_amount AS tagihan, kode_cabang
                	FROM hdr_debtor_main, (SELECT @no:= 0) AS NO
                	WHERE dpd = '-2' and skip='1' and (cell_phone1 != '-' or phone_1 != '-') and (cell_phone1 != '' or phone_1 != '') and (cell_phone1 != 'TIDAK ADA' or phone_1 != 'TIDAK ADA') and (substr(cell_phone1, 1, 2) != '00' or substr(phone_1, 1, 2) != '00') and substr(cell_phone1, 1, 2) != '+6' and substr(cell_phone1, 1, 2) != '62' and (cell_phone1 != '0' or phone_1 != '0') 
               	 ";
			
			$this->load->dbutil();
			$this->load->helper('download');
			
			$delimiter = "|";
			$newline = "\r\n";
			
			$query = $this->db->query($sql);
			
			$csv_layout = $this->dbutil->csv_from_result($query,$delimiter,$newline);
			$query->free_result();
			$csv_layout = preg_replace('!(")!','',$csv_layout);
			
			force_download($file_now,$csv_layout);
					
		}

		function link_report4(){
			//die('haha');
			$file_now = "DPD0.txt";
			$sql = "SELECT @no:=@no+1 No, primary_1 AS no_kontrak, LOWER( NAME ) AS nama, IF( cell_phone1 =0, phone_1, cell_phone1 ) AS New_phone, angsuran_ke AS angsuran, substring_index( lower( product ) , '/', 1 ) AS jenis, substring_index( lower( product ) , '/', -1 ) AS merk, police_no AS nopol, due_date AS jatuh_tempo,shift AS minimum, debt_amount AS tagihan, kode_cabang
                	FROM hdr_debtor_main, (SELECT @no:= 0) AS NO
                	WHERE dpd = '0' and skip='1' and (cell_phone1 != '-' or phone_1 != '-') and (cell_phone1 != '' or phone_1 != '') and (cell_phone1 != 'TIDAK ADA' or phone_1 != 'TIDAK ADA') and (substr(cell_phone1, 1, 2) != '00' or substr(phone_1, 1, 2) != '00') and substr(cell_phone1, 1, 2) != '+6' and substr(cell_phone1, 1, 2) != '62' and (cell_phone1 != '0' or phone_1 != '0') 
               	 ";
			
			$this->load->dbutil();
			$this->load->helper('download');
			
			$delimiter = "|";
			$newline = "\r\n";
			
			$query = $this->db->query($sql);
			
			$csv_layout = $this->dbutil->csv_from_result($query,$delimiter,$newline);
			$query->free_result();
			$csv_layout = preg_replace('!(")!','',$csv_layout);
			
			force_download($file_now,$csv_layout);
					
		}
		
}
?>