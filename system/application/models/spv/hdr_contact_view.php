<!--
  This script software package is NOT FREE And is Copyright 2010 (C) Valdo-intl all rights reserved.
  we do supply help or support or further modification to this script by Contact
  Haidar Mar'ie
  e-mail = haidar.m@valdo-intl.com
  e-mail = coder5@ymail.com
-->
<script type="text/javascript">
    function get_input(url) {
        jQuery.post(url, {

            search_acct: jQuery('input[name=search_acct]').val(),
            search_card_no: jQuery('input[name=search_card_no]').val(),
            name_debt: jQuery('input[name=name_debt]').val(),
            nxt_card: jQuery('input[name=nxt_card]').val(),
            post: jQuery('#post').val(),
            post: true
        }, function(html) {
            showPopUp('Confirmation', '<div style="width:250px"><center>' + html + '</center></div>', 'Cancel [x]');
        });

    }

    function changePTP(value) {
        //alert(value);
        if (value == 'P1,Janji Bayar') {
            jQuery('#cont_ptp').fadeIn(1000)
        } else {
            jQuery('#cont_ptp').fadeOut(1000);
        }

        if (value == '52,DXXX,0') {
            jQuery('#call_back').fadeIn(1000);
        } else {
            jQuery('#call_back').fadeOut(1000);
        }
    }

    function ptpKey(value) {
        if (value == "PTP" || value == "ptp") {
            jQuery('#cont_ptp').fadeIn(1000)
        } else {
            jQuery('#cont_ptp').fadeOut(1000);
        }
    }

    function changePTPagen(value) {
        if (value == 6) {
            jQuery('#agen_ptp').fadeIn(1000)
        } else {
            jQuery('#agen_ptp').fadeOut(1000);
        }
    }

    function callPopup(url, value) {
        //notif.hide();
        loading('<h2>Calling ' + value + '  Please wait......<br/>if take more than 5 sec press F5</h2>');
        jQuery.get(url, {}, function(html) {
            finsihCall(html);
        });
    }

    function finsihCall(html) {
        notif.hide();
        notif = new Boxy('<div id="load" style="text-align:center">' + html + '&nbsp;&nbsp;<a href="#" onclick="Boxy.get(this).hide(); return false">[X] Close!</a></div>', {
            modal: false,
            unloadOnHide: true
        });
        //jQuery('#loading_content').html("");

    }

    function addPhone(url, id) {
        if (id != 'add') {
            jQuery("#phone_" + id).remove();
        }
        var phone_no = jQuery('#phone_no').val();
        //var phone = +phone_no.replace(/\D/g,'');
        jQuery.post(url, {
            phone_no: phone_no,
            phone_type: jQuery('#phone_type').val(),
            primary_1: jQuery('#primary_1').val(),
            id_phone: jQuery('#id_phone').val(),
            post: true
        }, function(html) {
            setSubmitPhone(html)
            //alert(html);
        });
    }

    function addAddress(url, id) {
        if (id != '') {
            jQuery("#address_" + id + "_a").remove();
            jQuery("#address_" + id + "_b").remove();
            jQuery("#address_" + id + "_c").remove();
            jQuery("#address_" + id + "_d").remove();
            jQuery("#address_" + id + "_e").remove();
            jQuery("#address_" + id + "_f").remove();
            jQuery("#address_" + id + "_g").remove();
        }
        jQuery.post(url, {
            type: jQuery('#type').val(),
            address: jQuery('#address').val(),
            city: jQuery('#city').val(),
            zip_code: jQuery('#zip_code').val(),
            id_address: jQuery('#id_address').val(),
            phone_no: jQuery('#phone_no').val(),
            is_tagih: jQuery('input[name=is_tagih]:checked').val(),
            primary_1: jQuery('#primary_1').val(),
            flag: jQuery('#flag').val(),
            post: true
        }, function(html) {
            setSubmitAddress(html)
            //alert(html);
        });
    }

    function deletePhone(url, id) {
        if (confirm("Do you want to proceed?")) {
            jQuery.post(url, {}, function(html) {
                telli(html);
                jQuery("#phone_" + id).remove();
            });
        }
    }

    function deleteAddress(url, id) {
        if (confirm("Do you want to proceed?")) {
            jQuery.post(url, {}, function(html) {
                telli(html);
                jQuery("#address_" + id + "_a").remove();
                jQuery("#address_" + id + "_b").remove();
                jQuery("#address_" + id + "_c").remove();
                jQuery("#address_" + id + "_d").remove();
                jQuery("#address_" + id + "_e").remove();
                jQuery("#address_" + id + "_f").remove();
                jQuery("#address_" + id + "_g").remove();
            });
        }
    }

    function addInfo(url, id) {
        if (id != 'add') {
            jQuery("#info_" + id).remove();
        }
        var info = jQuery('#info').val();
        jQuery.post(url, {
            info: info,
            primary_1: jQuery('#primary_1').val(),
            id_debtor_info: jQuery('#id_debtor_info').val(),
            post: true
        }, function(html) {
            setSubmitInfo(html)
            //alert(html);
        });
    }

    function setSubmitPhone(html) {
        notif.hide();
        set_berhasil("New Phone No Has been added");
        jQuery("#debtor_info").append(html);
    }

    function setSubmitAddress(html) {
        notif.hide();
        set_berhasil("New Address has been added");
        jQuery("#address_info").append(html);
    }

    function setSubmitInfo(html) {
        notif.hide();
        set_berhasil("New Info  Has been added");
        jQuery("#addInfo").append(html);
        jQuery("#view_info").remove();
    }

    // for valdo dial

    function get_phone(value) {
        //var phone = +value.replace(/\D/g,'');
        //alert(phone);

        /*if(confirm("Apakah ingin telefon otomatis?")){
        if(value!=""){
        location.href='<?php echo site_url() ?>/user/hdr_contact_cont/call_debtor/'+value;
        }
        }*/
        location.href = '<?php echo site_url() ?>/user/hdr_contact_cont/call_debtor/' + value;
        $('#no_contacted').val(value);
    }
    <?php
    $_SESSION['work'] = '1';
    $today = date("Y-m-d");
    //$max_ptp =  strtotime("$today + 7 days");
    //echo 'max'.$max_ptp;

    $sum = strtotime(date("Y-m-d", strtotime("$today")) . " +3 days");
    $maxptpdate = date('Y-m-d', $sum);
    //die($maxptpdate);
    $dateTo = date('l') . ' ' . date_formating(date('Y-m-d', $sum));
    ?>

    function checkCalltrack(url, go) {
        var id_action_call_track = jQuery('#id_action_call_track').val();
        var id_action = id_action_call_track.split(',');
        var remarks = jQuery('#remarks').val();
        var no_contacted = jQuery('#no_contacted').val();
        var incomming = jQuery('input[name=incomming]').val();
        var id_contact_co = jQuery('#id_contact_code').val().split(',');
        var id_contact_code = id_contact_co[0];
        var ptp_date = jQuery('input[name=ptp_date]').val();
        var ptp_amount = jQuery('#ptp_amount').val();
        var due_date = jQuery('input[name=due_date]').val();
        var due_time = jQuery('input[name=due_time]').val();
        var incomming = $('input[name=incomming]').attr('checked') ? no_contacted = '0' : 0;
        var ptp = [28];
        var ptpr = [4];
        var today = '<?= date('Y-m-d')
                        ?>';
        var maxptp = '<?= $maxptpdate
                        ?>';
        var angsur = '<?= $a_value[8]
                        ?>';
        var ptp_amount_ex = ptp_amount;
        //alert(ptp_date);
        if (go != 'loc') {
            if (id_action_call_track == "0") {
                telli("Please select Status");
            } else if (remarks == "") {
                telli("Please filled out Remarks");
            } else if (no_contacted == "") {
                //alert(incomming);
                telli("Please Choose the phone No fist ");
            } else if (inArray(id_action[0], ptp)) {
                //alert(maxptp);
                if (ptp_date == "") {
                    telli("Please select PTP Date");
                } else if (ptp_date > maxptp) {
                    telli("Tanggal PTP Tidak boleh lebih dari 7 hari");
                } else if (ptp_date < today) {
                    telli("Tanggal PTP Tidak boleh kurang dari hari ini");
                } else {
                    proceedCalltrack(url);
                }
            } else if (inArray(id_action_call_track, ptpr)) {
                if (due_date == "") {
                    telli("Please select Reminder Date");
                } else if (due_time == "") {
                    telli("Please select Reminder  Time");
                } else {
                    proceedCalltrack(url);
                }
            } else {
                proceedCalltrack(url);
                return false;
            }
        } else {

            window.location = url;
        }
    }

    function proceedCalltrack(url) {

        var id_debtor = new Array();
        jQuery("#id_debtor option:selected").each(function(id) {
            message = jQuery("#id_debtor option:selected").get(id);
            id_debtor.push(message.value);
        });
        var incomming_c = jQuery('#incomming').val();
        //var id_risk_code = jQuery('#id_risk_code').val();
        var ptp_amount = jQuery('input[name=ptp_amount]').val();
        var ptp_amount_ex = ptp_amount.replace(/\./g, '');
        var ptp_date = jQuery('input[name=ptp_date]').val();

        var incomming = $('input[name=incomming]').attr('checked') ? incomming_c = '1' : 0;
        var id_contact_co = jQuery('#id_contact_code').val().split(',');
        var id_ptp_co = jQuery('#id_ptp').val().split(',');
        var id_action_call_track = jQuery('#id_action_call_track').val();
        var id_call = id_action_call_track.split(',');
        //alert(id_call[1]);
        if (confirm("Do you want to proceed?")) {
            jQuery.post(url, {
                id_calltrack: jQuery('#id_calltrack').val(),
                id_action_call_track: id_call[0],
                code_call_track: id_call[1],
                id_call_cat: id_call[2],
                remarks: jQuery('#remarks').val(),
                kode_cabang: jQuery('#kode_cabang').val(),
                bucket: jQuery('#bucket').val(),
                primary_1: jQuery('#primary_1').val(),
                cname: jQuery('#cname').val(),
                no_contacted: jQuery('#no_contacted').val(),
                id_ptp: id_ptp_co[0],
                id_contact_code: id_contact_co[0],
                contact_code: id_contact_co[1],
                id_user: jQuery('#id_user').val(),
                username: jQuery('#username').val(),
                os_ar_amount: jQuery('#os_ar_amount').val(),
                ptp_date: jQuery('input[name=ptp_date]').val(),
                ptp_amount: ptp_amount_ex,
                due_date: jQuery('input[name=due_date]').val(),
                due_time: jQuery('input[name=due_time]').val(),
                date_in: jQuery('#date_in').val(),
                surveyor: jQuery('#surveyor').val(),
                dpd: jQuery('#dpd').val(),
                <?php
                //echo $contact_type;
                switch ($contact_type) {
                    case "ptp":
                        echo "ptp_fu : jQuery('#ptp_fu').val(), \n";
                        break;
                    case "no_contact_fu":
                        echo "fu : jQuery('#fu').val(),\n";
                        break;
                    case "contact_fu":
                        echo "fu : jQuery('#fu').val(),\n";
                        break;
                    default:
                        echo "\n";
                }
                ?>
                incomming: incomming_c,
                //previous : jQuery('#previous').val(),
                //id_mytask : jQuery('#id_mytask').val(),
                post: true
            }, function(html) {
                telli(html); //reload_flexiCalltrack(html);
                jQuery('#nextButton').fadeIn(1000);
                jQuery('.but_proceed').fadeOut(800);
                jQuery('#skip_call').fadeOut(800);


            });
        }
    }


    function sumaryPop(url) {
        jQuery.get(url, {}, function(html) {
            notif = new Boxy(html, {
                title: "Summary",
                modal: false,
                unloadOnHide: true,
                closeText: "[X] Close!"
            });
            notif.show();
        });

    }

    function popBlock2(url) {
        //notif.hide();
        loading('<h2>Get Data Please wait...<br/>if take more than 5 sec press F5</h2>');
        jQuery.get(url, {}, function(html) {
            uiPopUp2(html);
        });
    }

    function uiPopUp2(html) {
        notif.hide();
        jQuery.blockUI({
            message: html,
            css: {
                padding: 0,
                margin: 0,
                width: '885px',
                top: '5%',
                left: ($(window).width() - 885) / 2 + 'px',
                textAlign: 'center',
                color: '#000',
                border: '7px solid #000',
                backgroundColor: '#48B8F3',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                cursor: 'default'
            },
            baseZ: 1500,
            showOverlay: false,
            constrainTabKey: false,
            focusInput: false,
            onUnblock: null,
        });

        jQuery('#close').click(function() {
            jQuery.unblockUI();
            //notif.hide();
            return false;
        });
    }
