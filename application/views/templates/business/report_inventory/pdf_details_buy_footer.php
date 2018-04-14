<div> 
    <table width="100%" class="table">
        <tbody>
            <tr>
                <td width="20%">お振込みは右記の銀行にお<br>願い申し上げます。</td>
                <?php 
                $base_bank = "";
                $base_brach = "";
                $base_number = "";
                if(isset($detail[0]["base_bank"])) {
                    foreach ($detail[0]["base_bank"] as $keyBank => $valueBank) {
                        if($valueBank['place_sale_id'] == $detail_sale['place_sale_id']) {
                            $base_bank .= '<div>'.$valueBank['base_bank'].'</div>';
                            $base_brach .= '<div>'.$valueBank['base_brach'].'</div>';
                            $base_number .= '<div>'.$valueBank['base_number'].'</div>';
                } } } ?>
                <td width="20%"><?php echo $base_bank; ?></td>
                <td width="20%"><?php echo $base_brach; ?></td>
                <td width="20%"><?php echo $base_number; ?></td>
                <td width="20%"><img src="<?php echo base_url('asset/images/box_chuky.png'); ?>" alt=""></td>
            </tr>

        </tbody>
    </table>
</div>