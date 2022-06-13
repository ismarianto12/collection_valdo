<?php
/*
********************************************************
TinyButStrong - Template Engine for Pro and Beginners
------------------------
Version  : 3.1.1 for PHP >= 4.0.6
Date     : 2006-06-25
Web site : www.tinybutstrong.com
Author   : skrol29@freesurf.fr
********************************************************
This library is free software.
You can redistribute and modify it even for commercial usage,
but you must accept and respect the LPGL License version 2.1.
*/
// Check PHP version
if (PHP_VERSION<'4.0.6') {
	echo '<br><b>TinyButStrong Error</b> (PHP Version Check) : Your PHP version is '.PHP_VERSION.' while TinyButStrong needs PHP version 4.0.6 or higher.';
} elseif (PHP_VERSION<'4.1.0') {
	function array_key_exists (&$key,&$array) {return key_exists($key,$array);}
}
if (PHP_VERSION<'5.1.0') {
	function property_exists(&$obj,$prop) {return true;}
}

// Render flags
define('TBS_NOTHING', 0);
define('TBS_OUTPUT', 1);
define('TBS_EXIT', 2);

// Plug-ins actions
define('TBS_INSTALL', -1);
define('TBS_ISINSTALLED', -3);

// *********************************************

class clsTbsLocator {
	var $PosBeg = false;
	var $PosEnd = false;
	var $Enlarged = false;
	var $FullName = false;
	var $SubName = '';
	var $SubOk = false;
	var $SubLst = array();
	var $SubNbr = 0;
	var $PrmLst = array();
	var $PrmIfNbr = false;
	var $MagnetId = false;
	var $BlockFound = false;
	var $FirstMerge = true;
	var $ConvProtect = true;
	var $ConvHtml = true;
	var $ConvMode = 1; // Normal
	var $ConvBr = true;
}

// *********************************************

class clsTbsDataSource {

var $Type = false;
var $SubType = 0;
var $SrcId = false;
var $Query = '';
var $RecSet = false;
var $RecKey = '';
var $RecNum = 0;
var $RecNumInit = 0;
var $RecSaving = false;
var $RecSaved = false;
var $RecBuffer = false;
var $CurrRec = false;
var $TBS = false;
var $OnDataOk = false;
var $OnDataPrm = false;
var $OnDataPrmDone = array();
var $OnDataPi = false;

function DataAlert($Msg) {
	return $this->TBS->meth_Misc_Alert('when merging block '.$this->TBS->_ChrOpen.$this->TBS->_CurrBlock.$this->TBS->_ChrClose,$Msg);
}

function DataPrepare(&$SrcId,&$TBS) {

	$this->SrcId =& $SrcId;
	$this->TBS =& $TBS;

	if (is_array($SrcId)) {
		$this->Type = 0;
	} elseif (is_resource($SrcId)) {

		$Key = get_resource_type($SrcId);
		switch ($Key) {
		case 'mysql link'            : $this->Type = 1; break;
		case 'mysql link persistent' : $this->Type = 1; break;
		case 'mysql result'          : $this->Type = 1; $this->SubType = 1; break;
		case 'pgsql link'            : $this->Type = 8; break;
		case 'pgsql link persistent' : $this->Type = 8; break;
		case 'pgsql result'          : $this->Type = 8; $this->SubType = 1; break;
		case 'sqlite database'       : $this->Type = 9; break;
		case 'sqlite database (persistent)'	: $this->Type = 9; break;
		case 'sqlite result'         : $this->Type = 9; $this->SubType = 1; break;
		default :
			$SubKey = 'resource type';
			$this->Type = 7;
			$x = strtolower($Key);
			$x = str_replace('-','_',$x);
			$Function = '';
			$i = 0;
			$iMax = strlen($x);
			while ($i<$iMax) {
				if (($x[$i]==='_') or (($x[$i]>='a') and ($x[$i]<='z')) or (($x[$i]>='0') and ($x[$i]<='9'))) {
					$Function .= $x[$i];
					$i++;
				} else {
					$i = $iMax;
				}
			}
		}

	} elseif (is_string($SrcId)) {

		switch (strtolower($SrcId)) {
		case 'array' : $this->Type = 0; $this->SubType = 1; break;
		case 'clear' : $this->Type = 0; $this->SubType = 3; break;
		case 'mysql' : $this->Type = 1; $this->SubType = 2; break;
		case 'text'  : $this->Type = 4; break;
		case 'num'   : $this->Type = 6; break;
		default :
			if ($SrcId[0]==='~') {
				$FctInfo = $SrcId;
				$ErrMsg = false;
				if ($TBS->meth_Misc_UserFctCheck($FctInfo,$ErrMsg,true)) {
					$this->FctOpen  =& $FctInfo[0];
					$this->FctFetch =& $FctInfo[1];
					$this->FctClose =& $FctInfo[2];
					$this->FctPrm = array(false,0);
					$this->SrcId =& $FctInfo[0][0];
					$this->Type = 11;
				} else {
					$this->Type = $this->DataAlert($ErrMsg);
				}
			} else {
				$Key = $SrcId;
				$SubKey = 'keyword';
				$this->Type = 7;
				$Function = $SrcId;
			}
		}

	} elseif (is_object($SrcId)) {
		if (method_exists($SrcId,'tbsdb_open')) {
			if (!method_exists($SrcId,'tbsdb_fetch')) {
				$this->Type = $this->DataAlert('the expected method \'tbsdb_fetch\' is not found for the class '.get_class($SrcId).'.');
			} elseif (!method_exists($SrcId,'tbsdb_close')) {
				$this->Type = $this->DataAlert('the expected method \'tbsdb_close\' is not found for the class '.get_class($SrcId).'.');
			} else {
				$this->Type = 10;
			}
		} else {
			$Key = get_class($SrcId);
			$SubKey = 'object type';
			$this->Type = 7;
			$Function = $Key;
		}
	} elseif ($SrcId===false) {
		$this->DataAlert('the specified source is set to FALSE. Maybe your connection has failed.');
	} else {
		$this->DataAlert('unsupported variable type : \''.gettype($SrcId).'\'.');
	}

	if ($this->Type===7) {
		$this->FctOpen  = 'tbsdb_'.$Function.'_open';
		$Ok = function_exists($this->FctOpen);
		if (!$Ok) { // Some extended call can have a suffix in the class name, we check without the suffix
			$i = strpos($Function,'_');
			if ($i!==false) {
				$x = substr($Function,0,$i);
				$z  = 'tbsdb_'.$x.'_open';
				$Ok = function_exists($z);
				if ($Ok) {
					$Function = $x;
					$this->FctOpen = $z;
				}
			}
		}
		if ($Ok) {
			$this->FctFetch = 'tbsdb_'.$Function.'_fetch';
			$this->FctClose = 'tbsdb_'.$Function.'_close';
			if (function_exists($this->FctFetch)) {
				if (!function_exists($this->FctClose)) $this->Type = $this->DataAlert('the expected custom function \''.$this->FctClose.'\' is not found.');
			} else {
				$this->Type = $this->DataAlert('the expected custom function \''.$this->FctFetch.'\' is not found.');
			}
		} else {
			$this->Type = $this->DataAlert('the data source Id \''.$Key.'\' is an unsupported '.$SubKey.' because custom function \''.$this->FctOpen.'\' is not found.');
		}
	}

	return ($this->Type!==false);

}

function DataOpen(&$Query) {

	// Init values
	unset($this->CurrRec); $this->CurrRec = true;
	if ($this->RecSaved) {
		$this->FirstRec = true;
		unset($this->RecKey); $this->RecKey = '';
		$this->RecNum = $this->RecNumInit;
		if ($this->OnDataOk) $this->OnDataArgs[1] =& $this->CurrRec;
		return true;
	}
	unset($this->RecSet); $this->RecSet = false;
	$this->RecNumInit = 0;
	$this->RecNum = 0;

	if (isset($this->TBS->_piOnData)) {
		$this->OnDataPi = true;
		$this->OnDataPiRef =& $this->TBS->_piOnData;
		$this->OnDataOk = true;
	}
	if ($this->OnDataOk) {
		$this->OnDataArgs = array();
		$this->OnDataArgs[0] =& $this->TBS->_CurrBlock;
		$this->OnDataArgs[1] =& $this->CurrRec;
		$this->OnDataArgs[2] =& $this->RecNum;
		$this->OnDataArgs[3] =& $this->TBS;
	}

	switch ($this->Type) {
	case 0: // Array
		if (($this->SubType===1) and (is_string($Query))) $this->SubType = 2;
		if ($this->SubType===0) {
			if (PHP_VERSION==='4.4.1') {$this->RecSet = $this->SrcId;} else {$this->RecSet =& $this->SrcId;} // bad bug in PHP 4.4.1
		} elseif ($this->SubType===1) {
			if (is_array($Query)) {
				if (PHP_VERSION==='4.4.1') {$this->RecSet = $Query;} else {$this->RecSet =& $Query;}
			} else {
				$this->DataAlert('type \''.gettype($Query).'\' not supported for the Query Parameter going with \'array\' Source Type.');
			}
		} elseif ($this->SubType===2) {
			// TBS query string for array and objects, syntax: "var[item1][item2]->item3[item4]..."
			$x = trim($Query);
			$z = chr(0);
			$x = str_replace(']->',$z,$x);
			$x = str_replace('][',$z,$x);
			$x = str_replace('->',$z,$x);
			$x = str_replace('[',$z,$x);
			if (substr($x,strlen($x)-1,1)===']') $x = substr($x,0,strlen($x)-1);
			$ItemLst = explode($z,$x);
			$ItemNbr = count($ItemLst);
			$Item0 =& $ItemLst[0];
			// Check first item
			if ($Item0[0]==='~') {
				$Item0 = substr($Item0,1);
				if ($this->TBS->ObjectRef!==false) {
					$Var =& $this->TBS->ObjectRef;
					$i = 0;
				} else {
					$i = $this->DataAlert('invalid query \''.$Query.'\' because property ObjectRef is not set.');
				}
			} else {
				if (isset($GLOBALS[$Item0])) {
					if ((PHP_VERSION==='4.4.1') and is_array($GLOBALS[$Item0])) {$Var = $GLOBALS[$Item0];} else {$Var =& $GLOBALS[$Item0];}
					$i = 1;
				} else {
					$i = $this->DataAlert('invalid query \''.$Query.'\' because global variable \''.$Item0.'\' is not found.');
				}
			}
			// Check sub-items
			$Empty = false;
			while (($i!==false) and ($i<$ItemNbr) and ($Empty===false)) {
				$x = $ItemLst[$i];
				if (is_array($Var)) {
					if (isset($Var[$x])) {
						$Var =& $Var[$x];
					} else {
						$Empty = true;
					}
				} elseif (is_object($Var)) {
					$ArgLst = tbs_Misc_CheckArgLst($x);
					if (method_exists($Var,$x)) {
						$f = array(&$Var,$x); unset($Var);
						$Var = call_user_func_array($f,$ArgLst);
					} elseif (isset($Var->$x)) {
						$Var =& $Var->$x;
					} else {
						$Empty = true;
					}
				} else {
					$i = $this->DataAlert('invalid query \''.$Query.'\' because item \''.$ItemLst[$i].'\' is neither an Array nor an Object. Its type is \''.gettype($Var).'\'.');
				}
				if ($i!==false) $i++;
			}
			// Assign data
			if ($i!==false) {
				if ($Empty) {
					$this->RecSet = array();
				} else {
					$this->RecSet =& $Var;
				}
			}
		} elseif ($this->SubType===3) { // Clear
			$this->RecSet = array();
		}
		// First record
		if ($this->RecSet!==false) {
			$this->RecNbr = $this->RecNumInit + count($this->RecSet);
			$this->FirstRec = true;
			$this->RecSaved = true;
			$this->RecSaving = false;
		}
		break;
	case 1: // MySQL
		switch ($this->SubType) {
		case 0: $this->RecSet = @mysql_query($Query,$this->SrcId); break;
		case 1: $this->RecSet = $this->SrcId; break;
		case 2: $this->RecSet = @mysql_query($Query); break;
		}
		if ($this->RecSet===false) $this->DataAlert('MySql error message when opening the query: '.mysql_error());
		break;
	case 4: // Text
		if (is_string($Query)) {
			$this->RecSet =& $Query;
		} else {
			$this->RecSet = ''.$Query;
		}
		break;
	case 6: // Num
		$this->RecSet = true;
		$this->NumMin = 1;
		$this->NumMax = 1;
		$this->NumStep = 1;
		if (is_array($Query)) {
			if (isset($Query['min'])) $this->NumMin = $Query['min'];
			if (isset($Query['step'])) $this->NumStep = $Query['step'];
			if (isset($Query['max'])) {
				$this->NumMax = $Query['max'];
			} else {
				$this->RecSet = $this->DataAlert('the \'num\' source is an array that has no value for the \'max\' key.');
			}
			if ($this->NumStep==0) $this->RecSet = $this->DataAlert('the \'num\' source is an array that has a step value set to zero.');
		} else {
			$this->NumMax = ceil($Query);
		}
		if ($this->RecSet) {
			if ($this->NumStep>0) {
				$this->NumVal = $this->NumMin;
			} else {
				$this->NumVal = $this->NumMax;
			}
		}
		break;
	case 7: // Custom function
		$FctOpen = $this->FctOpen;
		$this->RecSet = $FctOpen($this->SrcId,$Query);
		break;
	case 8: // PostgreSQL
		switch ($this->SubType) {
		case 0: $this->RecSet = @pg_query($this->SrcId,$Query); break;
		case 1: $this->RecSet = $this->SrcId; break;
		}
		if ($this->RecSet===false) $this->DataAlert('PostgreSQL error message when opening the query: '.pg_last_error($this->SrcId));
		break;
	case 9: // SQLite
		switch ($this->SubType) {
		case 0: $this->RecSet = @sqlite_query($this->SrcId,$Query); break;
		case 1: $this->RecSet = $this->SrcId; break;
		}
		if ($this->RecSet===false) $this->DataAlert('SQLite error message when opening the query:'.sqlite_error_string(sqlite_last_error($this->SrcId)));
		break;
	case 10: // Custom method
		$this->RecSet = $this->SrcId->tbsdb_open($this->SrcId,$Query);
		break;
	case 11: // ObjectRef
		$this->RecSet = call_user_func_array($this->FctOpen,array(&$this->SrcId,&$Query));
		break;
	}

	if ($this->Type===0) {
		unset($this->RecKey); $this->RecKey = '';
	} else {
		if ($this->RecSaving) {
			unset($this->RecBuffer); $this->RecBuffer = array();
		}
		$this->RecKey =& $this->RecNum; // Not array: RecKey = RecNum
	}

	return ($this->RecSet!==false);

}

function DataFetch() {

	if ($this->RecSaved) {
		if ($this->RecNum<$this->RecNbr) {
			if ($this->FirstRec) {
				if ($this->SubType===2) { // From string
					reset($this->RecSet);
					$this->RecKey = key($this->RecSet);
					$this->CurrRec =& $this->RecSet[$this->RecKey];
				} else {
					$this->CurrRec = reset($this->RecSet);
					$this->RecKey = key($this->RecSet);
				}
				$this->FirstRec = false;
			} else {
				if ($this->SubType===2) { // From string
					next($this->RecSet);
					$this->RecKey = key($this->RecSet);
					$this->CurrRec =& $this->RecSet[$this->RecKey];
				} else {
					$this->CurrRec = next($this->RecSet);
					$this->RecKey = key($this->RecSet);
				}
			}
			if ((!is_array($this->CurrRec)) and (!is_object($this->CurrRec))) $this->CurrRec = array('key'=>$this->RecKey, 'val'=>$this->CurrRec);
			$this->RecNum++;
			if ($this->OnDataOk) {
				if ($this->OnDataPrm) call_user_func_array($this->OnDataPrmRef,$this->OnDataArgs);
				if ($this->OnDataPi) $this->TBS->meth_PlugIn_RunAll($this->OnDataPiRef,$this->OnDataArgs);
				if ($this->SubType!==2) $this->RecSet[$this->RecKey] = $this->CurrRec; // save modifications because array reading is done without reference :(
			}
		} else {
			unset($this->CurrRec); $this->CurrRec = false;
		}
		return;
	}

	switch ($this->Type) {
	case 1: // MySQL
		$this->CurrRec = mysql_fetch_assoc($this->RecSet);
		break;
	case 4: // Text
		if ($this->RecNum===0) {
			if ($this->RecSet==='') {
				$this->CurrRec = false;
			} else {
				$this->CurrRec =& $this->RecSet;
			}
		} else {
			$this->CurrRec = false;
		}
		break;
	case 6: // Num
		if (($this->NumVal>=$this->NumMin) and ($this->NumVal<=$this->NumMax)) {
			$this->CurrRec = array('val'=>$this->NumVal);
			$this->NumVal += $this->NumStep;
		} else {
			$this->CurrRec = false;
		}
		break;
	case 7: // Custom function
		$FctFetch = $this->FctFetch;
		$this->CurrRec = $FctFetch($this->RecSet,$this->RecNum+1);
		break;
	case 8: // PostgreSQL
		$this->CurrRec = @pg_fetch_array($this->RecSet,$this->RecNum,PGSQL_ASSOC); // warning comes when no record left.
		break;
	case 9: // SQLite
		$this->CurrRec = sqlite_fetch_array($this->RecSet,SQLITE_ASSOC);
		break;
	case 10: // Custom method
		$this->CurrRec = $this->SrcId->tbsdb_fetch($this->RecSet,$this->RecNum+1);
		break;
	case 11: // ObjectRef
		$this->FctPrm[0] =& $this->RecSet; $this->FctPrm[1] = $this->RecNum+1;
		$this->CurrRec = call_user_func_array($this->FctFetch,$this->FctPrm);
		break;
	}

	// Set the row count
	if ($this->CurrRec!==false) {
		$this->RecNum++;
		if ($this->OnDataOk) {
			$this->OnDataArgs[1] =& $this->CurrRec; // Reference has changed if ($this->SubType===2)
			if ($this->OnDataPrm) call_user_func_array($this->OnDataPrmRef,$this->OnDataArgs);
			if ($this->OnDataPi) $this->TBS->meth_PlugIn_RunAll($this->OnDataPiRef,$this->OnDataArgs);
		}
		if ($this->RecSaving) $this->RecBuffer[$this->RecKey] = $this->CurrRec;
	}

}

function DataClose() {
	$this->OnDataOk = false;
	$this->OnDataPrm = false;
	$this->OnDataPi = false;
	if ($this->RecSaved) return;
	switch ($this->Type) {
	case 1: mysql_free_result($this->RecSet); break;
	case 7: $FctClose=$this->FctClose; $FctClose($this->RecSet); break;
	case 8: pg_free_result($this->RecSet); break;
	case 10: $this->SrcId->tbsdb_close($this->RecSet); break;
	case 11: call_user_func_array($this->FctClose,array(&$this->RecSet)); break;
	}
	if ($this->RecSaving) {
		$this->RecSet =& $this->RecBuffer;
		$this->RecNbr = $this->RecNumInit + count($this->RecSet);
		$this->RecSaving = false;
		$this->RecSaved = true;
	}
}

}

