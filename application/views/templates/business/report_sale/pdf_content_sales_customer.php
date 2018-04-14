<style>
	.fontJapan {
		font-family : "sun-exta";
	}
    table{
		border-collapse: collapse;
	}
</style>
<p class="color030a84 size120">グループコード グループ名</p>
    <div>
        <table width="100%" class="table"> 
            <thead>
                <tr>
                    <th width="10%" class="text-center border-bottom2 color030a84 size120">売上日</th>
                    <th width="10%" class="text-center border-bottom2 color030a84 size120">部署ｺｰﾄﾞ</th>
                    <th width="10%" class="text-center border-bottom2 color030a84 size120">部署名</th>
                    <th width="10%" class="text-center border-bottom2 color030a84 size120">商品コード</th>
                    <th width="10%" class="text-center border-bottom2 color030a84 size120">商品名</th>
                    <th width="10%" class="text-center border-bottom2 color030a84 size120">規格</th>
                    <th width="10%" class="text-center border-bottom2 color030a84 size120 fontJapan">ＣＯＬＯＲ</th>
                    <th width="10%" class="text-right border-bottom2 color030a84 size120">数量の合計</th>
                    <th width="10%" class="text-right border-bottom2 color030a84 size120">単価</th>
                    <th width="10%" class="text-right border-bottom2 color030a84 size120">金 額</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($category)) { ?>
                    <tr>
                        <th class="text-center"><?php echo $category['group_code']; ?></th>
                        <th class="text-left" colspan="9"><?php echo $category['code']; ?></th>
                    </tr>
                <?php } ?>
                <?php if(isset($department)) {
                    $totalQuantityAll = 0;
                    $totalAmountAll = 0;
                    foreach ($department as $key => $value) {
                        if($value["group_code"] == $category['group_code']) {
                        $totalQuantity = 0;
                        $totalAmount = 0;
                    ?>
                    <tr>
                        <th class="text-left"><?php echo $date_report; ?></th>
                        <th class="text-center"><?php echo $value['department_code']; ?></th>
                        <th class="text-center"><?php echo $value['department_name']; ?></th>
                        <th class="text-center">&nbsp;</th>
                        <th class="text-center">&nbsp;</th>
                        <th class="text-center">&nbsp;</th>
                        <th class="text-center">&nbsp;</th>
                        <th class="text-right">&nbsp;</th>
                        <th class="text-right">&nbsp;</th>
                        <th class="text-right">&nbsp;</th>
                    </tr>
                    <?php if(isset($detail)) {
                    foreach ($detail as $keyDetail => $valueDetail) {
                        if($valueDetail["group_code"] == $category['group_code'] && $value["department_code"] == $valueDetail['department_code']) {
                        $totalQuantity += $valueDetail['product_quantity'];
                        $totalAmount += $valueDetail['product_amount'];
                        $totalQuantityAll += $valueDetail['product_quantity'];
                        $totalAmountAll += $valueDetail['product_amount'];
                    ?>
                        <tr>
                            <td class="text-left">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center">&nbsp;</td>
                            <td class="text-center"><?php echo $valueDetail['product_code']; ?></td>
                            <td class="text-center"><?php echo $valueDetail['product_name']; ?></td>
                            <td class="text-center"><?php echo $valueDetail['product_format']; ?></td>
                            <td class="text-center"><?php echo $valueDetail['product_color']; ?></td>
                            <td class="text-right"><?php echo number_format($valueDetail['product_quantity'],0,",",","); ?></td>
                            <td class="text-right"><?php echo number_format($valueDetail['product_price'],0,",",","); ?></td>
                            <td class="text-right"><?php echo number_format($valueDetail['product_amount'],0,",",","); ?></td>
                        </tr>
                    <?php } } } ?>
                    <tr>
                        <td class="text-left">&nbsp;</td>
                        <td class="text-center sizeBig">小計</td>
                        <td class="text-center">&nbsp;</td>
                        <td class="text-center">&nbsp;</td>
                        <td class="text-center">&nbsp;</td>
                        <td class="text-center">&nbsp;</td>
                        <td class="text-center">&nbsp;</td>
                        <th class="text-right"><?php echo number_format($totalQuantity,0,",",",");?></th>
                        <th class="text-right">&nbsp;</th>
                        <th class="text-right"><?php echo number_format($totalAmount,0,",",",");?></th>
                    </tr>
                <?php } } } ?>
                <tr>
                    <td class="text-left">&nbsp;</td>
                    <td class="text-center sizeBig">合計</td>
                    <td class="text-center">&nbsp;</td>
                    <td class="text-center">&nbsp;</td>
                    <td class="text-center">&nbsp;</td>
                    <td class="text-center">&nbsp;</td>
                    <td class="text-center">&nbsp;</td>
                    <th class="text-right"><?php echo number_format($totalQuantityAll,0,",",",");?></th>
                    <th class="text-right">&nbsp;</th>
                    <th class="text-right"><?php echo number_format($totalAmountAll,0,",",",");?></th>
                </tr>
                
            </tbody>
        </table>
    </div>