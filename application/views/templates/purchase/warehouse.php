<style>
	#export table tr:hover{
		cursor: pointer;
	}
	#export table th:hover{
		cursor: default;
	}
	#export .center-2{
		width:100px;
		text-align: right;
		//margin-right:10px;
	}
	#export .center-1{
	
	//	width:62px !important;
	}
  /* Popup container - can be anything you want */
.popup {
    display: inline-block;
    cursor: pointer;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
    position: absolute;
        //margin-top: -35px;
    //margin-left: 26.5%;
    width: 204px;
    margin-top:-12%;
}

/* The actual popup */
.popup .popuptext {
    visibility:  visible;
    
    background-color: #cc5757;
    color: #fff;
    text-align: center;
    border-radius: 3px;
    padding: 8px 6px;
    position: absolute;
    z-index: 1;
    bottom: 125%;
    left: 50%;
    margin-left: -80px;
     width: 204px;
}
.top{
  margin-left: -6%;
  margin-top: -16%;
}
/* Popup arrow */
.popup .popuptext::after {
    content: "";
    position: absolute;
    top: 100%;
    left: 50%;
    margin-left: -5px;
    border-width: 5px;
    border-style: solid;
    border-color: #bb5c5c transparent transparent transparent;
}
/* Toggle this class - hide and show the popup */
.popup .show {
    visibility: visible;
    -webkit-animation: fadeIn 1s;
    animation: fadeIn 1s;
}

/* Add animation (fade in the popup) */
@-webkit-keyframes fadeIn {
    from {opacity: 0;} 
    to {opacity: 1;}
}

@keyframes fadeIn {
    from {opacity: 0;}
    to {opacity:1 ;}
}
a.disabled {
        cursor: not-allowed;
        background:#485a4a;
        border: 1px solid #485a4a;
    }
</style>
<div class="wrapper-contain order" id="export">
<div class="row">
	<div class="col-md-6">
	<h3>出庫管理 </h3>
	</div>
    <div class="right top-print">
    <a href="<?php echo site_url('purchase/') ?>" class="print">仕入管理</a>
	<a href="<?php echo site_url('purchase/debt') ?>" class="print">仕入請求管理</a>
    </div>
</div>
<div class="row first-row">


    <form class="form-horizontal" role="form">
    <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label ">出庫No:</label>
          <div class="col-md-8">
            <input class="form-control order_no" >
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-4" style="width:30.3333333%">
        <div class="form-group">
          <label for="inputPassword" class="col-md-3 control-label">出庫日:</label>
          <div class="col-md-9">
               <span class="form-control form-control-input">
            <input readonly class="date-start" style="max-width:219px;">
           <span class=" icon-large icon-calendar "></span>
            </span>    
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group" >
          <label  class="col-md-4 control-label center-1"><span id="character">~</span></label>
          <div class="col-md-8">
			<span class="form-control form-control-input">
            <input readonly class="date-end" >
           <span class=" icon-large icon-calendar "></span>
            </span>    
          </div>
        </div>
      </div>
	         <div class="clearfix"></div>
        <!--<div class="clearfix visible-sm-block "></div> -->
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputLabel4" class="col-md-4 control-label">販売先:</label>
          <div class="col-md-8">
             <select class="form-control distination">
              <option value=""></option>
              <?php foreach($sales_des_list as $sales_des){ ?>
              <option value="<?php echo($sales_des->id) ?>"><?php echo($sales_des->{TSD_DISTRIBUTOR_NAME}) ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-4" style="width:30.3333333%">
        <div class="form-group">
          <label for="input5" class="col-md-3 control-label"> 起票者:</label>
          <div class="col-md-9">
           <!-- <input type="text" class="form-control" >-->
              <select class="form-control issuer" style="max-width:219px;">
                <option value=""></option>
                <?php foreach($issuer_list as $issuer){ ?>
                <option value="<?php echo($issuer->{U_ID}) ?>"><?php echo($issuer->{U_NAME}) ?></option>
                <?php } ?>
              </select>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="input5" class="col-md-4 control-label center-1"> 出庫者:</label>
          <div class="col-md-8">
           <!-- <input type="text" class="form-control" >-->
              <select class="form-control shiper">
                <option value=""></option>
                <?php foreach($shiper_list as $shiper){ ?>
                <?php if($shiper->{UX_NAME}!='') { ?>
                <option value="<?php echo($shiper->{UX_ID}) ?>"><?php echo($shiper->{UX_NAME}) ?></option>
                <?php } ?>
                <?php } ?>
              </select>
          </div>
        </div>
      </div>
   <div class="clearfix visible-lg-block visible-md-block"></div>
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="input6" class="col-md-4 control-label">出庫内容:</label>
          <div class="col-md-8">
            <select class="form-control no-bottom-margin content" >
              <option value=""></option>
              <?php foreach($content_list as $content){ ?>
              <option value="<?php echo($content->{PC_ID}) ?>"><?php echo($content->{PC_PROCESSING_CONTENT}) ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-4" style="width:30.3333333%">
        <div class="form-group">
          <label for="input7" class="col-md-3 control-label">形態:</label>
          <div class="col-md-9">
            <select class="form-control no-bottom-margin status" style="max-width:219px;">
              <option value=""></option>
              <option value="1">一時保存</option>
			        <option value="2">保存</option>
            </select>
          </div>
        </div>
      </div>
    </div><!-- /.row this actually does not appear to be needed with the form-horizontal -->
  </form>
</div>
<!-- Button -->
<div class="row margin-bottom-table">
    <a href="#" class="search print print-1" >表示</a>
    <!--<a href="" class="print" style="width:auto !important;" >チェックリスト印刷</a>-->
</div>
<div class="row first-row">

    <a href="<?php echo base_url('purchase/export-warehouse-csv') ?>" class="print csv">CSV出力</a>
    <a href="<?php echo site_url('purchase/add-export-purchase') ?>" class="print right" style="margin-right:24px;">新規作成</a>   
</div>
<div style="overflow-x:auto !important;" class="margin-bottom-table sec-row">   
<table class="display datatable-call responsive cell-border" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>発注 No</th>
            <th style="width:5%">出庫日</th>
            <th>出庫先</th>
			      <th>出庫内容</th>
            <th>起票者</th>
            <th style="width:5%">形態</th>
        </tr>
    </thead>
	
    <tbody>
      <?php foreach ($warehouse_list as $warehouse) { ?>
      <tr>
        <td><?php echo $warehouse->{SHIP_ID} ?></td>
        <td><?php echo $warehouse->{SHIP_SHIP_DATE} ?></td>
        <td><?php echo $warehouse->sales_des ?></td>
        <td><?php echo $warehouse->content ?></td>
        <td><?php echo $warehouse->issuer ?></td>
        <td><a <?php if(!$warehouse->{SHIP_SAVE_STATUS}) echo("style='color:red;'");else echo("style='color:black'") ?>>
          <?php echo $warehouse->status ?>           
          </a></td>
      </tr>
      <?php } ?>
        <!--<tr>
            <td>10</td>
            <td>2016.09.22</td>
            <td>（株）テーオーリネンサプライ</td>
            <td>外注分</td>
            <td>リネン部 帝王太郎</td>
            <td class="red"><a style="color:red;" href="<?php echo site_url('purchase/detail-export-order') ?>">一時保存</a></td>
        </tr>-->
</tbody>
</table>

</div>
</div><!--End wrapper-contain-->
<script>var base_url = '<?php echo base_url() ?>'</script>