// *********************************************

class clsTinyButStrong {

// Public properties
var $Source = '';
var $Render = 3;
var $TplVars = array();
var $ObjectRef = false;
var $NoErr = false;
// Undocumented (can change at any version)
var $Version = '3.1.1';
var $HtmlCharSet = '';
var $TurboBlock = true;
var $VarPrefix = '';
var $Protect = true;
// Private
var $_LastFile = '';
var $_HtmlCharFct = false;
var $_Mode = 0;
var $_CurrBlock = '';
var $_ChrOpen = '[';
var $_ChrClose = ']';
var $_ChrVal = '[val]';
var $_ChrProtect = '&#91;';
var $_PlugIns = array();
var $_PlugIns_Ok = false;
var $_piOnFrm_Ok = false;

function clsTinyButStrong($Chrs='',$VarPrefix='') {
	if ($Chrs!=='') {
		$Ok = false;
		$Len = strlen($Chrs);
		if ($Len===2) { // For compatibility
			$this->_ChrOpen = $Chrs[0];
			$this->_ChrClose = $Chrs[1];
			$Ok = true;
		} else {
			$Pos = strpos($Chrs,',');
			if (($Pos!==false) and ($Pos>0) and ($Pos<$Len-1)) {
				$this->_ChrOpen = substr($Chrs,0,$Pos);
				$this->_ChrClose = substr($Chrs,$Pos+1);
				$Ok = true;
			}
		}
		if ($Ok) {
			$this->_ChrVal = $this->_ChrOpen.'val'.$this->_ChrClose;
			$this->_ChrProtect = '&#'.ord($this->_ChrOpen[0]).';'.substr($this->_ChrOpen,1);
		} else {
			$this->meth_Misc_Alert('with clsTinyButStrong() function','value \''.$Chrs.'\' is a bad tag delimitor definition.');
		}
	}
	$this->VarPrefix = $VarPrefix;
	// Liaison avec variables globales
	global $_TBS_FrmMultiLst, $_TBS_FrmSimpleLst, $_TBS_UserFctLst, $_TBS_AutoInstallPlugIns;
	if (!isset($_TBS_ObjectRefLink)) {
		$_TBS_FrmMultiLst = array();
		$_TBS_FrmSimpleLst = array();
		$_TBS_UserFctLst = array();
	}
	$this->_FrmMultiLst =& $_TBS_FrmMultiLst;
	$this->_FrmSimpleLst =& $_TBS_FrmSimpleLst;
	$this->_UserFctLst =& $_TBS_UserFctLst; 
	// Auto-installing plug-ins
	if (isset($_TBS_AutoInstallPlugIns)) foreach ($_TBS_AutoInstallPlugIns as $pi) $this->PlugIn(TBS_INSTALL,$pi);
}

// Public methods
function LoadTemplate($File,$HtmlCharSet='') {
	$Ok = true;
	if ($this->_PlugIns_Ok) {
		if (isset($this->_piBeforeLoadTemplate) or isset($this->_piAfterLoadTemplate)) {
			// Plug-ins
			$ArgLst = func_get_args();
			$ArgLst[0] =& $File;
			$ArgLst[1] =& $HtmlCharSet;
			if (isset($this->_piBeforeLoadTemplate)) $Ok = $this->meth_PlugIn_RunAll($this->_piBeforeLoadTemplate,$ArgLst);
		}
	}
	// Load the file
	if ($Ok!==false) {
		$x = '';
		if (!tbs_Misc_GetFile($x,$File)) return $this->meth_Misc_Alert('with LoadTemplate() method','file \''.$File.'\' is not found or not readable.');
		// CharSet analysis
		if ($HtmlCharSet==='+') {
			$this->Source .= $x;
		} else {
			$this->Source = $x;
			if ($this->_Mode==0) {
			$this->_LastFile = $File;
			$this->_HtmlCharFct = false;
			$this->TplVars = array();
			if (is_string($HtmlCharSet)) {
				if (($HtmlCharSet!=='') and ($HtmlCharSet[0]==='=')) {
					$ErrMsg = false;
					$HtmlCharSet = substr($HtmlCharSet,1);
					if ($this->meth_Misc_UserFctCheck($HtmlCharSet,$ErrMsg,false)) {
						$this->_HtmlCharFct = true;
					} else {
						$this->meth_Misc_Alert('with LoadTemplate() method',$ErrMsg);
						$HtmlCharSet = '';
					}
				}
			} elseif ($HtmlCharSet===false) {
				$this->Protect = false;
			} else {
				$this->meth_Misc_Alert('with LoadTemplate() method','the CharSet argument is not a string.');
				$HtmlCharSet = '';
			}
			$this->HtmlCharSet = $HtmlCharSet;
			}
		}
		// Automatic fields and blocks
		$this->meth_Merge_AutoOn($this->Source,'onload',true,true);
	}
	// Plug-ins
	if ($this->_PlugIns_Ok and isset($ArgLst) and isset($this->_piAfterLoadTemplate)) $Ok = $this->meth_PlugIn_RunAll($this->_piAfterLoadTemplate,$ArgLst);
	return $Ok;
}

function GetBlockSource($BlockName,$List=false,$KeepDefTags=true) {
	$RetVal = array();
	$Nbr = 0;
	$Pos = 0;
	$FieldOutside = false;
	$P1 = false;
	$Mode = ($KeepDefTags) ? 3 : 2;
	while ($Loc = $this->meth_Locator_FindBlockNext($this->Source,$BlockName,$Pos,'.',$Mode,$P1,$FieldOutside)) {
		$P1 = false;
		$Nbr++;
		$RetVal[$Nbr] = $Loc->BlockSrc;
		if (!$List) return $RetVal[$Nbr];
		$Pos = $Loc->PosEnd;
	}
	if ($List) {
		return $RetVal;
	} else {
		return false;
	}
}

function MergeBlock($BlockLst,$SrcId,$Query='') {
	if ($SrcId==='cond') {
		$Nbr = 0;
		$BlockLst = explode(',',$BlockLst);
		foreach ($BlockLst as $Block) {
			$Block = trim($Block);
			if ($Block!=='') $Nbr += $this->meth_Merge_AutoOn($this->Source,$Block,false,false);
		}
		return $Nbr;
	} else {
		return $this->meth_Merge_Block($this->Source,$BlockLst,$SrcId,$Query,false,0);
	}
}

function MergeField($NameLst,$Value=null,$IsUserFct=false) {

	$FctCheck = $IsUserFct;
	if ($PlugIn = isset($this->_piOnMergeField)) $ArgPi = array('','',&$Value,0,&$this->Source,0,0);
	$SubStart = 0;
	$Ok = true;

	$NameLst = explode(',',$NameLst);
	foreach ($NameLst as $Name) {
		$Name = trim($Name);
		if ($Name==='') continue;
		if ($this->meth_Merge_AutoAny($Name)) continue;
		if ($PlugIn) $ArgPi[0] = $Name;
		$PosBeg = 0;
		// Initilize the user function (only once)
		if ($FctCheck) {
			$FctInfo = $Value;
			$ErrMsg = false;
			if (!$this->meth_Misc_UserFctCheck($FctInfo,$ErrMsg,false)) return $this->meth_Misc_Alert('with MergeField() method',$ErrMsg);
			$FctArg = array('','');
			$SubStart = false;
			$FctCheck = false;
		}
		while ($Loc = $this->meth_Locator_FindTbs($this->Source,$Name,$PosBeg,'.')) {
			// Apply user function
			if ($IsUserFct) {
				$FctArg[0] =& $Loc->SubName; $FctArg[1] =& $Loc->PrmLst;
				$Value = call_user_func_array($FctInfo,$FctArg);
			}
			// Plug-ins
			if ($PlugIn) {
				$ArgPi[1] = $Loc->SubName; $ArgPi[3] =& $Loc->PrmLst; $ArgPi[5] =& $Loc->PosBeg; $ArgPi[6] =& $Loc->PosEnd;
				$Ok = $this->meth_PlugIn_RunAll($this->_piOnMergeField,$ArgPi);
			}
			// Merge the field
			if ($Ok) {
				$PosBeg = $this->meth_Locator_Replace($this->Source,$Loc,$Value,$SubStart);
			} else {
				$PosBeg = $Loc->PosEnd;
			}
		}
	}
}

function Show($Render=false) {
	$Ok = true;
	if ($Render===false) $Render = $this->Render;
	if ($this->_PlugIns_Ok) {
		if (isset($this->_piBeforeShow) or isset($this->_piAfterShow)) {
			// Plug-ins
			$ArgLst = func_get_args();
			$ArgLst[0] =& $Render;
			if (isset($this->_piBeforeShow)) $Ok = $this->meth_PlugIn_RunAll($this->_piBeforeShow,$ArgLst);
		}
	}
	if ($Ok!==false) {
		$this->meth_Merge_AutoAny('onshow');
		$this->meth_Merge_AutoAny('var');
	}
	if ($this->_PlugIns_Ok and isset($ArgLst) and isset($this->_piAfterShow)) $this->meth_PlugIn_RunAll($this->_piAfterShow,$ArgLst);
	if (($Render & TBS_OUTPUT)==TBS_OUTPUT) echo $this->Source;
	if (($this->_Mode==0) and (($Render & TBS_EXIT)==TBS_EXIT)) exit;
	return $Ok;
}

function PlugIn($Prm1,$Prm2=0) {

	if (is_numeric($Prm1)) {
		switch ($Prm1) {
		case TBS_INSTALL:
			$PlugInId = $Prm2;
	  	// Try to install the plug-in
			if (isset($this->_PlugIns[$PlugInId])) {
				return $this->meth_Misc_Alert('with PlugIn() method','plug-in \''.$PlugInId.'\' is already installed.');
			} else {
				$ArgLst = func_get_args();
				array_shift($ArgLst); array_shift($ArgLst);
				return $this->meth_PlugIn_Install($PlugInId,$ArgLst,false);
			}
		case TBS_ISINSTALLED:
	  	// Check if the plug-in is installed
			return isset($this->_PlugIns[$Prm2]);
		case -4: // Deactivate special plug-ins
			$this->_PlugIns_Ok_save = $this->_PlugIns_Ok;
			$this->_PlugIns_Ok = false;
			return true;
		case -5: // Deactivate OnFormat
			$this->_piOnFrm_Ok_save = $this->_piOnFrm_Ok;
			$this->_piOnFrm_Ok = false;
			return true;
		case -10:  // Restore
			$this->_PlugIns_Ok = $this->_PlugIns_Ok_save;
			$this->_piOnFrm_Ok = $this->_piOnFrm_Ok_save;
			return true;
		}

  } elseif (is_string($Prm1)) {
  	// Plug-in's command
  	$PlugInId = $Prm1;
		if (!isset($this->_PlugIns[$PlugInId])) {
			if (!$this->meth_PlugIn_Install($PlugInId,array(),true)) return false;
		}
		if (!isset($this->_piOnCommand[$PlugInId])) return $this->meth_Misc_Alert('with PlugIn() method','plug-in \''.$PlugInId.'\' can\'t run any command because the OnCommand event is not defined or activated.');
		$ArgLst = func_get_args();
		array_shift($ArgLst);
		$Ok = call_user_func_array($this->_piOnCommand[$PlugInId],$ArgLst);
		if (is_null($Ok)) $Ok = true;
		return $Ok;
  }
	return $this->meth_Misc_Alert('with PlugIn() method','\''.$Prm1.'\' is an invalid plug-in key, the type of the value is \''.gettype($Prm1).'\'.');

}

// *-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-*-

function meth_Locator_FindTbs(&$Txt,$Name,$Pos,$ChrSub) {
// Find a TBS Locator

	$PosEnd = false;
	$PosMax = strlen($Txt) -1;
	$Start = $this->_ChrOpen.$Name;

	do {
		// Search for the opening char
		if ($Pos>$PosMax) return false;
		$Pos = strpos($Txt,$Start,$Pos);

		// If found => next chars are analyzed
		if ($Pos===false) {
			return false;
		} else {
			$Loc =& new clsTbsLocator;
			$ReadPrm = false;
			$PosX = $Pos + strlen($Start);
			$x = $Txt[$PosX];

			if ($x===$this->_ChrClose) {
				$PosEnd = $PosX;
			} elseif ($x===$ChrSub) {
				$Loc->SubOk = true; // it is no longer the false value
				$ReadPrm = true;
				$PosX++;
			} elseif (strpos(';',$x)!==false) {
				$ReadPrm = true;
				$PosX++;
			} else {
				$Pos++;
			}

			if ($ReadPrm) {
				tbs_Locator_PrmRead($Txt,$PosX,false,'\'',$this->_ChrOpen,$this->_ChrClose,$Loc,$PosEnd);
				if ($PosEnd===false) {
					$this->meth_Misc_Alert('','can\'t found the end of the tag \''.substr($Txt,$Pos,$PosX-$Pos+10).'...\'.');
					$Pos++;
				}
			}

		}

	} while ($PosEnd===false);

	$Loc->PosBeg = $Pos;
	$Loc->PosEnd = $PosEnd;
	if ($Loc->SubOk) {
		$Loc->FullName = $Name.'.'.$Loc->SubName;
		$Loc->SubLst = explode('.',$Loc->SubName);
		$Loc->SubNbr = count($Loc->SubLst);
	} else {
		$Loc->FullName = $Name;
	}
	if ($ReadPrm and isset($Loc->PrmLst['comm'])) {
		$Loc->PosBeg0 = $Loc->PosBeg;
		$Loc->PosEnd0 = $Loc->PosEnd;
		$comm = $Loc->PrmLst['comm'];
		if (($comm===true) or ($comm==='')) {
			$Loc->Enlarged = tbs_Locator_EnlargeToStr($Txt,$Loc,'<!--' ,'-->');
		} else {
			$Loc->Enlarged = tbs_Locator_EnlargeToTag($Txt,$Loc,$comm,false);
		}
	}

	return $Loc;

}

// Search and cache TBS locators founded in $Txt.
function meth_Locator_SectionCache(&$LocR,$Bid) {

	$LocR->BlockChk[$Bid] = false;

	$LocLst =& $LocR->BlockLoc[$Bid];
	$Txt =& $LocR->BlockSrc[$Bid];
	$BlockName =& $LocR->BlockName[$Bid];

	$Pos = 0;
	$PrevEnd = -1;
	$Nbr = 0;
	while ($Loc = $this->meth_Locator_FindTbs($Txt,$BlockName,$Pos,'.')) {
		if (($Loc->SubName==='#') or ($Loc->SubName==='$')) {
			$Loc->IsRecInfo = true;
			$Loc->RecInfo = $Loc->SubName;
			$Loc->SubName = '';
		} else {
			$Loc->IsRecInfo = false;
		}
		if ($Loc->PosBeg>$PrevEnd) {
			// The previous tag is not embeding => increment
			$Nbr++;
		} else {
			// The previous tag is embeding => no increment, then previous is over writed
			$LocR->BlockChk[$Bid] = true;
		}
		$PrevEnd = $Loc->PosEnd;
		if ($Loc->Enlarged) { // Parameter 'comm'
			$Pos = $Loc->PosBeg0+1;
			$Loc->Enlarged = false;
		} else {
			$Pos = $Loc->PosBeg+1;
		}
		$LocLst[$Nbr] = $Loc;
	}

	$LocLst[0] = $Nbr;

}

function meth_Locator_Replace(&$Txt,&$Loc,&$Value,$SubStart) {
// This function enables to merge a locator with a text and returns the position just after the replaced block
// This position can be useful because we don't know in advance how $Value will be replaced.

	// Found the value if there is a subname
	if (($SubStart!==false) and $Loc->SubOk) {
		for ($i=$SubStart;$i<$Loc->SubNbr;$i++) {
			$x = $Loc->SubLst[$i]; // &$Loc... brings an error with Event Example, I don't know why.
			if (is_array($Value)) {
				if (isset($Value[$x])) {
					$Value =& $Value[$x];
				} elseif (array_key_exists($x,$Value)) {// can happens when value is NULL
					$Value =& $Value[$x];
				} else {
					if (!isset($Loc->PrmLst['noerr'])) $this->meth_Misc_Alert($Loc,'item \''.$x.'\' is not an existing key in the array.',true);
					unset($Value); $Value = ''; break;
				}
			} elseif (is_object($Value)) {
				$ArgLst = tbs_Misc_CheckArgLst($x);
				if (method_exists($Value,$x)) {
					$x = call_user_func_array(array(&$Value,$x),$ArgLst);
				} elseif (property_exists($Value,$x)) {
					$x =& $Value->$x;
				} else {
					if (!isset($Loc->PrmLst['noerr'])) $this->meth_Misc_Alert($Loc,'item '.$x.'\' is neither a method nor a property in the class \''.get_class($Value).'\'.',true);
					unset($Value); $Value = ''; break;
				}
				$Value =& $x; unset($x); $x = '';
			} else {
				if (!isset($Loc->PrmLst['noerr'])) $this->meth_Misc_Alert($Loc,'item before \''.$x.'\' is neither an object nor an array. Its type is '.gettype($Value).'.',true);
				unset($Value); $Value = ''; break;
			}
		}
	}

	$CurrVal = $Value; // Unlink

	if (isset($Loc->PrmLst['onformat'])) {
		if ($Loc->FirstMerge) {
			$Loc->OnFrmInfo = $Loc->PrmLst['onformat'];
			$Loc->OnFrmArg = array(&$Loc->FullName,'',&$Loc->PrmLst,&$this);
			$ErrMsg = false;
			if (!$this->meth_Misc_UserFctCheck($Loc->OnFrmInfo,$ErrMsg,false)) {
				unset($Loc->PrmLst['onformat']);
				if (!isset($Loc->PrmLst['noerr'])) $this->meth_Misc_Alert($Loc,'(parameter onformat) '.$ErrMsg);
				$Loc->OnFrmInfo = 'pi'; // Execute the function pi() just to avoid extra error messages 
			}
		}
		$Loc->OnFrmArg[1] =& $CurrVal;
		if (isset($Loc->PrmLst['subtpl'])) {
			$this->meth_Misc_ChangeMode(true,$Loc,$CurrVal);
			call_user_func_array($Loc->OnFrmInfo,$Loc->OnFrmArg);
			$this->meth_Misc_ChangeMode(false,$Loc,$CurrVal);
			$Loc->ConvProtect = false;
			$Loc->ConvHtml = false;
		} else {
			call_user_func_array($Loc->OnFrmInfo,$Loc->OnFrmArg);
		}
	}

	if ($Loc->FirstMerge) {
		if (isset($Loc->PrmLst['frm'])) {
			$Loc->ConvMode = 0; // Frm
			$Loc->ConvProtect = false;
		} else {
			// Analyze parameter 'htmlconv'
			if (isset($Loc->PrmLst['htmlconv'])) {
				$x = strtolower($Loc->PrmLst['htmlconv']);
				$x = '+'.str_replace(' ','',$x).'+';
				if (strpos($x,'+esc+')!==false)  {tbs_Misc_ConvSpe($Loc); $Loc->ConvHtml = false; $Loc->ConvEsc = true; }
				if (strpos($x,'+wsp+')!==false)  {tbs_Misc_ConvSpe($Loc); $Loc->ConvWS = true; }
				if (strpos($x,'+js+')!==false)   {tbs_Misc_ConvSpe($Loc); $Loc->ConvHtml = false; $Loc->ConvJS = true; }
				if (strpos($x,'+no+')!==false)   $Loc->ConvHtml = false;
				if (strpos($x,'+yes+')!==false)  $Loc->ConvHtml = true;
				if (strpos($x,'+nobr+')!==false) {$Loc->ConvHtml = true; $Loc->ConvBr = false; }
			} else {
				if ($this->HtmlCharSet===false) $Loc->ConvHtml = false; // No HTML
			}
			// Analyze parameter 'protect'
			if (isset($Loc->PrmLst['protect'])) {
				$x = strtolower($Loc->PrmLst['protect']);
				if ($x==='no') {
					$Loc->ConvProtect = false;
				} elseif ($x==='yes') {
					$Loc->ConvProtect = true;
				}
			} elseif ($this->Protect===false) {
				$Loc->ConvProtect = false;
			}
		}
		if ($Loc->Ope = isset($Loc->PrmLst['ope'])) {
			$ope = $Loc->PrmLst['ope'];
			if ($ope==='list') {
				$Loc->OpeId = 1;
				$Loc->OpeSep = (isset($Loc->PrmLst['valsep'])) ? $Loc->PrmLst['valsep'] : ',';
			} else {
				$x = substr($ope,0,4);
				if ($x==='max:') {
					$Loc->OpeId = (isset($Loc->PrmLst['maxhtml'])) ? 2 : 3;
					$Loc->OpeN = intval(trim(substr($ope,4)));
					$Loc->OpeEnd = (isset($Loc->PrmLst['maxend'])) ? $Loc->PrmLst['maxend'] : '...';
					if ($Loc->OpeN<=0) $Loc->Ope = false;
				} elseif ($x==='mod:') {
					$Loc->OpeId = 4; $Loc->OpeN = intval(trim(substr($ope,4)));
				} elseif ($x==='add:') {
					$Loc->OpeId = 5; $Loc->OpeN = intval(trim(substr($ope,4)));
				} elseif (isset($this->_piOnOperation)) {
					$Loc->OpeId = 0;
					$Loc->OpeArg = array(&$Loc->FullName,&$CurrVal,&$Loc->PrmLst,&$Txt,$Loc->PosBeg,$Loc->PosEnd,&$Loc);
				} else {
					$Loc->Ope = false;
					if (!isset($Loc->PrmLst['noerr'])) $this->meth_Misc_Alert($Loc,'parameter ope doesn\'t support value \''.$ope.'\'.',true);
				}
			}
		}
		$Loc->FirstMerge = false;
	}
	$ConvProtect = $Loc->ConvProtect;

	// Plug-in OnFormat
	if ($this->_piOnFrm_Ok) {
		if (isset($Loc->OnFrmArgPi)) {
			$Loc->OnFrmArgPi[1] =& $CurrVal;
		} else {
			$Loc->OnFrmArgPi = array(&$Loc->FullName,&$CurrVal,&$Loc->PrmLst,&$this);
		}
		$this->meth_PlugIn_RunAll($this->_piOnFormat,$Loc->OnFrmArgPi);
	}

	// Operation
	if ($Loc->Ope) {
		switch ($Loc->OpeId) {
		case 0: 
			$Loc->OpeArg[1] =& $CurrVal; $Loc->OpeArg[3] =& $Txt;
			if (!$this->meth_PlugIn_RunAll($this->_piOnOperation,$Loc->OpeArg)) return $Loc->PosBeg;
			break;
		case 1: if (is_array($CurrVal)) $CurrVal = implode($Loc->OpeSep,$CurrVal); break;
		case 2: if (strlen(''.$CurrVal)>$Loc->OpeN) tbs_Html_Max($CurrVal,$Loc->OpeN,$Loc->OpeEnd); break;
		case 3: if (strlen(''.$CurrVal)>$Loc->OpeN) $CurrVal = substr(''.$CurrVal,0,$Loc->OpeN).$Loc->OpeEnd; break;
		case 4: $CurrVal = intval($CurrVal) % $Loc->OpeN; break;
		case 5: $CurrVal = intval($CurrVal) + $Loc->OpeN; break;
		}
	}

	// HTML conversion or format
	if ($Loc->ConvMode===1) { // Html simple
		if (!is_string($CurrVal)) $CurrVal = @strval($CurrVal);
		if ($Loc->ConvHtml) {
			$this->meth_Conv_Html($CurrVal);
			if ($Loc->ConvBr) $CurrVal = nl2br($CurrVal);
		}
	} elseif ($Loc->ConvMode===0) { // Format
		$CurrVal = $this->meth_Misc_Format($CurrVal,$Loc->PrmLst);
	} elseif ($Loc->ConvMode===2) { // Html special
		if (!is_string($CurrVal)) $CurrVal = @strval($CurrVal);
		if ($Loc->ConvHtml) {
			$this->meth_Conv_Html($CurrVal);
			if ($Loc->ConvBr) $CurrVal = nl2br($CurrVal);
		}
		if ($Loc->ConvEsc) $CurrVal = str_replace('\'','\'\'',$CurrVal);
		if ($Loc->ConvWS) {
			$check = '  ';
			$nbsp = '&nbsp;';
			do {
				$pos = strpos($CurrVal,$check);
				if ($pos!==false) $CurrVal = substr_replace($CurrVal,$nbsp,$pos,1);
			} while ($pos!==false);
		}
		if ($Loc->ConvJS) {
			$CurrVal = addslashes($CurrVal); // apply to ('), ("), (\) and (null)
			$CurrVal = str_replace("\n",'\n',$CurrVal);
			$CurrVal = str_replace("\r",'\r',$CurrVal);
			$CurrVal = str_replace("\t",'\t',$CurrVal);
		}
	}

	// if/then/else process, there may be several if/then
	if ($Loc->PrmIfNbr) {
		$z = false;
		$i = 1;
		while ($i!==false) {
			if ($Loc->PrmIfVar[$i]) $Loc->PrmIfVar[$i] = $this->meth_Merge_AutoVar($Loc->PrmIf[$i],true);
			$x = str_replace($this->_ChrVal,$CurrVal,$Loc->PrmIf[$i]);
			if (tbs_Misc_CheckCondition($x)) {
				if (isset($Loc->PrmThen[$i])) {
					if ($Loc->PrmThenVar[$i]) $Loc->PrmThenVar[$i] = $this->meth_Merge_AutoVar($Loc->PrmThen[$i],true);
					$z = $Loc->PrmThen[$i];
				}
				$i = false;
			} else {
				$i++;
				if ($i>$Loc->PrmIfNbr) {
					if (isset($Loc->PrmLst['else'])) {
						if ($Loc->PrmElseVar) $Loc->PrmElseVar = $this->meth_Merge_AutoVar($Loc->PrmLst['else'],true);
						$z =$Loc->PrmLst['else'];
					}
					$i = false;
				}
			}
		}
		if ($z!==false) {
			if ($ConvProtect) {
				$CurrVal = str_replace($this->_ChrOpen,$this->_ChrProtect,$CurrVal); // TBS protection
				$ConvProtect = false;
			}
			$CurrVal = str_replace($this->_ChrVal,$CurrVal,$z);
		}
	}

	if (isset($Loc->PrmLst['file'])) {
		$x = $Loc->PrmLst['file'];
		if ($x===true) $x = $CurrVal;
		$this->meth_Merge_AutoVar($x,false);
		$x = trim(str_replace($this->_ChrVal,$CurrVal,$x));
		$CurrVal = '';
		if ($x!=='') {
			if (tbs_Misc_GetFile($CurrVal,$x)) {
				if (isset($Loc->PrmLst['getbody'])) $CurrVal = tbs_Html_GetPart($CurrVal,$Loc->PrmLst['getbody'],false,true);
			} else {
				if (!isset($Loc->PrmLst['noerr'])) $this->meth_Misc_Alert($Loc,'the file \''.$x.'\' given by parameter file is not found or not readable.',true);
			}
			$ConvProtect = false;
		}
	}

	if (isset($Loc->PrmLst['script'])) {// Include external PHP script
		$x = $Loc->PrmLst['script'];
		if ($x===true) $x = $CurrVal;
		$this->meth_Merge_AutoVar($x,false);
		$x = trim(str_replace($this->_ChrVal,$CurrVal,$x));
		if ($x!=='') {
			$this->_Subscript = $x;
			$this->CurrPrm =& $Loc->PrmLst;
			$sub = isset($Loc->PrmLst['subtpl']);
			if ($sub) $this->meth_Misc_ChangeMode(true,$Loc,$CurrVal);
			if ($this->meth_Misc_RunSubscript($CurrVal,$Loc->PrmLst)===false) {
				if (!isset($Loc->PrmLst['noerr'])) $this->meth_Misc_Alert($Loc,'the file \''.$x.'\' given by parameter script is not found or not readable.',true);
			}
			if ($sub) $this->meth_Misc_ChangeMode(false,$Loc,$CurrVal);
			if (isset($Loc->PrmLst['getbody'])) $CurrVal = tbs_Html_GetPart($CurrVal,$Loc->PrmLst['getbody'],false,true);
			unset($this->CurrPrm);
			$ConvProtect = false;
		}
	}

	// Case when it's an empty string
	if ($CurrVal==='') {

		if ($Loc->MagnetId===false) {
			if (isset($Loc->PrmLst['.'])) {
				$Loc->MagnetId = -1;
			} elseif (isset($Loc->PrmLst['ifempty'])) {
				$Loc->MagnetId = -2;
			} elseif (isset($Loc->PrmLst['magnet'])) {
				$Loc->MagnetId = 1;
				$Loc->PosBeg0 = $Loc->PosBeg;
				$Loc->PosEnd0 = $Loc->PosEnd;
				if (isset($Loc->PrmLst['mtype'])) {
					switch ($Loc->PrmLst['mtype']) {
					case 'm+m': $Loc->MagnetId = 2; break;
					case 'm*': $Loc->MagnetId = 3; break;
					case '*m': $Loc->MagnetId = 4; break;
					}
				}
			} else {
				$Loc->MagnetId = 0;
			}
		}

		switch ($Loc->MagnetId) {
		case 0: break;
		case -1: $CurrVal = '&nbsp;'; break; // Enables to avoid blanks in HTML tables
		case -2: $CurrVal = $Loc->PrmLst['ifempty']; break;
		case 1:
			$Loc->Enlarged = true;
			tbs_Locator_EnlargeToTag($Txt,$Loc,$Loc->PrmLst['magnet'],false);
			break;
		case 2:
			$Loc->Enlarged = true;
			$CurrVal = tbs_Locator_EnlargeToTag($Txt,$Loc,$Loc->PrmLst['magnet'],true);
			break;
		case 3:
			$Loc->Enlarged = true;
			$Loc2 = tbs_Html_FindTag($Txt,$Loc->PrmLst['magnet'],true,$Loc->PosBeg,false,1,false);
			if ($Loc2!==false) {
				$Loc->PosBeg = $Loc2->PosBeg;
				if ($Loc->PosEnd<$Loc2->PosEnd) $Loc->PosEnd = $Loc2->PosEnd;
			}
			break;
		case 4:
			$Loc->Enlarged = true;
			$Loc2 = tbs_Html_FindTag($Txt,$Loc->PrmLst['magnet'],true,$Loc->PosBeg,true,1,false);
			if ($Loc2!==false) $Loc->PosEnd = $Loc2->PosEnd;
			break;
		}
		$NewEnd = $Loc->PosBeg; // Useful when mtype='m+m'
	} else {

		if ($ConvProtect) $CurrVal = str_replace($this->_ChrOpen,$this->_ChrProtect,$CurrVal); // TBS protection
		$NewEnd = $Loc->PosBeg + strlen($CurrVal);

	}

	$Txt = substr_replace($Txt,$CurrVal,$Loc->PosBeg,$Loc->PosEnd-$Loc->PosBeg+1);
	return $NewEnd; // Return the new end position of the field

}

function meth_Locator_FindBlockNext(&$Txt,$BlockName,$PosBeg,$ChrSub,$Mode,&$P1,&$FieldBefore) {
// Return the first block locator just after the PosBeg position
// Mode = 1 : Merge_Auto => doesn't save $Loc->BlockSrc, save the bounds of TBS Def tags instead, return also fields
// Mode = 2 : FindBlockLst or GetBlockSource => save $Loc->BlockSrc without TBS Def tags
// Mode = 3 : GetBlockSource => save $Loc->BlockSrc with TBS Def tags

	$SearchDef = true;
	$FirstField = false;

	// Search for the first tag with parameter "block"
	while ($SearchDef and ($Loc = $this->meth_Locator_FindTbs($Txt,$BlockName,$PosBeg,$ChrSub))) {
		if (isset($Loc->PrmLst['block'])) {
			if ($P1) {
				if (isset($Loc->PrmLst['p1'])) return false;
			} else {
				if (isset($Loc->PrmLst['p1'])) $P1 = true;
			}
			$Block = $Loc->PrmLst['block'];
			$SearchDef = false;
		} elseif ($Mode===1) {
			return $Loc;
		} elseif ($FirstField===false) {
			$FirstField = $Loc;
		}
		$PosBeg = $Loc->PosEnd;
	}

	if ($SearchDef) {
		if ($FirstField!==false) $FieldBefore = true;
		return false;
	}

	if ($Block==='begin') { // Block definied using begin/end

		if (($FirstField!==false) and ($FirstField->PosEnd<$Loc->PosBeg)) $FieldBefore = true;

		$Opened = 1;
		while ($Loc2 = $this->meth_Locator_FindTbs($Txt,$BlockName,$PosBeg,$ChrSub)) {
			if (isset($Loc2->PrmLst['block'])) {
				switch ($Loc2->PrmLst['block']) {
				case 'end':   $Opened--; break;
				case 'begin': $Opened++; break;
				}
				if ($Opened==0) {
					if ($Mode===1) {
						$Loc->PosBeg2 = $Loc2->PosBeg;
						$Loc->PosEnd2 = $Loc2->PosEnd;
					} else {
						if ($Mode===2) {
							$Loc->BlockSrc = substr($Txt,$Loc->PosEnd+1,$Loc2->PosBeg-$Loc->PosEnd-1);
						} else {
							$Loc->BlockSrc = substr($Txt,$Loc->PosBeg,$Loc2->PosEnd-$Loc->PosBeg+1);
						}
						$Loc->PosEnd = $Loc2->PosEnd;
						$Loc->PosDef = 0;
					}
					$Loc->BlockFound = true;
					return $Loc;
				}
			}
			$PosBeg = $Loc2->PosEnd;
		}

		return $this->meth_Misc_Alert($Loc,'a least one tag with parameter \'block=end\' is missing.',false,'in block\'s definition');

	}

	if ($Mode===1) {
		$Loc->PosBeg2 = false;
	} else {

		$Loc->PosDef = $Loc->PosBeg;
		if (!$Loc->SubOk) {
			$PosBeg1 = $Loc->PosBeg;
			$PosEnd1 = $Loc->PosEnd;
		}
		if (tbs_Locator_EnlargeToTag($Txt,$Loc,$Block,false)===false) return $this->meth_Misc_Alert($Loc,'tag <'.$Loc->PrmLst['block'].'> or </'.$Loc->PrmLst['block'].'> is not found.',false,'in block\'s definition');
		$Loc->PosDef = $Loc->PosDef - $Loc->PosBeg;
		if ($Loc->SubOk or ($Mode===3)) {
			$Loc->BlockSrc = substr($Txt,$Loc->PosBeg,$Loc->PosEnd-$Loc->PosBeg+1);
			$Loc->PosDef++;
		} else {
			$Loc->BlockSrc = substr($Txt,$Loc->PosBeg,$PosBeg1-$Loc->PosBeg).substr($Txt,$PosEnd1+1,$Loc->PosEnd-$PosEnd1);
		}
	}

	$Loc->BlockFound = true;
	if (($FirstField!==false) and ($FirstField->PosEnd<$Loc->PosBeg)) $FieldBefore = true;
	return $Loc; // methods return by ref by default

}

function meth_Locator_FindBlockLst(&$Txt,$BlockName,$Pos,$SpePrm) {
// Return a locator object covering all block definitions, even if there is no block definition found.

	$LocR =& new clsTbsLocator;
	$LocR->P1 = false;
	$LocR->FieldOutside = false;
	$LocR->BlockNbr = 0; // Any section (normal, nodata, when, serial, condition, grp, ...)
	$LocR->BlockSrc = array();  // 1 to BlockNbr
	$LocR->BlockLoc = array();  // idem
	$LocR->BlockChk = array();  // idem
	$LocR->BlockName = array(); // idem
	$LocR->BlockPrm = array();  // idem. Provided only for plug-ins.
	$LocR->NoDataBid = false;
	$LocR->SpecialBid = false;
	$LocR->HeaderFound = false;
	$LocR->FooterFound = false;
	$LocR->WhenFound = false;
	$LocR->WhenDefaultBid = false;
	$LocR->SectionNbr = 0; // Normal section
	$LocR->SectionBid = array();       // 1 to SectionNbr
	$LocR->SectionIsSerial = array();  // idem
	$LocR->SectionSerialBid = array(); // idem
	$LocR->SectionSerialOrd = array(); // idem
	$LocR->SerialEmpty = false;

	$Bid =& $LocR->BlockNbr;
	$Sid =& $LocR->SectionNbr;
	$Pid = 0;

	do {

		if ($BlockName==='') {
			$Loc = false;
		} else {
			$Loc = $this->meth_Locator_FindBlockNext($Txt,$BlockName,$Pos,'.',2,$LocR->P1,$LocR->FieldOutside);
		}

		if ($Loc===false) {

			if ($Pid>0) { // parentgrp mode => disconnect $Txt from the source
				$Src = $Txt;
				$Txt =& $Parent[$Pid]['txt'];
				if ($LocR->BlockFound) {
					// Redefine the Header block
					$i = $Parent[$Pid]['bid'];
					$LocR->BlockSrc[$i] = substr($Src,0,$LocR->PosBeg);
					// Add a Footer block
					tbs_Locator_SectionAddBlk($LocR,$BlockName,substr($Src,$LocR->PosEnd+1),$LocR->BlockPrm[$i]);
					tbs_Locator_SectionAddGrp($LocR,$Bid,'F',$Parent[$Pid]['fld']);
				}
				// Now gowing down to previous level
				$Pos = $Parent[$Pid]['pos'];
				$LocR->PosBeg = $Parent[$Pid]['beg'];
				$LocR->PosEnd = $Parent[$Pid]['end'];
				$LocR->BlockFound = true;
				unset($Parent[$Pid]);
				$Pid--;
				$Loc = true;
			}

		} else {

			$Pos = $Loc->PosEnd;

			// Define the block limits
			if ($LocR->BlockFound) {
				if ( $LocR->PosBeg > $Loc->PosBeg ) $LocR->PosBeg = $Loc->PosBeg;
				if ( $LocR->PosEnd < $Loc->PosEnd ) $LocR->PosEnd = $Loc->PosEnd;
			} else {
				$LocR->BlockFound = true;
				$LocR->PosBeg = $Loc->PosBeg;
				$LocR->PosEnd = $Loc->PosEnd;
			}

			// Merge block parameters
			if (count($Loc->PrmLst)>0) $LocR->PrmLst = array_merge($LocR->PrmLst,$Loc->PrmLst);

			// Save the block and cache its tags (incrments $LocR->BlockNbr)
			tbs_Locator_SectionAddBlk($LocR,$BlockName,$Loc->BlockSrc,$Loc->PrmLst);

			// Add the text in the list of blocks
			if (isset($Loc->PrmLst['nodata'])) { // Nodata section
				$LocR->NoDataBid = $Bid;
			} elseif (($SpePrm!==false) and isset($Loc->PrmLst[$SpePrm])) { // Special section (used for navigation bar)
				$LocR->SpecialBid = $Bid;
			} elseif (isset($Loc->PrmLst['when'])) {
				if ($LocR->WhenFound===false) {
					$LocR->WhenFound = true;
					$LocR->WhenSeveral = false;
					$LocR->WhenNbr = 0;
					$LocR->WhenSectionBid[] = array(); // Bid of the section to display
					$LocR->WhenCondBid[] = array();    // Bid of the condition to check
					$LocR->WhenBeforeNS[] = array();   // True if the When section must be displayed before a 
				}
				$LocR->WhenNbr++;
				if (isset($Loc->PrmLst['several'])) $LocR->WhenSeveral = true;
				$LocR->WhenSectionBid[$LocR->WhenNbr] = $Bid;
				$this->meth_Merge_AutoVar($Loc->PrmLst['when'],false);
				tbs_Locator_SectionAddBlk($LocR,$BlockName,$Loc->PrmLst['when'],array());
				$LocR->WhenCondBid[$LocR->WhenNbr] = $Bid;
				$LocR->WhenBeforeNS[$LocR->WhenNbr] = ($Sid===0);
			} elseif (isset($Loc->PrmLst['default'])) {
				$LocR->WhenDefaultBid = $Bid;
				$LocR->WhenDefaultBeforeNS = ($Sid===0);
			} elseif (isset($Loc->PrmLst['headergrp'])) {
				tbs_Locator_SectionAddGrp($LocR,$Bid,'H',$Loc->PrmLst['headergrp']);
			} elseif (isset($Loc->PrmLst['footergrp'])) {
				tbs_Locator_SectionAddGrp($LocR,$Bid,'F',$Loc->PrmLst['footergrp']);
			} elseif (isset($Loc->PrmLst['splittergrp'])) {
				tbs_Locator_SectionAddGrp($LocR,$Bid,'S',$Loc->PrmLst['splittergrp']);
			} elseif (isset($Loc->PrmLst['parentgrp'])) {
				tbs_Locator_SectionAddGrp($LocR,$Bid,'H',$Loc->PrmLst['parentgrp']);
				$Pid++;
				$Parent[$Pid]['bid'] = $Bid;
				$Parent[$Pid]['fld'] = $Loc->PrmLst['parentgrp'];
				$Parent[$Pid]['txt'] =& $Txt;
				$Parent[$Pid]['pos'] = $Pos;
				$Parent[$Pid]['beg'] = $LocR->PosBeg;
				$Parent[$Pid]['end'] = $LocR->PosEnd;
				$Txt =& $LocR->BlockSrc[$Bid];
				$Pos = $Loc->PosDef + 1;
				$LocR->BlockFound = false;
				$LocR->PosBeg = false;
				$LocR->PosEnd = false;
			} elseif (isset($Loc->PrmLst['serial'])) {
				// Section	with Serial Sub-Sections
				$Src =& $LocR->BlockSrc[$Bid];
				$Loc0 = false;
				if ($LocR->SerialEmpty===false) {
					$NameSr = $BlockName.'_0';
					$x = false;
					$LocSr = $this->meth_Locator_FindBlockNext($Src,$NameSr,0,'.',2,$x,$x);
					if ($LocSr!==false) {
						$LocR->SerialEmpty = $LocSr->BlockSrc;
						$Src = substr_replace($Src,'',$LocSr->PosBeg,$LocSr->PosEnd-$LocSr->PosBeg+1);
					}
				}
				$NameSr = $BlockName.'_1';
				$x = false;
				$LocSr = $this->meth_Locator_FindBlockNext($Src,$NameSr,0,'.',2,$x,$x);
				if ($LocSr!==false) {
					$Sid++;
					$LocR->SectionBid[$Sid] = $Bid;
					$LocR->SectionIsSerial[$Sid] = true;
					$LocR->SectionSerialBid[$Sid] = array();
					$LocR->SectionSerialOrd[$Sid] = array();
					$SrBid =& $LocR->SectionSerialBid[$Sid];
					$SrOrd =& $LocR->SectionSerialOrd[$Sid];
					$BidParent = $Bid;
					$SrNum = 1;
					do {
						// Save previous sub-section
						$LocR->BlockLoc[$BidParent][$SrNum] = $LocSr;
						tbs_Locator_SectionAddBlk($LocR,$NameSr,$LocSr->BlockSrc,$LocSr->PrmLst);
						$SrBid[$SrNum] = $Bid;
						$SrOrd[$SrNum] = $SrNum;
						$i = $SrNum;
						while (($i>1) and ($LocSr->PosBeg<$LocR->BlockLoc[$BidParent][$SrOrd[$i-1]]->PosBeg)) {
							$SrOrd[$i] = $SrOrd[$i-1];
							$SrOrd[$i-1] = $SrNum;
							$i--;
						}
						// Search next section
						$SrNum++;
						$NameSr = $BlockName.'_'.$SrNum;
						$x = false;
						$LocSr = $this->meth_Locator_FindBlockNext($Src,$NameSr,0,'.',2,$x,$x);
					} while ($LocSr!==false);
					$SrBid[0] = $SrNum-1;
				}
			} else {
				// Normal section
				$Sid++;
				$LocR->SectionBid[$Sid] = $Bid;
				$LocR->SectionIsSerial[$Sid] = false;
			}

		}

	} while ($Loc!==false);

	if ($LocR->WhenFound and ($Sid===0)) {
		// Add a blank section if When is used without a normal section
		tbs_Locator_SectionAddBlk($LocR,$BlockName,'',array());
		$Sid++;
		$LocR->SectionBid[$Sid] = $Bid;
		$LocR->SectionIsSerial[$Sid] = false;
	}

	// Calculate Cache
	if ($this->TurboBlock) {
		for ($i=1;$i<=$LocR->BlockNbr;$i++) {
			$this->meth_Locator_SectionCache($LocR,$i);
		}
	}

	return $LocR; // methods return by ref by default

}

function meth_Merge_Block(&$Txt,&$BlockLst,&$SrcId,&$Query,$SpePrm,$SpeRecNum) {

	$BlockSave = $this->_CurrBlock;
	$this->_CurrBlock = $BlockLst;

	// Get source type and info
	$Src =& new clsTbsDataSource;
	if (!$Src->DataPrepare($SrcId,$this)) {
		$this->_CurrBlock = $BlockSave;
		return 0;
	}

	$BlockLst = explode(',',$BlockLst);
	$BlockNbr = count($BlockLst);
	$BlockId = 0;
	$WasP1 = false;
	$NbrRecTot = 0;
	$QueryZ =& $Query;
	$ReturnData = false;

	while ($BlockId<$BlockNbr) {

		$RecSpe = 0;  // Row with a special block's definition (used for the navigation bar)
		$QueryOk = true;
		$this->_CurrBlock = trim($BlockLst[$BlockId]);
		if ($this->_CurrBlock==='*') {
			$ReturnData = true;
			if ($Src->RecSaved===false) $Src->RecSaving = true;
			$this->_CurrBlock = '';
		}

		// Search the block
		$LocR = $this->meth_Locator_FindBlockLst($Txt,$this->_CurrBlock,0,$SpePrm);

		if ($WasP1) $this->meth_Merge_FieldOutside($Txt,$Src,$LocR);

		if ($LocR->BlockFound) {
			if ($LocR->SpecialBid!==false) $RecSpe = $SpeRecNum;
			// OnData
			if ($Src->OnDataPrm = isset($LocR->PrmLst['ondata'])) {
				$Src->OnDataPrmRef = $LocR->PrmLst['ondata'];
				if (isset($Src->OnDataPrmDone[$Src->OnDataPrmRef])) {
					$Src->OnDataPrm = false;
				} else {
					$ErrMsg = false;
					if ($this->meth_Misc_UserFctCheck($Src->OnDataPrmRef,$ErrMsg,false)) {
						$Src->OnDataOk = true;
					} else {
						$LocR->FullName = $this->_CurrBlock;
						$Src->OnDataPrm = $this->meth_Misc_Alert($LocR,'(parameter ondata) '.$ErrMsg,false,'block');
					}
				}
			}
			// Dynamic query
			if ($LocR->P1) {
				if (is_string($Query)) {
					$Src->RecSaved = false;
					unset($QueryZ); $QueryZ = ''.$Query;
					$i = 1;
					do {
						$x = 'p'.$i;
						if (isset($LocR->PrmLst[$x])) {
							$QueryZ = str_replace('%p'.$i.'%',$LocR->PrmLst[$x],$QueryZ);
							$i++;
						} else {
							$i = false;
						}
					} while ($i!==false);
				}
				$WasP1 = true;
			} elseif (($Src->RecSaved===false) and ($BlockNbr-$BlockId>1)) {
				$Src->RecSaving = true;
			}
		} elseif ($WasP1) {
			$QueryOk = false;
			$WasP1 = false;
		}

		// Open the recordset
		if ($QueryOk) {
			if ((!$LocR->BlockFound) and (!$LocR->FieldOutside)) {
				// Special case: return data without any block to merge 
				$QueryOk = false;
				if ($ReturnData and (!$Src->RecSaved)) {
					if ($Src->DataOpen($QueryZ)) {
						do {$Src->DataFetch();} while ($Src->CurrRec!==false);
						$Src->DataClose();
					}
				}
			}	else {
				$QueryOk = $Src->DataOpen($QueryZ);
			}
		}

		// Merge sections
		if ($QueryOk) {
			if ($Src->Type===4) { // Special for Text merge
				if ($LocR->BlockFound) {
					$Src->RecNum = 1;
					$Src->CurrRec = false;
					$Txt = substr_replace($Txt,$Src->RecSet,$LocR->PosBeg,$LocR->PosEnd-$LocR->PosBeg+1);
				} else {
					$Src->DataAlert('can\'t merge the block with a text value because the block definition is not found.');
				}
			} elseif ($LocR->BlockFound===false) {
				$Src->DataFetch(); // Merge first record only
			} else {
				$this->meth_Merge_BlockSections($Txt,$LocR,$Src,$RecSpe);
			}
			$Src->DataClose(); // Close the resource
		}

		if (!$WasP1) {
			$NbrRecTot += $Src->RecNum;
			if ($LocR->FieldOutside and $QueryOk) {
				$LocR->BlockFound = false; // Cancel Loc limit
				$this->meth_Merge_FieldOutside($Txt,$Src,$LocR);
			}
			$BlockId++;
		}

	}

	// End of the merge
	unset($LocR);
	$this->_CurrBlock = $BlockSave;
	if ($ReturnData) {
		return $Src->RecSet;
	} else {
		unset($Src);
		return $NbrRecTot;
	}

}

function meth_Merge_BlockSections(&$Txt,&$LocR,&$Src,&$RecSpe) {

	// Initialise
	$SecId = 0;
	$SecOk = ($LocR->SectionNbr>0);
	$SecIncr = true;
	$SecSrc = '';
	$BlockRes = ''; // The result of the chained merged blocks
	$SerialMode = false;
	$SerialNum = 0;
	$SerialMax = 0;
	$SerialTxt = array();
	$GrpFound = ($LocR->HeaderFound or $LocR->FooterFound);
	$piOMS = false;

  // Plug-ins
	if ($this->_PlugIns_Ok and isset($this->_piBeforeMergeBlock)) {
		$ArgLst = array(&$Txt,&$LocR->PosBeg,&$LocR->PosEnd,$LocR->PrmLst,&$Src,&$LocR);
		$this->meth_Plugin_RunAll($this->_piBeforeMergeBlock,$ArgLst);
	}
	if ($this->_PlugIns_Ok and isset($this->_piOnMergeSection)) {
		$ArgLst = array(&$BlockRes,&$SecSrc);
		$piOMS = true;
	}

	// Main loop
	$Src->DataFetch();
	while($Src->CurrRec!==false) {

		// Headers and Footers
		if ($GrpFound) {
			$grp_change = false;
			$grp_src = '';
			if ($LocR->FooterFound) {
				$change = false;
				for ($i=$LocR->FooterNbr;$i>=1;$i--) {
					$x = $Src->CurrRec[$LocR->FooterField[$i]];
					if ($Src->RecNum===1) {
						$LocR->FooterPrevValue[$i] = $x;
					} else {
						if ($LocR->FooterIsFooter[$i]) {
							$change_i =& $change;
						} else {
							unset($change_i); $change_i = false;
						}
						if (!$change_i) $change_i = !($LocR->FooterPrevValue[$i]===$x);
						if ($change_i) {
							$grp_change = true;
							$grp_src = $this->meth_Merge_SectionNormal($LocR,$LocR->FooterBid[$i],$PrevRec,$PrevNum,$PrevKey).$grp_src;
							$LocR->FooterPrevValue[$i] = $x;
						}
					}
				}
				$PrevRec = $Src->CurrRec;
				$PrevNum = $Src->RecNum;
				$PrevKey = $Src->RecKey;
			}
			if ($LocR->HeaderFound) {
				$change = ($Src->RecNum===1);
				for ($i=1;$i<=$LocR->HeaderNbr;$i++) {
					$x = $Src->CurrRec[$LocR->HeaderField[$i]];
					if (!$change) $change = !($LocR->HeaderPrevValue[$i]===$x);
					if ($change) {
						$grp_src .= $this->meth_Merge_SectionNormal($LocR,$LocR->HeaderBid[$i],$Src->CurrRec,$Src->RecNum,$Src->RecKey);
						$LocR->HeaderPrevValue[$i] = $x;
					}
				}
				$grp_change = ($grp_change or $change);
			}
			if ($grp_change) {
				if ($SerialMode) {
					$BlockRes .= $this->meth_Merge_SectionSerial($LocR,$SecId,$SerialNum,$SerialMax,$SerialTxt);
					$SecIncr = true;
				}
				$BlockRes .= $grp_src;
			}
		} // end of header and footer

		// Increment Section
		if ($SecIncr and $SecOk) {
			$SecId++;
			if ($SecId>$LocR->SectionNbr) $SecId = 1;
			$SerialMode = $LocR->SectionIsSerial[$SecId];
			if ($SerialMode) {
				$SerialNum = 0;
				$SerialMax = $LocR->SectionSerialBid[$SecId][0];
				$SecIncr = false;
			}
		}

		// Serial Mode Activation
		if ($SerialMode) { // Serial Merge
			$SerialNum++;
			$Bid = $LocR->SectionSerialBid[$SecId][$SerialNum];
			$SerialTxt[$SerialNum] = $this->meth_Merge_SectionNormal($LocR,$Bid,$Src->CurrRec,$Src->RecNum,$Src->RecKey);
			if ($SerialNum>=$SerialMax) {
				$SecSrc = $this->meth_Merge_SectionSerial($LocR,$SecId,$SerialNum,$SerialMax,$SerialTxt);
				$BlockRes .= $SecSrc;
				$SecIncr = true;
			}
		} else { // Classic merge
			if ($SecOk) {
				if ($Src->RecNum===$RecSpe) {
					$Bid = $LocR->SpecialBid;
				} else {
					$Bid = $LocR->SectionBid[$SecId];
				}
				$SecSrc = $this->meth_Merge_SectionNormal($LocR,$Bid,$Src->CurrRec,$Src->RecNum,$Src->RecKey);
			} else {
				$SecSrc = '';
			}
			if ($LocR->WhenFound) { // With conditional blocks
				$found = false;
				$continue = true;
				$i = 1;
				do {
					$cond = $this->meth_Merge_SectionNormal($LocR,$LocR->WhenCondBid[$i],$Src->CurrRec,$Src->RecNum,$Src->RecKey);
					if (tbs_Misc_CheckCondition($cond)) {
						$x_when = $this->meth_Merge_SectionNormal($LocR,$LocR->WhenSectionBid[$i],$Src->CurrRec,$Src->RecNum,$Src->RecKey);
						if ($LocR->WhenBeforeNS[$i]) {$SecSrc = $x_when.$SecSrc;} else {$SecSrc = $SecSrc.$x_when;}
						$found = true;
						if ($LocR->WhenSeveral===false) $continue = false;
					}
					$i++;
					if ($i>$LocR->WhenNbr) $continue = false;
				} while ($continue);
				if (($found===false) and ($LocR->WhenDefaultBid!==false)) {
					$x_when = $this->meth_Merge_SectionNormal($LocR,$LocR->WhenDefaultBid,$Src->CurrRec,$Src->RecNum,$Src->RecKey);
					if ($LocR->WhenDefaultBeforeNS) {$SecSrc = $x_when.$SecSrc;} else {$SecSrc = $SecSrc.$x_when;}
				}
			}
			if ($piOMS) $this->meth_PlugIn_RunAll($this->_piOnMergeSection,$ArgLst);
			$BlockRes .= $SecSrc;
		}

		// Next row
		$Src->DataFetch();

	} //--> while($CurrRec!==false) {

	$SecSrc = '';

	// Serial: merge the extra the sub-blocks
	if ($SerialMode and !$SecIncr) {
		$SecSrc .= $this->meth_Merge_SectionSerial($LocR,$SecId,$SerialNum,$SerialMax,$SerialTxt);
	}

	// Footer
	if ($LocR->FooterFound) {
		if ($Src->RecNum>0) {
			for ($i=1;$i<=$LocR->FooterNbr;$i++) {
				if ($LocR->FooterIsFooter[$i]) $SecSrc .= $this->meth_Merge_SectionNormal($LocR,$LocR->FooterBid[$i],$PrevRec,$PrevNum,$PrevKey);
			}
		}
	}

	// NoData
	if ($Src->RecNum===0) {
		if ($LocR->NoDataBid!==false) {
			$SecSrc = $LocR->BlockSrc[$LocR->NoDataBid];
		} elseif(isset($LocR->PrmLst['bmagnet'])) {
			tbs_Locator_EnlargeToTag($Txt,$LocR,$LocR->PrmLst['bmagnet'],false);
		}
	}

	// Plug-ins
	if ($piOMS and ($SecSrc!=='')) $this->meth_PlugIn_RunAll($this->_piOnMergeSection,$ArgLst);

	$BlockRes .= $SecSrc;

	// Plug-ins
	if ($this->_PlugIns_Ok and isset($ArgLst) and isset($this->_piAfterMergeBlock)) {
		$ArgLst = array(&$BlockRes,&$Src,&$LocR);
		$this->meth_PlugIn_RunAll($this->_piAfterMergeBlock,$ArgLst);
	}

	// Merge the result
	$Txt = substr_replace($Txt,$BlockRes,$LocR->PosBeg,$LocR->PosEnd-$LocR->PosBeg+1);

}

function meth_Merge_AutoVar(&$Txt,$HtmlConv) {
// Merge [var.*] fields with global variables

	$Pref =& $this->VarPrefix;
	$PrefL = strlen($Pref);
	$PrefOk = ($PrefL>0);

	if ($HtmlConv===false) {
		$HtmlCharSet = $this->HtmlCharSet;
		$this->HtmlCharSet = false;
	}

	// Then we scann all fields in the model
	$x = '';
	$Pos = 0;
	while ($Loc = $this->meth_Locator_FindTbs($Txt,'var',$Pos,'.')) {
		if ($Loc->SubNbr==0) $Loc->SubLst[0]=''; // In order to force error message
		if ($Loc->SubLst[0]==='') {
			$Pos = $this->meth_Merge_AutoSpe($Txt,$Loc);
		} elseif ($Loc->SubLst[0][0]==='~') {
			if (!isset($ObjOk)) $ObjOk = (is_object($this->ObjectRef) or is_array($this->ObjectRef));
			if ($ObjOk) {
				$Loc->SubLst[0] = substr($Loc->SubLst[0],1);
				$Pos = $this->meth_Locator_Replace($Txt,$Loc,$this->ObjectRef,0);
			} elseif ($this->NoErr or isset($Loc->PrmLst['noerr'])) {
				$Pos = $this->meth_Locator_Replace($Txt,$Loc,$x,false);
			} else {
				$this->meth_Misc_Alert($Loc,'property ObjectRef is neither an object nor an array. Its type is \''.gettype($this->ObjectRef).'\'.',true);
				$Pos = $Loc->PosEnd + 1;
			}
		} elseif ($PrefOk and (substr($Loc->SubLst[0],0,$PrefL)!==$Pref)) {
			if ($this->NoErr or isset($Loc->PrmLst['noerr'])) {
				$Pos = $this->meth_Locator_Replace($Txt,$Loc,$x,false);
			} else {
				$this->meth_Misc_Alert($Loc,'does not match the allowed prefix.',true);
				$Pos = $Loc->PosEnd + 1;
			}
		} elseif (isset($GLOBALS[$Loc->SubLst[0]])) {
			$Pos = $this->meth_Locator_Replace($Txt,$Loc,$GLOBALS[$Loc->SubLst[0]],1);
		} else {
			if ($this->NoErr or isset($Loc->PrmLst['noerr'])) {
				$Pos = $this->meth_Locator_Replace($Txt,$Loc,$x,false);
			} else {
				$Pos = $Loc->PosEnd + 1;
				$this->meth_Misc_Alert($Loc,'the PHP global variable named \''.$Loc->SubLst[0].'\' does not exist or is not set yet.',true);
			}
		}
	}

	if ($HtmlConv===false) $this->HtmlCharSet = $HtmlCharSet;

	return false; // Useful property PrmIfVar & PrmThenVar

}

function meth_Merge_AutoSpe(&$Txt,&$Loc) {
// Merge [var..*] (Special Var Fields)

	$ErrMsg = false;
	$SubStart = false;
	if (isset($Loc->SubLst[1])) {
		switch ($Loc->SubLst[1]) {
		case 'now': $x = mktime(); break;
		case 'version': $x = $this->Version; break;
		case 'script_name': $x = tbs_Misc_GetFilePart(((isset($_SERVER)) ? $_SERVER['PHP_SELF'] : $GLOBALS['HTTP_SERVER_VARS']['PHP_SELF'] ),1); break;
		case 'template_name': $x = $this->_LastFile; break;
		case 'template_date': $x = filemtime($this->_LastFile); break;
		case 'template_path': $x = tbs_Misc_GetFilePart($this->_LastFile,0); break;
		case 'name': $x = 'TinyButStrong'; break;
		case 'logo': $x = '**TinyButStrong**'; break;
		case 'charset': $x = $this->HtmlCharSet; break;
		case '': $ErrMsg = 'it doesn\'t have any keyword.'; break;
		case 'tplvars':
			if ($Loc->SubNbr==2) {
				$SubStart = 2;
				$x = implode(',',array_keys($this->TplVars));
			} else {
				if (isset($this->TplVars[$Loc->SubLst[2]])) {
					$SubStart = 3;
					$x =& $this->TplVars[$Loc->SubLst[2]];
				} else {
					$ErrMsg = 'property TplVars doesn\'t have any item named \''.$Loc->SubLst[2].'\'.';
				}
			}
			break;
		default:
			$IsSupported = false;
			if (isset($this->_piOnSpecialVar)) {
				$x = '';
				$ArgLst = array(substr($Loc->SubName,1),&$IsSupported ,&$x, &$Loc->PrmLst,&$Txt,&$Loc->PosBeg,&$Loc->PosEnd,&$Loc);
				$this->meth_PlugIn_RunAll($this->_piOnSpecialVar,$ArgLst) ;
			}
			if (!$IsSupported) $ErrMsg = '\''.$Loc->SubLst[1].'\' is an unsupported keyword.';
		}
	} else {
		$ErrMsg = 'it doesn\'t have any subname.';
	}
	if ($ErrMsg!==false) {
		$this->meth_Misc_Alert($Loc,$ErrMsg);
		$x = '';
	}
	if ($Loc->PosBeg===false) {
		return $Loc->PosEnd;
	} else {
		return $this->meth_Locator_Replace($Txt,$Loc,$x,$SubStart);
	}
}

function meth_Merge_AutoAny($Name) {
// Merge any automatic fields (var, onload, onshow)
	switch ($Name) {
	case 'var':	$this->meth_Merge_AutoVar($this->Source,true); return true;
	case 'onload': $this->meth_Merge_AutoOn($this->Source,'onload',true,true); return true;
	case 'onshow': $this->meth_Merge_AutoOn($this->Source,'onshow',false,true);return true;
	default: return false;
	}
}

function meth_Merge_FieldOutside(&$Txt,&$Src,&$LocR) {
	$Pos = 0;
	$SubStart = ($Src->CurrRec===false) ? false : 0;
	do {
		$Loc = $this->meth_Locator_FindTbs($Txt,$this->_CurrBlock,$Pos,'.');
		if ($LocR->BlockFound and ($Loc!==false)) {
			$OldEnd = $Loc->PosEnd;
			if ($Loc->PosEnd>=$LocR->PosBeg) $Loc = false;
		}
		if ($Loc!==false) {
			if ($Loc->SubName==='#') {
				$Pos = $this->meth_Locator_Replace($Txt,$Loc,$Src->RecNum,false);
			} else {
				$Pos = $this->meth_Locator_Replace($Txt,$Loc,$Src->CurrRec,$SubStart);
			}
			if ($LocR->BlockFound) {
				$Delta = $Pos - $OldEnd;
				$LocR->PosBeg += $Delta;  
				$LocR->PosEnd += $Delta;  
			}
		}
	} while ($Loc!==false);
}

function meth_Merge_SectionNormal(&$LocR,&$BlockId,&$CurrRec,&$RecNum,&$RecKey) {

	$Txt = $LocR->BlockSrc[$BlockId];
	$LocLst =& $LocR->BlockLoc[$BlockId];
	$iMax = $LocLst[0];
	$PosMax = strlen($Txt);

	if ($RecNum===false) { // Erase all fields

		$x = '';

		// Chached locators
		for ($i=$iMax;$i>0;$i--) {
			if ($LocLst[$i]->PosBeg<$PosMax) {
				$this->meth_Locator_Replace($Txt,$LocLst[$i],$x,false);
				if ($LocLst[$i]->Enlarged) {
					$PosMax = $LocLst[$i]->PosBeg;
					$LocLst[$i]->PosBeg = $LocLst[$i]->PosBeg0;
					$LocLst[$i]->PosEnd = $LocLst[$i]->PosEnd0;
					$LocLst[$i]->Enlarged = false;
				}
			}
		}

		// Unchached locators
		if ($LocR->BlockChk[$BlockId]) {
			$BlockName =& $LocR->BlockName[$BlockId];
			$Pos = 0;
			while ($Loc = $this->meth_Locator_FindTbs($Txt,$BlockName,$Pos,'.')) $Pos = $this->meth_Locator_Replace($Txt,$Loc,$x,false);
		}

	} else {

		// Chached locators
		for ($i=$iMax;$i>0;$i--) {
			if ($LocLst[$i]->PosBeg<$PosMax) {
				if ($LocLst[$i]->IsRecInfo) {
					if ($LocLst[$i]->RecInfo==='#') {
						$this->meth_Locator_Replace($Txt,$LocLst[$i],$RecNum,false);
					} else {
						$this->meth_Locator_Replace($Txt,$LocLst[$i],$RecKey,false);
					}
				} else {
					$this->meth_Locator_Replace($Txt,$LocLst[$i],$CurrRec,0);
				}
				if ($LocLst[$i]->Enlarged) {
					$PosMax = $LocLst[$i]->PosBeg;
					$LocLst[$i]->PosBeg = $LocLst[$i]->PosBeg0;
					$LocLst[$i]->PosEnd = $LocLst[$i]->PosEnd0;
					$LocLst[$i]->Enlarged = false;
				}
			}
		}

		// Unchached locators
		if ($LocR->BlockChk[$BlockId]) {
			$BlockName =& $LocR->BlockName[$BlockId];
			foreach ($CurrRec as $key => $val) {
				$Pos = 0;
				$Name = $BlockName.'.'.$key;
				while ($Loc = $this->meth_Locator_FindTbs($Txt,$Name,$Pos,'.')) $Pos = $this->meth_Locator_Replace($Txt,$Loc,$val,0);
			}
			$Pos = 0;
			$Name = $BlockName.'.#';
			while ($Loc = $this->meth_Locator_FindTbs($Txt,$Name,$Pos,'.')) $Pos = $this->meth_Locator_Replace($Txt,$Loc,$RecNum,0);
			$Pos = 0;
			$Name = $BlockName.'.$';
			while ($Loc = $this->meth_Locator_FindTbs($Txt,$Name,$Pos,'.')) $Pos = $this->meth_Locator_Replace($Txt,$Loc,$RecKey,0);
		}

	}

	return $Txt;

}

function meth_Merge_SectionSerial(&$LocR,&$SecId,&$SerialNum,&$SerialMax,&$SerialTxt) {

	$Txt = $LocR->BlockSrc[$LocR->SectionBid[$SecId]];
	$LocLst =& $LocR->BlockLoc[$LocR->SectionBid[$SecId]];
	$OrdLst =& $LocR->SectionSerialOrd[$SecId];

	// Prepare the Empty Item
	if ($SerialNum<$SerialMax) {
		if ($LocR->SerialEmpty===false) {
			$F = false;
		} else {
			$EmptySrc =& $LocR->SerialEmpty;
		}
	}

	// All Items
	for ($i=$SerialMax;$i>0;$i--) {
		$Sr = $OrdLst[$i];
		if ($Sr>$SerialNum) {
			if ($LocR->SerialEmpty===false) {
				$k = $LocR->SectionSerialBid[$SecId][$Sr];
				$EmptySrc = $this->meth_Merge_SectionNormal($LocR,$k,$F,$F,$F);
			}
			$Txt = substr_replace($Txt,$EmptySrc,$LocLst[$Sr]->PosBeg,$LocLst[$Sr]->PosEnd-$LocLst[$Sr]->PosBeg+1);
		} else {
			$Txt = substr_replace($Txt,$SerialTxt[$Sr],$LocLst[$Sr]->PosBeg,$LocLst[$Sr]->PosEnd-$LocLst[$Sr]->PosBeg+1);
		}
	}

	// Update variables
	$SerialNum = 0;
	$SerialTxt = array();

	return $Txt;

}

function meth_Merge_AutoOn(&$Txt,$Name,$TplVar,$AcceptGrp) {
// Merge [onload] or [onshow] fields and blocks

	$GrpDisplayed = array();
	$GrpExclusive = array();
	$P1 = false;
	$FieldBefore = false;
	$Pos = 0;

	if ($AcceptGrp) {
		$ChrSub = '_';
	} else {
		$ChrSub = '';
	}

	while ($LocA=$this->meth_Locator_FindBlockNext($Txt,$Name,$Pos,$ChrSub,1,$P1,$FieldBefore)) {

		if ($LocA->BlockFound) {

			if (!isset($GrpDisplayed[$LocA->SubName])) {
				$GrpDisplayed[$LocA->SubName] = false;
				$GrpExclusive[$LocA->SubName] = !($AcceptGrp and ($LocA->SubName===''));
			}
			$Displayed =& $GrpDisplayed[$LocA->SubName];
			$Exclusive =& $GrpExclusive[$LocA->SubName];

			$DelBlock = false;
			$DelField = false;
			if ($Displayed and $Exclusive) {
				$DelBlock = true;
			} else {
				if (isset($LocA->PrmLst['when'])) {
					if (isset($LocA->PrmLst['several'])) $Exclusive=false;
					$x = $LocA->PrmLst['when'];
					$this->meth_Merge_AutoVar($x,false);
					if (tbs_Misc_CheckCondition($x)) {
						$DelField = true;
						$Displayed = true;
					} else {
						$DelBlock = true;
					}
				} elseif(isset($LocA->PrmLst['default'])) {
					if ($Displayed) {
						$DelBlock = true;
					} else {
						$Displayed = true;
						$DelField = true;
					}
					$Exclusive = true; // No more block displayed for the group after VisElse
				}
			}

			// Del parts
			if ($DelField) {
				if ($LocA->PosBeg2!==false) $Txt = substr_replace($Txt,'',$LocA->PosBeg2,$LocA->PosEnd2-$LocA->PosBeg2+1);
				$Txt = substr_replace($Txt,'',$LocA->PosBeg,$LocA->PosEnd-$LocA->PosBeg+1);
				$Pos = $LocA->PosBeg;
			} else {
				if ($LocA->PosBeg2===false) {
					tbs_Locator_EnlargeToTag($Txt,$LocA,$LocA->PrmLst['block'],false);
				} else {
					$LocA->PosEnd = $LocA->PosEnd2;
				}
				if ($DelBlock) {
					$Txt = substr_replace($Txt,'',$LocA->PosBeg,$LocA->PosEnd-$LocA->PosBeg+1);
				} else {
					// Merge the block as if it was a field
					$x = '';
					$this->meth_Locator_Replace($Txt,$LocA,$x,false);
				}
				$Pos = $LocA->PosBeg;
			}

		} else { // Field

			// Check for Template Var
			if ($TplVar and	isset($LocA->PrmLst['tplvars'])) {
				$Ok = false;
				foreach ($LocA->PrmLst as $Key => $Val) {
					if ($Ok) {
						$this->TplVars[$Key] = $Val;
					} else {
						if ($Key==='tplvars') $Ok = true;
					}
				}
			}

			$x = '';
			$Pos = $this->meth_Locator_Replace($Txt,$LocA,$x,false);
			$Pos = $LocA->PosBeg;

		}

	}

	return count($GrpDisplayed);

}

// Convert a string to Html with several options
function meth_Conv_Html(&$Txt) {
	if ($this->HtmlCharSet==='') {
		$Txt = htmlspecialchars($Txt); // Faster
	} elseif ($this->_HtmlCharFct) {
		$Txt = call_user_func($this->HtmlCharSet,$Txt);
	} else {
		$Txt = htmlspecialchars($Txt,ENT_COMPAT,$this->HtmlCharSet);
	}
}

// Standard alert message provided by TinyButStrong, return False is the message is cancelled.
function meth_Misc_Alert($Src,$Msg,$NoErrMsg=false,$SrcType=false) {
	if ($this->NoErr) return false;
	if (!is_string($Src)) {
		if ($SrcType===false) $SrcType='in field';
		$Src = $SrcType.' '.$this->_ChrOpen.$Src->FullName.'...'.$this->_ChrClose;
	}
	$x = '<br /><b>TinyButStrong Error</b> '.$Src.' : '.htmlentities($Msg);
	if ($NoErrMsg) $x = $x.' <em>This message can be cancelled using parameter \'noerr\'.</em>';
	$x = $x."<br />\n";
	$x = str_replace($this->_ChrOpen,$this->_ChrProtect,$x);
	echo $x;
	return false;
}

function meth_Misc_ChangeMode($Init,&$Loc,&$CurrVal) {
	if ($Init) {
		// Save contents configuration
		$Loc->SaveSrc =& $this->Source;
		$Loc->SaveRender = $this->Render;
		$Loc->SaveMode = $this->_Mode;
		unset($this->Source); $this->Source = '';
		$this->Render = TBS_OUTPUT;
		$this->_Mode++; // Mode>0 means subtemplate mode
		ob_start(); // Start buffuring output 
	} else {
		// Restore contents configuration
		$this->Source =& $Loc->SaveSrc;
		$this->Render = $Loc->SaveRender;
		$this->_Mode = $Loc->SaveMode;
		$CurrVal = ob_get_contents();
		ob_end_clean();
	}
}

function meth_Misc_UserFctCheck(&$FctInfo,&$ErrMsg,$DataFct) {
	$Ref = ($FctInfo[0]==='~');
	if (isset($this->_UserFctLst[$FctInfo])) {
		if ($Ref) $FctInfo = $this->_UserFctLst[$FctInfo];
		return true;
	}
	$FctStr = $FctInfo;
	if ($Ref) {
		$ObjRef =& $this->ObjectRef;
		$Lst = explode('.',substr($FctStr,1));
		$iMax = count($Lst) - 1;
		$Suff = 'tbsdb';
		$iMax0 = $iMax;
		if ($DataFct) {
			$Suff = $Lst[$iMax];
			$iMax--;
		}
		// Reading sub items
		for ($i=0;$i<=$iMax;$i++) {
			$x =& $Lst[$i];
			if (is_object($ObjRef)) {
				$ArgLst = tbs_Misc_CheckArgLst($x);
				if (method_exists($ObjRef,$x)) {
					if ($i<$iMax) {
						$f = array(&$ObjRef,$x); unset($ObjRef);
						$ObjRef = call_user_func_array($f,$ArgLst);
					}
				} elseif ($i===$iMax0) {
					$ErrMsg = 'Expression \''.$FctStr.'\' is invalid because \''.$x.'\' is not a method in the class \''.get_class($ObjRef).'\'.';
					return false;
				} elseif (isset($ObjRef->$x)) {
					$ObjRef =& $ObjRef->$x;
				} else {
					$ErrMsg = 'Expression \''.$FctStr.'\' is invalid because sub-item \''.$x.'\' is neither a method nor a property in the class \''.get_class($ObjRef).'\'.';
					return false;
				}
			} elseif (($i<$iMax0) and is_array($ObjRef)) {
				if (isset($ObjRef[$x])) {
					$ObjRef =& $ObjRef[$x];
				} else {
					$ErrMsg = 'Expression \''.$FctStr.'\' is invalid because sub-item \''.$x.'\' is not a existing key in the array.';
					return false;
				}
			} else {
				$ErrMsg = 'Expression \''.$FctStr.'\' is invalid because '.(($i===0)?'property ObjectRef':'sub-item \''.$x.'\'').' is not an object'.(($i<$iMax)?' or an array.':'.');
				return false;
			}
		}
		// Referencing last item
		if ($DataFct) {
			$FctInfo = array(0=>'open',1=>'fetch',2=>'close');
			foreach ($FctInfo as $i=>$x) {
				$FctName = $Suff.'_'.$x;
				if (method_exists($ObjRef,$FctName)) {
					$FctInfo[$i] = array(&$ObjRef,$FctName);
				} else {
					$ErrMsg = 'Expression \''.$FctStr.'\' is invalid because method '.$FctName.' is not found.';
					return false;
				}
			}
		} else {
			$FctInfo = array(&$ObjRef,$x);
		}
		$this->_UserFctLst[$FctStr] =& $FctInfo;
	} else {
		if (!function_exists($FctStr)) {
			$x = explode('.',$FctStr);
			if (count($x)==2) {
				if (class_exists($x[0])) {
					$FctInfo = $x;
				} else {
					$ErrMsg = 'user function \''.$FctStr.'\' is not correct because \''.$x[0].'\' is not a class name.'; return false;
				}
			} else {
				$ErrMsg = 'user function \''.$FctStr.'\' is not found.'; return false;
			}
		}
		$this->_UserFctLst[$FctStr] = true;
	}
	return true;
}

function meth_Misc_RunSubscript(&$CurrVal,$CurrPrm) {
// Run a subscript without any local variable damage
	return @include($this->_Subscript);
}

function meth_PlugIn_RunAll(&$FctBank,&$ArgLst) {
	$OkAll = true;
	foreach ($FctBank as $FctInfo) {
		$Ok = call_user_func_array($FctInfo,$ArgLst);
		if (!is_null($Ok)) $OkAll = ($OkAll and $Ok);
	}
	return $OkAll;
}

function meth_PlugIn_Install($PlugInId,$ArgLst,$Auto) {

	$ErrMsg = 'with plug-in \''.$PlugInId.'\'';

	if (class_exists($PlugInId)) {
		// Create an instance
		$IsObj = true;
		$PiRef = new $PlugInId;
		$PiRef->TBS =& $this;
		if (!method_exists($PiRef,'OnInstall')) return $this->meth_Misc_Alert($ErrMsg,'OnInstall() method is not found.');
		$FctRef = array(&$PiRef,'OnInstall');
	} else {
		$FctRef = 'tbspi_'.$PlugInId.'_OnInstall';
		if(function_exists($FctRef)) {
			$IsObj = false;
			$PiRef = true;
		} else {
			return $this->meth_Misc_Alert($ErrMsg,'no class named \''.$PlugInId.'\' is found, and no function named \''.$FctRef.'\' is found.');
		}
	}

	$EventLst = call_user_func_array($FctRef,$ArgLst);
	if (is_string($EventLst)) $EventLst = explode(',',$EventLst);
	if (!is_array($EventLst)) return $this->meth_Misc_Alert($ErrMsg,'OnInstall() method does not return an array.');

	// Add activated methods
	$EventRef = explode(',','OnCommand,BeforeLoadTemplate,AfterLoadTemplate,BeforeShow,AfterShow,OnData,OnFormat,OnOperation,BeforeMergeBlock,OnMergeSection,AfterMergeBlock,OnSpecialVar,OnMergeField');
	foreach ($EventLst as $Event) {
		$Event = trim($Event);
		if (!in_array($Event,$EventRef)) return $this->meth_Misc_Alert($ErrMsg,'OnInstall() method return an unknowed plug-in event named \''.$Event.'\' (case-sensitive).');
		if ($IsObj) {
			if (!method_exists($PiRef,$Event)) return $this->meth_Misc_Alert($ErrMsg,'OnInstall() has returned a Plug-in event named \''.$Event.'\' which is not found.');
			$FctRef = array(&$PiRef,$Event);
		} else {
			$FctRef = 'tbspi_'.$PlugInId.'_'.$Event;
			if (!function_exists($FctRef)) return $this->meth_Misc_Alert($ErrMsg,'requiered function \''.$FctRef.'\' is not found.');
		}
		// Save information into the corresponding property
		$PropName = '_pi'.$Event;
		if (!isset($this->$PropName)) $this->$PropName = array();
		$PropRef =& $this->$PropName;
		$PropRef[$PlugInId] = $FctRef;
		// Flags saying if a plugin is installed
		switch ($Event) {
		case 'OnCommand': break;
		case 'OnSpecialVar': break;
		case 'OnOperation': break;
		case 'OnFormat': $this->_piOnFrm_Ok = true; break;
		default: $this->_PlugIns_Ok = true; break;
		}
	}

	$this->_PlugIns[$PlugInId] =& $PiRef;
	return true;

}

function meth_Misc_Format(&$Value,&$PrmLst) {
// This function return the formated representation of a Date/Time or numeric variable using a 'VB like' format syntax instead of the PHP syntax.

	$FrmStr = $PrmLst['frm'];
	$CheckNumeric = true;
	if (is_string($Value)) $Value = trim($Value);

	// Manage Multi format strings
	if (strpos($FrmStr,'|')!==false) {

		// Save the format if it doesn't exist
		if (isset($this->_FrmMultiLst[$FrmStr])) {
			$FrmLst =& $this->_FrmMultiLst[$FrmStr];
		} else {
			$FrmLst = explode('|',$FrmStr); // syntax : Postive|Negative|Zero|Null
			$FrmNbr = count($FrmLst);
			$FrmLst['abs'] = ($FrmNbr>1);
			if ($FrmNbr<3) $FrmLst[2] =& $FrmLst[0]; // zero
			if ($FrmNbr<4) $FrmLst[3] = ''; // null
			$this->_FrmMultiLst[$FrmStr] = $FrmLst;
		}

		// Select the format
		if (is_numeric($Value)) {
			if (is_string($Value)) $Value = 0.0 + $Value;
			if ($Value>0) {
				$FrmStr =& $FrmLst[0];
			} elseif ($Value<0) {
				$FrmStr =& $FrmLst[1];
				if ($FrmLst['abs']) $Value = abs($Value);
			} else { // zero
				$FrmStr =& $FrmLst[2];
				$Minus = '';
			}
			$CheckNumeric = false;
		} else {
			$Value = ''.$Value;
			if ($Value==='') {
				return $FrmLst[3]; // Null value
			} else {
				$t = strtotime($Value); // We look if it's a date
				if (($t===-1) or ($t===false)) { // Date not recognized
					return $FrmLst[1];
				} elseif ($t===943916400) { // Date to zero
					return $FrmLst[2];
				} else { // It's a date
					$Value = $t;
					$FrmStr =& $FrmLst[0];
				}
			}
		}

	}

	if ($FrmStr==='') return '';

	// Retrieve the correct simple format
	if (!isset($this->_FrmSimpleLst[$FrmStr])) $this->meth_Misc_FormatSave($FrmStr);

	$Frm =& $this->_FrmSimpleLst[$FrmStr];

	switch ($Frm['type']) {
	case 'num' :
		// NUMERIC
		if ($CheckNumeric) {
			if (is_numeric($Value)) {
				if (is_string($Value)) $Value = 0.0 + $Value;
			} else {
				return ''.$Value;
			}
		}
		if ($Frm['PerCent']) $Value = $Value * 100;
		$Value = number_format($Value,$Frm['DecNbr'],$Frm['DecSep'],$Frm['ThsSep']);
		return substr_replace($FrmStr,$Value,$Frm['Pos'],$Frm['Len']);
		break;
	case 'date' :
		// DATE
		if (is_string($Value)) {
			if ($Value==='') return '';
			$x = strtotime($Value);
			if (($x===-1) or ($x===false)) {
				if (!is_numeric($Value)) $Value = 0;
			} else {
				$Value =& $x;
			}
		} else {
			if (!is_numeric($Value)) return ''.$Value;
		}
		if (isset($PrmLst['locale'])) {
			return strftime($Frm['str_loc'],$Value);
		} else {
			return date($Frm['str_us'],$Value);
		}
		break;
	default:
		return $Frm['string'];
		break;
	}

}

function meth_Misc_FormatSave(&$FrmStr) {

	$nPosEnd = strrpos($FrmStr,'0');

	if ($nPosEnd!==false) {

		// Numeric format
		$nDecSep = '.';
		$nDecNbr = 0;
		$nDecOk = true;

		if (substr($FrmStr,$nPosEnd+1,1)==='.') {
			$nPosEnd++;
			$nPosCurr = $nPosEnd;
		} else {
			$nPosCurr = $nPosEnd - 1;
			while (($nPosCurr>=0) and ($FrmStr[$nPosCurr]==='0')) {
				$nPosCurr--;
			}
			if (($nPosCurr>=1) and ($FrmStr[$nPosCurr-1]==='0')) {
				$nDecSep = $FrmStr[$nPosCurr];
				$nDecNbr = $nPosEnd - $nPosCurr;
			} else {
				$nDecOk = false;
			}
		}

		// Thousand separator
		$nThsSep = '';
		if (($nDecOk) and ($nPosCurr>=5)) {
			if ((substr($FrmStr,$nPosCurr-3,3)==='000') and ($FrmStr[$nPosCurr-4]!=='') and ($FrmStr[$nPosCurr-5]==='0')) {
				$nPosCurr = $nPosCurr-4;
				$nThsSep = $FrmStr[$nPosCurr];
			}
		}

		// Pass next zero
		if ($nDecOk) $nPosCurr--;
		while (($nPosCurr>=0) and ($FrmStr[$nPosCurr]==='0')) {
			$nPosCurr--;
		}

		// Percent
		$nPerCent = (strpos($FrmStr,'%')===false) ? false : true;

		$this->_FrmSimpleLst[$FrmStr] = array('type'=>'num','Pos'=>($nPosCurr+1),'Len'=>($nPosEnd-$nPosCurr),'ThsSep'=>$nThsSep,'DecSep'=>$nDecSep,'DecNbr'=>$nDecNbr,'PerCent'=>$nPerCent);

	} else { // if ($nPosEnd!==false)

		// Date format
		$FrmPHP = '';
		$FrmLOC = '';
		$Local = false;
		$StrIn = false;
		$iMax = strlen($FrmStr);
		$Cnt = 0;

		for ($i=0;$i<$iMax;$i++) {

			if ($StrIn) {
				// We are in a string part
				if ($FrmStr[$i]===$StrChr) {
					if (substr($FrmStr,$i+1,1)===$StrChr) {
						$FrmPHP .= '\\'.$FrmStr[$i]; // protected char
						$FrmLOC .= $FrmStr[$i];
						$i++;
					} else {
						$StrIn = false;
					}
				} else {
					$FrmPHP .= '\\'.$FrmStr[$i]; // protected char
					$FrmLOC .= $FrmStr[$i];
				}
			} else {
				if (($FrmStr[$i]==='"') or ($FrmStr[$i]==='\'')) {
					// Check if we have the opening string char
					$StrIn = true;
					$StrChr = $FrmStr[$i];
				} else {
					$Cnt++;
					if     (strcasecmp(substr($FrmStr,$i,2),'hh'  )===0) { $FrmPHP .= 'H'; $FrmLOC .= '%H'; $i += 1; }
					elseif (strcasecmp(substr($FrmStr,$i,2),'hm'  )===0) { $FrmPHP .= 'h'; $FrmLOC .= '%I'; $i += 1; }
					elseif (strcasecmp(substr($FrmStr,$i,4),'ampm')===0) { $FrmPHP .= substr($FrmStr,$i,1); $FrmLOC .= '%p'; $i += 3; } // $Fmp = 'A' or 'a'
					elseif (strcasecmp(substr($FrmStr,$i,2),'nn'  )===0) { $FrmPHP .= 'i'; $FrmLOC .= '%M'; $i += 1; }
					elseif (strcasecmp(substr($FrmStr,$i,2),'ss'  )===0) { $FrmPHP .= 's'; $FrmLOC .= '%S'; $i += 1; }
					elseif (strcasecmp(substr($FrmStr,$i,2),'xx'  )===0) { $FrmPHP .= 'S'; $FrmLOC .= ''  ; $i += 1; }
					elseif (strcasecmp(substr($FrmStr,$i,4),'yyyy')===0) { $FrmPHP .= 'Y'; $FrmLOC .= '%Y'; $i += 3; }
					elseif (strcasecmp(substr($FrmStr,$i,2),'yy'  )===0) { $FrmPHP .= 'y'; $FrmLOC .= '%y'; $i += 1; }
					elseif (strcasecmp(substr($FrmStr,$i,4),'mmmm')===0) { $FrmPHP .= 'F'; $FrmLOC .= '%B'; $i += 3; }
					elseif (strcasecmp(substr($FrmStr,$i,3),'mmm' )===0) { $FrmPHP .= 'M'; $FrmLOC .= '%b'; $i += 2; }
					elseif (strcasecmp(substr($FrmStr,$i,2),'mm'  )===0) { $FrmPHP .= 'm'; $FrmLOC .= '%m'; $i += 1; }
					elseif (strcasecmp(substr($FrmStr,$i,1),'m'   )===0) { $FrmPHP .= 'n'; $FrmLOC .= '%m'; }
					elseif (strcasecmp(substr($FrmStr,$i,4),'wwww')===0) { $FrmPHP .= 'l'; $FrmLOC .= '%A'; $i += 3; }
					elseif (strcasecmp(substr($FrmStr,$i,3),'www' )===0) { $FrmPHP .= 'D'; $FrmLOC .= '%a'; $i += 2; }
					elseif (strcasecmp(substr($FrmStr,$i,1),'w'   )===0) { $FrmPHP .= 'w'; $FrmLOC .= '%u'; }
					elseif (strcasecmp(substr($FrmStr,$i,4),'dddd')===0) { $FrmPHP .= 'l'; $FrmLOC .= '%A'; $i += 3; }
					elseif (strcasecmp(substr($FrmStr,$i,3),'ddd' )===0) { $FrmPHP .= 'D'; $FrmLOC .= '%a'; $i += 2; }
					elseif (strcasecmp(substr($FrmStr,$i,2),'dd'  )===0) { $FrmPHP .= 'd'; $FrmLOC .= '%d'; $i += 1; }
					elseif (strcasecmp(substr($FrmStr,$i,1),'d'   )===0) { $FrmPHP .= 'j'; $FrmLOC .= '%d'; }
					else {
						$FrmPHP .= '\\'.$FrmStr[$i]; // protected char
						$FrmLOC .= $FrmStr[$i]; // protected char
						$Cnt--;
					}
				}
			} //-> if ($StrIn) {...} else

		} //-> for ($i=0;$i<$iMax;$i++)

		if ($Cnt>0) {
			$this->_FrmSimpleLst[$FrmStr] = array('type'=>'date','str_us'=>$FrmPHP,'str_loc'=>$FrmLOC);
		} else {
			$this->_FrmSimpleLst[$FrmStr] = array('type'=>'else','string'=>$FrmStr);
		}

	} // if ($nPosEnd!==false) {...} else

}

} // class clsTinyButStrong