</script>

<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.autocomplete.min.js"></script>
<link href="<?php echo base_url() ?>assets/css/jquery.autocomplete.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    $(function() {
        $("#name").autocomplete('<?= site_url() ?>user/hdr_contact_cont/autocomplete_name', {
            delay: 400,
            minChars: 3,
            max: 50,
            matchSubset: 1,
            matchContains: 1,
            cacheLength: 0,
            onItemSelect: selectItem,
            //autoFill:true
        });
    });
    $(function() {
        $("#search_acct").autocomplete('<?= site_url() ?>user/hdr_contact_cont/autocomplete_primary_1', {
            delay: 10,
            minChars: 5,
            max: 50,
            matchSubset: 1,
            matchContains: 1,
            cacheLength: 10,
            onItemSelect: selectItem,
            autoFill: false
        });
    });
    $(function() {
        $("#nxt_card").autocomplete('<?= site_url() ?>user/hdr_contact_cont/autocomplete_card_no', {
            delay: 10,
            minChars: 5,
            max: 50,
            matchSubset: 1,
            matchContains: 1,
            cacheLength: 10,
            onItemSelect: selectItem,
            autoFill: false
        });
    });
    $(function() {
        $("#search_card_no").autocomplete('<?= site_url() ?>user/hdr_contact_cont/autocomplete_card_no', {
            delay: 10,
            minChars: 8,
            max: 50,
            matchSubset: 1,
            matchContains: 1,
            cacheLength: 10,
            onItemSelect: selectItem,
            autoFill: false
        });
    });
    $(function() {
        $("#search_remark").autocomplete('<?= site_url() ?>user/hdr_contact_cont/autocomplete_remark', {
            delay: 10,
            minChars: 1,
            matchSubset: 1,
            matchContains: 1,
            cacheLength: 10,
            onItemSelect: selectItem,
            autoFill: true
        });
    });

    function selectItem(li, elementID) {
        $("#" + elementID).val(0);
        var setVal = (li.extra) ? li.extra[0] : 0;
        $("#" + elementID).val(setVal);
    }
