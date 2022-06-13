<?php
@session_start();
function get_tag_condition($condition,$pre="AND"){
	if($condition){
		$return = $condition?$pre .' '.$condition.' ':'';
		return  " ".$return." ";
	}
	return false;
}

function set_string_content($string){
	if (!get_magic_quotes_gpc()) {
		$string = strip_tags($string,'');
	}
	return $string;
}
function set_filename($path, $filename, $file_ext, $encrypt_name = FALSE){
		if ($encrypt_name == TRUE)
		{		
			mt_srand();
			$filename = md5(uniqid(mt_rand())).$file_ext;	
		}
	
		if ( ! file_exists($path.$filename))
		{
			return $filename;
		}
	
		$filename = str_replace($file_ext, '', $filename);
		
		$new_filename = '';
		for ($i = 1; $i < 100; $i++)
		{			
			if ( ! file_exists($path.$filename.$i.$file_ext))
			{
				$new_filename = $filename.$i.$file_ext;
				break;
			}
		}

		if ($new_filename == '')
		{
			return FALSE;
		}
		else
		{
			return $new_filename;
		}
}
function prep_filename($filename) {
	   if (strpos($filename, '.') === FALSE) {
		  return $filename;
	   }
	   $parts = explode('.', $filename);
	   $ext = array_pop($parts);
	   $filename    = array_shift($parts);
	   foreach ($parts as $part) {
		  $filename .= '.'.$part;
	   }
	   $filename .= '.'.$ext;
	   return $filename;
}
function get_extension($filename) {
	   $x = explode('.', $filename);
	   return '.'.end($x);
} 
?>
