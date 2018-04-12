<div class="pre-page">
    <div class="row">
        <table width="50%">
            <tbody> 
                <tr>
                    <td class="fontJapan">ｺﾝﾃﾅNO： <?php echo $dataReport['container'];?>／<?php echo $master[OS_TOTAL_NUMBER_CONTAINERS];?>台</td>
                    <td class="text-center"><h4><?php echo $setNoContainer;?></h4></td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td><?php echo $DATE_NOW;?></td>
                </tr>
                <tr>
                    <td class="fontJapan">配送便： <?php echo $master['delivery_classifition'];?></td>
                    <td class="fontJapan">発注者： <?php echo $master['user_order'];?></td>
                </tr>
                <tr>
                    <td>発注日： <?php echo $OS_ORDER_DATE;?></td>
                    <td class="fontJapan">出荷者： <?php echo $master['user_shipper'];?></td>
                </tr>
                <tr>
                    <td>納品日： <?php echo $OS_DELIVERY_DATE;?></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="row">
        <table width="50%">
            <tbody>
                <?php
                if($dataReport['customer'] != '') {
                    $maxTrackContainer = (1 * 80 * 1000);
                    foreach ($dataReport['customer'] as $key => $value) {
                        ?>
                        <tr>
                            <td colspan="4">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4">得意先 <?php echo $value['customer_name'];?></td>
                        </tr>
                        <tr>
                            <td colspan="4">部署&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span style="font-size: 180%;"><?php echo $value['department_name'];?></span></td>
                        </tr>
                        <tr>
                            <td>商品名</td>
                            <td>規格</td>
                            <td>COLOR</td>
                            <td class="text-center">納品</td>
                        </tr>
                        <?php
                        if($value['detail'] != '') {
                            foreach ($value['detail'] as $keyProduct => $valueProduct) {
                                $maxTrackContainer += (float)$valueProduct['product_weight'] * (float)$valueProduct['quantity_delivery'];
                                ?>
                                    <tr>
                                        <td><?php echo $valueProduct['product_name'];?></td>
                                        <td><?php echo $valueProduct['product_format'];?></td>
                                        <td><?php echo $valueProduct['product_color'];?></td>
                                        <td class="text-right"><?php echo $valueProduct['quantity_delivery'];?> □</td>
                                    </tr>
                                <?php
                            }
                        }
                    }
                }
                ?>
                <tr>
                    <td colspan="4">&nbsp;</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>重量：</td>
                    <td><?= ((float)$maxTrackContainer/1000);?>Kg</td>
                </tr>
                <tr>
                    <td colspan="4" class="text-center">-------------------------------</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>