</script>
<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/jquery.jeditable.mini.js"></script>
<script>
    $(document).ready(function() {
        $(".editphone").editable("<?= site_url() ?>user/hdr_contact_cont/blocked/", {
            indicator: "<img src='<?= base_url() ?>assets/images/ajax-loader.gif'> Saving...",
            type: 'textarea',
            submit: 'OK',
            name: 'phone_no',
            id: 'primary_1',
            tooltip: 'Click to edit...',
            cancel: 'Cancel',
            submit: 'Save',
        });
    });
    $(document).ready(function() {
        $(".editInfo").editable("<?= site_url() ?>user/hdr_contact_cont/get_info/edit", {

            indicator: "<img src='<?= base_url() ?>assets/images/ajax-loader.gif'> Saving...",
            type: 'textarea',
            height: '150px',
            submit: 'OK',
            name: 'info',
            id: 'primary_1',
            tooltip: 'Click to edit...',
            cancel: 'Cancel',
            submit: 'Save',
        });
    });
    //load last Calltrackt
    $(document).ready(function() {
        $('.last_call').load('<?= site_url() ?>user/hdr_contact_cont/last_call/<?= $primary_1 ?>');
    });
    $(document).ready(function() {
        $('.action_code_wom').load('<?= site_url() ?>user/hdr_contact_cont/action_code_wom/<?= $primary_1 ?>');
    });
    $(document).ready(function() {
        $('.other_info').load('<?= site_url() ?>user/hdr_contact_cont/other_info/<?= $primary_1 ?>');
    });
