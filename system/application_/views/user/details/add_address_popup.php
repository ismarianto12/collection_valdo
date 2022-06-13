<div style="width:620px;height:240px;overflow:auto" align="center">
    <form action="#" method="post">

        <table cellpadding="2" cellspacing="2" width="600" style="font:bold 12px Verdana;" align="center">
            <tr>
                <td width="150">Jenis Alamat</td>
                <td width=""><select name="type" id="type">
                        <option value="Alamat Rumah" <?= (@$type == 'Alamat Rumah') ? 'selected' : '' ?>>Alamat Rumah</option>
                        <option value="Alamat Kantor" <?= (@$type == 'Alamat Kantor') ? 'selected' : '' ?>>Alamat Kantor</option>
                        <option value="Emergency" <?= (@$type == 'Emergency') ? 'selected' : '' ?>>Emergency</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td><textarea class="fbtx" id="address" name="address"><?= @$address ?></textarea></td>
            </tr>
            <tr>
                <td>Kota</td>
                <td><input type="text" name="city"  id="city" value="<?= @$city ?>"/></td>
            </tr>
            <tr>
                <td>Kode Pos</td>
                <td><input name="zip_code" type="text"  id="zip_code" value="<?= @$zip_code ?>" maxlength="5"/></td>
            </tr>
            <tr>
                <td>No Telp</td>
                <td><input name="phone_no" type="text"  id="phone_no" value="<?= @$phone_no ?>" maxlength="15"/></td>
            </tr>
            <tr>
                <td>Alamat Tagih</td>
                <td><input type="checkbox" name="is_tagih" id="is_tagih" value="1" <?= (@$is_tagih == 0) ? '' : 'checked' ?> /></td>
            </tr>
            <tr>
                <td>&nbsp;<input type="hidden" name="primary_1" id="primary_1" value="<?php echo $this->uri->segment(4) ?>" /></td>
                <td><input type="hidden" name="flag" id="flag" value="<?= @$flag ?>" />
                    <input type="hidden" name="id_address" id="id_address" value="<?= @$id_address ?>" /></td>
            </tr>
            <tr>
                <td>&nbsp;</td>
                <td><input type="button" value="<?= strtoupper(@$flag) ?>" class="but_reg" id="hai" onclick="addAddress('<?= site_url() ?>user/hdr_contact_cont/get_address/','<?= @$id_address ?>');return false;"></td>
            </tr>
        </table>
    </form>