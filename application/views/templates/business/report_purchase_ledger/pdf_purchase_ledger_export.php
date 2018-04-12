
<!-- CSS -->
<link href="<?php echo site_url();?>asset/css/bootstrap-report.css" rel="stylesheet">
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
</style>
<div>
    <table width="100%">
        <tbody>
            <tr>
                <td class="text-left"><span class="text-center" style="font-size: 42px;"><?php echo $title;?></span></td>
            </tr>
            <tr>
                <td class="text-left">対象期間 <?php echo $date_from; ?> ～ <?php echo $date_to; ?> </td>
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
                <th colspan="2" class="size110 borTopIn">&nbsp;販売先名</th>
                <th colspan="2" class="size110 borTopIn text-left">&nbsp;仕入先名</th>
                <th class="size110 borTopIn">&nbsp;</th>
                <th class="size110 borTopIn">&nbsp;</th>
                <th class="size110 borTopIn">&nbsp;</th>
                <th class="size110 borTopIn">&nbsp;</th>
            </tr>
            <tr>
                <th width="16%" class="size110 borBotIn">&nbsp;日付</th>
                <th width="16%" class="size110 borBotIn text-center">商品名</th>
                <th width="14%" class="size110 borBotIn">備考</th>
                <th width="10%" class="size110 borBotIn">色調</th>
                <th width="10%" class="size110 borBotIn">規格</th>
                <th width="10%" class="size110 borBotIn">数量</th>
                <th width="12%" class="size110 borBotIn">販売単価</th>
                <th width="12%" class="size110 borBotIn">支払金額</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if($purchase_ledger_individual == 0) {
            $totalAll = 0;
            $numberAll = 0;
                if(isset($detail) && isset($detail[0]["data_event"])) {
                    foreach ($detail[0]["data_event"] as $keyEvent => $valueEvent) {
                        $totalEvent = 0;
                        $numberEvent = 0;
                ?>
            <tr>
                <th colspan="8" class="size110"><?php echo $valueEvent["event_name"]; ?></th>
            </tr>

            <?php
                if(isset($detail) && isset($detail[0]["place_buy_sale"])) {
                    foreach ($detail[0]["place_buy_sale"] as $keyPlace => $valuePlace) {
                        if($valueEvent["event_id"] == $valuePlace["event_id"]) {
                        $totalPlace = 0;
                        $numberPlace = 0;
                ?>
            <tr>
                <th colspan="2" class="size110"><?php echo $valuePlace["place_sale_name"]; ?></th>
                <th colspan="6" class="size110"><?php echo $valuePlace["place_buy_name"]; ?></th>
            </tr>

            <!-- Detail -->
            <?php
                if(isset($detail) && isset($detail[0]["detail"])) {
                    foreach ($detail[0]["detail"] as $keyDetail => $valueDetail) {
                        if($valuePlace["event_id"] == $valueDetail["event_id"] && $valuePlace["place_buy_id"] == $valueDetail["place_buy_id"] && $valuePlace["place_sale_id"] == $valueDetail["place_sale_id"]) {
                        $totalAll += $valueDetail["number_export"] * $valueDetail["price"];
                        $totalEvent += $valueDetail["number_export"] * $valueDetail["price"];
                        $totalPlace += $valueDetail["number_export"] * $valueDetail["price"];
                        $numberAll += $valueDetail["number_export"];
                        $numberEvent += $valueDetail["number_export"];
                        $numberPlace += $valueDetail["number_export"];
                ?>
            <tr>
                <td class="borderDotted"><?php echo $valueDetail["date_export"]; ?></td>
                <td class="borderDotted"><?php echo $valueDetail["product_code"]; ?> <?php echo $valueDetail["product_name"]; ?></td>
                <td class="borderDotted"><?php echo $valueDetail["product_note"]; ?></td>
                <td class="borderDotted"><?php echo $valueDetail["product_color"]; ?></td>
                <td class="borderDotted"><?php echo $valueDetail["product_format"]; ?></td>
                <td class="borderDotted text-left"><?php echo number_format($valueDetail["number_export"],0,",",","); ?></td>
                <td class="borderDotted text-right">¥<?php echo number_format($valueDetail["price"],0,",",","); ?></td>
                <td class="borderDotted text-right"><?php echo number_format(($valueDetail["number_export"] * $valueDetail["price"]),0,",",","); ?></td>
            </tr>
            <?php } } } ?>
            <!-- // Detail -->

            <tr>
                <th colspan="5" class="text-right"><?php echo number_format($numberPlace,0,",",","); ?></th>
                <th colspan="2" class="text-right">仕入金額総合計</th>
                <th class="text-right">¥<?php echo number_format($totalPlace,0,",",","); ?></th>
            </tr>
            <tr>
                <th colspan="7" class="text-right">消費税 8％</th>
                <th class="text-right">¥<?php echo number_format(($totalPlace * CONFIG_CONSUMPTION_TAX),0,",",","); ?></th>
            </tr>
            <tr>
                <th colspan="7" class="text-right">総合計</th>
                <th class="text-right">¥<?php echo number_format(($totalPlace + $totalPlace * CONFIG_CONSUMPTION_TAX),0,",",","); ?></th>
            </tr>
            <?php } } } ?>
            <tr>
                <th colspan="5" class="text-right"><?php echo number_format($numberEvent,0,",",","); ?></th>
                <th colspan="2" class="text-right">仕入金額総合計</th>
                <th class="text-right">¥<?php echo number_format($totalEvent,0,",",","); ?></th>
            </tr>
            <tr>
                <th colspan="7" class="text-right">消費税 8％</th>
                <th class="text-right">¥<?php echo number_format(($totalEvent * CONFIG_CONSUMPTION_TAX),0,",",","); ?></th>
            </tr>
            <tr>
                <th colspan="7" class="text-right">総合計</th>
                <th class="text-right">¥<?php echo number_format(($totalEvent + $totalEvent * CONFIG_CONSUMPTION_TAX),0,",",","); ?></th>
            </tr>
            <?php } } ?>
            <tr>
                <th colspan="5" class="text-right"><?php echo number_format($numberAll,0,",",","); ?></th>
                <th colspan="2" class="text-right">仕入金額総合計</th>
                <th class="text-right">¥<?php echo number_format($totalAll,0,",",","); ?></th>
            </tr>
            <tr>
                <th colspan="7" class="text-right">消費税 8％</th>
                <th class="text-right">¥<?php echo number_format(($totalAll * CONFIG_CONSUMPTION_TAX),0,",",","); ?></th>
            </tr>
            <tr>
                <th colspan="7" class="text-right">総合計</th>
                <th class="text-right">¥<?php echo number_format(($totalAll + $totalAll * CONFIG_CONSUMPTION_TAX),0,",",","); ?></th>
            </tr>
                        <?php } else {
                            $totalAll = 0;
                            $numberAll = 0;

                                if(isset($detail) && isset($detail[0]["place_buy_sale"])) {
                                    foreach ($detail[0]["place_buy_sale"] as $keyPlace => $valuePlace) {
                                        $totalPlace = 0;
                                        $numberPlace = 0;
                                ?>
                                <tr>
                                    <th colspan="8" class="size110">&nbsp;</th>
                                </tr>
                                <tr>
                                    <th colspan="2" class="size110"><?php echo $valuePlace["place_buy_name"]; ?></th>
                                    <th colspan="6" class="size110"><?php echo $valuePlace["place_sale_name"]; ?></th>
                                </tr>

                            <!-- Detail -->
                            <?php
                                if(isset($detail) && isset($detail[0]["detail"])) {
                                    foreach ($detail[0]["detail"] as $keyDetail => $valueDetail) {
                                        if($valuePlace["event_id"] == $valueDetail["event_id"] && $valuePlace["place_buy_id"] == $valueDetail["place_buy_id"] && $valuePlace["place_sale_id"] == $valueDetail["place_sale_id"]) {
                                        $totalAll += $valueDetail["number_import"] * $valueDetail["price"];
                                        $totalPlace += $valueDetail["number_import"] * $valueDetail["price"];
                                        $numberAll += $valueDetail["number_import"];
                                        $numberPlace += $valueDetail["number_import"];
                                ?>
                            <tr>
                                <td class="borderDotted"><?php echo $valueDetail["date_import"]; ?></td>
                                <td class="borderDotted"><?php echo $valueDetail["product_code"]; ?> <?php echo $valueDetail["product_name"]; ?></td>
                                <td class="borderDotted"><?php echo $valueDetail["product_note"]; ?></td>
                                <td class="borderDotted"><?php echo $valueDetail["product_color"]; ?></td>
                                <td class="borderDotted"><?php echo $valueDetail["product_format"]; ?></td>
                                <td class="borderDotted text-left"><?php echo number_format($valueDetail["number_import"],0,",",","); ?></td>
                                <td class="borderDotted text-right">¥<?php echo number_format($valueDetail["price"],0,",",","); ?></td>
                                <td class="borderDotted text-right"><?php echo number_format(($valueDetail["number_import"] * $valueDetail["price"]),0,",",","); ?></td>
                            </tr>
                            <?php } } } ?>
                            <!-- // Detail -->
                
                            <tr>
                                <th colspan="5" class="text-right"><?php echo number_format($numberPlace,0,",",","); ?></th>
                                <th colspan="2" class="text-right">販売金額総合計</th>
                                <th class="text-right">¥<?php echo number_format($totalPlace,0,",",","); ?></th>
                            </tr>
                            <tr>
                                <th colspan="7" class="text-right">消費税 8％</th>
                                <th class="text-right">¥<?php echo number_format(($totalPlace * CONFIG_CONSUMPTION_TAX),0,",",","); ?></th>
                            </tr>
                            <tr>
                                <th colspan="7" class="text-right">総合計</th>
                                <th class="text-right">¥<?php echo number_format(($totalPlace + $totalPlace * CONFIG_CONSUMPTION_TAX),0,",",","); ?></th>
                            </tr>
                            <?php } } ?>
                            <tr>
                                <th colspan="5" class="text-right"><?php echo number_format($numberAll,0,",",","); ?></th>
                                <th colspan="2" class="text-right">仕入金額総合計</th>
                                <th class="text-right">¥<?php echo number_format($totalAll,0,",",","); ?></th>
                            </tr>
                            <tr>
                                <th colspan="7" class="text-right">消費税 8％</th>
                                <th class="text-right">¥<?php echo number_format(($totalAll * CONFIG_CONSUMPTION_TAX),0,",",","); ?></th>
                            </tr>
                            <tr>
                                <th colspan="7" class="text-right">総合計</th>
                                <th class="text-right">¥<?php echo number_format(($totalAll + $totalAll * CONFIG_CONSUMPTION_TAX),0,",",","); ?></th>
                            </tr>

                        <?php } ?>
        </tbody>
    </table>
</div>