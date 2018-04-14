
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
                <td class="text-left">対象期間 2014/01/01 ～ 2017/06/14 </td>
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
                <th class="size110 borTopIn">&nbsp;仕入先名</th>
                <th colspan="2" class="size110 borTopIn text-center">&nbsp;販売先名</th>
                <th class="size110 borTopIn">&nbsp;</th>
                <th class="size110 borTopIn">&nbsp;</th>
                <th class="size110 borTopIn">&nbsp;</th>
                <th class="size110 borTopIn">&nbsp;</th>
                <th class="size110 borTopIn">&nbsp;</th>
            </tr>
            <tr>
                <th>&nbsp;</th>
                <th colspan="2">&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>
            <tr>
                <th width="16%" class="size110 borBotIn">&nbsp;日付</th>
                <th width="16%" class="size110 borBotIn text-center">商品名</th>
                <th width="14%" class="size110 borBotIn">備考</th>
                <th width="10%" class="size110 borBotIn">色調</th>
                <th width="10%" class="size110 borBotIn">規格</th>
                <th width="10%" class="size110 borBotIn">数量</th>
                <th width="12%" class="size110 borBotIn">仕入単価</th>
                <th width="12%" class="size110 borBotIn">支払金額</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th colspan="8" class="size110">当社分</th>
            </tr>
            <tr>
                <th class="size110">野島タオル(株)</th>
                <th colspan="2" class="size110">(株)テーオーリネンサプライ</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
                <th>&nbsp;</th>
            </tr>


            <!-- Detail -->
            <tr>
                <td class="borderDotted">2017/06/09</td>
                <td class="borderDotted">4941 プールタオル</td>
                <td class="borderDotted">拭上ﾀﾞｽﾀｰ用</td>
                <td class="borderDotted">白</td>
                <td class="borderDotted">34*34</td>
                <td class="borderDotted text-right">1800</td>
                <td class="borderDotted text-right">¥80.00</td>
                <td class="borderDotted text-right">144,000</td>
            </tr>
            <tr>
                <td class="borderDotted">2017/06/09</td>
                <td class="borderDotted">4941 プールタオル</td>
                <td class="borderDotted">拭上ﾀﾞｽﾀｰ用</td>
                <td class="borderDotted">白</td>
                <td class="borderDotted">34*34</td>
                <td class="borderDotted text-right">1800</td>
                <td class="borderDotted text-right">¥80.00</td>
                <td class="borderDotted text-right">144,000</td>
            </tr>
            <tr>
                <td class="borderDotted">2017/06/09</td>
                <td class="borderDotted">4941 プールタオル</td>
                <td class="borderDotted">拭上ﾀﾞｽﾀｰ用</td>
                <td class="borderDotted">白</td>
                <td class="borderDotted">34*34</td>
                <td class="borderDotted text-right">1800</td>
                <td class="borderDotted text-right">¥80.00</td>
                <td class="borderDotted text-right">144,000</td>
            </tr>
            <!-- // Detail -->

            <tr>
                <th colspan="5" class="text-right">10663</th>
                <th colspan="2" class="text-right">仕入金額合計</th>
                <th class="text-right">2,155,609</th>
            </tr>
            <tr>
                <th colspan="7" class="text-right">消費税 8％</th>
                <th class="text-right">2,155,609</th>
            </tr>
            <tr>
                <th colspan="7" class="text-right">総合計</th>
                <th class="text-right">2,155,609</th>
            </tr>

            <tr>
                <th colspan="7" class="text-right">種目区分金額合計</th>
                <th class="text-right">2,155,609</th>
            </tr>
            <tr>
                <th colspan="7" class="text-right">消費税 8％</th>
                <th class="text-right">2,155,609</th>
            </tr>
            <tr>
                <th colspan="7" class="text-right">総合計</th>
                <th class="text-right">2,155,609</th>
            </tr>
            <tr>
                <th colspan="5" class="text-right">52682</th>
                <th colspan="2" class="text-right">仕入金額総合計</th>
                <th class="text-right">2,155,609</th>
            </tr>
            <tr>
                <th colspan="7" class="text-right">消費税 8％</th>
                <th class="text-right">2,155,609</th>
            </tr>
            <tr>
                <th colspan="7" class="text-right">総合計</th>
                <th class="text-right">2,155,609</th>
            </tr>
        </tbody>
    </table>
</div>