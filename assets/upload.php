<?php
// JQuery File Upload Plugin v1.6.2 by RonnieSan - (C)2009 Ronnie Garcia
// Sample by Travis Nickels
$upload_date =$_GET['name_upload'];
$description = $_GET['description'];
$link = mysql_connect('localhost', 'root', 'root'); //changet the configuration in required
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
mysql_select_db('womdc');
$query="INSERT INTO hdr_upload_date (upload_date,description) VALUES
		('$names','$description')";
$result=mysql_query($query,$link);
$sql="SELECT * FROM hdr_upload_date Where upload_date ='$upload_date'";
$res=mysql_query($sql,$link);
$row_data = mysql_fetch_assoc($res);
$ids = $row_data['upload_date'];

function fileext($filename) {
    return substr(strrchr($filename,'.'),1);
}
$fr_loc =  explode('/',$_SERVER['SCRIPT_NAME']);
$ext = fileext($_FILES['Filedata']['name']);
$tempFile = $_FILES['Filedata']['tmp_name'];
    $targetPath = $_SERVER['DOCUMENT_ROOT'] . '/'.$fr_loc[1].'/assets/upload/master/' . '/';
    $correct_p = $_SERVER['DOCUMENT_ROOT'] . '/'.$fr_loc[1].'/assets/upload/master/';
    $newFileName = $fileUpload;
    echo $newFileName;
	$targetFile = str_replace('//', '/', $targetPath) . $newFileName;
    move_uploaded_file($tempFile, $targetFile);
    $fine = 'upload/master/' . $_FILES['Filedata']['name'];
    $root = "http://" . $_SERVER['HTTP_HOST'];
		$real_file = $correct_p . $date_time . '.txt';
	echo '1';

?>
