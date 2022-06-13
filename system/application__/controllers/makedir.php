<?php
//script for crontab use <- Martin [31 Dec 2011]
class Makedir extends Controller {

    public function __construct() {
		parent::Controller();
		date_default_timezone_set("Asia/Bangkok");
    }

    public function index()
    {
      //$this->read_dataMaster();
    }

	function makedir_od0(){
		$did = 'OD0';
		$this->outputSavetoPath($did);
	}
	
	function makedir_od1(){
		$did = 'OD1';
		$this->outputSavetoPath($did);
	}
	
	function makedir_od_2(){
		$did = 'OD-2';
		$this->outputSavetoPath($did);
	}
	
	function makedir_od_3(){
		$did = 'OD-3';
		$this->outputSavetoPath($did);
	}
	
	function makedir_od_all(){
		$did = 'ALL';
		$this->outputSavetoPath($did);
	}

	function outputSavetoPath($dial){
		$thnbln = date('m-Y');
		if (!file_exists('/home/adira/data/VoiceBlast/IN/'.$thnbln.'/'.$dial)) {
			$this->makedirs('/home/adira/data/VoiceBlast/IN/'.$thnbln.'/'.$dial, 0777);
		}
	}
	
	function makedirs($dirpath, $mode=0777) {
		return is_dir($dirpath) || mkdir($dirpath, $mode, true);
	}
		
}
?>
