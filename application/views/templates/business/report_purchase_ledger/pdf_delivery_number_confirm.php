
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
                <td class="text-left"><span class="text-center" style="font-size: 28px;"><?php echo $title;?></span> <span><?php echo $title2; ?></span></span></td>
            </tr>
            <tr>
                <td class="text-right">対象期間 <?php echo $date_from; ?> ～ <?php echo $date_to; ?> </td>
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
                <th colspan="8" class="size110 borTopIn">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;仕入先名</th>
            </tr>
            <tr>
                <th width="17%" class="size110 borBotIn">&nbsp;日付</th>
                <th width="10%" class="size110 borBotIn">伝票ID</th>
                <th width="10%" class="size110 borBotIn">商品ID</th>
                <th width="16%" class="size110 borBotIn">商 品 名</th>
                <th width="10%" class="size110 borBotIn text-right">出荷数</th>
                <th width="12%" class="size110 borBotIn text-right">単価</th>
                <th width="15%" class="size110 borBotIn text-right"></th>
                <th width="10%" class="size110 borBotIn text-right"></th>
            </tr>
            
        </thead>
        <tbody>
        <?php
            $totalAmout = 0;
            $numberExport = 0;
                if(isset($detail) && isset($detail[0]["place_only_buy"])) {
                    foreach ($detail[0]["place_only_buy"] as $keyBuy => $valueBuy) {
                        $totalAmoutBuy = 0;
                        $numberExportBuy = 0;
                ?>
            <tr>
                <th class="size110 text-center"><?php echo $valueBuy["place_buy_id"]; ?></th>
                <th colspan="7" class="size110"><?php echo $valueBuy["place_buy_name"]; ?></th>
            </tr>
            <!-- Detail -->
            <?php 
                if(isset($detail[0]["detail"])) {
                    foreach ($detail[0]["detail"] as $keyDetail => $valueDetail) {
                        if($valueBuy["place_buy_id"] == $valueDetail["place_buy_id"]) {
                            $numberExport += $valueDetail["number_export"];
                            $numberExportBuy += $valueDetail["number_export"];
                            $totalAmout += ($valueDetail["number_export"] * $valueDetail["price"]);
                            $totalAmoutBuy += ($valueDetail["number_export"] * $valueDetail["price"]);
                            ?>
            <tr>
                <td><?php echo $valueDetail["date_export"]; ?></td>
                <td><?php echo $valueDetail["id_export"]; ?></td>
                <td><?php echo $valueDetail["product_buy_code"]; ?></td>
                <td><?php echo $valueDetail["product_buy_name"]; ?></td>
                <td class="text-right"><?php echo $valueDetail["number_export"]; ?></td>
                <td class="text-right">¥<?php echo number_format($valueDetail["price"],0,",",","); ?></td>
                <td class="text-right">¥<?php echo number_format(($valueDetail["price"] * $valueDetail["number_export"]),0,",",","); ?></td>
                <td class="text-right"><?php echo $valueDetail["factory_name"];?></td>
            </tr>
            <?php } } } ?>
            <!-- // Detail -->

            <tr>
                <th colspan="4" class="text-right"><?php echo $valueBuy["place_buy_name"]; ?>の小計</th>
                <th class="text-right"><?php echo number_format($numberExportBuy,0,",",","); ?></th>
                <th colspan="2" class="text-right">¥<?php echo number_format($totalAmoutBuy,0,",",","); ?></th>
                <th class="text-right"></th>
            </tr> 
            

            <tr>
                <th colspan="4" class="text-right size110">&nbsp;</th>
                <th class="text-right size110">&nbsp;</th>
                <th class="text-right">&nbsp;</th>
                <th colspan="2" class="text-left size110">&nbsp;</th>
            </tr>
                    <?php } } ?>
            <tr>
                <th colspan="4" class="text-right size110">総合計</th>
                <th class="text-right size110"><?php echo number_format($numberExport,0,",",","); ?></th>
                <th colspan="2" class="text-right size110">¥<?php echo number_format($totalAmout,0,",",","); ?></th>
                <th class="text-right"></th>
            </tr>
        </tbody>
    </table>
</div>