// *********************************************

function tbs_Misc_ConvSpe(&$Loc) {
	if ($Loc->ConvMode!==2) {
		$Loc->ConvMode = 2;
		$Loc->ConvEsc = false;
		$Loc->ConvWS = false;
		$Loc->ConvJS = false;
	}
}

function tbs_Misc_CheckArgLst(&$Str) {
	$ArgLst = array();
	if (substr($Str,-1,1)===')') {
		$pos = strpos($Str,'(');
		if ($pos!==false) {
			$ArgLst = explode(',',substr($Str,$pos+1,strlen($Str)-$pos-2));
			$Str = substr($Str,0,$pos);
		}
	}
	return $ArgLst;
}

function tbs_Misc_CheckCondition($Str) {
// Check if an expression like "exrp1=expr2" is true or false.

	// Find operator and position
	$Ope = '=';
	$Len = 1;
	$Max = strlen($Str)-1;
	$Pos = strpos($Str,$Ope);
	if ($Pos===false) {
		$Ope = '+';
		$Pos = strpos($Str,$Ope);
		if ($Pos===false) return false;
		if (($Pos>0) and ($Str[$Pos-1]==='-')) {
			$Ope = '-+'; $Pos--; $Len=2;
		} elseif (($Pos<$Max) and ($Str[$Pos+1]==='-')) {
			$Ope = '+-'; $Len=2;
		} else {
			return false;
		}
	} else {
		if ($Pos>0) {
			$x = $Str[$Pos-1];
			if ($x==='!') {
				$Ope = '!='; $Pos--; $Len=2;
			} elseif ($x==='~') {
				$Ope = '~='; $Pos--; $Len=2;
			} elseif ($Pos<$Max) {
				$y = $Str[$Pos+1];
				if ($y==='=') {
					$Len=2;
				} elseif (($x==='+') and ($y==='-')) {
					$Ope = '+=-'; $Pos--; $Len=3;
				} elseif (($x==='-') and ($y==='+')) {
					$Ope = '-=+'; $Pos--; $Len=3;
				}
			} else {
			}
		}
	}

	// Read values
	$Val1  = trim(substr($Str,0,$Pos));
	$Nude1 = tbs_Misc_DelDelimiter($Val1,'\'');
	$Val2  = trim(substr($Str,$Pos+$Len));
	$Nude2 = tbs_Misc_DelDelimiter($Val2,'\'');

	// Compare values
	if ($Ope==='=') {
		return (strcasecmp($Val1,$Val2)==0);
	} elseif ($Ope==='!=') {
		return (strcasecmp($Val1,$Val2)!=0);
	} elseif ($Ope==='~=') {
		return (preg_match($Val2,$Val1)>0);
	} else {
		if ($Nude1) $Val1 = (float) $Val1;
		if ($Nude2) $Val2 = (float) $Val2;
		if ($Ope==='+-') {
			return ($Val1>$Val2);
		} elseif ($Ope==='-+') {
			return ($Val1 < $Val2);
		} elseif ($Ope==='+=-') {
			return ($Val1 >= $Val2);
		} elseif ($Ope==='-=+') {
			return ($Val1<=$Val2);
		} else {
			return false;
		}
	}

}

