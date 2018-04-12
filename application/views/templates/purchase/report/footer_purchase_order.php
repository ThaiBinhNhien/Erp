<div class="row footer">
    <div>
    <table>
        <thead>
            <tr>
                <th>納品場所</th><th>注意事項等</th><th>注意事項等</th><th>発注者</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: left;" valign="top">
                    <?php echo $base->{BM_BASE_NAME} ?>工場<br>
                    〒:<?php echo $base->{BM_POSTAL_CODE} ?><br>
                    <?php echo $base->{BM_ADDRESS_1}." ".$base->{BM_ADDRESS_2} ?><br>
                    <?php echo $base->{BM_COMPANY_NAME} ?><br>
                </td>
                <td>
                        <?php echo str_replace("\n", "<br>", $comment); ?>
                </td>
                <td>
                        <?php echo $order_content; ?>
                </td>
                <td>
                        <?php echo $user; ?>
                </td>
            </tr>
        </tbody>
    </table>
    </div>
</div>