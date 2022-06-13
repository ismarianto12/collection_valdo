<?php $idx = 1; ?>
<?php if(COUNT($spvlist) > 0) {  ?>
    <table style="width: 100%;">
        <tr class="th_head">
                <th class="centerize">User AI</th>
                <th class="centerize">Online</th>
                <th class="centerize">Waiting</th> 
                <th class="centerize">Off Line</th> 
        </tr>
        <tr>
            <td id="tot_all" class="striped bold centerize"></td>
            <td id="tot_aktif" class="striped bold centerize"></td>
            <td id="tot_non_aktif" class="striped bold centerize"></td>
            <td id="tot_offline" class="striped bold centerize"></td>
        </tr>
    </table>
    
    <?php foreach($spvlist as $spv) { ?>
    
    
    
    <table id="tbl_<?=$idx;?>" style="width: 100%; height: 95%; <?=$idx == 1 ? '' : 'display:none'; ?>">
<!--          <tr>
            <th class="th_prehead" colspan="7">SPV - <?=$miscModel->get_tableDataById('hdr_user', $spv['id_spv'], 'id_user', 'fullname');?> </th>
          </tr>-->
          <tr class="th_head">
            <th class="centerize">NO</th>
            <th class="centerize">Online</th>
            <th class="centerize">Status Queue</th>
            <th class="centerize">Username</th>
            <th class="centerize">Status</th>
            <!--<th class="centerize">Last Dial</th>-->
            <th class="centerize">Talktime</th>
            <th class="centerize">Totalcall</th>
            <th class="centerize">TotalData</th>
            <th class="centerize">Last Call</th>
            <th class="centerize">Idle Time</th>
          </tr>
          
          <?php foreach($spv['agentlist'] as $agent) { ?>
          
          <tr id="tr_body_<?=$agent['id_user'];?>">    
            <td class="striped centerize"><span id="nums_<?=$agent['id_user'];?>"</span></td>
            <td class="striped centerize"><span id="loginstat_<?=$agent['id_user'];?>"><?=$agent['loginstat_image'];?></span></td>
            <td class="striped loginol centerize"><span id="statuslogin_<?=$agent['id_user'];?>" >..</span></td> 
            <td class="striped centerize"><strong><?=$agent['fullname'];?></strong></td>
            <td class="striped centerize"><span id="status_<?=$agent['id_user'];?>" >..</span></td> 
    <!--        <td class="striped centerize"><span id="lastdial_<?=$agent['id_user'];?>" >..</span></td> -->
            <td class="striped centerize"><span id="talktime_<?=$agent['id_user'];?>" >..</span></td> 
    <!--        <td class="striped bold centerize"><span id="activity_<?=$agent['id_user'];?>" >..</span></td>-->
            <td class="striped bold centerize"><span id="totcall_<?=$agent['id_user'];?>" >..</span></td>
            <td class="striped bold centerize"><span id="tottrack_<?=$agent['id_user'];?>" >..</span></td>
            <td class="striped centerize"><span id="last_call_<?=$agent['id_user'];?>" >..</span></td>
            <td class="striped centerize"><span id="idle_time_<?=$agent['id_user'];?>" >..</span></td>
          </tr>
          <?php } ?>
    </table>
    <?php $idx++; ?>
    <?php } ?>
<?php } ?>

<script type="text/javascript">
 $(document).ready(function(){
    upd_wallboardkiri();
    setTimeout(function(){
        //scroll_wallboardkiri();
        upd_wallboardkiri();
    },10000);
 });

 
 function upd_wallboardkiri(){
    var xurl = '<?=site_url();?>wallboard/upd_wallboardkiri';
    $.ajax({
        url: xurl,
        type: "POST",
        success: function(resp){
          if(resp != '[]'){
            var json = $.parseJSON(resp);
            $.each(json, function(x,y){
                $('#nums_'+x).html(y.nums);
                $('#loginstat_'+x).html(y.loginstat);
                $('#statuslogin_'+x).html(y.status_login);
                $('#status_'+x).html(y.status);
                $('#lastdial_'+x).html(y.last_call);
                $('#talktime_'+x).html(y.talktime);
                $('#activity_'+x).html(y.ratio != null ? y.ratio+'%' : '-');
                $('#totcall_'+x).html(y.totcall != null ? y.totcall : '-');
                $('#tottrack_'+x).html(y.tottrack != null ? y.tottrack : '-');
                if(y.status_string == '1'){
                 $('#tr_body_'+x).removeClass();
                 $('#tr_body_'+x).addClass('oncall');   
                 $('#last_call_'+x).html(0);
                $('#idle_time_'+x).html(0);
                
                } else {
                 $('#tr_body_'+x).removeClass();
                 $('#tr_body_'+x).addClass('idle');
                 $('#last_call_'+x).html(y.last_call);
                 $('#idle_time_'+x).html(y.idle_time);    
                }            
                
                
               
            });
            
                $('#tot_all').html(json.tot_all);
                $('#tot_aktif').html(json.tot_aktif);
                $('#tot_non_aktif').html(json.tot_non_aktif);
                $('#tot_offline').html(json.tot_offline); 
          }
          setTimeout(function(){ upd_wallboardkiri(); }, 2000);
        }        
    });
 }
 
  function scroll_wallboardkiri(){
    var totalspv = parseInt(<?=count($spvlist);?>);
    var start = 1;
    
    function show_tbl(idx, totalspv){
        $("[id^='tbl_']").hide();
        $("#tbl_"+idx).slideDown('slow');
        //location.href = "#tbl_"+idx;
        var next = idx+1;
        next > totalspv ? next = 1 : next;
        setTimeout(function(){
           show_tbl(next, totalspv); 
        }, 10000);
    }
    
    show_tbl(start, totalspv);
  }
</script>