<?php
/*
This script software package is NOT FREE And is Copyright 2010 (C) Valdo all rights reserved.
we do supply help or support or further modification to this script by Contact
Haidar Mar'ie 
e-mail = coder5@ymail.com
*/
class Hdr_spv_send_to_agen_ctrl extends Controller{
	public function __construct(){
		parent::Controller();
		if(@$_SESSION['blevel']!='spv_sta'){
			redirect('login');	
		}
		$this->load->model('hdr_debtor/hdr_debtor_model', 'debtor_model');
		$this->load->model('admin/hdr_user_model','user_model');
		$this->load->model('user/hdr_call_track_model','call_track_model');
        $this->load->model('spv/hdr_sta_model','sta_model');
		$this->load->helper('flexigrid');
		$this->id_user = @$_SESSION["id_user"];
		$this->role = @$_SESSION["role"];
	}
	
	public function index(){
		$this->sta();
	}
	
	public function sta(){
		$data_t['title'] = 'Send To Agen';
		$data['text'] = 'Send To Agen';
		$begin_uri = $this->uri->segment(4);
		$end_uri = $this->uri->segment(5);
		$begindate = $begin_uri==""?$begindate=date('Y-m-d'):$begindate=$begin_uri;
		$enddate = $begin_uri==""?$enddate=date('Y-m-d'):$enddate=$end_uri;
		$report = '1';
		$this->load->helper('flexigrid');
		$this->load->model('hdr/hdr_load_ajax_model','load_ajax');
		$data = $this->load_ajax->get_sta_track($begindate,$enddate,$report);
		$data['begindate'] = $begindate;
		$data['enddate'] = $enddate;
		$data['report'] = $report;
		$data['page'] = 'sta';
		$this->load->view('spv/hdr_header_spv_sta',$data_t);
		$this->load->view('spv/sta/hdr_sta_view',$data);
		$this->load->view('spv/hdr_footer',$data);
	}
	
	public function sta_rtf(){
		$data_t['title'] = 'Send To Agen';
		$data['text'] = 'Send To Agen';
		$begin_uri = $this->uri->segment(4);
		$end_uri = $this->uri->segment(5);
		$begindate = $begin_uri==""?$begindate=date('Y-m-d'):$begindate=$begin_uri;
		$enddate = $begin_uri==""?$enddate=date('Y-m-d'):$enddate=$end_uri;
		$report = '1';
		$this->load->helper('flexigrid');
		$this->load->model('hdr/hdr_load_ajax_model','load_ajax');
		$data = $this->load_ajax->get_sta_rtf();
		$data['begindate'] = $begindate;
		$data['enddate'] = $enddate;
		$data['page'] = 'sta_rtf';
		$data['text'] = 'Report';
		$this->load->view('spv/hdr_header_spv_sta',$data_t);
		$this->load->view('spv/sta/hdr_sta_view',$data);
		$this->load->view('spv/hdr_footer',$data);
	}
	public function upload_sta_csv(){
		$this->load->model('admin/hdr_setup_model', 'setup_model');
		$data['title'] = 'Please Choose File to be upload';
		$data['file_type'] = "sta";
		$data['header_file'] = $this->setup_model->field_file($id_upload_cat='7');
		$this->load->view('spv/hdr_header_spv_sta',$data);
		$this->load->view('spv/sta/hdr_upload_sta_view',$data);
		$this->load->view('spv/hdr_footer',$data);
	}
	
