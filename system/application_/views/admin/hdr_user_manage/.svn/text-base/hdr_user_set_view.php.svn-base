<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery.jeditable.mini.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery.columnhover.pack.js"></script>
<script>
    $(document).ready(function() {
        $(".edit").editable("<?= site_url() ?>admin/hdr_setup_user_cont/blocked/", { 
            data   : " {'0':'Unblocked','1':'Blocked'}",
            indicator : "<img src='<?= base_url() ?>assets/images/ajax-loader.gif'> Saving...",
            type   : 'select',
            submit : 'OK',
            name     : 'blocked',
            id        : 'id_user',
            tooltip    : 'Click to edit...',
            cancel    : 'Cancel',
            submit    : 'Save',
        });
    });
    $(document).ready(function() {
        $(".editSpv").editable("<?= site_url() ?>admin/hdr_setup_user_cont/edit_spv/", { 
	
            data   : " <?php echo '{';
foreach ($list_spv->result() as $spv) {
    echo "'" . $spv->id_user . "':'" . $spv->username . "',";
} echo '}' ?> ",
            indicator : "<img src='<?= base_url() ?>assets/images/ajax-loader.gif'> Saving...",
            type   : 'select',
            submit : 'OK',
            name     : 'id_spv',
            id        : 'id_user',
            tooltip    : 'Click to edit...',
            cancel    : 'Cancel',
            submit    : 'Save',
        });
    });
    $(document).ready(function() {
        $(".editShift").editable("<?= site_url() ?>admin/hdr_setup_user_cont/edit_shift/", { 
	
            data   : " {'1':'1','2':'2'} ",
            indicator : "<img src='<?= base_url() ?>assets/images/ajax-loader.gif'> Saving...",
            type   : 'select',
            submit : 'OK',
            name     : 'shift',
            id        : 'id_user',
            tooltip    : 'Click to edit...',
            cancel    : 'Cancel',
            submit    : 'Save',
        });
    });
    
    $(document).ready(function(){
        $('#listHover').columnHover({eachCell:true, hoverClass:'betterhover'}); 
    });
</script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/hdr_tables.css" type="text/css"  />
<style type="text/css">
    table.hdrtable
    {
        width: 450px;
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
<div class="content">
    <div class="cnfull">
        <div class="sideleft"> <span class="boxsideleft_top"></span>
            <div class="boxsideleft_box">
                <div class="inside_boxleft">
                    <h2>User Active</h2>
                    <br />
                            <?php if ($active_user->num_rows() > 1) {
                                foreach ($active_user->result() as $row_user): ?>
                            <p><strong>        
                    <?= $row_user->username ?>&nbsp;&nbsp;&nbsp; <img src="<?php echo base_url(); ?>assets/images/<? if	($row_user->id_level == '1'){echo 'ico_individu_pass.png';}
                   	 			else if ($row_user->id_level == '2'){echo 'ico_spv.png';}
                   	 			else if ($row_user->id_level == '3'){echo 'ico_individu.png';}
                   	 			
                   	 			echo '">';                 
                    	 ?>
                    	 
                                        </strong></p>                
                                    <br />                
                    <?php
                                    endforeach;
                                } else {
                                    echo 'no user';
                                }
                    ?>
                            </div>            
                        </div>            
                        <span class="boxsideleft_bot"></span> </div>            
                    <div class="contright"> <span class="boxcontright_top"></span>            
                        <div class="boxcontright_box">            
                            <div class="inside_boxright">            
                                <h2>User Lists</h2>            
                                <br />            
                                <table class="hdrtable" id="listHover" cellspacing="0" style="width:100%;margin-top:10px">            
                                    <thead>            
                                        <tr>            
                                            <th scope="col" class="th_bg">No</th>            
                                            <th scope="col" class="th_bg">Username</th>            
                                            <th scope="col" class="th_bg">Fullname</th>            
                                            <th scope="col" class="th_bg">Level</th>            
                                            <th scope="col" class="th_bg">Leader</th>           
                                            <th scope="col" class="th_bg">Shift</th>          
                                            <th scope="col" class="th_bg">Last login</th>            
                                            <th scope="col" class="th_bg">Access</th>            
                                            <th scope="col" class="th_bg">Edit</th>            
                                        </tr>            
                                    </thead>            
                                    <tbody>            
<?php
                                if ($list_user->num_rows() > 1) {
                                    $i = 1;
                                    foreach ($list_user->result() as $row_user):
?>
                                <?php $hide = $i > 10 ? 'hideTR' : '' ?>
                                    <tr class="spec<?= $i % 2 == 0 ? ' ' . $hide : 'alt ' . $hide ?>">
                                        <td class="alt"><?php echo $i++ ?></td>
                                        <td class="alts"><?php echo $row_user->username ?></td>
                                        <td class="alt"><?php echo $row_user->fullname ?></td>
                                        <td class="alt"><?php echo $row_user->level_user ?></td>
                            <?php $name = $this->user_model->get_user($row_user->id_leader) ?>
                                            <td class="alt"><?php echo $tc_only = $row_user->id_level == 3 ? '<div class="editSpv" id="' . $row_user->id_user . '" >' . @$name->username . '</div>' : @$name->username ?></td>
                                            <td class="alt"><div class="editShift" id="<?=$row_user->id_user?>"><?=$row_user->shift?></div></td>
                                            <td class="alt"><?php echo $row_user->last_login ?></td>
                                            <td class="alt"><div class="edit" id="<?= $row_user->id_user ?>" ><?php echo $row_user->blocked ? 'Blocked' : 'Unblocked' ?></div></td>
                                            <td class="alt"><a href="<?= site_url() ?>admin/hdr_setup_user_cont/edit_user/<?= $row_user->id_user ?>" >Edit</a>  | <a href="javascript:void(0)" onclick="confirmation('<?php echo site_url() ?>admin/hdr_setup_user_cont/delete_user/<?php echo $row_user->id_user ?>','You want to delete <?php echo $row_user->username ?>?')">Delete</a></td>
                                        </tr>            
<?php
                                        endforeach;
                                    } else {
                                        echo 'no user';
                                    }
?>
                        </tbody>
                    </table>
                </div>
            </div>
            <span class="boxcontright_bot"></span> </div>
    </div>
    <p class="clear"></p>
</div>
