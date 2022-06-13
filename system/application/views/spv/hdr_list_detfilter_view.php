<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery.columnhover.pack.js"></script>
<script>
function setAktif(url){
	if(confirm("Apakah Anda yakin ingin mengaktifkan?")){
		jQuery.post(url,{}, 
		function(html) {
			telli(html);
			setTimeout(function(){ location.reload(); }, 2000);
		});
	}
}
function setNonAktif(url){
	if(confirm("Apakah Anda yakin ingin menonaktifkan?")){
		jQuery.post(url,{}, 
		function(html) {
			telli(html);
			setTimeout(function(){ location.reload(); }, 2000);
		});
	}
}
function setUser(url){

	//notif.hide();
	loading('<h2>Get Data Please wait...<br/>if take more than 5 sec press F5</h2>');
	jQuery.get(url,{
			  }, function(html) {
		  userPop(html);
		});
}
function userPop(html){
	notif.hide();

	jQuery.blockUI({ message: html,
						  css: { padding:0, margin:0,width:'885px',top:'5%',left:($(window).width() - 885) /2 + 'px',textAlign:'left',border:'0px solid #000','-webkit-border-radius': '10px','-moz-border-radius': '10px',cursor:'default',},showOverlay: false,  constrainTabKey: false,  focusInput: false,  onUnblock: null,});

     jQuery('#close').click(function() {
            jQuery.unblockUI();
			//notif.hide();
            return false;
        });
   }
function viewDebt(url){

	//notif.hide();
	loading('<h2>Get Data Please wait...<br/>if take more than 5 sec press F5</h2>');
	jQuery.get(url,{
			  }, function(html) {
		  viewDebtpop(html);
		});
}
function viewDebtpop(html){
	notif.hide();
	jQuery.blockUI({ message: html,
						  css: { padding:0, margin:0,width:'950px',top:'5%',left:($(window).width() - 950) /2 + 'px',textAlign:'center',color:'#000',border:'7px solid #000',backgroundColor:'#48B8F3','-webkit-border-radius': '10px','-moz-border-radius': '10px',cursor:'default',},showOverlay: false,  centerX: true,allowBodyStretch: true, constrainTabKey: false,  focusInput: false,  onUnblock: null,});

     jQuery('#close').click(function() {
            jQuery.unblockUI();
			//notif.hide();
            return false;
        });
   }
$(document).ready(function(){
 $('#listHover').columnHover({eachCell:true, hoverClass:'betterhover'});
});

</script>
<script>
function test(com,grid)
{

		 if (com=='Select All')
		{
			$('.bDiv tbody tr',grid).addClass('trSelected');
		}
		if (com=='DeSelect All')
		{
			$('.bDiv tbody tr',grid).removeClass('trSelected');
		}

}
</script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/hdr_tables.css" type="text/css"  />
<style type="text/css">
table.hdrtable
{
	width: 400px;
}
td.hover, #listHover tbody tr:hover
{
	background-color: LemonChiffon;
}
td.betterhover, #listHover tbody tr:hover
{
	background: LightCyan;
}
</style>
			<?php
			//die("aab");
			function findinside_filter($start, $string) {
				$start_f = 'hdm.'.$start.' IN("';
				preg_match_all('/' . preg_quote($start_f, '/') . '([^\.)]+)'. preg_quote('")', '/').'/i', $string, $m);
				$output = preg_replace("/[,\"]+/",',' ,$m[1]);
				return $output[0] ;
			}
			function findinside_filter_p($start, $string) {
				$start_f = 'hdm.'.$start;
				preg_match_all('/' . preg_quote($start_f, '/') . '([^\.)]+)'. preg_quote('"', '/').'/i', $string, $m);
				$output = preg_replace("/[,\"]+/",' ' ,$m[1]);
				return $output[0] ;
			}

			?>
			<br/>
			<br/>
			<div class="us_filter" style="width: 900px; height: 500px;overflow:scroll;">
			<table class="hdrtable" id="listHover" cellspacing="0" style="width:100%;margin-top:10px">
            <thead>
              <tr>
                <th scope="col" class="nobg">No</th>
                <th scope="col" class="th_bg">Username</th>
                <th scope="col" class="th_bg">Fullname</th>
                <!--
                <th scope="col" class="th_bg">View Debtor</th>
                -->
                <th scope="col" class="th_bg">Overdue</th>
                <th scope="col" class="th_bg">Priority</th>
                <th scope="col" class="th_bg">Region</th>
                <th scope="col" class="th_bg">Cabang</th>
                <th scope="col" class="th_bg">Score Result</th>
                <th scope="col" class="th_bg">Call ID</th>
				<th scope="col" class="th_bg">Queing Contact</th>
								<!--th scope="col" class="th_bg">Product Flag</th>
								<th scope="col" class="th_bg">Bucket Coll</th-->

                <!--<th scope="col" class="th_bg">Export</th> -->
              </tr>
            </thead>
            <tbody>
              <?php
              //die();

			  function match_f($filter,$string){
				if(preg_match('/'.$filter.'/',$string)){

					return 1;
				}else{
					return 0;
				}
			  }