   	public function sta_to_csv($begindate,$enddate,$report){
        $this->sta_model->sta_to_csv($begindate,$enddate,$report);   
	}
	public function reject_debtor_sta(){
		$primary_1_array = explode(",",$this->input->post('items'));
  		foreach($primary_1_array as $index => $primary_1)
		if (is_numeric($primary_1) && $primary_1 >= 1) 
		$this->sta_model->reject_debtor_sta($primary_1);
  		$c_primary_1 =  count($primary_1_array)-1;
		$error = $c_primary_1." Selected debtors has been rejected";
  		$this->output->set_header($this->config->item('ajax_header'));
  		$this->output->set_output($error);
	}
	public function reject_debtor_sta_rtf(){
		$primary_1_array = explode(",",$this->input->post('items'));
  		foreach($primary_1_array as $index => $primary_1)
		if (is_numeric($primary_1) && $primary_1 >= 1) 
		$this->sta_model->reject_debtor_sta_pdf($primary_1);
  		$c_primary_1 =  count($primary_1_array)-1;
		$error = $c_primary_1." Selected debtors has been rejected";
  		$this->output->set_header($this->config->item('ajax_header'));
  		$this->output->set_output($error);
	}
	
	public function test_pdf(){
		//$pdf_info = array('info'=>'1','info'=>'2','info'=>'3');
		$ex_val =  array('info' => '1a', 'info2' => '2a', 'info3' => '3a', 'info4' => '4a');
		echo 'total='.$total_val = count($ex_val);
		echo '<br/>';
		$i = 0;
		for($a=0;$i<$total_val ;$a++):
			 foreach ($ex_val as $row):
				$i++;
					echo "keterangan  ".$row;
					echo "<br/>";
				if($i%2==0)
						echo 'break<hr/>';
				endforeach;//endforeach
			endfor; //endif
		}
	
