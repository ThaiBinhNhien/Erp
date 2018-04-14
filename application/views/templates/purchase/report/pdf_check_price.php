
<!-- CSS -->
<link href="<?php echo site_url();?>asset/css/bootstrap-report.css" rel="stylesheet">
<style>
    body {
        font-size: 100%;
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
    .size100 {
		font-size: 100%;
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
<h2 class="color030a84">&nbsp;<?php echo $title; ?></h2>
<p class="size110">&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">入庫日 :</span>	<?php echo $date_month; ?> – <?php echo $date_month; ?></p>
<p class="size110">&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">入庫 :</span>	済</p>
<p class="size110">&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">仕入先 :</span>	<?php echo $place_buy_name; ?></p>
<p class="size110">&nbsp;&nbsp;&nbsp;<span style="font-weight: bold;">販売先 :</span>	<?php echo $place_sale_name; ?></p>
<div> 
    <table width="100%" class="table">
        <thead>
            <tr>
                <th width="10%" class="border-bottom2 color030a84 size120">&nbsp;入庫日</th>
                <th width="10%" class="border-bottom2 color030a84 size120">入庫番号</th>
                <th width="10%" class="border-bottom2 color030a84 size120">商品ID</th>
                <th width="10%" class="border-bottom2 color030a84 size120">商品名</th>
                <th width="10%" class="border-bottom2 color030a84 size120">色調</th>
                <th width="10%" class="border-bottom2 color030a84 size120">規格</th>
                <th width="10%" class="border-bottom2 color030a84 size120">備考</th>
                <th width="10%" class="text-right border-bottom2 color030a84 size120">数量</th>
                <th width="10%" class="text-right border-bottom2 color030a84 size120">単価（円）</th>
                <th width="10%" class="text-right border-bottom2 color030a84 size120">小計（円）</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $totalAmount = 0;
        if(isset($data_check)) {
            foreach ($data_check as $key => $value) {
                $totalAmount += $value["number_import"] * $value["price"];
        ?>
            <tr>
                <td><?= $value["detail_date"]; ?></td>
                <td><?= $value["id_import"]; ?></td>
                <td><?= $value["product_buy_code"]; ?></td>
                <td><?= $value["product_buy_name"]; ?></td>
                <td><?= $value["product_color"]; ?></td>
                <td><?= $value["product_format"]; ?></td>
                <td><?= $value["note"]; ?></td>
                <td class="text-right"><?= $value["number_import"]; ?></td>
                <td class="text-right"><?= number_format($value["price"],0,",",","); ?></td>
                <td class="text-right"><?= number_format($value["number_import"] * $value["price"],0,",",","); ?></td>
            </tr>
        <?php
            }
        }
        ?>
        <tr class="sum-col"> 
            <th class="text-right" colspan="9"> 総合計</th>
            <th class="text-right"><?= number_format($totalAmount,0,",",","); ?></th>
        </tr>
        </tbody>
    </table>
</div>