function tbs_Misc_DelDelimiter(&$Txt,$Delim) {
// Delete the string delimiters
	$len = strlen($Txt);
	if (($len>1) and ($Txt[0]===$Delim)) {
		if ($Txt[$len-1]===$Delim) $Txt = substr($Txt,1,$len-2);
		return false;
	} else {
		return true;
	}
}

function tbs_Misc_GetFile(&$Txt,$File) {
// Load the content of a file into the text variable.
	$Txt = '';
	$fd = @fopen($File, 'r'); // 'rb' if binary for some OS
	if ($fd===false) return false;
	$fs = @filesize($File); // return False for an URL
	if ($fs===false) {
		while (!feof($fd)) $Txt .= fread($fd,4096);
	} else {
		if ($fs>0) $Txt = fread($fd,$fs);
	}
	fclose($fd);
	return true;
}

function tbs_Misc_GetFilePart($File,$Part) {
	$Pos = strrpos($File,'/');
	if ($Part===0) { // Path
		if ($Pos===false) {
			return '';
		} else {
			return substr($File,0,$Pos+1);
		}
	} else { // File
		if ($Pos===false) {
			return $File;
		} else {
			return substr($File,$Pos+1);
		}
	}
}

function tbs_Locator_SectionAddBlk(&$LocR,$BlockName,$Txt,$PrmLst) {
	$i = ++$LocR->BlockNbr;
	$LocR->BlockName[$i] = $BlockName;
	$LocR->BlockSrc[$i] = $Txt;
	$LocR->BlockLoc[$i] = array(0=>0);
	$LocR->BlockChk[$i] = true;
	$LocR->BlockPrm[$i] = $PrmLst;
	return $i;
}

