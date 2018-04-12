<?php $countDetail = 0; ?>
<div>
	<table width="100%" class="table">
		<thead>
			<tr>
				<th class="text-center border-bottom2 color030a84 size120">売上日</th>
				<?php
				if($detail_page != null) {
					foreach ($detail_page as $key => $value) {
						if($value["type"] == 0) {
							$countDetail++;
				?>
				<th class="text-right border-bottom2 color030a84 size120"><?php echo $value["name"]; ?></th>
				<?php
						}
					}
				} 
				?>
				<th class="text-right border-bottom2 color030a84 size120">売上合計額</th>
			</tr>
		</thead>
		<tbody>
			<?php
				if($detail != null) {
					$Total = 0;
					$sumValue[$value['id']] = 0;
					foreach ($detail as $keyDetail => $valueDetail) {
						$sumTotal = 0;
				?>
			<tr>
				<td class="text-center"><?php echo $valueDetail['date']; ?></td>
				<?php
				if($detail_page != null) {
					foreach ($detail_page as $key => $value) {
						if($value["type"] == 0) {
						$valueDepratment = "";
						if($valueDetail['data'] != null) {
							foreach ($valueDetail['data'] as $keyData => $valueData) {
								if($value['id'] == $valueData['id']) {
									$sumValue[$value['id']] += $valueData['value'];
									$valueDepratment = $valueData['value'];
									$Total+=$valueData['value'];
									$sumTotal+=$valueData['value'];
								}
							}
						}
				?>
				<td class="text-right"><?php echo number_format($valueDepratment,0,",",","); ?></td>
				<?php
					}
				}
				} 
				?>
				<?php ?>
				<td class="text-right"><?php echo number_format($sumTotal,0,",",","); ?></td>
			</tr>
			<?php
					}
				} 
				?>
				<tr>
				<th class="text-center border-top2">&nbsp;</th>
				<?php
				if($detail_page != null) {
					foreach ($detail_page as $key => $value) {
						if($value["type"] == 0) {
				?>
				<th class="text-right border-top2"><?php echo number_format($sumValue[$value['id']],0,",",","); ?></th>
				<?php
						}
					}
				} 
				?>
				<th class="text-right border-top2"><?php echo number_format($Total,0,",",","); ?></th>
			</tr>
				<?php if($isTotal == true && $Total > 0) { ?>
			<tr>
				<th colspan="<?php echo $countDetail; ?>">&nbsp;</th>
				<th class="text-left sizeBig">合 計</th>
				<th class="text-right"><?php echo number_format($valueTotal,0,",",","); ?>
				</th>
			</tr>
			<?php } ?>
		</tbody>
	</table>
</div>