<!-- CSS -->
<link href="<?php echo site_url();?>asset/css/bootstrap-report.css" rel="stylesheet">
<style>
    body {
        font-size: 110%;
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
                <td class="text-left"><span class="text-center" style="font-size: 42px;"><?php echo $title;?></span></td>
            </tr>
            <tr>
                <td class="text-left">対象期間 <?php echo $exp_from; ?> ～ <?php echo $exp_to; ?> </td>
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
                <th width="9%" class="size120 borTopIn borBotIn">&nbsp;商 品 名</th>
                <th width="8%" class="size120 borTopIn borBotIn"></th>
                <th width="7%" class="size120 borTopIn borBotIn">色調</th>
                <th width="7%" class="size120 borTopIn borBotIn">規格</th>
                <th width="7%" class="size120 borTopIn borBotIn">処理</th>
                <th width="7%" class="size120 borTopIn borBotIn">日付</th>
                <!-- <th width="7%" class="size120 borTopIn borBotIn">受注</th> -->
                <th width="7%" class="size120 borTopIn borBotIn">単価</th>
                <th width="7%" class="size120 borTopIn borBotIn">発注</th>
                <th width="7%" class="size120 borTopIn borBotIn">入荷</th>
                <th width="7%" class="size120 borTopIn borBotIn">出荷</th>
                <th width="7%" class="size120 borTopIn borBotIn">返品</th>
                <th width="13%" class="size120 borTopIn borBotIn">仕入先名</th>
                <th width="12%" class="size120 borTopIn borBotIn">販売先名</th>
            </tr> 
        </thead>
        <tbody>
            <?php
            if(isset($detail)) {
                if(isset($detail[0]["product"])) {
                foreach ($detail[0]["product"] as $key => $value) {
            ?>
            <tr>
                <th colspan="2"><?php echo $value['product_code']; ?> <?php echo $value['product_name']; ?></th>
                <th><?php echo $value['product_color']; ?></th>
                <th><?php echo $value['product_format']; ?></th>
                <th></th>
                <th></th>
                <th>¥<?php echo number_format($value['product_price'],0,",",","); ?></th>
                <th colspan="4" ><?php echo $value['product_note']; ?></th>
                <th><?php echo $value['company_buy_name']; ?></th>
                <th><?php echo $value['company_sale_name']; ?></th>
            </tr>
            <?php
            if(isset($detail[0]['detail'])) {
                foreach ($detail[0]['detail'] as $keyDetail => $valueDetail) {
                    $product_price = (!empty($valueDetail["id_order"]) && !empty($valueDetail["id_import"])) ? $valueDetail["price_buy"] : $valueDetail["price_sell"];
                    if($value["product_code"] == $valueDetail["product_buy_code"] && $value["product_price"] == $product_price && $value["company_buy_id"] == $valueDetail["place_buy_id"] && $value["company_sale_id"] == $valueDetail["place_sale_id"]) {
            ?>
            	<tr>
                    <td><?php echo $valueDetail['id_order']; ?></td>
                    <td><?php echo $valueDetail['id_import']; ?></td>
                    <td><?php echo $valueDetail['id_export']; ?></td>
                    <td colspan="2" class="text-center"><?php echo $valueDetail['process_content_name']; ?></td>
                    <td><?php echo $valueDetail['date_creater']; ?></td>
                    <td></td>
                    <td><?php echo ($valueDetail['number_order'] == 0) ? "" : number_format($valueDetail['number_order'],0,",",","); ?></td>
                    <td><?php echo ($valueDetail['number_import'] == 0) ? "" : number_format($valueDetail['number_import'],0,",",","); ?></td>
                    <td><?php echo ($valueDetail['number_export'] == 0) ? "" : number_format($valueDetail['number_export'],0,",",","); ?></td>
                    <td><?php echo ($valueDetail['number_repay'] == 0) ? "" : number_format( $valueDetail['number_repay'],0,",",","); ?></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php } } } ?>
            <tr>
                <th class="borderDotted"></th>
                <th class="borderDotted"></th>
                <th class="borderDotted"></th>
                <th class="borderDotted"></th>
                <th class="borderDotted"></th>
                <th class="borderDotted"></th>
                <th class="borderDotted"></th>
                <th class="borderDotted"></th>
                <th class="borderDotted"></th>
                <th class="borderDotted"></th>
                <th class="borderDotted"></th>
                <th class="borderDotted"></th>
                <th class="borderDotted"></th>
            </tr>
            <?php } } } ?>
        </tbody>
    </table>
</div>