function tbs_Locator_SectionAddGrp(&$LocR,$Bid,$Type,$Field) {

	if ($Type==='H') {
		if ($LocR->HeaderFound===false) {
			$LocR->HeaderFound = true;
			$LocR->HeaderNbr = 0;
			$LocR->HeaderBid = array();       // 1 to HeaderNbr
			$LocR->HeaderPrevValue = array(); // 1 to HeaderNbr
			$LocR->HeaderField = array();     // 1 to HeaderNbr
		}
		$i = ++$LocR->HeaderNbr;
		$LocR->HeaderBid[$i] = $Bid;
		$LocR->HeaderPrevValue[$i] = false;
		$LocR->HeaderField[$i] = $Field;
	} else {
		if ($LocR->FooterFound===false) {
			$LocR->FooterFound = true;
			$LocR->FooterNbr = 0;
			$LocR->FooterBid = array();       // 1 to FooterNbr
			$LocR->FooterPrevValue = array(); // 1 to FooterNbr
			$LocR->FooterField = array();     // 1 to FooterNbr
			$LocR->FooterIsFooter = array();  // 1 to FooterNbr
		}
		$i = ++$LocR->FooterNbr;
		$LocR->FooterBid[$i] = $Bid;
		$LocR->FooterPrevValue[$i] = false;
		if ($Type==='F') {
			$LocR->FooterField[$i] = $Field;
			$LocR->FooterIsFooter[$i] = true;
		} else {
			$LocR->FooterField[$i] = $Field;
			$LocR->FooterIsFooter[$i] = false;
		}
	}

}

