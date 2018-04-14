<div class="row home" id="dashboard_page">
<!-- content receive-order -->
    <div class="col-sm-6 col-md-6">
        <div class="wrapper">
            <div class="title">
                <h3>注文管理　新着情報</h3>
                <h5><a href="<?php echo site_url().'receive-order'?>">一覧はこちら</a></h5>
            </div>
            <div id="receive-order" class="content <?php if(!empty($list_order)){ echo 'scroll_are';} ?>">
				<?php
					if(empty($list_order)) 
					{
						if($author_order == false)
						{
							echo 'アクセス拒否 Access Denied';
						}	
						else
						{
							echo '適当な検索結果が見つかりません。!';
						}
					}
					else
					{	
						echo '<ul class="scroll_tab">';
						$flag_date = '';
						$count_break_loder = 0;
						foreach ($list_order as $item) 
						{
							$date_sale = str_replace('-', '/', date('Y-m-d',strtotime($item[SL_SALES_DATE])));

							if($flag_date != $date_sale)
							{
								
								$count_break_loder ++;
								if($count_break_loder > 3)
								{
									break;
								}
								echo '<h5 class="line_margin_left" style="font-weight: bold">'.$date_sale.'</h5>';
							}
							$status  = '';
							$title_name = '';
							if($item[SL_NUMBER_ORDER_MODIFY] > 0)
							{
								$status='<span class="blue">更新</span>';
							}
							else
							{
								$status='<span class="red">NEW</span>';
							}
							$url = '';
							if($item[SL_ORDER_CLASSIFICATION] == '2')
							{
								$url = 'order/detail-order-2?id=';
								$title_name = 'ニューオータニ';
							}
							else
							{
								$url = 'order/detail-order?id=';
								$title_name = '○○ホテル';
							}

							if(!empty($item['SL_REVENUE_DATE'])){
								$flag_reven_text  = "（注文伝票）";
							} else {
								$flag_reven_text  = "（納品・売上）";
							}

							echo'<li id = '.$item[SL_ID].'_rod>'.$status.'<span class="link"><span class="tri-angle"></span>
													<a href="'.base_url($url).$item[SL_ID].'" class="tool" target="_blank">' 
														.$title_name. ' (No.'.$item[SL_ID].')'.$flag_reven_text.'
														<span></span>
													</a>
												</span>
								';
							echo '<div style=" overflow:auto; position: relative" id = table_'.$item[SL_ID].'>';
								echo '<table class="table table-bordered table_detail">';
									echo '<thead>
										<tr>
											<th>'.TGRI_PRODUCT_ID.'</th>
											<th>'.TGRI_PRODUCT_NAME.'</th>
											<th>'.PL_STANDARD.'</th>
											<th>'.PL_COLOR_TONE.'</th>
											<th>'.TGRI_UNIT_PRICE.'</th>
											<th>'.TGRI_NUMBER_OF_ORDERS.'</th>
										</tr>
									</thead><tbody></tbody>';
								echo '</table>';
							echo '</div>';
							echo '</li>';
							$flag_date = $date_sale;
						}//End foreach
						echo '</ul>';
					}
				?>
            </div>
        </div>
    </div>
<!-- end content receive-order -->

