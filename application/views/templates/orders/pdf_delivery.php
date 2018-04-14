<div>
<?php foreach ($delivery as $indexMaster => $valueMaster) { ?>

	<div style="width:100%">
		<div style="float:left;width:10%;text-align:center"><b><?= $id ?></b></div>
		<div style="margin-left:38% ;width:20%;text-align:center"><h1>納 品 書</h1></div>
	</div>
	<div style="width:30%;float:right;text-align:center;clear:both;font-size:14pt">
		<?= $date ?>
	</div>
	<div style="width:60%;clear:both">
		<div style="float:right;width:15%;text-align:right;font-size:16pt">御中</div>
		<div class="right text-right border-bottom" style="width:80%"><?= $company_name ?></div>
		<div class="right text-right border-bottom" style="width:75%;margin:50px 15% 0 0"><?= $other_name ?></div>
	</div>
	<div style="clear:both;font-size:14pt;margin:20px 0px 20px 0px">
		下記のとおり納品申し上げましたのでご査収ください。
	</div>
	<div style="width:100%;clear:both">
		<table style="width:100%">
			<thead>
				<tr>
					<th style="width:30%">商品名</th>
					<th style="width:10%">規格</th>
					<th style="width:10%">Color</th>
					<th style="width:15%">量数量</th>
					<th style="width:15%">単価</th>
					<th style="width:20%">金額金額</th>
				</tr>
			</thead>
			<tbody>
				<?php 
					$total_quantity = 0;
					$total_cost = 0;
					foreach ($valueMaster as $key => $value) { 
						$total_quantity += $value[DD_QUANTITY];
						$total_cost += $value[DD_UNIT_PRICE]*$value[DD_QUANTITY];
					?>
					<tr>
						<td><?= $value[PL_PRODUCT_NAME]?></td>
						<td><?= $value[PL_STANDARD]?></td>
						<td><?= $value[PL_COLOR_TONE]?></td>
						<td><?= $value[DD_QUANTITY]?></td>
						<td><?= $value[DD_UNIT_PRICE]?></td>
						<td><?= number_format($value[DD_UNIT_PRICE]*$value[DD_QUANTITY],2) ?></td>
					</tr>
				<?php }?>
				<tr style="border-bottom:solid 3px #8585ad"></tr>
				<tr>
					
				</tr>
			</tbody>
		</table>
		
	</div>
	
	<htmlpagefooter name="myfooter<?= $indexMaster ?>">
		<div style="width:100%;clear:both;border:solid 2px black"></div>
		<table style="width:100%;margin-top:10px">
			<thead>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</thead>
			<tbody>
				<tr>
					<td colspan="2" class="border">合計</td>
					<td class="border">数量</td>
					<td class="border"><?= number_format($total_quantity,2) ?></td>
					<td class="border">金額</td>
					<td class="border">¥<?= number_format($total_cost,2) ?></td>
				</tr>
				<tr>
					<td class="border" style="width:60px;height:100px">受領者</td>
					<td class="border"></td>
					<td class="border" style="width:60px">担当者</td>
					<td class="border"></td>
					<td class="border" style="width:60px">係</td>
					<td class="border"></td>
				</tr>
			</tbody>
		</table>
		<div style="width:100%;clear:both;text-align:center">
	        <h2>株式会社　テーオーリネンサプライ</h2>
	    </div>
	    <div style="width:100%">
	        <table style="width:100%;font-size:13pt">
	            <tbody>
	                <tr>
	                    <td >本社</td>
	                    <td>〒102-8578</td>
	                    <td>東京都千代田区紀尾井町４－１</td>
	                    <td>電話(03) 3221-4081 (代表)</td>
	                </tr>
	                <tr>
	                    <td>工場</td>
	                    <td>〒243-0801</td>
	                    <td>神奈川県厚木市上依知３００６－１</td>
	                    <td>電話(046)2861-33111 (代表)</td>
	                </tr>
	            </tbody>
	        </table>
	    </div>
	</htmlpagefooter>
	<sethtmlpagefooter name="myfooter<?= $indexMaster ?>" page="ALL" value="1" />
	<?php if($indexMaster != count($delivery) -1){
		echo '<pagebreak />';
	}?>
<?php } ?>
</div>

<style>
	th{
		background-color: #7575a3;
		text-align: center;
		padding: 10px;
		font-weight: bold;
		border:solid 1px black;
		font-size:14pt;
	}
	.border{
		border:solid 2px black;
	}
	table{
		border-collapse: collapse;
	}
	.right{
		float:right;
	}
	.text-right{
		text-align: right
	}
	.border-bottom{
		border-bottom:solid 2px black
	}
	
</style>