function tbs_Locator_PrmRead(&$Txt,$Pos,$HtmlTag,$DelimChrs,$BegStr,$EndStr,&$Loc,&$PosEnd) {

	$BegLen = strlen($BegStr);
	$BegChr = $BegStr[0];
	$BegIs1 = ($BegLen===1);

	$DelimIdx = false;
	$DelimCnt = 0;
	$DelimChr = '';
	$BegCnt = 0;
	$SubName = $Loc->SubOk;

	$Status = 0; // 0: name not started, 1: name started, 2: name ended, 3: equal found, 4: value started
	$PosName = 0;
	$PosNend = 0;
	$PosVal = 0;

	// Variables for checking the loop
	$PosEnd = strpos($Txt,$EndStr,$Pos);
	if ($PosEnd===false) return;
	$Continue = ($Pos<$PosEnd);

	while ($Continue) {

		$Chr = $Txt[$Pos];

		if ($DelimIdx) { // Reading in the string

			if ($Chr===$DelimChr) { // Quote found
				if ($Chr===$Txt[$Pos+1]) { // Double Quote => the string continue with un-double the quote
					$Pos++;
				} else { // Simple Suote => end of string
					$DelimIdx = false;
				}
			}

		} else { // Reading outside the string

			if ($BegCnt===0) {

				// Analyzing parameters
				$CheckChr = false;
				if (($Chr===' ') or ($Chr==="\r") or ($Chr==="\n")) {
					if ($Status===1) {
						$Status = 2;
						$PosNend = $Pos;
					} elseif ($HtmlTag and ($Status===4)) {
						tbs_Locator_PrmCompute($Txt,$Loc,$SubName,$Status,$HtmlTag,$DelimChr,$DelimCnt,$PosName,$PosNend,$PosVal,$Pos);
						$Status = 0;
					}
				} elseif (($HtmlTag===false) and ($Chr===';')) {
					tbs_Locator_PrmCompute($Txt,$Loc,$SubName,$Status,$HtmlTag,$DelimChr,$DelimCnt,$PosName,$PosNend,$PosVal,$Pos);
					$Status = 0;
				} elseif ($Status===4) {
					$CheckChr = true;
				} elseif ($Status===3) {
					$Status = 4;
					$DelimCnt = 0;
					$PosVal = $Pos;
					$CheckChr = true;
				} elseif ($Status===2) {
					if ($Chr==='=') {
						$Status = 3;
					} elseif ($HtmlTag) {
						tbs_Locator_PrmCompute($Txt,$Loc,$SubName,$Status,$HtmlTag,$DelimChr,$DelimCnt,$PosName,$PosNend,$PosVal,$Pos);
						$Status = 1;
						$PosName = $Pos;
						$CheckChr = true;
					} else {
						$Status = 4;
						$DelimCnt = 0;
						$PosVal = $Pos;
						$CheckChr = true;
					}
				} elseif ($Status===1) {
					if ($Chr==='=') {
						$Status = 3;
						$PosNend = $Pos;
					} else {
						$CheckChr = true;
					}
				} else {
					$Status = 1;
					$PosName = $Pos;
					$CheckChr = true;
				}

				if ($CheckChr) {
					$DelimIdx = strpos($DelimChrs,$Chr);
					if ($DelimIdx===false) {
						if ($Chr===$BegChr) {
							if ($BegIs1) {
								$BegCnt++;
							} elseif(substr($Txt,$Pos,$BegLen)===$BegStr) {
								$BegCnt++;
							}
						}
					} else {
						$DelimChr = $DelimChrs[$DelimIdx];
						$DelimCnt++;
						$DelimIdx = true;
					}
				}

			} else {
				if ($Chr===$BegChr) {
					if ($BegIs1) {
						$BegCnt++;
					} elseif(substr($Txt,$Pos,$BegLen)===$BegStr) {
						$BegCnt++;
					}
				}
			}

		}

		// Next char
		$Pos++;

		// We check if it's the end
		if ($Pos===$PosEnd) {
			if ($DelimIdx===false) {
				if ($BegCnt>0) {
					$BegCnt--;
				} else {
					$Continue = false;
				}
			}
			if ($Continue) {
				$PosEnd = strpos($Txt,$EndStr,$PosEnd+1);
				if ($PosEnd===false) return;
			} else {
				tbs_Locator_PrmCompute($Txt,$Loc,$SubName,$Status,$HtmlTag,$DelimChr,$DelimCnt,$PosName,$PosNend,$PosVal,$Pos);
			}
		}

	}

	$PosEnd = $PosEnd + (strlen($EndStr)-1);

}

