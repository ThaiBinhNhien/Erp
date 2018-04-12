<div> 
    <table width="100%" class="table">
        <tbody>
            <tr>
                <td width="33%" class="text-left">&nbsp;</td>
                <th width="33%" class="text-center" style="font-size: 160%;"><?php echo $title; ?></th>
                <td width="33%" class="text-right">ページ {PAGENO}</td>
            </tr>
        </tbody> 
	</table>
</div> 
<div> 
    <table width="100%" class="table">
        <tbody>
            <tr>
                <td width="33%" class="text-left fontJapan">お客様コード: <?php echo $detail_sale["place_sale_id"]; ?> <br>〒 <?php echo $detail_sale["place_sale_postage"]; ?></td>
                <th width="33%" class="text-center" style="font-size: 110%;">&nbsp;</th>
                <td width="33%" class="text-right"><?php echo $date_report_now; ?></td>
            </tr>
            <tr>
                <td width="33%" class="text-left"><?php echo $detail_sale["place_sale_address1"]; ?></td>
                <th width="33%" class="text-center" style="font-size: 110%;">&nbsp;</th>
                <td width="33%" class="text-right">&nbsp;</td>
            </tr>
            <tr>
                <td width="33%" class="text-right"><?php echo $detail_sale["place_sale_address2"]; ?></td>
                <th width="33%" class="text-center" style="font-size: 110%;">&nbsp;</th>
                <th width="33%" class="text-left fontJapan">〒<?php echo TOLINEN_POST_OFFICE; ?></th>
            </tr>
            <tr>
                <td width="33%" class="text-center"><?php echo $detail_sale["place_sale_name"]; ?></td>
                <th width="33%" class="text-center" style="font-size: 110%;">&nbsp;</th>
                <th width="33%" class="text-left"><?php echo TOLINEN_ADDRESS; ?></th>
            </tr>
            <tr>
                <td width="33%" class="text-right">&nbsp;</td>
                <th width="33%" class="text-center" style="font-size: 110%;">&nbsp;</th>
                <th width="33%" class="text-left"><?php echo TOLINEN_ADDRESS_HOTEL; ?></th>
            </tr>
            <tr>
                <td width="33%" class="text-right">&nbsp;</td>
                <th width="33%" class="text-center" style="font-size: 110%;">&nbsp;</th>
                <th width="33%" class="text-left"><?php echo TOLINEN_COMPANY_NAME; ?></th>
            </tr>
            <tr>
                <td width="33%" class="text-right">&nbsp;</td>
                <th width="33%" class="text-center" style="font-size: 110%;">&nbsp;</th>
                <td width="33%" class="text-center">平成<?php echo $exp_last_month; ?> 末日締切り</td>
            </tr>
        </tbody>
    </table>
</div>
<div> 
    <table width="100%" class="table">
        <thead>
            <tr>
                <td width="16.6%" class="">今回御買上金額</td>
                <td width="16.6%" class="">取扱手数料</td>
                <td width="16.6%" class="">今回消費税額</td>
                <td width="16.6%" class="">&nbsp;</td>
                <td width="16.6%" class="">今回御請求金額</td>
                <td width="16.6%" class="">&nbsp;</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td width="16.6%" class=""><?php echo number_format($totalBuy,0,",",","); ?></td>
                <td width="16.6%" class=""><?php echo number_format($HANDLING_FEE,0,",",","); ?></td>
                <td width="16.6%" class=""><?php echo number_format($totalBuyTax,0,",",","); ?></td>
                <td width="16.6%" class="">&nbsp;</td>
                <td width="16.6%" class="">¥<?php echo number_format($totalPay,0,",",","); ?></td>
                <td width="16.6%" class="">&nbsp;</td>
            </tr>
        </tbody>
    </table>
</div>