<style>
	table{
		border-collapse: collapse;
	}
</style>
<?php if($detail_sale != null) { ?>


<div> 

<table width="100%" class="table" style="margin-top:0;padding-top:0;margin-bottom:0;padding-bottom:0">
    <thead>
    
    <tr> 
    <?php if($isOnlyMonth == true) { ?> 
        <td width="15%"></td>
            <td width="10%"></td>
            <td width="10%"></td>
            <td width="10%"></td>
            <td width="10%"></td>
            <td width="8%"></td>
            <td width="7%"></td>
            <td width="10%"></td>
            <td width="10%"></td>
            <td width="10%"></td>
    <?php } else { ?>
        <td width="5%"></td>
            <td width="12%"></td>
            <td width="12%"></td>
            <td width="12%"></td>
            <td width="10%"></td>
            <td width="8%"></td>
            <td width="7%"></td>
            <td width="12%"></td>
            <td width="12%"></td>
            <td width="10%"></td>
    <?php } ?>
        </tr>
    
    </thead>
    <tbody>


<?php
        if(isset($detail[0]["place_buy"])) {
            foreach ($detail[0]["place_buy"] as $keyBuy => $valueBuy) {
                if($valueBuy['place_sale_id'] == $detail_sale['place_sale_id']) {
                $totalQuantityFactory = 0;
                $totalAmountFactory = 0;
    ?>
        <tr>
            <td colspan="10"><span style="font-weight: bold;"><?php echo $valueBuy['place_buy_name']; ?></span><?php if($isOnlyMonth == false) { ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 対象期間 <?php echo $date_from; ?> ～ <?php echo $date_to; ?><?php } ?></td>
        </tr>
        <?php
                    if(isset($detail[0]["detail"])) {
                        $detail_date_a = "";
                        foreach ($detail[0]["detail"] as $keyDetail => $valueDetail) {
                            if($valueBuy['place_sale_id'] == $valueDetail['place_sale_id'] && $valueBuy['place_buy_id'] == $valueDetail['place_buy_id']) {
                                $amount_product = $valueDetail['price'] * $valueDetail['number_import'];
                                $totalQuantityFactory += $valueDetail['number_import'];
                                $totalAmountFactory += $amount_product;
                                
                                // Date
                                $detail_date_b = "";
                                $view_date = "";
                                if(empty($detail_date_a)) {
                                    $detail_date_a = $valueDetail['detail_date'];
                                }
                                else {
                                    $detail_date_b = $valueDetail['detail_date'];
                                }

                                if($detail_date_a != $detail_date_b) {
                                    $detail_date_a = $valueDetail['detail_date'];
                                    $detail_date_b = $detail_date_a;
                                    $view_date = $valueDetail['detail_date'];
                                }
                    ?>
        <tr> 
        <?php if($isOnlyMonth == true) { ?>
            <td><?php echo $view_date; ?></td>
    <?php } else { ?>
        <td></td>
    <?php } ?>
            
            <td><?php echo $valueDetail['product_sale_code']; ?></td>
            <td><?php echo $valueDetail['product_sale_name']; ?></td>
            <td><?php echo $valueDetail['product_color']; ?></td>
            <td><?php echo $valueDetail['product_format']; ?></td>
            <td><?php echo $valueDetail['note']; ?></td>
            <td class="text-right"><?php echo number_format($valueDetail['number_import'],0,",",","); ?></td>
            <td class="text-right">¥<?php echo number_format($valueDetail['price'],0,",",","); ?></td>
            <td class="text-right">¥<?php echo number_format($amount_product,0,",",","); ?></td>
            <td class="text-right"><img src="<?php echo base_url('asset/images/box_checked_report.png'); ?>" alt=""> <?php echo $valueDetail['base_name']; ?></td>
        </tr>
<?php } } } ?>
<tr> 
            <td colspan="6" class="text-right">小 計</td>
            <td class="text-right"><?php echo number_format($totalQuantityFactory,0,",",","); ?></td>
            <td colspan="2" class="text-right"><?php echo number_format($totalAmountFactory,0,",",","); ?></td>
            <td class="text-right"></td>
        </tr>
    <?php } } } ?>










    </tbody>
</table>





                
</div>
<div>
&nbsp;
</div>
<?php } ?>