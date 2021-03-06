<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
	<!-- <link rel="shortcut icon" href="<?php echo base_url() ?>/assets/images/favicon.ico" type="image/x-icon" /> -->
	<title> Valdo Management - <?php echo @$title ?></title>
	<link href="<?php echo base_url() ?>assets/css/hdr_style.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url() ?>/assets/pngfix/iepngfix_tilebg.js"></script>
	<link href="<?php echo base_url() ?>assets/css/flexigrid.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.4.2.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/flexigrid.pack.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery.blockUI.js"></script>
	<!--Datepicker-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>/assets/js/themes/base/ui.all.css" />
	<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/ui.core-min.js"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/ui.datepicker.js"></script>
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/boxy.css" type="text/css" />
	<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.cluetip.css" type="text/css" />
	<script language="javascript" src="<?php echo base_url() ?>assets/js/jquery.boxy.js" type="text/javascript"></script>
	<script language="javascript" src="<?php echo base_url() ?>assets/js/jquery.cluetip.js" type="text/javascript"></script>
	<script type="text/javascript" src="<?php echo base_url() ?>assets/js/hdr_ajax.js"></script>
	<script language="javascript" src="<?php echo base_url() ?>assets/js/jquery.price_format.1.3.js" type="text/javascript"></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

	<!--END Datepicker-->
	<script type="text/javascript">
		function confirmation(url, txt) {

			if (confirm(txt)) {
				location.href = url;
			}
		}

		<?php if (@$txt_result) : ?>
			$(document).ready(function() {
				$.blockUI({
					message: '<h1><?php echo $txt_result ?></h1>',
					timeout: 2000
				});
			});
		<?php endif; ?>
	</script>
	<script type="text/javascript">
		$(function() {
			$("#datepicker").datepicker({
				showOn: 'button',
				buttonImage: '<?php echo base_url() ?>/assets/images/calendar.gif',
				dateFormat: 'yy-mm-dd',
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true
			});
			$("#datepicker2").datepicker({
				showOn: 'button',
				buttonImage: '<?php echo base_url() ?>assets/images/calendar.gif',
				dateFormat: 'yy-mm-dd',
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true
			});
			$("#datepicker3").datepicker({
				showOn: 'button',
				buttonImage: '<?php echo base_url() ?>/assets/images/calendar.gif',
				dateFormat: 'yy-mm-dd',
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true
			});
			$("#datepicker4").datepicker({
				showOn: 'button',
				buttonImage: '<?php echo base_url() ?>assets/images/calendar.gif',
				dateFormat: 'yy-mm-dd',
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true
			});
			$("#datepicker5").datepicker({
				showOn: 'button',
				buttonImage: '<?php echo base_url() ?>/assets/images/calendar.gif',
				dateFormat: 'yy-mm-dd',
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true
			});
			$("#datepicker6").datepicker({
				showOn: 'button',
				buttonImage: '<?php echo base_url() ?>assets/images/calendar.gif',
				dateFormat: 'yy-mm-dd',
				buttonImageOnly: true,
				changeMonth: true,
				changeYear: true
			});
		});
	</script>
</head>