function tbs_Locator_PrmCompute(&$Txt,&$Loc,&$SubName,$Status,$HtmlTag,$DelimChr,$DelimCnt,$PosName,$PosNend,$PosVal,$Pos) {

	if ($Status===0) {
		$SubName = false;
	} else {
		if ($Status===1) {
			$x = substr($Txt,$PosName,$Pos-$PosName);
		} else {
			$x = substr($Txt,$PosName,$PosNend-$PosName);
		}
		if ($HtmlTag) $x = strtolower($x);
		if ($SubName) {
			$Loc->SubName = $x;
			$SubName = false;
		} else {
			if ($Status===4) {
				$v = trim(substr($Txt,$PosVal,$Pos-$PosVal));
				if ($DelimCnt===1) { // Delete quotes inside the value
					if ($v[0]===$DelimChr) {
						$len = strlen($v);
						if ($v[$len-1]===$DelimChr) {
							$v = substr($v,1,$len-2);
							$v = str_replace($DelimChr.$DelimChr,$DelimChr,$v);
						}
					}
				}
			} else {
				$v = true;
			}
			if ($x==='if') {
				tbs_Locator_PrmIfThen($Loc,true,$v);
			} elseif ($x==='then') {
				tbs_Locator_PrmIfThen($Loc,false,$v);
			} else {
				$Loc->PrmLst[$x] = $v;
			}
		}
	}

}

