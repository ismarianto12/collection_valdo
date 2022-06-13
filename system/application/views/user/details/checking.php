<script>
notif.hide();
<?php if($check_use_again!='1'){?>
location.href="<?=site_url()?>user/hdr_contact_cont/contact/";
<?php } elseif($check_use_again=='0') {?>
notif.hide();
<?php } ?>
 
 //checks('<?=site_url()?>user/hdr_contact_cont/check_close')

</script>
	<script></script>		
                <h2>User ini boleh di Call</h2>