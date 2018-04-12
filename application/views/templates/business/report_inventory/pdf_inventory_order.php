		<!-- CSS -->
		<link href="<?php echo site_url();?>asset/css/bootstrap-report.css" rel="stylesheet">
		<style>
			h1 {
				font-weight: 900;
			}
	table{
		border-collapse: collapse;
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
				font-size: 100%;
			}
			.sizeBig {
				font-size: 120%;
				font-weight: bold;
				color: #000;
			}
            .borTopIn {
                border-top: 1px solid #000;
                padding-top: 5px;
            }
            .borBotIn {
                border-bottom:2px solid #000;
                padding-bottom: 5px;
            }
            .borBotInL {
                border-bottom:1px solid #000;
                padding-bottom: 5px;
            }
            .borTopInL {
                border-top:1px solid #000;
                padding-bottom: 5px;
            }
            .borTopInBig {
                border-top: 2px solid #000;
                padding-top: 5px;
            }
            .borBotInBig {
                border-bottom:2px solid #000;
                padding-bottom: 5px;
            }
            .box-factory {
                font-size: 120%;
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
                        <td class="text-left"><span class="text-center" style="font-size: 42px;"><?php echo $title;?></span></td>
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
                        <th width="20%" class="size120 borTopIn borBotIn">&nbsp;&nbsp;仕 入 先 名 </th>
                        <th width="12%" class="size120 borTopIn borBotIn">&nbsp;</th>
                        <th width="22%" class="size120 borTopIn borBotIn">商品名</th>
                        <th width="12%" class="size120 borTopIn borBotIn">備考</th>
                        <th width="12%" class="size120 borTopIn borBotIn text-right">発注数</th>
                        <th width="12%" class="size120 borTopIn borBotIn text-right">&nbsp;</th>
                        <th width="22%" class="size120 borTopIn borBotIn text-right">&nbsp;</th>
                    </tr>
                </thead>
                <tbody> 

                    <?php
                    if(isset($detail[0]["company_only"])) {
                        $totalQuantity = 0;
					    $totalAmount = 0;
                        foreach ($detail[0]["company_only"] as $keyCompany => $valueCompany) {
                            $totalQuantityFactory = 0;
                            $totalAmountFactory = 0;
                    ?>
                    <tr>
                        <td colspan="7" class="borTopInBig borBotInBig" style="font-weight: bold;font-size: 18px;"><?php echo $valueCompany['company_name']; ?></td>
                    </tr>

                    <?php
                    if(isset($detail[0]["category_company"])) {
                        foreach ($detail[0]["category_company"] as $keyCategory => $valueCategory) {
                            if($valueCompany["company_id"] == $valueCategory["company_id"]){
                            $totalQuantityCategory = 0;
                            $totalAmountCategory = 0;
                    ?>
                    <tr>
                        <td colspan="7" class="borTopInL borBotInL" style="font-weight: bold;font-size: 18px;"><?php echo $valueCategory['category_buy_name']; ?></td>
                    </tr>

                    <?php
                    if(isset($detail[0]['detail'])) {
                        foreach ($detail[0]['detail'] as $keyProduct => $valueProduct) {
                            if($valueCompany["company_id"] == $valueProduct["place_buy_id"] && $valueCategory["category_buy_id"] == $valueProduct["event_id"]) {
                                $product_amount = (float)$valueProduct['price_buy'] * (float)$valueProduct['quantity_order'];
                                $totalQuantityFactory += $valueProduct['quantity_order'];
                                $totalAmountFactory += $product_amount;
                                $totalQuantityCategory += $valueProduct['quantity_order'];
                                $totalAmountCategory += $product_amount;
                                $totalQuantity += $valueProduct['quantity_order'];
                                $totalAmount += $product_amount;
                    ?>
                    <tr>
                        <th class="" colspan="3"><?php echo $valueProduct['product_buy_code']; ?> <?php echo $valueProduct['product_buy_name']; ?></th>
                        <td class=""><?php echo $valueProduct['product_note']; ?></td>
                        <td class=" text-right"><?php echo number_format($valueProduct['quantity_order'],0,",",","); ?></td>
                        <td class=" text-right"><?php echo number_format($valueProduct['price_buy'],0,",",","); ?></td>
                        <td class=" text-right">¥<?php echo number_format($product_amount,0,",",","); ?></td>
                    </tr>
                    <tr>
                        <td class="borderDotted text-center" colspan="4"><?php echo $valueProduct['product_common_use']; ?></td>
                        <td class="borderDotted" colspan="3">&nbsp;</td>
                    </tr>
                    <?php } } } ?>

                    <tr>
                        <th colspan="4"  class="borTopIn text-right">小 計</th>
                        <th class="borTopIn text-right"><?php echo number_format($totalQuantityCategory,0,",",","); ?></th>
                        <th class="borTopIn text-right">&nbsp;</th>
                        <th class="borTopIn text-right" colspan="1">¥<?php echo number_format($totalAmountCategory,0,",",","); ?></th>
                    </tr>
                    <?php } } } ?>
                    
                    <tr>
                        <th colspan="4"  class=" text-right">合 計</th>
                        <th class=" text-right"><?php echo number_format($totalQuantityFactory,0,",",","); ?></th>
                        <th class=" text-right">&nbsp;</th>
                        <th class=" text-right" colspan="1">¥<?php echo number_format($totalAmountFactory,0,",",","); ?></th>
                    </tr>
                    <?php } } ?>

                    <tr>
                        <th colspan="4"  class=" text-right">総　合　計 </th>
                        <th class=" text-right"><?php echo number_format($totalQuantity,0,",",","); ?></th>
                        <th class=" text-right">&nbsp;</th>
                        <th class=" text-right" colspan="1">¥<?php echo number_format($totalAmount,0,",",","); ?></th>
                                
                    </tr>
                </tbody>
            </table>
        </div>