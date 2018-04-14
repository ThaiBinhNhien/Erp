<style>
#purchase .center-2{
		width:100px;
		text-align: right;
	}
	ul.dropdown-menu a{
		color:white;
		
	}
  .print--full-width{
    width:auto !important;
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
    margin-left: -94px;
    width: 204px;
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
.top{
  margin-top:-15%;
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
<div class="wrapper-contain purchase order" id="purchase">
<div class="row">
	<div class="col-md-6">
		<h3>仕入管理</h3>
	</div>
    <div class="right top-print">
    <a href="<?php echo site_url('purchase/export-purchase') ?>" class="print">出庫管理</a><a href="<?php echo site_url('purchase/debt') ?>" class="print">仕入請求管理</a>
    </div>
</div>
	<div class="first-row">
    <form class="form-horizontal" role="form" id="search_form">
    <div class="row">
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label" >発注No:</label>
          <div class="col-md-8">
            <input class="form-control input__select__margin" id="code" name="code"/>
          </div>
        </div>
      </div>
      <div class="clearfix visible-sm"></div>
      <div class="col-sm-6 col-md-4 col-lg-4" >
        <div class="form-group">
          <label for="inputPassword" class="col-md-3 control-label ">発注日:</label>
          <div class="col-md-9">
               <span class="form-control form-control-input">
            <input  class="input__select__control" id="order_date_start" name="from_date">
           <span class=" icon-large icon-calendar "></span>
            </span>    
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label  class="col-md-4 control-label center"><span id="character">~</span></label>
          <div class="col-md-8">
			<span class="form-control form-control-input">
            <input  class="input__select__control" id="order_date_end" name="to_date">
           <span class=" icon-large icon-calendar "></span>
            </span>    
          </div>
        </div>
      </div>
	         <div class="clearfix"></div>
        <!--<div class="clearfix visible-sm-block "></div> -->
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputLabel4" class="col-md-4 control-label">仕入先:</label>
          <div class="col-md-8">
           <!--  <input type="text" class="form-control" id="supplier_name" > -->
            <select class="right-3 form-control first-opt-hidden" id="supplier_id" name="supplier_name">
            <option></option>
            <?php foreach($supplier_list as $supplier){ ?>
            <option value="<?php echo($supplier->{SUP_ID}) ?>"><?php echo($supplier->{SUP_SUPPLIER_COMPANY_NAME}) ?></option>
            <?php } ?>
            </select>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-4" >
        <div class="form-group">
          <label for="input5" class="col-md-3 control-label">販売先:</label>
          <div class="col-md-9">
           <!-- <input type="text" class="form-control" >-->
              <select class="form-control first-opt-hidden" id="sales_des_id" name="place_of_sale">
                <option></option>
                <?php foreach($sales_des_list as $sales_des){ ?>
                <option value="<?php echo($sales_des->{TSD_ID}) ?>">
                  <?php echo($sales_des->{TSD_DISTRIBUTOR_NAME}) ?>
                </option>
                <?php } ?>
              </select>
          </div>
        </div>
      </div>
   <div class="clearfix visible-lg-block visible-md-block"></div>
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="input6" class="col-md-4 control-label">発注内容:</label>
          <div class="col-md-8">
            <select class="form-control first-opt-hidden" id="content_id" name="reason">
              <option></option>
              <?php foreach($order_content_list as $order_content){ ?>
              <option value="<?php echo($order_content->{PC_ID}) ?>">
                <?php echo($order_content->{PC_PROCESSING_CONTENT}) ?>
              </option>
              <?php } ?>
            </select>
            
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-4" >
        <div class="form-group">
          <label for="input7" class="col-md-3 control-label">形態:</label>
          <div class="col-md-9">
            <select class="form-control first-opt-hidden"  id="status" name="status">
              <option></option>
              <option value="1">一時保存</option>
              <option value="2">承認待</option>
              <option value="3">承認済</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="input8" class="col-md-4 control-label center">入庫:</label>
          <div class="col-md-8">
            <select class="form-control first-opt-hidden" id="is_import" name="is_warehoused">
              <option></option>
              <option value="1" >未入庫</option>
              <option value="2" >入庫済</option>
            </select>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="input9" class="col-md-4 control-label">起票者:</label>
          <div class="col-md-8">
              <select class="form-control no-bottom-margin first-opt-hidden" id="user_id" name="issuer">
                <option></option>
                <?php foreach($register_user_list as $user){ ?>
                <option value="<?php echo($user->{U_ID}) ?>">
                  <?php echo($user->{U_NAME}) ?>
                </option>
                <?php } ?>
              </select>
          </div>
        </div>
      </div>


<!-- 	  <div class="col-sm-6 col-md-4 col-lg-4" >

        <div class="form-group">
          <label for="input7" class="col-md-3 control-label">単価チェック:</label>
          <div class="col-md-9">
            <select class="form-control dk-detail first-opt-hidden"  name="order_checking" id="order_checking">
              <option></option>
            </select>
          </div>
        </div>

      </div> -->

<!-- 		<div class="clearfix"></div> -->


        <div class="col-sm-6 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="input9" class="col-md-3 control-label">納品場所:</label>
          <div class="col-md-9">
              <select class="form-control no-bottom-margin first-opt-hidden" name="place_of_delivery" id="stock_id">
                <option></option>
                <?php foreach($base_list as $base){ ?>
                <option value="<?php echo $base->{BM_BASE_CODE} ?>"><?php echo $base->{BM_BASE_NAME} ?></option>
                <?php } ?>
              </select>
          </div>
        </div>
      </div>
    </div><!-- /.row this actually does not appear to be needed with the form-horizontal -->
  </form>
	</div>
<!-- Button -->
<div class="row left">
    <a class="print search" id="search">検索</a>
    <a class="print  go-detail checklist print--full-width">チェックリスト印刷</a>
</div>
<div class="clearfix"></div>
	<div class="row first-row">
    <a href="<?php echo site_url('purchase/export-purchase-csv') ?>"  class="print csv" >CSV出力</a>
    <a href="<?php echo site_url('purchase/add-purchase') ?>" class="print right" style="margin-right:26px;">新規作成</a>
	</div>	
<div class="clearfix"></div>
<!-- Table -->
<div style="overflow-x:auto !important;" class="third-row">
<table  class="dataTables_scrollBody display datatable-call responsive cell-border" cellspacing="0" width="100%" id="buying-table">
    <thead>
        <th style="width:6%">発注No</th>
        <th style="width:8%">発注日</th>
        <th style="width:20%">仕入先</th>
        <th style="width:14%">発注内容</th>
        <th style="width:17%">拠点</th>
        <th style="width:14%">起票者</th>
        <th style="width:7%">形態</th>
        <th style="width:8%">納品日</th> 
        <th style="width:6%">入庫</th>    
    </thead>

    <tbody>
      <?php foreach($order_list as $order){ ?>
        <tr>
            <td class="order_id"><?php echo($order->{TO_ID}) ?></td>
             <td><?php echo($order->{TO_ORDER_DATE}) ?></td>
            <td><?php echo($order->supplier) ?></td>
            <td><?php echo($order->content_order) ?></td>
            <td><?php echo($order->base) ?></td>
            <td><?php echo($order->register_user) ?></td>
            <?php switch ($order->{TO_FORM}) {
              case 0://lưu tạm
                echo "<td class='red'>一時保存</td>";
                break;
              case 1://chờ xác nhận
                echo "<td class='red'>承認待</td>";
                break;
              case 2://xác nhận xong
                echo "<td>承認済</td>";
                break;
              default: echo "<td></td>";
                break;
            } ?>
            <td><?php echo($order->import_date) ?></td>
            <?php if($order->{TO_RECEIPT}>0) echo "<td>済</td>"; else echo "<td class='red'>未</td>";?>  
        </tr>
      <?php } ?>
<!-- <tr role="row" class="odd"><td>20</td><td>2016-10-01</td><td>Mydate</td><td></td><td>1</td><td>1</td><td>1</td></tr> -->
</tbody>
</table>

</div>

<!--End table -->
</div><!-- /.container -->
<script type="text/javascript">
  var base_url = "<?php echo(base_url()) ?>";
  var stock_default = 0;
  <?php if(!$isAdmin) echo "stock_default=".$this->LOGIN_INFO[U_BASE_CODE].";"?>
</script>