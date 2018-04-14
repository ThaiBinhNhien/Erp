
<!-- CSS -->
<link href="<?php echo site_url();?>asset/css/bootstrap-report.css" rel="stylesheet">
<style>
    body {
        font-size: 95%;
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
<h1 class="color030a84">&nbsp;<?php echo $label_date; ?>月分洗剤等の使用状況等</h1>
<div> 
    <table width="100%" class="table">
        <thead>
            <tr>
                <th width="5%" class="text-left border-bottom2 color030a84 size120">&nbsp;商品ID</th>
                <th width="9%" class="text-center border-bottom2 color030a84 size120">商品名</th>
                <th width="9%" class="text-center border-bottom2 color030a84 size120">単位</th>
                <th width="9%" class="text-right border-bottom2 color030a84 size120">仕入単価</th>
                <th width="9%" class="text-right border-bottom2 color030a84 size120">標準在庫数</th>
                <th width="9%" class="text-right border-bottom2 color030a84 size120">繰越在庫数</th>
                <th width="9%" class="text-right border-bottom2 color030a84 size120">当月購入量</th>
                <th width="9%" class="text-right border-bottom2 color030a84 size120">購入金額</th>
                <th width="9%" class="text-right border-bottom2 color030a84 size120">当月出庫量</th>
                <th width="11%" class="text-right border-bottom2 color030a84 size120">出庫金額</th>
                <th width="11%" class="text-right border-bottom2 color030a84 size120">月末在庫量</th>
                <!-- <th width="7%" class="text-right border-bottom2 color030a84 size120">拠点名</th> -->
            </tr>
        </thead>
        <tbody>
            
            <?php
            if(isset($detail)) {
                $total_amount_import_all = 0;
                $total_amount_export_all = 0;
                if(isset($detail[0]["factory"])) {
                foreach ($detail[0]["factory"] as $key => $value) {
                    $total_amount_import_factory = 0;
                    $total_amount_export_factory = 0;
            ?>
            <tr>
                <th colspan="13">&nbsp;</th>
            </tr>
            <tr>
                <th colspan="13"><?php echo $value["stock_name"]; ?></th>
            </tr>
            <tr>
                <th colspan="13">&nbsp;</th>
            </tr>

            <?php
                if(isset($detail[0]["event"])) {
                foreach ($detail[0]["event"] as $keyEvent => $valueEvent) {
                    if($value["stock_id"] == $valueEvent["stock_id"]) {
                        $total_amount_import_event = 0;
                        $total_amount_export_event = 0;
            ?>
            <tr>
                <th colspan="13"><?php echo $valueEvent["product_event_name"]; ?></th>
            </tr>

            <?php
                if(isset($detail[0]["company"])) {
                foreach ($detail[0]["company"] as $keyCompany => $valueCompany) {
                    if($value["stock_id"] == $valueCompany["stock_id"] && $valueEvent["product_event_id"] == $valueCompany["product_event_id"]) {
                        $total_amount_import_company = 0;
                        $total_amount_export_company = 0;
            ?>
            <tr>
            <tr>
                <th colspan="13">&nbsp;&nbsp;<?php echo $valueCompany["company_name"]; ?></th>
            </tr>
            <?php
                if(isset($detail[0]["detail"])) {
                foreach ($detail[0]["detail"] as $keyDetail => $valueDetail) {
                    if($value["stock_id"] == $valueDetail["stock_id"] && $valueEvent["product_event_id"] == $valueDetail["product_event_id"] && $valueCompany["company_id"] == $valueDetail["company_id"]) {
                        $total_amount_import_company += $valueDetail["amount_import"];
                        $total_amount_export_company += $valueDetail["amount_export"];
                        $total_amount_import_event += $valueDetail["amount_import"];
                        $total_amount_export_event += $valueDetail["amount_export"];
                        $total_amount_import_factory += $valueDetail["amount_import"];
                        $total_amount_export_factory += $valueDetail["amount_export"];
                        $total_amount_import_all += $valueDetail["amount_import"];
                        $total_amount_export_all += $valueDetail["amount_export"];
            ?>
            <tr>
                <td class="text-right">&nbsp;&nbsp;<?php echo $valueDetail["product_code"]; ?></td>
                <td><?php echo $valueDetail["product_name"]; ?></td>
                <td class="text-center"><?php echo $valueDetail["product_unit"]; ?></td>
                <td class="text-right">¥<?php echo number_format($valueDetail["price"],0,",",","); ?></td>
                <td class="text-right"><?php echo number_format($valueDetail["product_inventory_standard"],0,",",","); ?></td>
                <td class="text-right"><?php echo number_format($valueDetail["number_last_inventory"],0,",",","); ?></td>
                <td class="text-right"><?php echo number_format($valueDetail["number_import"],0,",",","); ?></td>
                <td class="text-right">¥<?php echo number_format($valueDetail["amount_import"],0,",",","); ?></td>
                <td class="text-right"><?php echo number_format($valueDetail["number_export"],0,",",","); ?></td>
                <td class="text-right">¥<?php echo number_format($valueDetail["amount_export"],0,",",","); ?></td>
                <td class="text-right"><?php echo number_format($valueDetail["number_inventory"],0,",",","); ?></td>
                <!-- <td class="text-right"><?php //echo $valueDetail["base_name"]; ?></td> -->
            </tr>
            <?php } } } ?>
            <tr> 
                <th colspan="6" class="text-right"><?php echo $valueCompany["company_name"]; ?> &nbsp;&nbsp;&nbsp;&nbsp; 洗剤等の小計</th>
                <th class="text-right"></th>
                <th class="text-right">¥<?php echo number_format($total_amount_import_company,0,",",","); ?></th>
                <th class="text-right"></th>
                <th class="text-right">¥<?php echo number_format($total_amount_export_company,0,",",","); ?></th>
                <th class="text-right"></th>
                <th class="text-right"></th>
                <!-- <th class="text-right"></th> -->
            </tr>
            <?php } } } ?>
            <tr>
                <th colspan="6" class="text-right"><?php echo $valueEvent["product_event_name"]; ?>の合計</th>
                <th class="text-right"></th>
                <th class="text-right">¥<?php echo number_format($total_amount_import_event,0,",",","); ?></th>
                <th class="text-right"></th>
                <th class="text-right">¥<?php echo number_format($total_amount_export_event,0,",",","); ?></th>
                <th class="text-right"></th>
                <th class="text-right"></th>
                <!-- <th class="text-right"></th> -->
            </tr>
            <?php } } } ?>
            <tr>
                <th colspan="13">&nbsp;</th>
            </tr>
            <tr>
                <th colspan="6" class="text-right"><?php echo $value["stock_name"]; ?>の合計</th>
                <th class="text-right"></th>
                <th class="text-right">¥<?php echo number_format($total_amount_import_factory,0,",",","); ?></th>
                <th class="text-right"></th>
                <th class="text-right">¥<?php echo number_format($total_amount_export_factory,0,",",","); ?></th>
                <th class="text-right"></th>
                <th class="text-right"></th>
                <!-- <th class="text-right"></th> -->
            </tr>
            <?php } } } ?>
            <tr>
                <th colspan="6" class="text-right">総合計</th>
                <th class="text-right"></th>
                <th class="text-right">¥<?php echo number_format($total_amount_import_all,0,",",","); ?></th>
                <th class="text-right"></th>
                <th class="text-right">¥<?php echo number_format($total_amount_export_all,0,",",","); ?></th>
                <th class="text-right"></th>
                <th class="text-right"></th>
                <!-- <th class="text-right"></th> -->
            </tr>
            
        </tbody>
    </table>
</div>