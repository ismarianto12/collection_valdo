<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <link rel="shortcut icon" href="<?php echo base_url() ?>/assets/images/favicon.ico" type="image/x-icon" />
        <title> Valdo Management - TC Dashboard <?= $title ?> &nbsp;-<?php echo @$_SESSION['bsname_s'] ?>-</title>
        <!--flexi grid-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/hdr_style.css"/>
        <link href="<?php echo base_url() ?>assets/css/flexigrid.css" rel="stylesheet" type="text/css" />
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery-1.4.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/flexigrid.pack.js"></script>
        <link rel="stylesheet"  href="<?php echo base_url() ?>assets/css/boxy.css" type="text/css"  />
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/jquery.cluetip.css" type="text/css"  />
        <script language="javascript" src="<?php echo base_url() ?>assets/js/jquery.boxy.js" type="text/javascript"></script>
        <script language="javascript" src="<?php echo base_url() ?>assets/js/jquery.cluetip.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/hdr_ajax.js"></script>
        <!--END flexi grid-->
        <script type="text/javascript" src="<?php echo base_url() ?>assets/pngfix/iepngfix_tilebg.js"></script>
        <!--Datepicker-->
        <link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/js/themes/base/ui.all.css"/>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/ui.core-min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/js/ui.datepicker.js"></script>
        <!--END Datepicker-->
        <!--JS Form-->
        <script src="<?php echo base_url() ?>assets/js/jquery.blockUI.js" type="text/javascript"></script>
        <script src="<?php echo base_url() ?>assets/js/jquery.price_format.1.3.js" type="text/javascript"></script>
        <!---end-JS Form-->
        <script type="text/javascript">
            jQuery(function() {
                jQuery("#datepicker").datepicker({showOn: 'button', buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',dateFormat: 'yy-mm-dd', buttonImageOnly: true, changeMonth: true,
                    changeYear: true});
                jQuery("#datepicker2").datepicker({showOn: 'button', buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',dateFormat: 'yy-mm-dd', buttonImageOnly: true, changeMonth: true,
                    changeYear: true});
                jQuery("#datepicker3").datepicker({showOn: 'button', buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',dateFormat: 'yy-mm-dd', buttonImageOnly: true, changeMonth: true,
                    changeYear: true});
                jQuery("#datepicker4").datepicker({showOn: 'button', buttonImage: '<?php echo base_url() ?>assets/images/datepicker.gif',dateFormat: 'yy-mm-dd', buttonImageOnly: true, changeMonth: true,
                    changeYear: true});
            });

		window.onload = function () {
					document.onkeydown = function (e) {
						return (e.which || e.keyCode) != 116;
					};
				}

         function hideThisDiv(obj){
					$('#'+obj).slideUp('slow');
				 }

				 function goNextDebtor(){
						//alert('Access Failed, You Must Prossed This Account...!');
						//return false;
				 		telli('Please Wait ..');
				 		setTimeout(function(){
				 			window.location = "<?php echo site_url()?>user/hdr_contact_cont/contact/call/";
				 		},750);
				 }

					function doLogout(){
					    $('#signout_reason').fadeIn('slow');
					    return;
						var redir = "<?php echo site_url(); ?>logout";
						var confBox = new Boxy.confirm('Signout berulang-ulang dapat membuat account anda diblock dari sistem, signout ?', function(){
							location.href = redir;
						});
					}

          function checkLogoutReason(){
              var xval = $('#signout_reason').val();
              if(xval == ""){
                  $('#signout_reason').fadeOut('fast');
              } else {
                  confirmLogout(xval);
              }
          }

          function confirmLogout(xval){
              var flag = confirm('Signout dari sistem ?');
              if(flag == true){
                  location.href = "<?=site_url()?>logout/logoutv2/"+xval;
              } else {
                  $('#signout_reason').val("");
                  $('#signout_reason').fadeOut('fast');
              }
          }
		

        </script>
    </head>
    <body>
    	<!-- For Reminder / Callback -->
    	   	<div id="reminder_float_div" style="background-color:rgba(219,243,255,0.7);border:1px solid white;width:60%;text-align:center;position:fixed;margin-left:20%;margin-right:20%;height:100px;border-radius:15px 15px 15px 15px;padding:1%;display:<?=$div_state; ?>;box-shadow:0px 0px 5px 5px gray" >
    			<div style="background-color:rgba(255,255,255,0.7);height:100%;border-radius:15px 15px 15px 15px;">
    				Reminder List <br/><hr/><br/>
    				<table style="font-size:8px">
    				<?php
    					if($get_reminder_new)
    					{
		    					foreach($get_reminder_new as $reminder){

		    					if($reminder['diff'] < 0 && intval($reminder['is_paid']) == 0){
		    							$state = "Ready In ".abs($reminder['diff'])."Minutes(s)";
		    							$state_url = "#";
		    					}else if(intval($reminder['is_paid']) != 0){
		    						$state = "Paid Already";
		    						$state_url = site_url()."user/hdr_contact_cont/fetch_reminder/paid/".$reminder['primary_1'];
		    					} else {
		    							$state = "Ready";
		    							$state_url = site_url()."user/hdr_contact_cont/fetch_reminder/call/".$reminder['primary_1'];
		    					}
		    					$state_remove = site_url()."user/hdr_contact_cont/fetch_reminder/paid/".$reminder['primary_1'];

		    							echo "<tr>";
		    							echo "<td style='width:15%;padding:2px;border-right:1px double gray'>".$reminder['remind_at_fix']."</td>";
		    							echo "<td style='width:15%;padding:2px;border-right:1px double gray'>".$reminder['primary_1']."</td>";
		    							echo "<td style='width:15%;padding:2px;border-right:1px double gray'>".$reminder['name']."</td>";
		    							echo "<td style='width:20%;padding:2px;border-right:1px double gray'>".$reminder['notes']."</td>";
		    							echo "<td style='width:20%;padding:2px;border-right:1px double gray'><a href='".$state_url."'>".$state."</a>&nbsp&nbsp<a href='".$state_remove."'>[X]</a></td>";
		    							echo "</tr>";
		    				}
		    			}	?>
    				</table>
    			</div>
    			<a style="font-size:8px" onclick="hideThisDiv('reminder_float_div');"> HIDE[X] </a>
    		</div>
    		<!-- End For Reminder / Callback -->

        <!-- HEADER start -->
        <div id="wrap_header">
            <div id="header">
                <!-- <span class="head_logo"><a href="#"><img src="<?=base_url()?>assets/images/syaria.gif" /></a></span> -->
                <div class="head_right">
                    <div class="head_welcome">
                        <p>Welcome, <?php echo @$_SESSION['bsname_s'] ?></p> <a onclick="doLogout()" class="signout">Sign out</a>
                        <p>
                            <select id="signout_reason" name="signout_reason" style="display:none; border-radius: 8px;" onchange="checkLogoutReason()">
                                <option value="">-Out Reason-</option>
                                <?php if(COUNT($get_signout_option) > 0): ?>
                                    <?php foreach($get_signout_option as $signout_opt): ?>
                                        <option value="<?=$signout_opt['code'];?>"><?=$signout_opt['description'];?></option>
                                    <?php endforeach; ?>
                                <?php endif;?>
                            </select>
                        </p>

                    </div>
                </div>
                <p class="clear"></p>
            </div>
            <?php if ($_SESSION['blevel'] == 'user') {
            ?>
                  <!-- Head Menu start  for  User-->
                  <div id="head_menu_wrap">
                      <div class="head_menu">
                          <ul>
                               <li <?php echo $current = $this->uri->segment(4) == 'call' ? 'id="current"' : '' ?>><a onclick="goNextDebtor()"><span>Contact</span><!--/a--></li>
                             <!-- <li <?php echo $current = $this->uri->segment(4) == 'no_contact_fu' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>/user/hdr_contact_cont/contact/no_contact_fu"><span>No Contact FU</span></a></li>
                              <li <?php echo $current = $this->uri->segment(4) == 'contact_fu' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>/user/hdr_contact_cont/contact/contact_fu"><span>Contact FU</span></a></li>
                              <li <?php echo $current = $this->uri->segment(4) == 'ptp' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>/user/hdr_contact_cont/contact/ptp"><span>PTP FU</span></a></li>
                              <li <?php echo $current = $this->uri->segment(2) == 'hdr_user_setting_cont' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>user/hdr_contact_cont/contact/"><a href="<?= site_url() ?>user/hdr_user_setting_cont/setting/"><span>Setting</span></a></li> -->
                          </ul>
                      </div>
                  </div>
                  <!-- Head Menu start  for  SPV-->
            <?php } elseif ($_SESSION['blevel'] == 'spv') {
            ?>
                  <div id="head_menu_wrap">
                      <div class="head_menu">
                          <ul>
                              <li <?php echo $current = $this->uri->segment(2) == 'hdr_contact_cont' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>user/hdr_contact_cont/contact/"><span>Contact</span></a></li>
                              <li <?php echo $current = $this->uri->segment(2) == 'hdr_view_debtor_cont' ? 'id="current"' : '' ?> ><a href="<?= site_url() ?>admin/hdr_view_debtor_cont/"><span>View Debtor</span></a></li>
                              <li <?php echo $current = $this->uri->segment(2) == 'hdr_spv_report_ctrl' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>spv/hdr_spv_report_ctrl/report"><span>Report</span></a></li>
                              <li <?php echo $current = $this->uri->segment(2) == 'hdr_setup_filter_cont' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>spv/hdr_setup_filter_cont/"><span>Setup Filter</span></a></li>
                          </ul>
                      </div>
                  </div>
                  <!-- Head Menu start  for  Admin-->
            <?php } elseif ($_SESSION['blevel'] == 'admin') {
            ?>
                  <div id="head_menu_wrap">
                      <div class="head_menu">
                          <ul>
                              <li <?php echo $current = $this->uri->segment(2) == 'hdr_contact_cont' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>user/hdr_contact_cont/contact/"><span>Contact</span></a></li>
                              <li <?php echo $current = $this->uri->segment(2) == 'hdr_view_debtor_cont' ? 'id="current"' : '' ?> ><a href="<?= site_url() ?>admin/hdr_view_debtor_cont/"><span>View Debtor</span></a></li>
                              <li <?php echo $current = $this->uri->segment(2) == 'hdr_upload_cont' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>admin/hdr_upload_cont/master"><span>Upload / Download</span></a></li>
                              <li <?php echo $current = $this->uri->segment(2) == 'hdr_setup_user_cont' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>admin/hdr_setup_user_cont/"><span>User</span></a></li>
                          </ul>
                      </div>
                  </div>
            <?php } elseif ($_SESSION['blevel'] == 'spv_sta') {
            ?>
                  <div id="head_menu_wrap">
                      <div class="head_menu">
                          <ul>
                              <li <?php echo $current = $this->uri->segment(2) == 'hdr_contact_cont' ? 'id="current"' : '' ?>><a href="<?= site_url() ?>user/hdr_contact_cont/contact/"><span>Contact</span></a></li>
                              <li <?php echo $current = $this->uri->segment(2) == 'hdr_spv_send_to_agen_ctrl' ? 'id="current"' : '' ?> ><a href="<?= site_url() ?>spv/hdr_spv_send_to_agen_ctrl/sta"><span>STA</span></a></li>

                          </ul>
                      </div>
                  </div>
            <?php } ?>
              <!-- Head Menu end -->
              <!-- SUB Menu start -->
            <?php if (($this->uri->segment(2) == 'hdr_contact_cont')): ?>
                  <div class="submenu_wrap">
                      <div class="submenu">
                          <ul>
                              <li><a onclick="goNextDebtor()" id="current_sub">Contact1</a></li>
                          </ul>
                      </div>
                  </div>
            <?php endif; ?>

            <?php if (($this->uri->segment(2) == 'hdr_user_setting_cont')): ?>
                      <div class="submenu_wrap">
                          <div class="submenu">
                              <ul>
                                  <li><a href="<?= site_url() ?>user/hdr_user_setting_cont/setting/" id="current_sub">Setting</a></li>
                              </ul>
                          </div>
                      </div>
            <?php endif; ?>
            <!-- SUB Menu end -->
        </div>
        <div id="wrap_content">
            <div class="content">