function tbs_Locator_PrmIfThen(&$Loc,$IsIf,$Val) {
	$nbr =& $Loc->PrmIfNbr;
	if ($nbr===false) {
		$nbr = 0;
		$Loc->PrmIf = array();
		$Loc->PrmIfVar = array();
		$Loc->PrmThen = array();
		$Loc->PrmThenVar = array();
		$Loc->PrmElseVar = true;
	} 
	if ($IsIf) {
		$nbr++;
		$Loc->PrmIf[$nbr] = $Val;
		$Loc->PrmIfVar[$nbr] = true;
	} else {
		$nbr2 = $nbr;
		if ($nbr2===false) $nbr2 = 1; // Only the first 'then' can be placed before its 'if'. This is for compatibility.
		$Loc->PrmThen[$nbr2] = $Val;
		$Loc->PrmThenVar[$nbr2] = true;
	}
}

function tbs_Locator_EnlargeToStr(&$Txt,&$Loc,$StrBeg,$StrEnd) {
/*
This function enables to enlarge the pos limits of the Locator.
If the search result is not correct, $PosBeg must not change its value, and $PosEnd must be False.
This is because of the calling function.
*/

	// Search for the begining string
	$Pos = $Loc->PosBeg;
	$Ok = false;
	do {
		$Pos = strrpos(substr($Txt,0,$Pos),$StrBeg[0]);
		if ($Pos!==false) {
			if (substr($Txt,$Pos,strlen($StrBeg))===$StrBeg) $Ok = true;
		}
	} while ( (!$Ok) and ($Pos!==false) );

	if ($Ok) {
		$PosEnd = strpos($Txt,$StrEnd,$Loc->PosEnd + 1);
		if ($PosEnd===false) {
			$Ok = false;
		} else {
			$Loc->PosBeg = $Pos;
			$Loc->PosEnd = $PosEnd + strlen($StrEnd) - 1;
		}
	}

	return $Ok;

}

function tbs_Locator_EnlargeToTag(&$Txt,&$Loc,$TagLst,$RetInnerSrc) {
//Modify $Loc, return false if tags not found, returns the inner source of tag if $RetInnerSrc=true

	// Analyze string
	$Ref = 0;
	$LevelStop = 0;
	$TagLst = explode('+',$TagLst);
	$TagIsSgl = array();
  $TagMax = count($TagLst) - 1;
  for ($i=0;$i<=$TagMax;$i++) {
 		do { // Check parentheses, relative position and single tag
 			$tag =& $TagLst[$i];
	  	$tag = trim($tag);
	 		$x = strlen($tag) - 1; // pos of last char
	 		if (($x>1) and ($tag[0]==='(') and ($tag[$x]===')')) {
	 			if ($Ref===0) $Ref = $i;
	 			if ($Ref===$i) $LevelStop++;
	 			$tag = substr($tag,1,$x-1);
	 		} else {
	 			if (($x>=0) and ($tag[$x]==='/')) {
	 				$TagIsSgl[$i] = true;
	 				$tag = substr($tag,0,$x);
	 			} else {
	 				$TagIsSgl[$i] = false;
	 			}
	 			$x = false;
	 		}
 		}	while ($x!==false);
  }

	// Find tags that embeds the locator
	if ($LevelStop===0) $LevelStop = 1;
	$TagO = tbs_Html_FindTag($Txt,$TagLst[$Ref],true,$Loc->PosBeg-1,false,$LevelStop,false);
	if ($TagO===false) return false;
	$PosBeg = $TagO->PosBeg;
	if ($TagIsSgl[$Ref]) {
		$PosEnd = max($Loc->PosEnd,$TagO->PosEnd);
		$InnerLim = $PosEnd + 1;
	} else {
		$TagC = tbs_Html_FindTag($Txt,$TagLst[$Ref],false,$Loc->PosEnd+1,true,-$LevelStop,false);
		if ($TagC==false) return false;
		$PosEnd = $TagC->PosEnd;
		$InnerLim = $TagC->PosBeg;
	}

	$RetVal = true;
	if ($RetInnerSrc) {
		$RetVal = '';
		if ($Loc->PosBeg>$TagO->PosEnd) $RetVal .= substr($Txt,$TagO->PosEnd+1,min($Loc->PosBeg,$InnerLim)-$TagO->PosEnd-1);
		if ($Loc->PosEnd<$InnerLim) $RetVal .= substr($Txt,max($Loc->PosEnd,$TagO->PosEnd)+1,$InnerLim-max($Loc->PosEnd,$TagO->PosEnd)-1);
	}

	// Forward
	$TagC = true;
	for ($i=$Ref+1;$i<=$TagMax;$i++) {
		$x = $TagLst[$i];
		if (($x!=='') and ($TagC!==false)) {
			$level = ($TagIsSgl[$i]) ? 1 : 0;
			$TagC = tbs_Html_FindTag($Txt,$x,$TagIsSgl[$i],$PosEnd+1,true,$level,false);
			if ($TagC!==false) $PosEnd = $TagC->PosEnd;
		}
	}

	// Backward
	$TagO = true;
	for ($i=$Ref-1;$i>=0;$i--) {
		$x = $TagLst[$i];
		if (($x!=='') and ($TagO!==false)) {
			$level = ($TagIsSgl[$i]) ? 1 : 0;
			$TagO = tbs_Html_FindTag($Txt,$x,true,$PosBeg-1,false,$level,false);
			if ($TagO!==false) $PosBeg = $TagO->PosBeg;
		}
	}

	$Loc->PosBeg = $PosBeg;
	$Loc->PosEnd = $PosEnd;
	return $RetVal;

}

function tbs_Html_Max(&$Txt,&$Nbr,$MaxEnd) {
// Limit the number of HTML chars

	$pMax =  strlen($Txt)-1;
	$p=0;
	$n=0;
	$in = false;
	$ok = true;

	while ($ok) {
		if ($in) {
			if ($Txt[$p]===';') {
				$in = false;
				$n++;
			}
		} else {
			if ($Txt[$p]==='&') {
				$in = true;
			} else {
				$n++;
			}
		}
		if (($n>=$Nbr) or ($p>=$pMax)) {
			$ok = false;
		} else {
			$p++;
		}
	}

	if (($n>=$Nbr) and ($p<$pMax)) $Txt = substr($Txt,0,$p).$MaxEnd;

}

function tbs_Html_GetPart(&$Txt,$Tag,$WithTags=false,$CancelIfEmpty=false) {
// This function returns a part of the HTML document (HEAD or BODY)
// The $CancelIfEmpty parameter enables to cancel the extraction when the part is not found.

	if (($Tag===true) or ($Tag==='')) $Tag = 'BODY';

	$x = false;

	$LocOpen = tbs_Html_FindTag($Txt,$Tag,true,0,true,false,false);
	if ($LocOpen!==false) {
		$LocClose = tbs_Html_FindTag($Txt,$Tag,false,$LocOpen->PosEnd+1,true,false,false);
		if ($LocClose!==false) {
			if ($WithTags) {
				$x = substr($Txt,$LocOpen->PosBeg,$LocClose->PosEnd - $LocOpen->PosBeg + 1);
			} else {
				$x = substr($Txt,$LocOpen->PosEnd+1,$LocClose->PosBeg - $LocOpen->PosEnd - 1);
			}
		}
	}

	if ($x===false) {
		if ($CancelIfEmpty) {
			$x = $Txt;
		} else {
			$x = '';
		}
	}

	return $x;

}

function tbs_Html_FindTag(&$Txt,$Tag,$Opening,$PosBeg,$Forward,$LevelStop,$WithPrm) {
/* This function is a smarter issue to find an HTML tag.
It enables to ignore full opening/closing couple of tag that could be inserted before the searched tag.
It also enables to pass a number of encapsulations.
To ignore encapsulation and opengin/closing just set $LevelStop=false.
*/

	if ($Tag==='_') { // New line
		$p = tbs_Html_FindNewLine($Txt,$PosBeg,$Forward);
		$Loc =& new clsTbsLocator;
		$Loc->PosBeg = ($Forward) ? $PosBeg : $p;
		$Loc->PosEnd = ($Forward) ? $p : $PosBeg;
		return $Loc;
	}

	$Pos = $PosBeg + (($Forward) ? -1 : +1);
	$TagIsOpening = false;
	$TagClosing = '/'.$Tag;
	$LevelNum = 0;
	$TagOk = false;

	do {

		// Look for the next tag def
		if ($Forward) {
			$Pos = strpos($Txt,'<',$Pos+1);
		} else {
			if ($Pos<=0) {
				$Pos = false;
			} else {
				$Pos = strrpos(substr($Txt,0,$Pos - 1),'<');
			}
		}

		if ($Pos!==false) {

			// Check the name of the tag
			if (strcasecmp(substr($Txt,$Pos+1,strlen($Tag)),$Tag)==0) {
				$PosX = $Pos + 1 + strlen($Tag); // The next char
				$TagOk = true;
				$TagIsOpening = true;
			} elseif (strcasecmp(substr($Txt,$Pos+1,strlen($TagClosing)),$TagClosing)==0) {
				$PosX = $Pos + 1 + strlen($TagClosing); // The next char
				$TagOk = true;
				$TagIsOpening = false;
			}

			if ($TagOk) {
				// Check the next char
				$x = $Txt[$PosX];
				if (($x===' ') or ($x==="\r") or ($x==="\n") or ($x==='>')) {
					// Check the encapsulation count
					if ($LevelStop===false) { // No encaplusation check
						if ($TagIsOpening!==$Opening) $TagOk = false;
					} else { // Count the number of level
						if ($TagIsOpening) {
							$LevelNum++;
						} else {
							$LevelNum--;
						}
						// Check if it's the expected level
						if ($LevelNum!=$LevelStop) $TagOk = false;
					}
				} else {
					$TagOk = false;
				}
			} //--> if ($TagOk)

		}
	} while (($Pos!==false) and ($TagOk===false));

	// Search for the end of the tag
	if ($TagOk) {
		$Loc =& new clsTbsLocator;
		if ($WithPrm) {
			$PosEnd = 0;
			tbs_Locator_PrmRead($Txt,$PosX,true,'\'"','<','>',$Loc,$PosEnd);
		} else {
			$PosEnd = strpos($Txt,'>',$PosX);
			if ($PosEnd===false) {
				$TagOk = false;
			}
		}
	}

	// Result
	if ($TagOk) {
		$Loc->PosBeg = $Pos;
		$Loc->PosEnd = $PosEnd;
		return $Loc;
	} else {
		return false;
	}

}

function tbs_Html_FindNewLine(&$Txt,$PosBeg,$Forward) {

	$p = $PosBeg;
	if ($Forward) {
		$Inc = 1;
		$Inf =& $p;
		$Sup = strlen($Txt)-1;
	} else {
		$Inc = -1;
		$Inf = 0;
		$Sup =& $p;
	}

	do {
		if ($Inf>$Sup) return max($Sup,0);
		$x = $Txt[$p];
		if (($x==="\r") or ($x==="\n")) {
			$x2 = ($x==="\n") ? "\r" : "\n";
			$p0 = $p;
			if (($Inf<$Sup) and ($Txt[$p+$Inc]===$x2)) $p += $Inc; // Newline char can have two chars.
			if ($Forward) return $p; // Forward => return pos including newline char.
			if ($p0!=$PosBeg) return $p0+1; // Backwars => return pos without newline char. Ignore newline if it is the very first char of the search.
		}
		$p += $Inc;
	} while (true);

}

?>