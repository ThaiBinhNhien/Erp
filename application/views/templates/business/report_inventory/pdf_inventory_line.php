		<!-- CSS -->
		<style>
            body {
                font-size: 90%; 
            }
            table{
                border-collapse: collapse;
            }
			h1 {
				font-weight: 900;
			}
			table tbody tr td, table tbody tr th {
				padding: 2px 5px;
			}
			.text-center {
				text-align: center;
			}
			.text-left {
				text-align: left;
			}
			.text-right {
				text-align: right;
			}
			.border {
				border: 1px solid #000;
			}
			.border-left {
				border-left: 1px solid #000;
			}
			.border-right {
				border-right: 1px solid #000;
			}
			.border-top {
				border-top: 1px solid #000;
			}
			.border-bottom {
				border-bottom: 1px solid #000;
			}
			.border-bottom2{
				border-bottom: 2px solid #030a84;
			}
			.border-top2{
				border-top: 2px solid #030a84;
			}
			.color030a84{
				color: #030a84;
			}
			.table-border {
				border-bottom: 1px solid #000;
			}
			.table-border tbody tr td, .table-border tbody tr th{
				border-top: 1px solid #000;
				border-left: 1px solid #000;
			}
			.table-border thead tr th {
				border-top: 1px solid #000;
				border-left: 1px solid #000;
			}
			.table-border thead tr th {
				border-right: 1px solid #000;
			}
			table tbody tr td.padding-left {
				padding-left: 0 !important;
			}
			table tbody tr td.padding-right {
				padding-right: 0 !important;
			}
			.size120 {
				font-size: 120%;
			}
			.sizeBig {
				font-size: 120%;
				font-weight: bold;
				color: #000;
			}
            .borTopIn {
                border-top: 2px solid #000;
                padding-top: 5px;
            }
            .borBotIn {
                border-bottom:3px solid #000;
                padding-bottom: 5px;
            }
            .box-factory {
                font-size: 140%;
                background-color: #bbfbf4;
            }
            .borderDotted {
                border-bottom: 1px dotted #000;
            }
            .borderBottom {
                border-bottom:3px solid #000;
            }
		</style>
        <div>
            <table width="100%">
                <tbody>
                    <tr>
                        <td class="text-left"><span class="text-center" style="font-size: 42px;"><?php echo $title;?></span> &nbsp;&nbsp;&nbsp;&nbsp; 新品在庫=貯蔵品 </td>
                        <td class="text-right"> <?php echo $date_report_now; ?> 現在</td>
                    </tr>
                    <tr> 
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            <table width="100%">
                <thead>
                    <tr>
                        <th width="15%" class="size120 borTopIn borBotIn">&nbsp;&nbsp;仕 入 先 名</th>
                        <th width="15%" class="size120 borTopIn borBotIn">商品名</th>
                        <th width="10%" class="size120 borTopIn borBotIn">&nbsp;</th>
                        <th width="10%" class="size120 borTopIn borBotIn">&nbsp;</th>
                        <th width="10%" class="size120 borTopIn borBotIn">備考</th>
                        <th width="10%" class="size120 borTopIn borBotIn">主な使用先</th>
                        <th width="10%" class="size120 text-right borTopIn borBotIn text-right">在庫数</th>
                        <th width="10%" class="size120 borTopIn borBotIn text-right">&nbsp;</th>
                        <th width="10%" class="size120 borTopIn borBotIn text-right">&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if(isset($detail) && isset($detail[0]["factory"])) {
                        $totalQuantity = 0;
                        $totalAmount = 0;
                        foreach ($detail[0]["factory"] as $key => $value) {
                            $totalQuantityFactory = 0;
                            $totalAmountFactory = 0;
                    ?>
                    <tr>
                        <td colspan="9">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="box-factory" style="font-weight: bold;" colspan="9">&nbsp;<?php echo $value['factory_name']; ?></td>
                    </tr>

                    <?php
                    if(isset($detail[0]["category"])) {
                        foreach ($detail[0]["category"] as $keyEvent => $valueEvent) {
                            if($value["factory_id"] == $valueEvent["factory_id"]) {
                            $totalQuantityCategory = 0;
                            $totalAmountCategory = 0;
                    ?>

                    <tr>
                        <td colspan="9" style="font-weight: bold;font-size: 20px;"><?php echo $valueEvent["category_buy_name"]; ?></td>
                    </tr>
                    <?php
                    if(isset($detail[0]["product_category"])) { 
                        foreach ($detail[0]["product_category"] as $keyCategory => $valueCategory) {
                            if($value["factory_id"] == $valueCategory["factory_id"] && $valueEvent["product_category_id"] == $valueCategory["product_category_id"]) {
                    ?>
                    <tr>
                        <td colspan="9" style="font-weight: bold;font-size: 18px;"><?php echo $valueCategory['product_category_name']; ?></td>
                    </tr>
                    <?php
                    if(isset($detail[0]["company"])) {
                        foreach ($detail[0]["company"] as $keyCompany => $valueCompany) {
                            if($value["factory_id"] == $valueCompany["factory_id"] && $valueEvent["category_buy_id"] == $valueCompany["category_buy_id"] && $valueCategory["product_category_id"] == $valueCompany["product_category_id"]) {
                    ?>
                    <?php
                    if(isset($detail[0]['detail'])) {
                        foreach ($detail[0]['detail'] as $keyProduct => $valueProduct) {
                            if($value["factory_id"] == $valueProduct["base_code"] && $valueEvent["category_buy_id"] == $valueProduct["event_id"] && $valueCompany["company_id"] == $valueProduct["place_buy_id"] && $valueCompany["product_category_id"] == $valueProduct["product_category_buy_id"]) {
                                $product_amount = (float)$valueProduct['price_buy'] * (float)$valueProduct['zaikosu'];
                                $totalQuantityFactory += $valueProduct['zaikosu'];
                                $totalAmountFactory += $product_amount;
                                $totalQuantityCategory += $valueProduct['zaikosu'];
                                $totalAmountCategory += $product_amount;
                                $totalQuantity += $valueProduct['zaikosu'];
                                $totalAmount += $product_amount;
                    ?>
                    <tr>
                    <td><?php echo ($keyProduct == 0) ? $valueCompany['company_name'] : ""; ?></td>
                        <td class="borderDotted"><?php echo $valueProduct['product_buy_code']; ?> <?php echo $valueProduct['product_buy_name']; ?></td>
                        <td class="borderDotted"><?php echo $valueProduct['product_color']; ?></td>
                        <td class="borderDotted"><?php echo $valueProduct['product_format']; ?></td>
                        <td class="borderDotted"><?php echo $valueProduct['product_note']; ?></td>
                        <td class="borderDotted"><?php echo $valueProduct['product_common_use']; ?></td>
                        <td class="borderDotted text-right"><?php echo number_format($valueProduct['zaikosu'],0,",",","); ?></td>
                        <td class="borderDotted text-right"><?php echo number_format($valueProduct['price_buy'],0,",",","); ?></td>
                        <td class="borderDotted text-right"><?php echo number_format($product_amount,0,",",","); ?></td>
                    </tr>
                    <?php } } } ?>
                    <?php } } } ?>
                    <?php } } } ?>
                    <tr>
                        <th colspan="6"  class="borderBottom text-right"><?php echo $valueEvent["category_buy_name"]; ?>の合計</th>
                        <th class="borderBottom text-right"><?php echo number_format($totalQuantityCategory,0,",",","); ?></th>
                        <th class="borderBottom text-right">&nbsp;</th>
                        <th class="borderBottom text-right"><?php echo number_format($totalAmountCategory,0,",",","); ?></th>
                    </tr>
                   
                    <?php } } } ?>
                    <tr>
                        <th colspan="6"  class="borderBottom text-right"><?php echo $value['factory_name']; ?>の合計</th>
                        <th class="borderBottom text-right"><?php echo number_format($totalQuantityFactory,0,",",","); ?></th>
                        <th class="borderBottom text-right">&nbsp;</th>
                        <th class="borderBottom text-right"><?php echo number_format($totalAmountFactory,0,",",","); ?></th>
                    </tr>
                    <?php } } ?>
                    <tr>
                        <th colspan="6"  class=" text-right">総　　合　　計</th>
                        <th class=" text-right"><?php echo number_format($totalQuantity,0,",",","); ?></th>
                        <th class=" text-right">&nbsp;</th>
                        <th class=" text-right"><?php echo number_format($totalAmount,0,",",","); ?></th>
                    </tr>
                </tbody>
            </table>
        </div>