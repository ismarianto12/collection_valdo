
<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery.columnhover.pack.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery-1.4.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("input[name='checkAll']").click(function() {
			var checked = $(this).attr("checked");
			$("#form1 tr td input:checkbox").attr("checked", checked);
		});
	});
</script>
<script>
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

			<br/>
			<br/>
<form name="form1" action="" method="POST" id="form1">
	<input type="button" value="Approved" onclick="goApproved();return false;" /><input type="button" value="Rejected" onclick="goRejected();return false;" />
	<input type="button" value="Pending" onclick="goPending();return false;" />
			<table class="hdrtable" id="listHover" cellspacing="0" style="width:100%;margin-top:10px">
            <thead>
              <tr>
              	<th class="th_bg">
              	<input type="checkbox" id="checkAll" name="checkAll" /></th>
                <th scope="col" class="th_bg">User</th>
                <th scope="col" class="th_bg">CustomerNo</th>
                <th scope="col" class="th_bg">CustomerName</th>
                <th scope="col" class="th_bg">Phone Type</th>
                <th scope="col" class="th_bg">Phone no</th>
                <th scope="col" class="th_bg">Created</th>
                <th scope="col" class="th_bg">Status</th>
                <th scope="col" class="th_bg">Action</th>

              </tr>
            </thead>
            <tbody>
                <?php
              if($list_debtor)
              {
									foreach ($list_debtor as $key => $list){
										?>
										<tr>
											<td class="alt"><input id="chk[<?=$list['primary_1']."/".$list['id_phone'];?>]" name="chk[<?=$list['primary_1']."/".$list['id_phone'];?>]" type="checkbox" /></td>
											<td class="alt"><?=$list['username'];?></td>
											<td class="alt"><?=$list['primary_1'];?></td>
											<td class="alt"><?=$list['card_holder_name'];?></td>
											<td class="alt"><?=$list['phone_type'];?></td>
											<td class="alt"><?=$list['phone_no'];?></td>
											<td class="alt"><?=date_formating($list['createdate']);?></td>
											<td class="alt"><?=$list['xstatus']?></td>
											<td class="alt"><a href="<?=site_url()?>spv/hdr_spv_debtor_cont/edit_debtor/<?=$list['id_phone']?>">EDIT</a></td>
		  							</tr>
							<?php
								}
							}
							?>
             </tbody>
          </table>
         </form>
