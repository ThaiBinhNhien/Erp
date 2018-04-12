<htmlpageheader name="myhead" >
	<div style="width:20%;text-align:center;font-size:20pt;font-weight:bold;float:left">
		<?= date('Y/m/d') ?>
	</div>
	<div style="width:50%;text-align:left;font-size:20pt;float:left">
		入力分チェックリスト
	</div>
	<div style="width:100%;clear:both;border-bottom:solid 3px black;margin:10px 0px 10px 0px">
		<div style="width:5%;float:left;text-align:left">伝票ID </div>
		<div style="width:5%;float:left;text-align:left">注文日</div>
		<div style="width:6%;float:left;text-align:left">処理内容</div>
		<div style="width:6%;float:left;text-align:left">発注社員</div>
		<div style="width:5%;float:left;text-align:left">商品ID</div>
		<div style="width:12%;float:left;text-align:left">商品名</div>
		<div style="width:10%;float:left;text-align:left">備考</div>
		<div style="width:5%;float:left;text-align:left">単価 </div>
		<div style="width:5%;float:left;text-align:left">数量</div>
		<div style="width:5%;float:left;text-align:left">金額</div>
		<div style="float:left;text-align:left">主な使用内容</div>
	</div>
</htmlpageheader>
<sethtmlpageheader name="myhead" page="ALL" value="1" show-this-page="1"/>

<table style="width:100%;margin-top:50px">
	<thead>
		<tr>
			<th style="width:5%"></th>
			<th style="width:6%"></th>
			<th style="width:6%"></th>
			<th style="width:6%"></th>
			<th style="width:5%"></th>
			<th style="width:12%"></th>
			<th style="width:10%"></th>
			<th style="width:5%"></th>
			<th style="width:5%"></th>
			<th style="width:5%"></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		
		<?php foreach ($lstMaster as  $type) { ?>
			<tr><td colspan="11">処理区分： <?= $type['name'] ?></td></tr>
			<?php foreach ($type['detail'] as $key => $value) { 
				$first = true; ?>
	            <?php foreach ($value['detail'] as $keyCompany => $company) { 
	            	$first_company = true;?>
	            	<?php foreach ($company['detail'] as $item) { ?>
	            		<?php if($first_company == true && $keyCompany != '-1'){ ?>
	            			<tr>
	            				<td></td>
	            				<td></td>
	            				<td></td>
	            				<td></td>
	            				<td colspan="7"><?= $company['name'] ?></td>
	            			</tr>
	            		<?php $first_company = false;  } ?>
	            		
	            		<tr>
			            	<?php if($first == true) {?>
			            		<td><?= $key ?></td>
			            		<td><?= $value['date'] ?></td>
			            		<td><?= $value['processing_content'] ?></td>
			            		<td><?= $value['user'] ?></td>
			            	<?php $first = false;}else{ ?>
			            		<td></td>
			            		<td></td>
			            		<td></td>
			            		<td></td>
			            	<?php } ?>
			            		<td><?= $item['product_id'] ?></td>
			            		<td><?= $item['product_name'] ?></td>
			            		<td><?= $item['note'] ?></td>
			            		<td><?= $item['price'] ?></td>
			            		<td><?= $item['quantity'] ?></td>
			            		<td><?= $item['price']*$item['quantity'] ?></td>
			            		<td><?= $item['product_note'] ?></td>
		            	</tr>
	            	<?php } ?>
            	<?php } ?>
            <?php } ?>
        <?php }?>
	</tbody>
</table>

<htmlpagefooter name="myfooter" >
	<div style="width:100%;clear:both;border-top:solid 3px black;margin:10px 0px 10px 0px">
		<div style="float:left;width:20%">
			<?= $this->helper->readDate(date('Y/m/d')) ?>
		</div>
		<div style="float:right;width:20%;text-align:right">
			{PAGENO}/{nb} ページ
		</div>
	</div>
</htmlpagefooter>
<sethtmlpagefooter name="myfooter" page="ALL" value="1"/>

