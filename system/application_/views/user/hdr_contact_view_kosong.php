<!--
  This script software package is NOT FREE And is Copyright 2010 (C) Valdo-intl all rights reserved.
  we do supply help or support or further modification to this script by Contact
  Haidar Mar'ie
  e-mail = haidar.m@valdo-intl.com
  e-mail = coder5@ymail.com
-->
<script  type="text/javascript">
	$(document).ready(function(){
		//random 1-5
		//var rand = Math.floor((Math.random() * 5) + 1);
		//var seconds = rand+'000';
	
    	var refreshId = setInterval(function() {
			window.location = "<?php echo site_url()?>user/hdr_contact_cont/contact/call/";
			//alert(seconds);
		}, 1000);
	
    });
</script>
<style>
.meter-wrap{
    position: relative;
		}

		.meter-wrap, .meter-value, .meter-text {
		    /* The width and height of your image */
		    width: 950px; height: 15px;
		    border-radius:0 20px 20px 0;
		}

		.meter-wrap, .meter-value {
		    background: #bdbdbd url(<?php echo base_url() ?>assets/images/meter-outline-copy.png) top left no-repeat;

		}

		.meter-text {
		    position: absolute;
		    top:0; left:0;
		    padding-top: 1px;
		    font-size: 9px;
		    font-family: cursive;
		    color: brown;
		    text-align: center;
		    width: 100%;
		    height: 100%;
		}
</style>


<!-- Call Progess Bar-->

<div class="meter-wrap">
    <div class="meter-value" style="background-color: hsla(175,275%,50%,0.8); width: <?php if($work_percentage > 100) { echo "100"; $work_text = "Target Archived"; } else {echo $work_percentage ; $work_text = "Work Progress";} ?>%;border-radius:0px 20px 20px 10px ;box-shadow: 3px 0px 0px #888888;">
        <div class="meter-text">
          <b><?php echo $work_text.' '.$work_percentage ;?>%</b>
        </div>
    </div>
</div>
<!-- End Progress Bar -->

<br/>
       <h1><center>NO DATA</center></h1>
<br/>		

</div>


