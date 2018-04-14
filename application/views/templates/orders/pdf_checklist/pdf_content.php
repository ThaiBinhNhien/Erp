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
		font-size: 100%;
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
    .pdf-border-tr {
        border-top:3px solid #000;
    }
    .pdf-border {
        border:1px solid #000;
    }
</style>

<div>
    <table width="100%">
        <thead>
            <tr>
                <th colspan="12" class="pdf-border-tr"></th>
            </tr>
            <tr>
                <th width="5%" class="size120 text-center pdf-border">伝票番号</th>
                <th width="12%" class="size120 text-center pdf-border">得意先名</th>
                <th width="10%" class="size120 text-center pdf-border">部署名</th>
                <th width="9%" class="size120 text-center pdf-border">売上日</th>
                <th width="6%" class="size120 text-center pdf-border">商品コード</th>
                <th width="12%" class="size120 text-center pdf-border">商品名</th>
                <th width="7%" class="size120 text-center pdf-border">規格</th>
                <th width="7%" class="size120 text-center pdf-border">c o l or</th>
                <th width="8%" class="size120 text-center pdf-border">数量</th>
                <th width="8%" class="size120 text-center pdf-border">単価</th>
                <th width="8%" class="size120 text-center pdf-border">明細金額</th>
                <th width="8%" class="size120 text-center pdf-border">入力日</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $totalAmount = 0;
            $totalNumber = 0;
            if(isset($data_order)) {
                foreach ($data_order as $key => $value) {
                    $totalAmountOrder = 0;
                    $totalNumberOrder = 0;
                    $textCustomer = "";
                    $textDepartment = "";
                    $fist_detail = 0; 
            ?>
            <?php 
            if(isset($data_detail)) {
                foreach ($data_detail as $key_detail => $value_detail) {
                    if($value['order_id'] == $value_detail['order_id']) {
                        $totalAmount += $value_detail['amount'];
                        $totalNumber += $value_detail['quantity_delivery'];
                        $totalAmountOrder += $value_detail['amount'];
                        $totalNumberOrder += $value_detail['quantity_delivery']; 
                        $textCustomer = $value_detail['customer_name'];
                        $textDepartment = $value_detail['department_name'];
                        $fist_detail++;
            ?>
            <tr>
                <td class="text-center"><?php echo ($fist_detail <= 1) ? $value_detail['order_id'] : ""; ?></td>
                <td><?php echo $value_detail['customer_name']; ?></td>
                <td><?php echo $value_detail['department_name']; ?></td>
                <td><?php echo date('Y-m-d', strtotime($value_detail['date_delivery'])); ?></td>
                <td class="text-right"><?php echo $value_detail['product_code_sale']; ?></td>
                <td><?php echo $value_detail['product_name_sale']; ?></td>
                <td class="text-center"><?php echo $value_detail['product_format']; ?></td>
                <td class="text-center"><?php echo $value_detail['product_color']; ?></td>
                <td class="text-right"><?php echo number_format($value_detail['quantity_delivery'],0,",",","); ?></td>
                <td class="text-right">¥<?php echo number_format($value_detail['price'],0,",",","); ?></td>
                <td class="text-right"><?php echo number_format($value_detail['amount'],0,",",","); ?></td>
                <td><?php echo date('Y-m-d', strtotime($value_detail['date_order'])); ?></td>
            </tr>
            <?php } } } ?>
            <tr>
                <th colspan="8" class="text-right"><?php echo $textCustomer . " &nbsp;" . $textDepartment . "の合計"; ?></th>
                <th class="text-right"><?php echo number_format($totalNumberOrder,0,",",","); ?></th>
                <th colspan="2" class="text-right"><?php echo number_format($totalAmountOrder,0,",",","); ?></th>
                <th></th>
            </tr>
            <?php } } ?>
            <tr>
                <th colspan="8" class="text-right">合&nbsp;&nbsp;計&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                <th class="text-right"><?php echo number_format($totalNumber,0,",",","); ?></th>
                <th colspan="2" class="text-right"><?php echo number_format($totalAmount,0,",",","); ?></th>
                <th></th>
            </tr>
        </tbody>
    </table>
</div>