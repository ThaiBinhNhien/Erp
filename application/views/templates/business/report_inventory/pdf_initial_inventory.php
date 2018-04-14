<!-- CSS -->
<link href="<?php echo site_url();?>asset/css/bootstrap-report.css" rel="stylesheet">
<style>
    body {
        font-size: 100%;
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
                <td class="text-left">日付 : <?php echo $exp_from; ?> ～ <?php echo $exp_to; ?> </td>
            </tr>
            <tr> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>
</div> 
<div>
    <table width="100%" class="table-border">
        <thead>


			<tr>
                <th width="7%" class="size120 borBotIn text-center">商品コード</th>
                <th width="13%" class="size120 borBotIn text-center">商品名</th>
                <th width="10%" class="size120 borBotIn text-center">規格</th>
                <th width="7%" class="size120 borBotIn text-center">色調</th>
                <th width="10%" class="size120 borBotIn text-center">棚卸日(直近)</th>
                <th width="10%" class="size120 borBotIn text-center">棚卸数(直近)</th>
                <th width="10%" class="size120 borBotIn text-center">累計出庫数</th>
				<th width="8%" class="size120 borBotIn text-center">累計廃棄数</th>
				<th width="10%" class="size120 borBotIn text-center">使用中リネン</th>
				<th width="10%" class="size120 borBotIn text-center">累計納品数</th>
				<th width="5%" class="size120 borBotIn text-center">回転率</th>
			</tr>
        </thead>

        <tbody>
            <?php
            if(isset($data_result) && $data_result != null) {
                foreach ($data_result as $key => $value) {
             ?>
                <tr>
                    <td><?php echo $value['product_code_sell']; ?></td>
                    <td><?php echo $value['product_name_sell']; ?></td>
                    <td><?php echo $value['product_format']; ?></td>
                    <td><?php echo $value['product_color']; ?></td>
                    <td class="text-center"><?php echo $value['date_initial']; ?></td>
					<td class="text-right"><?php echo $value['number_initial']; ?></td>
					<td class="text-right"><?php echo $value['number_export']; ?></td>
					<td class="text-right"><?php echo $value['number_disposal']; ?></td>
					<td class="text-right"><?php echo $value['number_product']; ?></td>
					<td class="text-right"><?php echo $value['number_delivery']; ?></td>
					<td class="text-right border-right">
						<?php 
						if($value['number_delivery'] > 0 && $value['number_product'] > 0) {
						echo round(($value['number_delivery']/$value['number_product']),2);
						} else {
							echo '0';
						}
						 ?></td>
                </tr>
            <?php } } ?>
        </tbody>
    </table>
</div>