<div style="border-bottom:solid 3px black">
	<div style="width:50%;float:left;font-size:20pt" class="purple"><b>エネルギー使用量</b></div>
	<div style="width:50%;float:right;text-align: right;font-size:20pt;">
		<div class="purple"><b>ボイラー及び設備機器運転日誌</b></div>
		<div style="margin-right:20px"><?= $date_from." ~ ".$date_to ?></div>
	</div>
</div>
<table style="width:100%;margin-top:20px">
	<thead>
		<tr>
			<th></th>		
			<th></th>	
			<th>前年</th>	
			<th></th>	
			<th></th>	
			<th>前年</th>	
		</tr>
	</thead>
	<tbody>
		<tr>
			<td class="purple">●給油量の合計</td>
			<td><?= $lstMaster['supply_oil'] ?>l</td>
			<td><?= $lstMaster['supply_oil_last_year'] ?>l</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td class="purple">●油量使用量の合計 </td>
			<td><?= $lstMaster['supply_oil'] ?>l</td>
			<td><?= $lstMaster['supply_oil_last_year'] ?>l</td>
			<td class="purple">◆1号の小計</td>
			<td><?= $lstMaster['used_oil1'] ?>l</td>
			<td><?= $lstMaster['used_oil1_last_year'] ?>l</td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td class="purple">◆2号の小計</td>
			<td><?= $lstMaster['used_oil2'] ?>l</td>
			<td><?= $lstMaster['used_oil2_last_year'] ?>l</td>
		</tr>

		<tr>
			<td class="purple">●給水使用量の合計  </td>
			<td><?= $lstMaster['supply_water'] ?>m<sup>3</sup></td>
			<td><?= $lstMaster['supply_water_last_year'] ?>m<sup>3</sup></td>
			<td class="purple">◆1号の小計</td>
			<td><?= $lstMaster['supply_water1'] ?>m<sup>3</sup></td>
			<td><?= $lstMaster['supply_water1_last_year'] ?>m<sup>3</sup></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td class="purple">◆2号の小計</td>
			<td><?= $lstMaster['supply_water2'] ?>m<sup>3</sup></td>
			<td><?= $lstMaster['supply_water2_last_year'] ?>m<sup>3</sup></td>
		</tr>

		<tr>
			<td class="purple">●電力使用量の合計 </td>
			<td><?= $lstMaster['electric_used'] ?>Kwh</td>
			<td><?= $lstMaster['electric_used_last_year'] ?>Kwh</td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td class="purple">●県水使用量の合計 </td>
			<td><?= $lstMaster['water_kensui_used'] ?>m<sup>3</sup></td>
			<td><?= $lstMaster['water_kensui_used_last_year'] ?>m<sup>3</sup></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td class="purple">●ガスメーターの合計</td>
			<td><?= $lstMaster['used_gas'] ?>m<sup>3</sup></td>
			<td><?= $lstMaster['used_gas_last_year'] ?>m<sup>3</sup></td>
			<td class="purple">◆1号の小計</td>
			<td><?= $lstMaster['gas1'] ?>m<sup>3</sup></td>
			<td><?= $lstMaster['gas1_last_year'] ?>m<sup>3</sup></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td class="purple">◆2号の小計</td>
			<td><?= $lstMaster['gas2'] ?>m<sup>3</sup></td>
			<td><?= $lstMaster['gas2_last_year'] ?>m<sup>3</sup></td>
		</tr>

		<tr>
			<td class="purple">●井水メーターの合計</td>
			<td><?= $lstMaster['water_meter_used'] ?>m<sup>3</sup></td>
			<td><?= $lstMaster['water_meter_used_last_year'] ?>m<sup>3</sup></td>
			<td class="purple">◆No1の小計</td>
			<td><?= $lstMaster['water_meter2'] ?>m<sup>3</sup></td>
			<td><?= $lstMaster['water_meter2_last_year'] ?>m<sup>3</sup></td>
		</tr>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td class="purple">◆No2の小計</td>
			<td><?= $lstMaster['water_meter2'] ?>m<sup>3</sup></td>
			<td><?= $lstMaster['water_meter2_last_year'] ?>m<sup>3</sup></td>
		</tr>

		<tr>
			<td class="purple">●井水メーター(星製薬)の合計</td>
			<td><?= $lstMaster['water_special_used'] ?>m<sup>3</sup></td>
			<td><?= $lstMaster['water_special_used_last_year'] ?>m<sup>3</sup></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>

		<tr>
			<td class="purple">●洗濯量の合計</td>
			<td><?= $lstMaster['weight'] ?>m<sup>3</sup></td>
			<td><?= $lstMaster['weight_last_year'] ?>m<sup>3</sup></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>


	</tbody>
</table>

<htmlpagefooter name="myfooter">
	<div>
	<?= $this->helper->readDate(date('Y-m-d')) ?>
	</div>
</htmlpagefooter>
<sethtmlpagefooter name="myfooter" page="ALL" value="1" show-this-page="1"/>
<style>
	body{
		font-size:16pt;

	}
	table{
		border-spacing: 0 1em;
	}
	td,th{
		text-align: left
	}
	.purple{
		color:#25258e;
	}
	tr{
	}
</style>