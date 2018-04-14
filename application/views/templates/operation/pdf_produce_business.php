<div>
	<htmlpageheader name="myhead" >
		<div style="width:100%;text-align:center;font-size:20pt;border-bottom:solid 3px black">
			<b>得意先別生産実績表</b>
		</div>
		<div style="width:100%;clear:both;border-bottom:solid 3px black;margin:10px 0px 10px 0px">
			<div style="width:50%;float:left;text-align:right">日報日付: <?= $this->helper->readDate(date('Y-m-d')) ?></div>
			<div style="width:50%;float:right;text-align:right">対象期間: <?= $date_from." ～ ".$date_to ?></div>
		</div>
	</htmlpageheader>
	<sethtmlpageheader name="myhead" page="ALL" value="1" show-this-page="1"/>
</div>
<table style="width:100%:clear:both;margin-top:70px">
	<thead>
		<tr>
			<th width="15%">得意先名 </th>
			<th width="10%" style="border-right:solid 1px black">細目 </th>
			<th>本日売上 </th>
			<th>前年同日売上  </th>
			<th>差額 </th>
			<th style="border-right:solid 1px black">比率 </th>
			<th>当月累計 </th>
			<th>前年同月累計  </th>
			<th>差額 </th>
			<th>比率 </th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($customer as $value) { 
			$index = 0; 
			$total_amount_today = 0;
			$total_amount_today_lastyear = 0;
			$total_difference_day = 0;
			$total_amount_thismonth = 0;
			$amount_thismonth_lastyesr = 0;
			$difference_month = 0;
			?>
			<?php foreach ($value['detail'] as $key => $item) { 
				$total_amount_today += $item['amount_today'];
				$total_amount_today_lastyear += $item['amount_today_lastyear'];
				$total_difference_day += $item['difference_day'];
				$total_amount_thismonth += $item['amount_thismonth'];
				$total_amount_thismonth_lastyear += $item['amount_thismonth_lastyesr'];
				$total_difference_month += $item['difference_month'];
				?>
				<tr>
					<td><?= $index==0? $value['cus_name']:'' ?></td>
					<td style="border-right:solid 1px black"><?= $item['depart_name'] ?></td>
					<td><?= number_format($item['amount_today'],2,'.',',') ?>¥</td>
					<td><?= number_format($item['amount_today_lastyear'],2,'.',',') ?>¥</td>
					<td><?= number_format($item['difference_day'],2,'.',',') ?>¥</td>
					<td style="border-right:solid 1px black"><?= $item['percent_day'] ?>%</td>
					<td><?= number_format($item['amount_thismonth'],2,'.',',') ?>¥</td>
					<td><?= number_format($item['amount_thismonth_lastyear'],2,'.',',') ?>¥</td>
					<td><?= number_format($item['difference_month'],2,'.',',') ?>¥</td>
					<td><?= $item['percent_month'] ?>%</td>
				</tr>
			<?php $index += 1; } ?>
			<tr class="sum">
				<td colspan="2" style="border-right:solid 1px black">小 計</td>
				<td><?= number_format($total_amount_today,2,'.',',') ?>¥</td>
				<td><?= number_format($total_amount_today_lastyear,2,'.',',') ?>¥</td>
				<td><?= number_format($total_difference_day,2,'.',',') ?>¥</td>
				<td style="border-right:solid 1px black"><?= $total_amount_today_lastyear ==0 ?0:round($total_amount_today/$total_amount_today_lastyear,1)?>%</td>
				<td><?= number_format($total_amount_thismonth,2,'.',',')?>¥</td>
				<td><?= number_format($total_amount_thismonth_lastyear,2,'.',',') ?>¥</td>
				<td><?= number_format($total_difference_month,2,'.',',')?>¥</td>
				<td><?= $total_amount_thismonth_lastyear == 0 ? 0:round($total_amount_thismonth/$total_amount_thismonth_lastyear,1)?>%</td>
			</tr>
		<?php } ?>
	</tbody>
</table>
<style>
	body{
		font-size:13pt;
	}
	table{
		border-collapse: collapse;
	}
	th{
		border-bottom:solid 3px black;
	}
	td,th{
		text-align: center
	}
	.purple{
		color:#25258e;

	}
	td{
		padding: 5px;
	}
	.center{
		text-align: center;
	}
	.border-dot{
		border-bottom:dotted 1px black;
	}
	.border-solid{
		border-bottom:solid 1px black;
	}
	.sum{
		font-weight: bold;
	}
	.sum td{
		background-color: #dcccff;
		font-weight: bold;
	}
	
</style>