	public function rtf(){
		$this->load->library('rtf/Rtf');
		//paragraph formats
		$rtf = new Rtf();
		$sect = &$rtf->addSection();
		
		$sect->setMargins(1,1,1,1); 
		$sect->setPaperWidth(900); 
		$parGreyLeft = new ParFormat('left'); 
		$parGreyLeft->setSpaceBefore(1); 
		$parGreyLeft->setSpaceAfter(1); 
		$parRight = new ParFormat('right');
		$parKop = new ParFormat('left'); 
		$font1 = new Font(8, 'Arial	', '#000055'); 
		$font2 = new Font(8, 'Arial	', '#000055'); 
		$font2->setBold();
		$fontBlank = new Font(8, 'Arial', '#FFFFFF'); 
		//$parGreyLeft->setShading(10); 
		function is_blank($string){
			$blank = $string==''?'.':$string;
			return $blank;
		}
		$fontSmall = new Font(3); 

		$parBlack = new ParFormat(); 
		$parBlack->setBackColor('#000000'); 

		$text_kop = "SURAT TUGAS PENAGIHAN"; 
		$text_kop2 = "KARTU KREDIT BANK BUMIPUTERA";
        $kop_alamat = "JL. Raden Saleh I No. 3A Jakarta 10340,Phone 021 31990588 Fax 021 3900005.\n\n";
		// $parSimple->setIndentLeft(5); 
		// $parSimple->setIndentRight(0.5); 

		$pdf_info = $this->sta_model->sta_to_rtf();
		$total_debt_sta_rtf = $pdf_info->num_rows(); 
		$null = null;

		$img  = basic_path().'assets/images/bp.jpg';
		$i = 0 ;
		$a = 1;
		foreach ($pdf_info->result() as $row_pdf){
			$table = &$sect->addTable(); 
			$table->addRow(1); 
			$table->addColumnsList(array(7.5, 10)); 
			$table->writeToCell(1, 2,$text_kop, $font2, $parKop ); 
			$table->writeToCell(1, 2,$text_kop2, $font2, $parKop ); 
			$table->writeToCell(1, 2,$a++, $font2, $parRight ); 
			$sect->writeText($kop_alamat, $font1, $parGreyLeft); 
			$sect->emptyParagraph($fontSmall, $parBlack); 
			$sect->writeText('.', $fontSmall, $parGreyLeft); 
			$cell = &$table->getCell(1, 1); 
			$cell->addImage($img, $null); 

			$table = &$sect->addTable();
			$table->addRows(20);
			$table->addColumn(5);
			$table->addColumn(5);
			$table->addColumn(3);
			$table->addColumn(7);
			$i++;
			$debt_info = $row_pdf->en_value;
			$debt_data = strs_to_arrs($debt_info);	
			$table->writeToCell(1, 1, 'Agency', $font1, $parGreyLeft);      
			$table->writeToCell(1, 2, $row_pdf->agency, $font1, $parGreyLeft);             
			$table->writeToCell(1, 3, '24 Profile<br/>Limit', $font1, $parGreyLeft);    
			$table->writeToCell(1, 4, $debt_data[26].'<br/>'.price_format($debt_data[8]), $font2, $parGreyLeft);    
			$table->writeToCell(2, 1, 'Tgl Serah', $font1, $parGreyLeft);          
			$table->writeToCell(2, 2, date_formating($row_pdf->date_in), $font1, $parGreyLeft);           
			$table->writeToCell(2, 3, '.', $fontBlank, $parGreyLeft);           
			$table->writeToCell(2, 4, '.', $fontBlank, $parGreyLeft);     
			$table->writeToCell(3, 1, 'Tgl Tarik', $font1, $parGreyLeft);     
			$table->writeToCell(3, 2, date_formating($row_pdf->date_over), $font1, $parGreyLeft);     
			$table->writeToCell(3, 3, 'Out Standing', $font1, $parGreyLeft);         
			$table->writeToCell(3, 4, price_format($row_pdf->amount), $font2, $parGreyLeft);         
			$table->writeToCell(4, 1, '.', $fontBlank, $parGreyLeft);           
			$table->writeToCell(4, 2, '.', $fontBlank, $parGreyLeft);        
			$table->writeToCell(4, 3, 'Current', $font1, $parGreyLeft);  
			$table->writeToCell(4, 4, price_format($debt_data[28]), $font1, $parGreyLeft);   
			$table->writeToCell(5, 1, 'No. Kartu', $font1, $parGreyLeft);  
			$table->writeToCell(5, 2, $debt_data[1], $font2, $parGreyLeft); 
			$table->writeToCell(5, 3, 'X-Days', $font1, $parGreyLeft);  
			$table->writeToCell(5, 4, is_blank(price_format($debt_data[29])), $font1, $parGreyLeft); 
			$table->writeToCell(6, 1, 'Nama', $font1, $parGreyLeft);  
			$table->writeToCell(6, 2, $debt_data[3], $font2, $parGreyLeft); 
			$table->writeToCell(6, 3, '30Dpd', $font1, $parGreyLeft);  
			$table->writeToCell(6, 4, is_blank(price_format($debt_data[30])), $font1, $parGreyLeft); 
			$table->writeToCell(7, 1, 'Gender', $font1, $parGreyLeft); 
			$table->writeToCell(7, 2, $debt_data[69], $font1, $parGreyLeft);  
			$table->writeToCell(7, 3, '60Dpd', $font1, $parGreyLeft);  
			$table->writeToCell(7, 4, is_blank(price_format($debt_data[31])), $font1, $parGreyLeft);  
			$table->writeToCell(8, 1, 'Lahir', $font1, $parGreyLeft);  
			$table->writeToCell(8, 2, date_formating($debt_data[67]), $font1, $parGreyLeft); 
			$table->writeToCell(8, 3, '90Dpd', $font1, $parGreyLeft);     
			$table->writeToCell(8, 4, is_blank(price_format($debt_data[32])), $font1, $parGreyLeft); 
			$table->writeToCell(9, 1, 'Ibu Kandung', $font1, $parGreyLeft);      
			$table->writeToCell(9, 2, $debt_data[68], $font1, $parGreyLeft); 
			$table->writeToCell(9, 3, '120Dpd', $font1, $parGreyLeft);      
			$table->writeToCell(9, 4, is_blank(price_format($debt_data[34])), $font1, $parGreyLeft);
			$table->writeToCell(10, 1, 'Open Date', $font1, $parGreyLeft); 
			$table->writeToCell(10, 2, date_formating($debt_data[11]), $font1, $parGreyLeft);
			$table->writeToCell(10, 3, '150Dpd', $font1, $parGreyLeft);   
			$table->writeToCell(10, 4, is_blank(price_format($debt_data[34])), $font1, $parGreyLeft); 
			$table->writeToCell(11, 1, 'Cycle', $font1, $parGreyLeft); 
			$table->writeToCell(11, 2, $row_pdf->cycle, $font1, $parGreyLeft); 
			$table->writeToCell(11, 3, '180Dpd', $font1, $parGreyLeft);   
			$table->writeToCell(11, 4, is_blank(price_format($debt_data[35])), $font1, $parGreyLeft); 
			$table->writeToCell(12, 1, 'Bucket', $font1, $parGreyLeft); 
			$table->writeToCell(12, 2, $row_pdf->bucket, $font1, $parGreyLeft); 
			$table->writeToCell(12, 3, '210Dpd', $font1, $parGreyLeft);    
			$table->writeToCell(12, 4, is_blank(price_format($debt_data[36])), $font1, $parGreyLeft);
			$table->writeToCell(13, 1, 'Last Pay (Date)', $font1, $parGreyLeft);   
			$table->writeToCell(13, 2, is_blank(date_formating($debt_data[18])), $font1, $parGreyLeft);
			$table->writeToCell(13, 3, 'TOTAL', $font1, $parGreyLeft);   
			$table->writeToCell(13, 4, is_blank(price_format($debt_data[37])), $font1, $parGreyLeft);
			$table->writeToCell(14, 1, 'Last Pay (Rp)', $font1, $parGreyLeft);   
			$table->writeToCell(14, 2, is_blank(price_format($debt_data[19])), $font1, $parGreyLeft);
			$table->writeToCell(14, 3, '.', $fontBlank, $parGreyLeft);   
			$table->writeToCell(14, 4, '.', $fontBlank, $parGreyLeft);   
			$table->writeToCell(15, 1, 'Alamat Rumah', $font1, $parGreyLeft);   
			$table->writeToCell(15, 2, $debt_data[46], $font1, $parGreyLeft);
			$table->writeToCell(15, 3, 'Kantor', $font1, $parGreyLeft);   
			$table->writeToCell(15, 4, $debt_data[52], $font1, $parGreyLeft);
			$table->writeToCell(16, 1, '.', $fontBlank, $parGreyLeft);   
			$table->writeToCell(16, 2, '.', $fontBlank, $parGreyLeft);   
			$table->writeToCell(16, 3, 'Posisi', $font1, $parGreyLeft);   
			$table->writeToCell(16, 4, $debt_data[51], $font1, $parGreyLeft);
			$table->writeToCell(17, 1, 'Nama ECON', $font1, $parGreyLeft);   
			$table->writeToCell(17, 2, $debt_data[54], $font1, $parGreyLeft);
			$table->writeToCell(17, 3, 'Alamat ECON', $font1, $parGreyLeft);     
			$table->writeToCell(17, 4, $debt_data[55], $font1, $parGreyLeft);
			$table->writeToCell(18, 1, 'Telp Rumah', $font1, $parGreyLeft); 
			$table->writeToCell(18, 2, $debt_data[60], $font1, $parGreyLeft);
			$table->writeToCell(18, 3, '.', $fontBlank, $parGreyLeft); 
			$table->writeToCell(18, 4, '.', $fontBlank, $parGreyLeft); 
			$table->writeToCell(19, 1, 'Telp Kantor', $font1, $parGreyLeft); 
			$table->writeToCell(19, 2, $debt_data[61], $font1, $parGreyLeft);
			$table->writeToCell(19, 3, 'HP', $font1, $parGreyLeft); 
			$table->writeToCell(19, 4, $debt_data[59], $font1, $parGreyLeft);
			$table->writeToCell(20, 1, 'Note', $font1, $parGreyLeft);
			$table->writeToCell(20, 2, $row_pdf->notes, $font1, $parGreyLeft);
			$sect->writeText('.', $fontSmall, $parGreyLeft); 
			 if($i%2==0)
               $sect->insertPageBreak();
			/*  if($i=1)
					break;  */
		}
		$rtf->sendRtf(); 
	}
	
}
	
?>