</script>
<link href="<?php echo base_url() ?>assets/css/timepicker.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/jquery.utils.lite.min.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>assets/js/ui.timepicker.js"></script>
<script type="text/javascript">
    $(function() {
        //$('#call_back_time').timepickr().focus();
        $('#call_back_time').timepickr({
            handle: '#trigger-test',
            convention: 24
        });
        $('#visit_time').timepickr({
            handle: '#trigger-test',
            convention: 24
        });
        // $('#time').timepickr({handle: '#trigger-test', convention: 24});
    });
    $(document).ready(function() {
        $('a.title').cluetip({
            splitTitle: '|'
        });
    });
</script>

<?php
$today = @$get_main_info->dpd;
$shift_now = @$get_main_info->shift;
$dpd = $today;
?>
<div class="cmidleft">
    <span class="boxmid_top"></span>
    <div class="boxmid_box">
        <table class="midleft">
            <form action="#" method="post">
                <tr class="listB">
                    <td class="tit">Name</td>
                    <td><input type="text" value="" style="width:200px" name="name_debt" id="name" /><input type="button" onclick="get_input('<?= site_url()
                                                                                                                                                ?>user/hdr_contact_cont/go_filter');return false;" name="submit" value="GO" /><img src="<?= base_url()
                                                                                        ?>assets/images/ico_company.png" style="" width="30" /></td>
                </tr>
                <tr class="listA">
                    <td class="tit">SEARCH ACCOUNT </td>
                    <td><input type="text" value="" style="width:200px" name="search_acct" id="search_acct" /><input type="submit" name="button" onclick="get_input('<?= site_url()
                                                                                                                                                                        ?>user/hdr_contact_cont/go_filter');return false;" value="GO" /></td>
                </tr>
                <tr class="listB">
                    <td class="tit">1. NO AGREEMENT</td>
                    <td><?= $a_value[0]
                        ?>
            </form>
            <tr class="listA">
                <td class="tit">2. NAMA</td>
                <td>
                    <h1><?= $a_value[1] ?></h1>
                </td>
            </tr>

            <?php if ($get_ptp_status->num_rows() > 0) : ?>
                <?php
                foreach ($get_ptp_status->result() as $ptp_row) {
                    $ptp_status = $ptp_row->ptp_status;
                    if ($ptp_status == '1')
                        $ptp_status = 'BROKEN';
                    elseif ($ptp_status == '2')
                        $ptp_status = 'KEEP';
                ?>

                    <tr class="listA">
                        <td class="tit">PTP STATUS</td>
                        <td><span class="max_ptp"><?= $ptp_status;
                                                    ?> ON <?= date_formating($ptp_row->call_date)
                    ?> <?= $ptp_row->username
                ?></span></td>
                    </tr>
                <?php } ?>
            <?php endif; ?>

            <tr class="listB">
                <td class="tit">3. GENDER</td>
                <td><?= $a_value[39] ?></td>
            </tr>
            <tr class="listA">
                <td class="tit">4. BUCKET</td>
                <td><?= $a_value[3] ?></td>
            </tr>
            <tr class="listB">
                <td class="tit">5. TENOR</td>
                <td><?= $a_value[4] ?></td>
            </tr>
            <tr class="listA">
                <td class="tit">6. DUE DATE</td>
                <td> <?= date_formating($a_value[5]) ?> </td>
            </tr>
            <tr class="listB">
                <td class="tit">7. Angs ke</td>
                <td><?= $a_value[6] ?></td>
            </tr>
            <tr class="listA">
                <td class="tit">8. O/S Balance</td>
                <td><?= ($a_value[7] != 'no DATA' && trim($a_value[7]) != '' && isset($a_value[7]) ? number_format($a_value[7]) : '')  ?></td>
            </tr>
            <tr class="listB">
                <td class="tit">9. AMOUNT DUE</td>
                <td class="currency">
                    <h2><?= @price_format($a_value[8]) ?></h2>
                </td>
            </tr>
            <tr class="listB">
                <td class="tit"> DENDA</td>
                <td class="currency">
                    <h2><?= @price_format($a_value[9]) ?></h2>
                </td>
            </tr>

        </table>
    </div>
    <span class="boxmid_bot"></span>

    <span class="boxmid_top"></span>
    <div class="boxmid_box">
        <table class="midleft" cellpadding="3" cellspacing="2">
            <tr class="listB">
                <td class="tit">10. REGION</td>
                <td><span class="max_ptp"><?= $a_value[11] ?></span></td>
            </tr>
            <tr class="listA">
                <td class="tit">11. BRANCH/POS</td>
                <td><?= $a_value[12] ?> / <?= $a_value[13] ?></td>
            </tr>
            <tr class="listB">
                <td class="tit">12. RESIDENCE CITY</td>
                <td><?= $a_value[14] ?></td>
            </tr>
            <tr class="listA">
                <td class="tit">13. RESIDENCE KECAMATAN</td>
                <td><?= $a_value[14] ?></td>
            </tr>
            <tr class="listB">
                <td class="tit">14. RESIDENCE KELURAHAN</td>
                <td><?= $a_value[16] ?></td>
            </tr>
            <tr class="listA">
                <td class="tit">15. ALAMAT KTP</td>
                <td><?= ($a_value[49] . ' ' . $a_value[50] . ' ' . $a_value[51] . ' ' . $a_value[52]) ?></td>
            </tr>
            <tr class="listB">
                <td class="tit">16. ALAMAT TAGIH</td>
                <td><?= $a_value[18]; ?></td>
            </tr>
            <tr class="listA">
                <td class="tit">17. ALAMAT LAIN</td>
                <td><?= $a_value[18] ?></td>
            </tr>

        </table>
    </div>
    <span class="boxmid_bot"></span>

    <span class="boxmid_top"></span>
    <div class="boxmid_box">
        <table class="midleft">
            <tr class="listA">
                <td class="tit">18. YEAR SALES</td>
                <td><?= $a_value[23] ?></td>
            </tr>
            <tr class="listB">
                <td class="tit">19. MONTH SALES</td>
                <td><?= $a_value[24] ?></td>
            </tr>
            <tr class="listA">
                <td class="tit">20. CMO/CRO NAME </td>
                <td><?= $a_value[25] ?></td>
            </tr>
            <tr class="listB">
                <td class="tit">21. COLLECTOR NAME</td>
                <td><?= $a_value[26] ?></td>
            </tr>
            <tr class="listA">
                <td class="tit">22. DEALER NAME</td>
                <td><?= $a_value[27] ?></td>
            </tr>
            <tr class="listB">
                <td class="tit">23. PRODUK</td>
                <td><?= $a_value[29] ?></td>
            </tr>
            <tr class="listA">
                <td class="tit">24. BRAND</td>
                <td><?= ($a_value[55] != 'no DATA' && trim($a_value[55]) != '' ? $a_value[55] : '')  ?></td>
            </tr>
            <tr class="listB">
                <td class="tit">25. MODEL</td>
                <td><?= $a_value[28] ?></td>
            </tr>
            <tr class="listA">
                <td class="tit">26. NO RANGKA, NO MESIN / NO Serial</td>
                <td><?= $a_value[35] ?></td>
            </tr>
            <tr class="listB">
                <td class="tit">26. NO POL</td>
                <td><?= $a_value[36] ?></td>
            </tr>
            <tr class="listA">
                <td class="tit">27. WARNA</td>
                <td><?= $a_value[37] ?></td>
            </tr>
        </table>
    </div>
    <span class="boxmid_bot"></span>

    <span class="boxmid_top"></span>
    <div class="boxmid_box" style="<?php if ($get_other_address->num_rows() > 0)
                                        echo 'height: 200px;width: 430px;overflow: scroll;'; ?>">
        <center>
            <h3>New Other Address</h3><br />
            <input type="button" id="view_phone" value="Add New Address" style="text-align:center; font-size:12px;  padding-bottom:5px; background:url(<?php echo base_url() ?>assets/images/but_clean.png); border:none;width:115px; height:31px;" onclick="boxPopup('Add New  Address','<?php echo site_url() ?>user/hdr_contact_cont/get_address/<?= $a_value[0] ?>');return false;" />
        </center><br />
        <table class="midleft" id="address_info">
            <?php
            if ($get_other_address->num_rows() > 0) {
                $noadd = 1;
                foreach ($get_other_address->result() as $new_address) {
            ?>
                    <tr class="listB" id="address_<?= $new_address->id_address
                                                    ?>_a">
                        <td class="tit">NEW ADDRESS</td>
                        <td style="font-weight:bold;"><?= $new_address->address
                                                        ?></td>
                    </tr>
                    <tr class="listA" id="address_<?= $new_address->id_address
                                                    ?>_b">
                        <td class="tit">CITY</td>
                        <td style="font-weight:bold;"><?= $new_address->city
                                                        ?></td>
                    </tr>
                    <tr class="listB" id="address_<?= $new_address->id_address
                                                    ?>_c">
                        <td class="tit">POS CODE</td>
                        <td style="font-weight:bold;"><?= $new_address->zip_code
                                                        ?></td>
                    </tr>
                    <tr class="listA" id="address_<?= $new_address->id_address
                                                    ?>_d">
                        <td class="tit">ADDRESS TYPE</td>
                        <td style="font-weight:bold;"><?= $new_address->type
                                                        ?></td>
                    </tr>
                    <tr class="listB" id="address_<?= $new_address->id_address
                                                    ?>_d">
                        <td class="tit">Phone No</td>
                        <td style="font-weight:bold;"><?= $new_address->phone_no
                                                        ?></td>
                    </tr>
                    <tr class="listA" id="address_<?= $new_address->id_address
                                                    ?>_e">
                        <td class="tit">ALAMAT TAGIH</td>
                        <td style="font-weight:bold;"><?= ($new_address->is_tagih == 1) ? 'Yes' : 'No' ?></td>
                    </tr>
                    <tr class="listB" id="address_<?= $new_address->id_address
                                                    ?>_f">
                        <td class="tit">&nbsp;</td>
                        <td style="font-weight:bold;text-align:right;">
                            <a id="no_under" class="title" title="Created by : <?= $new_address->username
                                                                                ?>|Created Date : <?= $new_address->createdate
                                ?>" href="#">Info</a>
                            | <a href="#" onclick="boxPopup('Edit New Address','<?= site_url()
                                                                                ?>user/hdr_contact_cont/get_address/edit/<?= $new_address->id_address
                                                        ?>');return false;">Edit</a> |
                            <a href="#" onclick="deleteAddress('<?= site_url()
                                                                ?>user/hdr_contact_cont/delete_address/<?= $new_address->id_address
                                                    ?>','<?= $new_address->id_address
                    ?>')">Delete</a>
                            &nbsp;
                        </td>
                    </tr>
                    <tr id="address_<?= $new_address->id_address
                                    ?>_g">
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
            <?php
                    $noadd++;
                }
            }
            ?>
        </table>
    </div>
    <span class="boxmid_bot"></span>

    <span class="boxmid_top"></span>
    <div class="boxmid_box">
        <table class="midleft">
            <!--Inside Calltrack-->
            <div class="last_call" style="">
                <center><img src="<?= base_url()
                                    ?>assets/images/loader.gif" /></center>
            </div>
        </table>
    </div>
    <span class="boxmid_bot"></span>
    <span class="boxmid_top"></span>
    <div class="boxmid_box">
        <center>
            <?php $details = $a_value[1] . '&' . $a_value[15] . '&' . $a_value[23] . '&' . $a_value[0] . '&' . $a_value[8] . '&' . $a_value[13] . '&' . $a_value[2];
            $details2 = $a_value[1] . '&' . $a_value[15] . '&' . $a_value[23] . '&' . $a_value[0] . '&' . $a_value[8] . '&' . $a_value[13] . '&' . $a_value[2]; ?>
            <?php $name = base64_encode($a_value[1]); ?>
            <input type="button" class="but_sp" onclick="popBlock('<?= site_url() ?>user/hdr_contact_cont/hist_payment/<?= $this->uri->segment(5) ?>/<?= $name ?>'); return false;" value="HISTORY PAYMENT" />
            <input type="button" class="but_sp" value="HISTORY REMINDER" onclick="popBlock('<?= site_url() ?>user/hdr_contact_cont/hist_call_track/all/rem/<?= $name ?>'); return false;" /><br />
            <input type="button" class="but_htcall" onclick="popBlock('<?= site_url() ?>user/hdr_contact_cont/hist_call_track/<?= $this->uri->segment(5) ?>/all/<?= $name ?>'); return false;" />

            <!--<input type="button" class="but_htagen" onclick="popBlock('<?= site_url() ?>user/hdr_contact_cont/hist_agen_track/<?= $a_value[0] ?>/<?= $name ?>'); return false;" />-->
            <input type="button" class="but_histptp" onclick="popBlock('<?= site_url() ?>user/hdr_contact_cont/hist_call_track/<?= $this->uri->segment(5) ?>/ptp/<?= $name ?>'); return false;" />
            <br />

            <?php if ($get_other_info->num_rows() == 0) { ?>
                <input type="button" class="but_sp" id="view_info" value="Add Notes" onclick="boxPopup('Add New Notes','<?php echo site_url() ?>user/hdr_contact_cont/get_info/popup/<?= $a_value[0] ?>');return false;" />
            <?php } ?>
            <br />
            <br />
            <table class="midleft" id="addInfo">
                <center>Click Personal Messages di bawah ini untuk Edit</center>
                <br />
                <?php
                if ($get_other_info->num_rows() > 0) {
                    $i = 1;
                    $no_p = 65;
                ?>
                    <?php foreach ($get_other_info->result() as $new_info) {
                        $i++; ?>
                        <tr class="listA" id="info_<?= $new_info->primary_1 ?>">
                            <td class="tit" style="font-weight:bold;">
                                <div class="editInfo" id="<?= $a_value[0] ?>"><?= strtoupper($new_info->info) ?></div><a class="title" id="no_under" title="Created by : <?= $new_info->username ?>|Created Date : <?= $new_info->createdate ?>" href="#">&nbsp;&nbsp;- Edit By -&nbsp;&nbsp;
                            </td></a>
                        </tr>
                <?php
                    }
                } else {
                }
                ?>
            </table>
        </center>
    </div>
    <span class="boxmid_bot"></span>


    <!-- Finish Calltrack-->
