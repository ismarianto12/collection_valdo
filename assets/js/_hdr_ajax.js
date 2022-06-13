function uploadFile(url){
	//notif.hide();
	loading('<h1>Get Data</h1>');
	jQuery.get(url,{ 
			  }, function(html) {
		  popUpContent(html);
		});
}
function popBlock(url){
	//notif.hide();
	loading('<h2>Get Data Please wait...<br/>if take more than 5 sec press F5</h2>');
	jQuery.get(url,{ 
			  }, function(html) {
		  uiPopUp(html);
		});
}
function uiPopUp(html){
	notif.hide();
	jQuery.blockUI({ message: html,
						  css: { padding:0, margin:0,width:'885px',top:'5%',left:($(window).width() - 885) /2 + 'px',textAlign:'center',color:'#000',border:'7px solid #000',backgroundColor:'#48B8F3','-webkit-border-radius': '10px','-moz-border-radius': '10px',cursor:'default',},showOverlay: false,  constrainTabKey: false,  focusInput: false,  onUnblock: null,});
 		
     jQuery('#close').click(function() { 
            jQuery.unblockUI(); 
			//notif.hide();
            return false; 
        });
   }
function boxPopup(txtTitle,url){
	loading('<h3>please Wait..<br/>if take more than 5 sec press F5</h3>');
	jQuery.get(url,{ }, function(html) {
		   setAjaxBox(txtTitle,html);
	});
}
function setAjaxBox(txtTitle,html){
	notif.hide();
	//jQuery('#loading_content').html("");
	showPopUp(txtTitle,html);
}
function loading(txt){
	notif = new Boxy('<div id="load" style="text-align:center">'+txt+'</div>', {
                modal: false,unloadOnHide:true
              });
	notif.show();
}
function addMaster(url){
jQuery.post(url,{ 
								subject : jQuery('#subject').val(),
								task_description : jQuery('#task_description').val(),
								due_date : jQuery('#due_date').val(),
								post : true
							}, function(html) {
			   			set_berhasil(html);
		});	
	
}
function popUpContent(html){
	jQuery.blockUI({ message: html,
						  css: { padding:0, margin:0,width:'65%',top:'8%',left:'17%',textAlign:'center',color:'#000',border:'7px solid #000',backgroundColor:'#48B8F3','-webkit-border-radius': '10px','-moz-border-radius': '10px',cursor:'default',},showOverlay: false,  constrainTabKey: false,  focusInput: false,  onUnblock: null,});
 		
     jQuery('#cancel').click(function() { 
            jQuery.unblockUI(); 
            return false; 
        });
   }
function showPopUp(txtTitle,html){
	notif = new Boxy(html, {
                title:txtTitle,modal: false,unloadOnHide:true,closeText:'[x] Close'
              });
	notif.show();
}
function set_berhasil(html){
	//notif.hide();
	notif = new Boxy('<div id="load" style="text-align:center">'+html+'&nbsp;&nbsp;<a href="#" onclick="Boxy.get(this).hide(); return false">[X] Close!</a></div>', {
                modal: false,unloadOnHide:true
              });
	//jQuery('#loading_content').html("");
	
}
function telli(html){
$(document).ready(function() { 
        $.blockUI({ 
            message: '<h1>'+(html)+'</h1>',
			baseZ: 2000, 
            timeout: 1000 
        }); 
}); 	
}

function inArray(needle, haystack) {
    var length = haystack.length;
    for(var i = 0; i < length; i++) {
        if(typeof haystack[i] == 'object') {
            if(arrayCompare(haystack[i], needle)) return true;
        } else {
            if(haystack[i] == needle) return true;
        }
    }
    return false;
}
function checkPro(html){
	//notif.hide();
	notif = new Boxy('<div id="load" style="text-align:center"><h3>'+html+'&nbsp;&nbsp;<a href="#" onclick="Boxy.get(this).hide(); return false">[X] Close!</a></h3></div>', {
                modal: false,unloadOnHide:true
              });
	
}

$(function() {
  $('.boxy').boxy();
});
