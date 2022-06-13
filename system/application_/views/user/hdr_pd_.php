<script  type="text/javascript">

    $(document).ready(function(){
          changeState();
        //heartbeat();
        get_dispolist();
        
//           setTimeout(function(){
//                        alert();
//                    },1000);
                    
            var refreshId = setInterval(function() {
                    heartbeat_exec();
                }, 1000);        
                           
         
    });
    
         
   function  update_data(primari_1){
       
        var session_name = "<?=$session_name;?>";
         
        var xurl = "<?= site_url() ?>user/hdr_contact_cont/update_getdata/";
        var url = "<?= site_url() ?>user/hdr_contact_cont/contact/call"
        var Menit = new Date().getMinutes();
        
            //alert(xurl);
                $.ajax({
                   url: xurl,
                   data: {primary_1:primari_1},
                   type: "POST",
                   success: function(data){
                          //if(data == 'OK')
                          //alert(url+primari_1+'_'+Menit);
                          //var no_apl = Base64._utf8_encode(primari_1t);
                           window.location = url;
                    }
                });
       
   }                
     
    
    
    function heartbeat_exec(){
        var session_name = "<?=$session_name;?>"; 
        var xurl = "<?=$api_url?>"+"/api/agent/agent_keepalive_heartbeat";
            
            //alert(xurl);
                $.ajax({
                   url: xurl,
                   data: {session_name:session_name},
                   type: "POST",
                   success: function(json){
                    var resp = JSON.parse(json);
                        $('#active_status').html(resp.active_status);
                        $('#vendor_lead_code').html(resp.incoming.vendor_lead_code); 
                        $('#first_name').html(resp.incoming.first_name);
                        $('#last_name').html(resp.incoming.last_name);
                        $('#outcall_id').html(resp.incoming.outcall_id); 
                        
                        if(resp.active_status == 'PAUSED'){
                           changeState(); 
                        $('#vendor_lead_code').html('-'); 
                        $('#first_name').html('-');
                        $('#last_name').html('-');
                        $('#outcall_id').html('-');
                        } 
                        
                        if($('#vendor_lead_code') != '-' && resp.active_status == 'INCALL' ){
                            update_data(resp.incoming.vendor_lead_code);
                        }
                        
                    }
                });
                
            }
    
    function get_dispolist(){
        var xurl4 = "<?=$api_url?>"+"/api/dispo/get_dispolist";
        $.ajax({
               url: xurl4, 
               type: "GET",
               success: function(json){
                var resp = JSON.parse(json);
                $.each(resp.result, function(x,y){
                    $("#dispo_choice").append(new Option(y.status_name, y.status));
                });
               },
        });
    }       
    
    
     function changeState(){
        //var xstatus = $('#active_status').html();
        var xstatus = 'PAUSED' ;
        var session_name = "<?=$session_name?>";
        
        if(xstatus == 'PAUSED'){
             xurl2 = "<?=$api_url?>"+"/api/agent/set_agentReady";
        } else if(xstatus == 'READY'){
             xurl2 = "<?=$api_url?>"+"/api/agent/set_agentPause";
        } else {
             xurl2 = "";
        }
        
            $.ajax({
               url: xurl2,
               data: {session_name:session_name},
               type: "POST",
               success: function(json){}
            });
    }
    
  function requestHangup(xobj){
       
        var session_name = "<?=$session_name?>";
        var xurl3 = "<?=$api_url?>"+"/api/softphone/cust_hangup";
        
        $.ajax({
               url: xurl3,
               data: {session_name:session_name}, 
               type: "POST",
               success: function(json){
                   submit_dispo();
                   changeState();
                   $('#vendor_lead_code').html('-'); 
                        $('#first_name').html('-');
                        $('#last_name').html('-');
                        $('#outcall_id').html('-');
                   
               },
               fail: function(resp){
                alert('hangup failed');
                
               }
        });
    }  
    
    
  function submit_dispo(){
        var session_name    = "<?=$session_name?>";
        var outcall_id      = $('#outcall_id').val();
        //var dispo_choice    = $('#dispo_choice').val();
        //var dispo_nextpause = $('#dispo_nextpause').is(":checked");
        
        var xurl5 = "<?=$api_url?>"+"/api/dispo/submitDispo";
        $.ajax({
            url: xurl5,
            type: "POST",
            data: {
                session_name:session_name,
                outcall_id:outcall_id,
                dispo_choice:'B',
                //dispo_nextpause:dispo_nextpause
            },
            success: function(json){
                $('#modalForm').modal('hide');
            }
        });
        return false;
    }  
    
        
   
    
</script>

<form action="#" method="post">
<div class="content">
<div class="viewCenter">
	<!-- start of CONTENT FULL -->
	<span class="boxcontright_top"></span>
      <div class="boxcontright_box">
        <div class="inside_boxright_center">
<h2 class="tit"></h2>

<table>	
    <tr>
        <td>Session Name</td>
        <td></td>
        <td><?=$session_name?></td>
        
    </tr>
	<tr>
    	<td>SIP</td>
        <td></td>
    	<td>SIP/<?=$extension?></td>
        
    </tr>
    <tr>
        <td>
            Status
        </td>
        <td>
        </td>
        <td>
             <font size="4" color="red"><h1><div id="active_status" >Standby</h1></font></div>
        </td>
    </tr>
    <tr>
        <td>
            No Aplikasi
        </td>
        <td>
        </td>
        <td>
            <a id="vendor_lead_code" >-</a>
        </td>
    </tr>
    <tr>
        <td>
            Nama First
        </td>
        <td>
        </td>
        <td>
            <a id="first_name" ></a>
        </td>
    </tr>
    <tr>
        <td>
            Last Name
        </td>
        <td>
        </td>
        <td>
            <a id="last_name" ></a>
        </td>
    </tr>
    <tr>
        <td>
            Outcall id
        </td>
        <td>
        </td>
        <td>
            <a id="outcall_id" ></a>
        </td>
    </tr>
   
    <tr>
        <td>Disposition
        </td>
        <td>
        </td>
        <td>
            <select id="dispo_choice">
               <option value="">-Disposition-</option>
             </select>
        </td>
    </tr>                                           
    
                                              
    <tr hidden>
        <td>
        <input type="button"  style="margin-left:10px" value="HangUp" onclick="requestHangup(this)" />
        </td>
        <td>
        <input type="button" class="but_proceed" style="margin-left:10px" onclick="parent.location='<?php echo site_url() ?>user/hdr_contact_cont/contact/'+$('#vendor_lead_code    ').html()" />
        </td>
    </tr>                                                                                                  
    
  </table>

        
</form>
 </div>
      </div>
      <span class="boxcontright_bot"></span> </div>
  <p class="clear"></p>
  </div>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  <br/>
  
  
  