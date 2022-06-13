<script type="text/javascript">
	$(document).ready(function() {
		generatePreview();
	});

	function generatePreview(){
		var error_flag = <?php echo $flag; ?>;
		if (error_flag == 0) { }
	}

	function doInsert(){
		$('.sub_button').attr("disabled","true");
		var file = $('#hide_file').val();
		var area_class = $('#area_class').val();
		var timeout = 5;
		//new Boxy.load('././doInsert/'+file+'/','POST');
		var asd = new Boxy("<center><div class='loading'><p>Please Wait..</p><p>Inserting..</><br/><img src='/qnb_recovery/assets/images/loader_2.gif'></div></center><center><div id='indicator' name='indicator' style='display:none'></div></center><span class='timer' style='text-align:right'></span>",{modal:true});
		var url = "../doInsert/"+file+"/<?php echo $file_type; ?>"+"/"+area_class;
		var file_type = "<?php echo $file_type ; ?>";
		//START POST
		var dsa = $.post(url,function(data){
			var insert_count = data;
			$('.loading').slideUp('fast');
			$('#indicator').append('<span style="color:green;text-shadow: 2px 2px 3px #808080;font-size:14px;font-weight:bold;"><img src="/qnb_recovery/assets/images/correct.gif">'+data+' Data Inserted !!</span>');

			if(file_type != 'assignment')
				$('#indicator').fadeIn(1000);
			else
				$('#indicator').fadeIn(5);
			//var closeBut = '<a href="#" onclick="Boxy.get(this).hideAndUnload();" >[X]CLOSE</a>';
		})
		.success( function() {
			update_ptp(file_type);
			if(file_type == "payment" || file_type == "assignment" ) { asd.moveTo(null,0); }
			countdown_close(asd,5);
		});
	}

	function update_ptp(file_type){
		if(file_type == "payment"){
			setTimeout(function(){
				var payment_box = new Boxy("<center><div class='loading' style='width:300px'><p>Please Wait..</p><p style='text-decoration:blink'>UPDATING PTP</><br/><img src='/mega/assets/images/loader_2.gif'></div></center>");
				var url_update = "../update_ptp/";
				$.post(url_update,function(data) {
					if(data < 3){
						alert('System Tidak Berhasil Mengupdate Beberapa data !! \nHubungi System Admin Anda!! \n ##ERRMSRMUPTP'+data+'-3');
					}
				})
				.complete(function(){
					$('.loading').slideUp('fast');
					$('.loading').html('');
					$('.loading').html('<h2 style="color:green">UPDATED SUCCESFULLY</h2>');
					$('.loading').slideDown('fast');
					countdown_close(payment_box,2);
				});
			},2000);
		}
	}

	function countdown_close(asd,timeout){
		update_timer();
		setTimeout(function(){
			countdown(asd);
			update_timer();
		},1000);

		function update_timer(){
			var closeBut = '<a href="#" onclick="Boxy.get(this).hideAndUnload();" >[X]CLOSE</a>';
			$('.timer').html(closeBut+' '+timeout).fadeIn('slow');
		}

		function countdown(){
			if(timeout <= 0) {
				asd.hideAndUnload();
				return;
			} else {
				update_timer();
				timeout = timeout -1 ;
				setTimeout(function(){
				countdown();
				},1000);
			}
		}
	}

	function doCancel(){
		var asd = new Boxy("<p> Action Canceled !!</p><span class='timer' style='text-align:right'></span>",{title: "Message",modal:true});
		var timeout = 5;
		countdown_close(asd,timeout);
	}
	
	function doPrint(){
		window.open('<?php echo site_url(); ?>admin/hdr_notification_blast_cont/warning_letter/','_blank');
	}
</script>
<!-- CRUD FILES -->
<?php
	$css_array = $preview->css_files;
	foreach($css_array as $file):
?>

<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />

<?php endforeach; ?>

<?php
	$js_array = $preview->js_files;
	foreach($js_array as $file):
?>

<script src="<?php echo $file; ?>"></script>

<?php endforeach; ?>

<!-- END CRUD FILES -->

<div class="content">
	<!-- start of CONTENT FULL -->
	<div class="cnfull">
		<span class="boxfull_top"></span>
		<div class="boxfull_box">
			<h1>Upload Result</h1>
			<br>
			<br>
			<h2 class="tit">
				<center>
					<?php
						echo $err_msg;
					?>
					<br/>
					<?php echo $total_row." Data Ditampilkan"; ?>
				</center>
			</h2>
			<br/>
			<div id="preview_box" name="preview_box">
				<?php
					 $output = $preview->output;
					 echo $output;
				?>
			</div>
			<input type="hidden" name="hide_file" id="hide_file" value="<?php echo $file_path; ?>" >
			<input type="hidden" name="area_class" id="area_class" value="<?php echo ($area_class ? $area_class : '') ?>" >
			<br/>
			<?php
				$segment = $this->uri->segment(4);
				
				if($segment == 'warning_letter'){
			?>
					<input class="sub_button" type="button" value=" PRINT " onclick="doPrint()" />
					&nbsp
					<input class="sub_button" type="button" value="CANCEL" onclick="doCancel()">
			<?php
				} else if($segment == 'visit_report'){
			?>
			<?php
				} else if($segment != 'assignment_da'){ ?>
					<input class="sub_button" type="button" value=" NEXT "  onclick="doInsert()">
					&nbsp
					<input class="sub_button" type="button" value="CANCEL" onclick="doCancel()">
			<?php } ?>
		</div>
		<span class="boxfull_bot"></span>
	</div>
	<!-- end of CONTENT FULL -->
</div>