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
                <td class="text-left">対象期間 : <?php echo $exp_from; ?> ～ <?php echo $exp_to; ?> </td>
            </tr>
            <tr> 
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>
</div> 
<div style="font-size:120%;font-weight:bold;margin-bottom: 5px;">対象商品：全商品</div>
<div>
    <table width="100%" class="table-border">
        <thead>
            <tr>
                <th width="15%" class="size120 borBotIn text-center" rowspan="2">商品コード</th>
                <th width="40%" class="size120 borBotIn text-center" rowspan="2">商品名</th>
                <th width="15%" class="size120 text-center">納品数</th>
                <th width="15%" class="size120 borBotIn text-center" rowspan="2">達成率</th>
			</tr>
			<tr>
				<th width="15%" class="size120 borBotIn text-center">注文数</th>
            </tr>
        </thead>
        <tbody>
			<?php
			$dem = 0;
			$total_rate = 0;
            if(isset($detail)) {
                foreach ($detail as $key => $value) {
					$rate = 0;
					$number_order = (!empty($value['number_order'])) ? $value['number_order'] : 0;
					$number_delivery = (!empty($value['number_delivery'])) ? $value['number_delivery'] : 0;
					if($number_delivery >= $number_order) {
						$rate = 100;
					} else {
						$rate = $number_delivery/$number_order * 100;
					}

					$dem ++;
					$total_rate += $rate;
            ?>
            <tr>
				<td rowspan="2"><?php echo $value['product_code_sell']; ?></td>
				<td rowspan="2"><?php echo $value['product_name_sell']; ?></td>
				<td class="text-right"><?php echo $number_delivery; ?></td>
				<td rowspan="2" class="border-right text-center"><?php echo round($rate)."%"; ?></td>
			</tr>
			<tr>
				<td class="text-right"><?php echo $number_order; ?></td>
			</tr>
			<?php } } ?>

			<tr>
				<th class="text-right size120" colspan="3">平均：</th>
				<th class="border-right text-center"><?php echo (!empty($total_rate)) ? round(($total_rate/$dem))."%" : ""; ?></th>
			</tr>
        </tbody>
    </table>
</div>