</div>

<div class="cmidleft">


    <span class="boxmid_top"></span>
    <div class="boxmid_box">
        <table class="midleft">
            <tr class="listA">
                <td class="tit">28. EMERGENCY CONTACT</td>
                <td><?= ($a_value[49] != 'NULL' ? $a_value[49] : '') ?></td>
            </tr>
            <tr class="listB">
                <td class="tit">29. HUBUNGAN DENGAN EMERGENCY</td>
                <td><?= $a_value[50]
                    ?></td>
            </tr>
            <tr class="listA">
                <td class="tit">24. TELP RUMAH</td>
                <td><?= ($a_value[20] != 'NULL' ? $a_value[20] : '') ?></td>
                <td class="call"><input type="button" value="Call" onclick="get_phone('<?= clean_phone($a_value[20])
                                                                                        ?>')" /></td>
            </tr>
            <tr class="listB">
                <td class="tit">25. TELP KANTOR</td>
                <td><?= ($a_value[19] != 'NULL' ? $a_value[19] : '') ?></td>
                <td class="call"><input type="button" value="Call" onclick="get_phone('<?= clean_phone($a_value[19])
                                                                                        ?>')" /></td>
            </tr>
            <tr class="listA">
                <td class="tit">26. HP</td>
                <td><?= ($a_value[21] != 'NULL' ? $a_value[21] : '') ?></td>
                <td class="call"><input type="button" value="Call" onclick="get_phone('<?= clean_phone($a_value[21])
                                                                                        ?>')" /></td>
            </tr>
            <tr class="listB">
                <td class="tit">27. EMERGENCY PHONE</td>
                <td><?= ($a_value[22] != 'NULL' ? $a_value[22] : '') ?></td>
                <td class="call"><input type="button" value="Call" onclick="get_phone('<?= clean_phone($a_value[22])
                                                                                        ?>')" /></td>
            </tr>
            <tr class="listA">
                <td class="tit">For Incoming Call</td>
                <td><input type="checkbox" name="incomming" id="incomming" value="" />
                <td class="call"></td>
            </tr>
            <tr class="listB">
                <td class="tit">32. <strong>108</strong></td>
                <td>
                    <h3>108</h3>
                </td>
                <td class="call"><input type="button" value="Call" onclick="get_phone('108')" /></td>
            </tr>
        </table>
    </div>
    <span class="boxmid_bot"></span>

    <span class="boxmid_top"></span>
    <div class="boxmid_box">
        <center>
            <h2>New Phone No.</h2>
        </center>

        <br />
        <center><input type="button" id="view_phone" value="Add New Phone" style="text-align:center; font-size:12px;  padding-bottom:5px; background:url(<?php echo base_url() ?>assets/images/but_clean.png); border:none;width:115px; height:31px;" onclick="boxPopup('Add New Phone Number','<?php echo site_url() ?>user/hdr_contact_cont/get_phone_no/<?= $a_value[0] ?>');return false;" /></center>
        <table id="debtor_info" class="midleft">

            <?php

            function clean_phone($phones)
            {
                $clean_no = preg_replace('/[^0-9]/', '', $phones);
                return $clean_no;
            }
            ?>
            <?php
            if ($get_other_phone->num_rows() > 0) {
                $i = 1;
                $no_p = 65;
            ?>
                <?php foreach ($get_other_phone->result() as $new_phone) {
                    $i++; ?>
                    <tr class="list<?= $i % 2 == 0 ? "A" : "B"; ?>" id="phone_<?= $new_phone->id_phone ?>">
                        <td class="tit"><?= $no_p + $i ?>. <?= $new_phone->phone_type ?></td>
                        <td><?= $new_phone->phone_no ?></td>
                        <td class="call"><input type="button" value="Call" onclick="get_phone('<?= clean_phone($new_phone->phone_no) ?>')" /> &nbsp;&nbsp;
                            <a id="no_under" class="title" title="Created by : <?= $new_phone->username ?>|Created Date : <?= $new_phone->createdate ?>" href="#">Info</a>&nbsp;&nbsp;
                            <a href="#" onclick="boxPopup('Edit Phone No','<?= site_url() ?>user/hdr_contact_cont/get_phone_no/edit/<?= $new_phone->id_phone ?>');return false;">Edit</a>&nbsp;|&nbsp;
                            <a href="#" onclick="deletePhone('<?= site_url() ?>user/hdr_contact_cont/delete_phone/<?= $new_phone->id_phone ?>','<?= $new_phone->id_phone ?>')">Delete</a>
                        </td>
                    </tr>
            <?php
                }
            } else {
            }
            ?>

            <br></br>
        </table>
    </div>
    <span class="boxmid_bot"></span>

    <span class="boxmid_top"></span>
    <div class="boxmid_box">
        <table class="midleft">
            <tr class="listB">
                <td class="tit">36. TEMPAT/TGL LAHIR</td>
                <td><?= $a_value[38]
                    ?></td>
            </tr>
            <tr class="listB">
                <td class="tit">37. STATUS PERKAWINAN</td>
                <td><?= $a_value[40]
                    ?></td>
            </tr>
            <tr class="listB">
                <td class="tit">38. UMUR</td>
                <td><?= $a_value[41]
                    ?></td>
            </tr>
            <tr class="listA">
                <td class="tit">39. NAMA IBU KANDUNG</td>
                <td class="currency"><?= $a_value[42]
                                        ?></td>
            </tr>
            <tr class="listB">
                <td class="tit">40. STATUS RUMAH</td>
                <td class="currency"><?= $a_value[43]
                                        ?></td>
            </tr>
            <tr class="listB">
                <td class="tit">41. PEKERJAAN</td>
                <td class="currency"><?= $a_value[44]
                                        ?></td>
            </tr>
        </table>

    </div>
    <span class="boxmid_bot"></span>

    <span class="boxmid_top"></span>
    <div class="boxmid_box">

        <br />
        <br />
        <select class="fbsx" id="id_action_call_track" name="id_action_call_track" style="width:32em;">
            <option selected="selected" value="0">Action Code</option>
            <?php foreach ($action_call_track->result() as $row_call) { ?>
                <option value="<?= $row_call->id_action_call_track ?>,<?= $row_call->code_call_track ?>,<?= $row_call->id_call_cat ?>"><?= $row_call->code_call_track ?>:&nbsp;&nbsp;&nbsp;<?= $row_call->description ?>&nbsp;&nbsp;&nbsp;(<?= $row_call->contact ?>)</option>
            <?php } ?>
        </select>
        <br />
        <br />

        <br />
        <div style="display:none;" id="cont_ptp">

            <br />PTP Date
            <input type="text" id="datepicker" name="ptp_date" class="ptp_date" size="15" value="" />
            PTP Amount
            <input type="text" name="ptp_amount" id="ptp_amount" class="ptp_amount" value="<?= $a_value[8] ?>" />
        </div>
        <div style="display:none;" id="call_back">
            <br />Reminder Date
            <input type="text" id="datepicker2" name="due_date" class="due_date" size="15" />
            Time Call
            <input type="text" name="due_time" class="call_b" id="call_back_time" value="" />
            <!--<img src="<?= base_url() ?>assets/images/clock.png" alt="Time" border="0" style="position:absolute;margin:4px 0 0 6px;" id="trigger-test" />-->
            <br />
            <br />
            <br />
        </div>
        <br />
        <h3><span class="max_ptp">Maximum Tanggal PTP adalah <?= $dateTo ?></span></h3>
        <br />
        <select class="fbsx" id="id_contact_code" name="id_contact_code" style="width:10em;">
            <option selected="selected" value="">Catagory Call</option>
            <?php foreach ($call_catagory->result() as $row_loc) { ?>
                <option value="<?= $row_loc->code ?>,<?= $row_loc->description ?>"><?= $row_loc->description ?></option>
            <?php } ?>
        </select>
        <select class="fbsx" id="id_ptp" name="id_ptp" onchange="changePTP(this.value)" style="width:10em;">
            <option selected="selected" value="">Catagory PTP</option>
            <?php foreach ($ptp_catagory->result() as $row_ptp) { ?>
                <option value="<?= $row_ptp->code ?>,<?= $row_ptp->description ?>"><?= $row_ptp->description ?></option>
            <?php } ?>
        </select>
        <br />
        <textarea class="fbtx" id="remarks" name="remarks" value=""></textarea>
        <br />
        <br />
        <input type="button" class="but_proceed" onclick="checkCalltrack('<?php echo site_url() ?>user/hdr_contact_cont/insert_calltrack/','1');return false;" />
        <br />
        <br />
        <?php if ($this->uri->segment(4) != 'call') {
        ?>
            <input type="button" class="but_reg" value='SKIP CALL' id="skip_call" onclick="parent.location='<?php echo site_url() ?>user/hdr_contact_cont/contact/<?= $contact_type ?>'" />
        <?php } ?>
        <br />
        <br />
        <br />


        <div style="display:none;" id="nextButton">

            <br />
            <br />
            <br />
            <input type="button" class="but_sp" value="Next" <?php
                                                                switch ($contact_type) {
                                                                    case "ptp":
                                                                        echo 'onclick="checkCalltrack(\'' . site_url() . 'user/hdr_contact_cont/contact/ptp\',\'loc\');return false;"';
                                                                        break;
                                                                    case "no_contact_fu":
                                                                        echo 'onclick="checkCalltrack(\'' . site_url() . 'user/hdr_contact_cont/contact/no_contact_fu\',\'loc\');return false;"';
                                                                        break;
                                                                    case "contact_fu":
                                                                        echo 'onclick="checkCalltrack(\'' . site_url() . 'user/hdr_contact_cont/contact/contact_fu\',\'loc\');return false;"';
                                                                        break;
                                                                    default:
                                                                        echo 'onclick="checkCalltrack(\'' . site_url() . '/user/hdr_contact_cont/contact/call\',\'loc\');return false;"';
                                                                }
                                                                ?> /></form>
        </div>
        <input type="hidden" id="primary_1" name="primary_1" value="<?= $a_value[0]
                                                                    ?>" />
        <input type="hidden" id="id_user" name="id_user" value="<?= $id_user
                                                                ?>" />
        <?php
        switch ($contact_type) {
            case "ptp":
                echo '<input type="hidden" id="ptp_fu" name="ptp_fu" value="1"   />';
                break;
            case "no_contact_fu":
                echo '<input type="hidden" id="fu" name="fu" value="1"   />';
                break;
            case "contact_fu":
                echo '<input type="hidden" id="fu" name="fu" value="1"   />';
                break;
            default:
                echo '';
        }
        ?>
        <?php //$get_in_use = $this->call_track_model->get_latest_use($a_value[0],$id_user,$in_use);         
        ?>
        <input type="hidden" id="id_calltrack" name="id_calltrack" value="<?php //@$get_in_use->id_calltrack            
                                                                            ?>" />
        <input type="hidden" id="username" name="username" value="<?= $username ?>" />
        <input type="hidden" id="cname" name="cname" value="<?= $a_value[1] ?>" />
        <input type="hidden" id="kode_cabang" name="kode_cabang" value="<?= $a_value[10] ?>" />
        <input type="hidden" id="no_contacted" name="no_contacted" value="" />
        <input type="hidden" id="os_ar_amount" name="os_ar_amount" value="<?= $a_value[13] ?>" />
        <input type="hidden" id="surveyor" name="surveyor" value="<?= $a_value[7] ?>" />
        <input type="hidden" id="dpd" name="dpd" value="<?= $dpd ?>" />
        <br />
        <br />
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        <br />
        <center><input type="button" class="but_reg" value="View Dashboard" onclick="boxPopup('View Dashboard','<?php echo site_url('user/hdr_contact_cont/summary_pop/' . $primary_1) ?>')" /></center>
        <br />
        <br />

        <!-- Other info Reminder , Active Records,  Reschedule -->
        <!--<div class='other_info'><center><img src="<?= base_url() ?>assets/images/loader.gif" /></div>-->
    </div>
    <span class="boxmid_bot"></span>
</div>
<p class="clear"></p>

<script>
    $('.ptp_amount').priceFormat({
        prefix: '',
        centsSeparator: '',
        thousandsSeparator: '.',
        centsLimit: 0
    });

    $('.phone_no').priceFormat({
        prefix: '',
        centsSeparator: '',
        thousandsSeparator: '',
        centsLimit: 0
    });
</script>