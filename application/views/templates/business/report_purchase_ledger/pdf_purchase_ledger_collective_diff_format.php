
<!-- CSS -->
<link href="<?php echo site_url();?>asset/css/bootstrap-report.css" rel="stylesheet">
<style>
    body {
        font-size: 90%;
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
    .size110 {
		font-size: 110%;
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
    table{
		border-collapse: collapse;
	}
</style>
<div>
    <table width="100%">
        <tbody>
            <tr>
                <td class="text-left"><span class="text-center" style="font-size: 42px;"><?php echo $title;?></span></td>
            </tr>
            <tr>
                <td class="text-left">対象期間 <?php echo $date_from;?> ～ <?php echo $date_to;?> </td>
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
                <th width="23%" class="size110 borTopIn">&nbsp;仕入先名</th>
                <th width="10%" class="size110 borTopIn">日付</th>
                <th width="10%" class="size110 borTopIn">商品名</th>
                <th width="10%" class="size110 borTopIn">色調</th>
                <th width="8%" class="size110 borTopIn">規格</th>
                <th width="5%" class="size110 borTopIn text-right">数量</th>
                <th width="10%" class="size110 borTopIn text-right">販売単価</th>
                <th width="10%" class="size110 borTopIn text-right">請求金額</th>
                <th width="14%" class="size110 borTopIn"></th>
            </tr>
            <tr>
                <th class="size110 borBotIn">&nbsp;販売先名</th>
                <th class="size110 borBotIn"></th>
                <th class="size110 borBotIn"></th>
                <th class="size110 borBotIn"></th>
                <th class="size110 borBotIn"></th>
                <th class="size110 borBotIn"></th>
                <th class="size110 borBotIn text-right">仕入単価</th>
                <th class="size110 borBotIn text-right">支払金額</th>
                <th class="size110 borBotIn text-right">差 額</th>
            </tr>
        </thead>
        <tbody>
        <?php
            $totalSaleAll = 0;
            $totalBuyAll = 0;
            $numberAll = 0;
                if(isset($detail) && isset($detail[0]["place_only_buy"])) {
                    foreach ($detail[0]["place_only_buy"] as $keyBuy => $valueBuy) {
                        $totalSaleFromBuy = 0;
                        $totalBuyFromBuy = 0;
                        $numberBuy = 0;
                ?> 
            <tr>
                <th colspan="9" class="size110"><?php echo $valueBuy["place_buy_name"]; ?></th>
            </tr>


            <!-- Detail -->
            <?php 
                if(isset($detail[0]["place_sale_from_buy"])) {
                    foreach ($detail[0]["place_sale_from_buy"] as $keySaleBuy => $valueSaleBuy) {
                        if($valueBuy["place_buy_id"] == $valueSaleBuy["place_buy_id"]) {
                            $coutBuy = 0;
            ?>

            <?php 
                if(isset($detail[0]["detail"])) {
                    foreach ($detail[0]["detail"] as $keyDetail => $valueDetail) {
                        if($valueSaleBuy["place_buy_id"] == $valueDetail["place_buy_id"] && $valueSaleBuy["place_sale_id"] == $valueDetail["place_sale_id"]) {
                            $coutBuy++;
                            $numberBuy += $valueDetail["number_export"];
                            $numberAll += $valueDetail["number_export"];
                            $totalSaleFromBuy += ($valueDetail["number_export"] * $valueDetail["price"]);
                            $totalBuyFromBuy += ($valueDetail["number_export"] * $valueDetail["price_buy"]);
                            $totalSaleAll += ($valueDetail["number_export"] * $valueDetail["price"]);
                            $totalBuyAll += ($valueDetail["number_export"] * $valueDetail["price_buy"]);
           ?>
            <tr>
                <td class=""><?php echo ($coutBuy == 1) ? $valueDetail["place_sale_name"] : ""; ?></td>
                <td class=""><?php echo $valueDetail["date_export"]; ?></td>
                <td class=""><?php echo $valueDetail["product_buy_name"]; ?></td>
                <td class=""><?php echo $valueDetail["product_buy_code"]; ?></td>
                <td class=""><?php echo $valueDetail["product_format"]; ?></td>
                <td class=" text-right"><?php echo number_format($valueDetail["number_export"],0,",",","); ?></td>
                <td class=" text-right">¥<?php echo number_format($valueDetail["price"],2,".",","); ?></td>
                <td class=" text-right"><?php echo number_format(($valueDetail["number_export"] * $valueDetail["price"]),0,",",","); ?></td>
                <td class=" text-right"></td>
                </tr>
                <tr>
                <td class=""></td>
                <td class=""></td>
                <td class=""></td>
                <td class=""></td>
                <td class=""></td>
                <td class=" text-right"></td>
                <td class=" text-right">¥<?php echo number_format($valueDetail["price_buy"],2,".",","); ?></td>
                <td class=" text-right"><?php echo number_format(($valueDetail["number_export"] * $valueDetail["price_buy"]),0,",",","); ?></td>
                <td class=" text-right"><?php echo number_format((($valueDetail["number_export"] * $valueDetail["price"]) - ($valueDetail["number_export"] * $valueDetail["price_buy"])),0,",",","); ?></td>
                </tr>
                <?php } } } ?>
            <?php } } } ?>
            <!-- // Detail -->

            <tr>
                <th colspan="6" class="text-right"><?php echo number_format($numberBuy,0,",",","); ?></th>
                <th class="text-right">販売金額合計</th>
                <th class="text-right">¥<?php echo number_format($totalSaleFromBuy,0,",",","); ?></th>
                <th class="text-right"></th>
            </tr>
            <tr>
                <th colspan="7" class="text-right">仕入金額合計</th>
                <th class="text-right">¥<?php echo number_format($totalBuyFromBuy,0,",",","); ?></th>
                <th class="text-right">差額合計 &nbsp;<?php echo number_format(($totalSaleFromBuy - $totalBuyFromBuy),0,",",","); ?></th>
            </tr>


            <tr>
                <td class="borBotIn"></td>
                <td class="borBotIn"></td>
                <td class="borBotIn"></td>
                <td class="borBotIn"></td>
                <td class="borBotIn"></td>
                <td class="borBotIn text-right"></td>
                <td class="borBotIn text-right"></td>
                <td class="borBotIn text-right"></td>
                <td class="borBotIn text-right"></td>
            </tr>
            <?php } } ?>
            <tr>
                <th colspan="6" class="text-right"><?php echo number_format($numberAll,0,",",","); ?></th>
                <th class="text-right"></th>
                <th class="text-right">¥<?php echo number_format($totalSaleAll,0,",",","); ?></th>
                <th class="text-right"></th>
            </tr>
                    
            <tr>
                <th colspan="7" class="text-right"></th>
                <th class="text-right">¥<?php echo number_format($totalBuyAll,0,",",","); ?></th>
                <th class="text-right"><?php echo number_format(($totalSaleAll - $totalBuyAll),0,",",","); ?></th>
            </tr>
        </tbody>
    </table>
</div>