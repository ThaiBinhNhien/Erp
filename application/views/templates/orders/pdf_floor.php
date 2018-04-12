
<div>
	 <?php 
		$size = (int)(count($data)/4);
		$size += count($data)%4 != 0?1:0;
		$index = 0;
		for($i=0;$i<$size;$i++){ ?>
			<div class="clearfix" >
			<?php for(;$index<count($data) && $index <= ($i+1)*4;$index++){ 
				$floor_name = array_keys($data)[$index];?>
			
					<div class="col-sm-6 col-md-4 col-lg-4">
						<div><?= $date ?></div>
				        <table>
				        	<thead repeat_header="0">
				        		<tr>
						        	<th><b><?= $floor_name ?></b></th>
						        	<th>納品数</th>
					        	</tr>
				        	</thead>
				        	<tbody>
					        <?php  foreach ($data[$floor_name] as $key => $value) { ?>
					        	<tr>
					        		<td><?= $value["name"] ?></td>
					        		<td><?= $value["quantity"] ?></td>
					        	</tr>
					        <?php } ?>
					        </tbody>
				        </table>
				        
				      </div>
				
			<?php } ?>
			</div>
		<?php } ?> 
		<div class="clearfix">
			<table style="width:100%">
				<thead>
					<tr>
						<th>(残)</th>
						<th>(空)</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td style="height:100px"></td>
						<td></td>
					</tr>
				</tbody>
			</table>
		</div>
</div>
<style type="text/css">
	.col-lg-4 {
    	width: 20%;
    	float: left;
	}
	table{
		border-collapse: collapse;
	}
	td,th,tr:not(.header-date){
		border: solid 2px black;

	}
	td{
		padding: 10px
	}
	.clearfix{
		clear: both;
		margin-top: 20px
	}
	@page { sheet-size: A4-L; }
  
	@page bigger { sheet-size: 420mm 370mm; }
  
	@page toc { sheet-size: A4; }
</style>