<body>
	<!-- HEADER start -->
	<!-- HEADER start -->
	<div id="wrap_header">
		<div id="header">
			<span class="head_logo"><a href="#"><img src="<?= base_url() ?>assets/images/logo.png" style="width:150px ;" /></a></span>
			<div class="head_right">
				<div class="head_welcome">
					<p>Welcome, <?php echo @$_SESSION['bsname_s'] ?></p> <a href="<?php echo site_url() ?>logout" class="signout">Sign out</a>
				</div>
			</div>
			<p class="clear"></p>
		</div>
		<!-- Head Menu start -->
		<?php if ($_SESSION['blevel'] == 'spv') { ?>
			<div id="head_menu_wrap">
				<div class="head_menu">
					<ul>
						<li <?php echo $current = $this->uri->segment(2) == 'hdr_contact_cont' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>user/hdr_contact_cont/contact/"><span>Contact</span></a></li>
						<li <?php echo $current = $this->uri->segment(2) == 'hdr_view_debtor_cont' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>admin/hdr_view_debtor_cont/"><span>View Debtor</span></a></li>
						<!-- <li <?php echo $current = $this->uri->segment(2) == 'hdr_spv_report_ctrl' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>spv/hdr_spv_report_ctrl/report"><span>Report</span></a></li> -->

					</ul>
				</div>
			</div>
		<?php } else { ?>
			<div id="head_menu_wrap">
				<div class="head_menu">
					<ul>
						<li <?php echo $current = $this->uri->segment(2) == 'hdr_contact_cont' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>user/hdr_contact_cont/contact/"><span>Contact</span></a></li>
						<li <?php echo $current = $this->uri->segment(2) == 'hdr_view_debtor_cont' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>admin/hdr_view_debtor_cont/"><span>View Debtor</span></a></li>
						<li <?php echo $current = $this->uri->segment(2) == 'hdr_upload_cont' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>admin/hdr_upload_cont/master"><span>Upload / Download</span></a></li>
						<li <?php echo $current = $this->uri->segment(2) == 'hdr_setup_user_cont' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>admin/hdr_setup_user_cont/"><span>User</span></a></li>
						<!--	<li <?php echo $current = $this->uri->segment(2) == 'hdr_setup_config' ? 'id="current"' : '' ?>><a href="#"><span>Config</span></a></li> -->
						<!-- <li <?php echo $current = $this->uri->segment(2) == 'hdr_setup_config' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>admin/hdr_adm_report_ctrl/report"><span>Report</span></a></li> -->

					</ul>
				</div>
			</div>
		<?php } ?>
		<!-- View Menu start - -->
		<div class="submenu_wrap">
			<?php if (($this->uri->segment(2) == 'hdr_view_debtor_cont')) : ?>
				<div class="submenu">
					<ul>
						<li <?php echo $current_sub = $this->uri->segment(3) == 'view' ? 'id="current_sub"' : '' ?>><a href="<?= site_url() ?>admin/hdr_view_debtor_cont/view" class="#">View & Filter</a></li>
					</ul>
				</div>
			<?php endif; ?>
			<!-- Upload Menu start - -->
			<?php if (($this->uri->segment(2) == 'hdr_upload_cont')) : ?>
				<div class="submenu">
					<ul>
						<!-- 	<li <?php echo $current_sub = $this->uri->segment(3) == 'master' || $this->uri->segment(3) == '' ? 'id="current_sub"' : '' ?>><a href="<?= site_url() ?>admin/hdr_upload_cont/master" class="#">Master</a></li>
	 <li <?php echo $current_sub = $this->uri->segment(3) == 'dpd_minus' || $this->uri->segment(3) == '' ? 'id="current_sub"' : '' ?>><a href="<?= site_url() ?>admin/hdr_upload_cont/dpd_minus" class="#">DPD Minus</a></li> -->
						<li <?php echo $current_sub = $this->uri->segment(3) == 'payment' ? 'id="current_sub"' : '' ?>><a href="<?= site_url() ?>admin/hdr_upload_cont/payment" class="#">Payment</a></li>
						<li <?php echo $current_sub = $this->uri->segment(3) == 'redownload' ? 'id="current_sub"' : '' ?>><a href="<?= site_url() ?>admin/hdr_upload_cont/redownload" class="#">Redownload</a></li>
						<li <?php echo $current_sub = $this->uri->segment(3) == 'branchwork' ? 'id="current_sub"' : '' ?>><a href="<?= site_url() ?>admin/hdr_upload_cont/branchwork" class="#">Branch Work</a></li>
						<li <?php echo $current_sub = $this->uri->segment(3) == 'branchwork' ? 'id="current_sub"' : '' ?>><a href="<?= site_url() ?>admin/hdr_upload_cont/untouch" class="#">Untouch / Retouch</a></li>
						<!-- <li <?php echo $current_sub = $this->uri->segment(3) == 'call_track' ? 'id="current_sub"' : '' ?>><a href="<?= site_url() ?>admin/hdr_upload_cont/call_track" class="#">Call Track</a></li>
				<li <?php echo $current_sub = $this->uri->segment(3) == 'action_code' ? 'id="current_sub"' : '' ?>><a href="<?= site_url() ?>admin/hdr_upload_cont/action_code" class="#">Action Code</a></li>
				<li <?php echo $current_sub = $this->uri->segment(3) == 'active_agency' ? 'id="current_sub"' : '' ?>><a href="<?= site_url() ?>admin/hdr_upload_cont/active_agency" class="#">Active Agency</a></li>
				<li <?php echo $current_sub = $this->uri->segment(3) == 'reschedule' ? 'id="current_sub"' : '' ?>><a href="<?= site_url() ?>admin/hdr_upload_cont/reschedule" class="#">Reschedule</a></li> -->
					</ul>
				</div>
			<?php endif; ?>


			<?php if (($this->uri->segment(2) == 'hdr_setup_user_cont')) : ?>
				<div class="submenu">
					<ul>
						<li <?php echo $current_sub = $this->uri->segment(3) == 'user' ? 'id="current_sub"' : '' ?>><a href="<?= site_url() ?>admin/hdr_setup_user_cont/user" class="#">List Users</a></li>
						<li <?php echo $current_sub = $this->uri->segment(3) == 'add_user' ? 'id="current_sub"' : '' ?>><a href="<?= site_url() ?>admin/hdr_setup_user_cont/add_user" class="#">Add Users</a></li>
					</ul>
				</div>
			<?php endif; ?>

			<?php if (($this->uri->segment(2) == 'hdr_adm_report_ctrl')) : ?>
				<div class="submenu">
					<ul>
						<li <?php echo $current_sub = $this->uri->segment(3) == 'admin_report' ? 'id="current_sub"' : '' ?>><a href="<?= site_url() ?>admin/hdr_adm_report_ctrl/report" class="#">List Users</a></li>
					</ul>
				</div>
			<?php endif; ?>


		</div>
		<!-- SUB Menu end -->
	</div>