//var_dump($list_user);
//echo $list_user->num_rows();
//die();
			  if($list_user->num_rows() > 0 ){
			  	//die($list_user);
							$i =1;
							foreach($list_user->result() as $row_user){
							switch($row_user->score_result)
		{
			case '1': $score_result = 'HIGH';
			break;
			case '0': $score_result = 'MEDIUM, LOW';
			break;
		}
?>

							 <?php $hide = $i>10?'hideTR':'' ?>
              <tr>
                <td class="alt"><?php echo ($i); $i++; ?></td>
                <td class="alts"><strong><a href="#" onclick="setUser('<?=site_url();?>spv/hdr_setup_filter_cont/user_set_filter/<?=$row_user->id_user?>')"><?=$row_user->username ?></a><strong></td>
                <td class="alt"><?=$row_user->fullname?></td>
                <!--
                <td class="alt"><?php

                //var_dump($row_user->id_user);
                //die();
                //hide by nudi 4 agust 2016
                //$no_case = $this->report_model->count_assign_debtor_tc($row_user->id_user);
                //echo $contact = $no_case>=1 ? '<a href="#" onclick="viewDebt(\''.site_url().'spv/hdr_setup_filter_cont/view_debtor/'.$row_user->id_user.'\')">'.$no_case.'</a>':'no debtor';
                //echo $contact = $no_case>=1 ? $no_case :'no debtor'
                ?></td>
                -->
                <td class="alt"><?php echo($row_user->over_days) ?></td>
                <td class="alt"><?php echo($row_user->priority) ?></td>
                <td class="alt"><?php echo($row_user->region_area) ?></td>
                <td class="alt"><?php echo($row_user->branch_area) ?></td>
                <td class="alt"><?php echo($score_result) ?></td>
                <td class="alt"><?php echo($row_user->id_user) ?></td>
				<td class="alt">
				<?php if($row_user->ai == 0){
					?>
					Status: Non-Aktif | <a href="#" onclick="setAktif('<?=site_url();?>spv/hdr_setup_filter_cont/user_set_aktif/<?=$row_user->id_user?>')">Aktifkan</a>
				<?php }else{
					?>
					Status: Aktif | <a href="#" onclick="setNonAktif('<?=site_url();?>spv/hdr_setup_filter_cont/user_set_nonaktif/<?=$row_user->id_user?>')">Non-Aktifkan</a>
				<?php } ?>
				
				</td>
						<!--		<td class="alt"><?php echo($row_user->product_flag) ?></td>
								<td class="alt"><?php echo($row_user->bucket_coll) ?></td>

                <td class="alt"><?php echo('<a href="'.site_url().'spv/hdr_setup_filter_cont/export_debtor/'.$row_user->id_user.'/">Export</a>') ?></td> -->
              </tr>
            <?php		}
								} else {
									echo 'no user';
								}
								?>
            </tbody>
          </table>
			</div>