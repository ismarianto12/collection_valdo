<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<title>Agent Status</title>
	<script src="<?php echo base_url() ?>assets/js/jquery-1.3.2.min.js"></script>

</head>
<body>

<?php
	$st_url = "http://172.25.150.201/cc-adira/status_agent_adira.php";
	$hasil = file_get_contents($st_url);

	echo($hasil);

?>

</body>
</html>
