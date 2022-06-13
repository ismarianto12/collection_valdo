<script>
<?php $a=0 ?>

function set_success(html){
	notif.hide();
	notif = new Boxy('<div id="load" style="text-align:center">'+html+'&nbsp;&nbsp;<a href="#" onclick="Boxy.get(this).hide(); return false">[X] Close!</a></div>', {
                modal: false,unloadOnHide:true
              });
	
}
</script>
<div style="width:720px; height:400px; overflow:scroll;">
<div class="contright">
	<!-- start of CONTENT FULL -->
	<span class="boxcontright_top"></span>
      <div class="boxcontright_box">
        <div class="inside_boxright_reg">
	<dl>
			<?php 
			$isi_value = $get_debtor->en_value; 
			$a_value = explode('|', $isi_value);
			$name_f = $name_of_field->field_name;
			$a_field = explode('|', $name_f);
			$val = '';
			$total_field = count($a_field);
			$total_value = count($a_value);
			$i = 0;
			for($a = $a_field;$i<$total_field;$a++){
				foreach($a_value as $row){
					echo '<dt><label class="lblfl">'.$a[$i++].'</label><strong>'.$row.'</strong></dt>';
					;
				}
			}
			?>
	</dl>
	<br />
	<br />
	<br />
		
	 </div>
      </div>
      <span class="boxcontright_bot"></span> </div>
  <p class="clear"></p>
  </div>