<!-- content Revenue management -->
    <div class="col-sm-6  col-md-6">
        <div class="wrapper">
            <div class="title">
                <h3>売上管理　新着情報</h3>
                <h5><a  href="<?php echo site_url().'sale'?>">一覧はこちら</a></h5>
            </div>
            <div id="revenue-list" class="content <?php if(!empty($list_revenue)){ echo 'scroll_are';} ?>">
				<?php
					if(empty($list_revenue))
					{
						if($author_revenue == false)
						{
							echo 'アクセス拒否 Access Denied';
						}	
						else
						{
							echo '適当な検索結果が見つかりません。!';
						}
					}
					else
					{
						echo '<ul class="scroll_tab">';
							$flag_date_revenue = '';
							$count_break_revenue = 0;
							foreach ($list_revenue as $key => $item_revenue) 
							{
								$date_revenue = str_replace('-', '/', date('Y-m-d',strtotime($item_revenue[I_DATE_CREATE])));
								if($flag_date_revenue != $date_revenue)
								{
									$count_break_revenue ++ ; 
									if($count_break_revenue  > 3)
									{
										break;
									}
									echo '<h5 class="line_margin_left" style="font-weight: bold">'.$date_revenue.'</h5>';
								}
								$status  = '';
								$title_name = '';
								if($item_revenue[I_CHECK_UPDATE] == '0')
								{
									$status='<span class="red">NEW</span>';
								}
								else
								{
									$status='<span class="blue">更新</span>';
								}
								if($item_revenue[CUS_TYPE_CUSTOMER] == '2')
								{
									$title_name = 'ニューオータニ';
								}
								else
								{
									$title_name = '○○ホテル';
								}
								echo'<li id = '.$item_revenue[I_ID].'_rev>'.$status.'<span class="link"><span class="tri-angle"></span>
														<a target="_blank" href="'.base_url('sale/detail-sale-2?inv_id=').$item_revenue[I_ID].'" class="tool">' 
															.$title_name. ' (No.'.$item_revenue[I_ID].')
															<span></span>
														</a>
													</span>
												';
								echo '<div style=" overflow:auto; position: relative" id = table_re_'.$item_revenue[I_ID].'>';
									echo '<table class="table table-bordered table_revenue">';
										echo '<thead>
											<tr>
												<th>'.TGRI_PRODUCT_ID.'</th>
												<th>'.TGRI_PRODUCT_NAME.'</th>
												<th>'.PL_STANDARD.'</th>
												<th>'.PL_COLOR_TONE.'</th>
												<th>'.TGRI_UNIT_PRICE.'</th>
												<th>'.TGRI_NUMBER_OF_ORDERS.'</th>
											</tr>
										</thead><tbody></tbody>';
									echo '</table>';
								echo '</div>';
								echo '</li>';
								$flag_date_revenue = $date_revenue;

							}
						echo '</ul>';
					}
				?>
				
            </div>
        </div>
	</div>
<!-- end Revenue management -->

<!-- content Shipment -->
    <div class="col-sm-6  col-md-6">
        <div class="wrapper">
            <div class="title">
                <h3>受発注管理　新着情報</h3>
                <h5><a href="<?php echo site_url().'shipment'?>">一覧はこちら</a></h5>
            </div>
            <div id="ship-list-tmp" class="content <?php if(!empty($list_shipment)){ echo 'scroll_are';} ?>">
				<?php
					if(empty($list_shipment))
					{
						if($author_shipment == false)
						{
							echo 'アクセス拒否 Access Denied';
						}	
						else
						{
							echo '適当な検索結果が見つかりません。!';
						}
					}
					else
					{
						echo '<ul class="scroll_tab">';
						$flag_date_ship = '';
						$count_break_ship = 0;
						foreach ($list_shipment as $row)
						{

							$date_sale = str_replace('-', '/', date('Y-m-d',strtotime($row[OS_ORDER_DATE])));
							$date_ship = str_replace('-', '/', date('Y-m-d',strtotime($row[OS_DELIVERY_DATE])));
							if($flag_date_ship != $date_sale)
							{
								$count_break_ship ++;
								if($count_break_ship > 3)
								{
									break;
								}
								echo '<h5 class="line_margin_left" style="font-weight: bold">'.$date_sale.'</h5>';
							}
							$str='';
							$status='';
							switch ($row[OS_STATUS]) 
							{
								case 1:
								case 2:
									if($row[OS_FLAG_FLICKER] == 1){
										$status='<span class="red">NEW</span>';
									}else{
										$status='<span class="red flicker">NEW</span>';
									}
									
									break;
								case 3:
									if(!empty($row[OS_NUMBER_REQUEST]))
									{
										if($row[OS_FLAG_FLICKER] == 1){
											$status='<span style = "color:'.$list_color[$row[OS_NUMBER_REQUEST]].'">再依頼 ('.$row[OS_NUMBER_REQUEST].') </span>';
										}else{
											$status='<span class = "flicker" style = "color:'.$list_color[$row[OS_NUMBER_REQUEST]].'">再依頼 ('.$row[OS_NUMBER_REQUEST].') </span>';
										}
										
									}else
									{
										$status='<span class="red ">再依頼 </span>';
									}
									break;
								case 4:
									if($row[OS_FLAG_FLICKER] == 1){
										$status='<span class="red">出荷確定(不足)</span>';
									}else{
										$status='<span class="red flicker">出荷確定(不足)</span>';
									}
									
									break;
								case 5:
									if($row[OS_FLAG_FLICKER] == 1){
										$status='<span class="red">出荷確定</span>';
									}else{
										$status='<span class="red flicker">出荷確定</span>';
									}
									break;
								default:
									$status='<span class="green">&nbsp;&nbsp;</span>';
									break;
							}

							echo '<li id = '.$row['id'].'_slt>'.$status.'<span class="link"><span class="tri-angle"></span>
									<a href="'.base_url('shipment/detail_shipment?id=').$row['id'].'" class="tool" target="_blank">'.$date_ship.' '.$row[DC_NAME].' (No.'.$row['id'].')</a></span>';
							echo '<div style=" overflow:auto; position: relative" id = table_ship_'.$row['id'].'>';
								echo '<table class="table table-bordered table_shipment">';
									echo '<thead>
										<tr>
											<th>'.TGRI_PRODUCT_ID.'</th>
											<th>'.TGRI_PRODUCT_NAME.'</th>
											<th>'.PL_STANDARD.'</th>
											<th>'.PL_COLOR_TONE.'</th>
											<th>'.TGRI_UNIT_PRICE.'</th>
											<th>'.TGRI_NUMBER_OF_ORDERS.'</th>
										</tr>
									</thead><tbody></tbody>';
								echo '</table>';
							echo '</div>';
							echo '</li>';
							$flag_date_ship = $date_sale;

						}//End foreach
						echo '</ul>';
					}
						
					
				?>
			</div>
        </div>
    </div>
		<!-- content Purchase management -->
