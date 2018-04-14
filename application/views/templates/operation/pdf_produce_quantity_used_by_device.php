<div style="width:100%">
		<htmlpageheader name="myhead">
			<div style="width:100%;float:right;text-align:right;font-weight:bold">
				<div><?= $this->helper->readDate(date('Y/m/d')) ?></div>
				<div>{PAGENO}/{nb} ページ</div>
			</div>
			<div style="width:100%;clear:both;margin-top:20px;font-weight:bold;border-bottom:solid 3px black">
				<div style="width:50%;float:left;font-size:20pt">洗剤別機器使用量</div>
				<div style="width:40%;float:right;text-align:right;margin-right:30px"><?= $date_from." ~ ".$date_to ?></div>
			</div>
		</htmlpageheader>
		<sethtmlpageheader name="myhead" page="ALL" value="1" show-this-page="1"/>
</div>
<htmlpagebody>
<div style="clear:both">
	<div style="width:100%;margin-top:100px">
		<?php foreach ($lstMaster as $key => $value) {?>
			<table style="width:100%">
				<thead style="border-bottom:solid 1px black">
					<tr>
						<th style="width:6%">洗剤コード</th>
						<th style="width:18%">洗剤名</th>
						<th style="width:6%"></th>
						<th style="width:20%"></th>
						<th style="width:10%"></th>
						<th style="width:10%"></th>
						<th style="width:10%">洗剤量(kq)</th>
						<th style="width:10%">単価</th>
						<th style="width:10%">金額</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?= $value['id'] ?></td>
						<td><?= $value['name'] ?></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td><?= $value['quantity'] ?></td>
						<td><?= $value['price'] ?></td>
						<td><?= $value['quantity']*$value['price'] ?></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td class="header-child">機器コード</td>
						<td class="header-child">機器名</td>
						<td class="header-child">洗濯回数</td>
						<td class="header-child">使用量(g/ml)</td>
						<td class="header-child">洗剤量(kg)</td>
						<td class="header-child">単価</td>
						<td class="header-child">金額</td>
						
					</tr>

				<?php foreach ($value['detail'] as  $item) { ?>
					<tr>
						<td></td>
						<td></td>
						<td><?= $item[EQ_CODE] ?></td>
						<td><?= $item[EQ_NAME] ?></td>
						<td><?= $item['quantity'] ?></td>
						<td><?= $item['amount_washing'] ?></td>
						<td><?= $item['weight'] ?></td>
						<td><?= $item[DEL_UNIT_PRICE] ?></td>
						<td><?= $item[DEL_UNIT_PRICE]*$item['weight'] ?></td>
					</tr>
				<?php }?>
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