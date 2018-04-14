<div style="width:100%">
		<htmlpageheader name="myhead">
			<div style="width:100%;float:right;text-align:right;font-weight:bold">
				<div><?= $this->helper->readDate(date('Y/m/d')) ?></div>
				<div>{PAGENO}/{nb} ページ</div>
			</div>
			<div style="width:100%;clear:both;margin-top:20px;font-weight:bold;border-bottom:solid 3px black">
				<div style="width:50%;float:left;font-size:20pt">機器別洗剤使用量</div>
				<div style="width:40%;float:right;text-align:right;margin-right:30px"><?= $date_from." ~ ".$date_to ?></div>
			</div>
		</htmlpageheader>
		<sethtmlpageheader name="myhead" page="ALL" value="1" show-this-page="1"/>
	</div>
<htmlpagebody>
<div style="clear:both">
	<div style="width:100%;margin-top:100px">
		<?php foreach ($lstMaster as $key => $value) {?>
			<div>
				<?= $value['name'] ?>
			</div>
			<table style="width:100%">
				<thead style="border-bottom:solid 1px black">
					<tr>
						<th style="width:6%">洗濯コード</th>
						<th style="width:18%">洗濯品名</th>
						<th style="width:6%"></th>
						<th style="width:20%"></th>
						<th style="width:10%"></th>
						<th style="width:10%"></th>
						<th style="width:10%">洗剤量(kq)</th>
						<th style="width:10%"></th>
						<th style="width:10%">金額</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($value['detail'] as $item) {?>
						<tr>
							<td><?= $item['id'] ?></td>
							<td><?= $item['name'] ?></td>
							<td></td>
							<td></td>
							<td></td>
							<td></td>
							<td><?= $item['quantity'] ?></td>
							<td></td>
							<td><?= $item['amount'] ?></td>
						</tr>
						<tr>
							<td></td>
							<td></td>
							<td class="header-child">洗剤コード</td>
							<td class="header-child">洗剤名</td>
							<td class="header-child">洗濯回数</td>
							<td class="header-child">使用量(g/ml)</td>
							<td class="header-child">洗剤量(kg)</td>
							<td class="header-child">単価</td>
							<td class="header-child">金額</td>
							
						</tr>
						<?php foreach ($item['detail'] as $detail) {?>
							<tr>
								<td></td>
								<td></td>
								<td><?= $detail['id'] ?></td>
								<td><?= $detail['name'] ?></td>
								<td><?= number_format($detail['quantity']) ?></td>
								<td><?= number_format($detail['amount_washing']) ?></td>
								<td><?= number_format($detail['weight'],2,'.',',') ?></td>
								<td><?= number_format($detail['price'],2,'.',',') ?>¥</td>
								<td><?= number_format($detail['price']*$detail['weight'],2,'.',',') ?>¥</td>
							</tr>
						<?php }?>
					<?php } ?>
					

				</tbody>
			</table>
		<?php } ?>
	</div>
</div>
</htmlpagebody>
<style>
	table{
		border-collapse: collapse;
	}
	td{
		
	}
	th{
		text-align: left;
		border-bottom:solid 3px black;
	}
	.header-child{
		border-bottom:solid 3px black;
		font-weight:bold
	}
</style>