<!-- End content Purchase management -->
<!-- content Purchase			 -->
	<div class="col-sm-6  col-md-6">
        <div class="wrapper">
            <div class="title">
                <h3>仕入管理　新着情報</h3>
                <h5><a href="<?php echo site_url().'purchase'?>">一覧はこちら</a></h5>
            </div>
            <div class="content <?php if(!empty($list_purchare)){ echo 'scroll_are';} ?>">
				<?php
					if(empty($list_purchare))
					{
						if($author_purchare == false)
						{
							echo 'アクセス拒否 Access Denied';
						}	
						else
						{
							echo '適当な検索結果が見つかりません。!';
						}
						
					}
					else
					{	
						echo '<ul class="scroll_tab" id = "Purchase">';
							$flag_date_purchare = '';
							$count_purchare = 0;
							$check_id = '';
							foreach ($list_purchare as $key => $item_purchare)
							{
								if($check_id != $item_purchare[TO_ID]){
									$date_revenue = str_replace('-', '/', date('Y-m-d',strtotime($item_purchare[TO_ORDER_DATE])));
									if($flag_date_purchare != $date_revenue)
									{
										$count_purchare ++ ;
										if($count_purchare > 3)
										{
											break;
										}
										echo '<h5 class="line_margin_left" style="font-weight: bold">'.$date_revenue.'</h5>';
									}
									$status  = '';
									$title_name = $item_purchare[BM_COMPANY_NAME];
									if($item_purchare[TO_FORM] == 1)
									{
										$status='<span class="blue" >承認済み</span>';
									}
									else
									{
										$status='<span class="red flicker">承認申請</span>';
									}
									echo'<li id = "'.$item_purchare[TO_ID].'_pch">'.$status.'<span class="link"><span class="tri-angle"></span>
															<a target="_blank" href="'.base_url('purchase/detail-purchase?id=').$item_purchare[TO_ID].'" class="tool">' 
																.$title_name. ' (No.'.$item_purchare[TO_ID].')
																<span></span>
															</a>
														</span>';
													
	
									echo '<div style=" overflow:auto; position: relative" id = table_purchar_'.$item_purchare[TO_ID].'>';
										echo '<table class="table table-bordered table_purchar">';
											echo '<thead>
												<tr>
													<th>'.TGRI_PRODUCT_ID.'</th>
													<th>'.TGRI_PRODUCT_NAME.'</th>
													<th>'.PL_STANDARD.'</th>
													<th>'.PL_COLOR_TONE.'</th>
													<th>'.TGRI_UNIT_PRICE.'</th>
													<th>'.TGRI_NUMBER_OF_ORDERS.'</th>
												</tr>
											</thead><tbody></tbody>';
										echo '</table>';
									echo '</div>';
									echo '</li>';
									$flag_date_purchare = $date_revenue;
								}
								$check_id = $item_purchare[TO_ID];
								
							}
						echo '</ul>';
					}
				?>
            </div>
        </div>
    </div>
<!-- End content Purchase -->
</div>
<script>
	var getDetailOder = "<?= site_url('/getDetailOrder')?>";
	var getDetailOder_revenue = "<?= site_url('/getDetailOrder_revenue_1')?>";
	var getDetailOrder_shipment = "<?= site_url('/getDetailODPD')?>";
	var getPurcharDetail = "<?= site_url('getPurcharDetail')?>";
	var edit_flagflicker_shipment = "<?= site_url('editFlicker')?>";
</script>

