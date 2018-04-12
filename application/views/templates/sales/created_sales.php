<style>
	.created-revenues tr:hover{
		cursor: pointer;
	}
	.created-revenues th{
		cursor: auto;
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
    width: 204px;
    margin-left: -94px;
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
</style>
<div class="wrapper-contain created-revenues order" id="revenues">
<div class="row">
<div class="col-md-6">
	<h3>作成済請求書 </h3>
	</div>
  <a href="<?php echo site_url('sale');?>"  class="print right print-auto top-print">未請求注文伝票一覧</a>
	</div>
<div class="row first-row">

 
<form class="form-horizontal" role="form" >
    <div class="row">
      <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputEmail" class="col-md-4 control-label">請求書No:</label>
          <div class="col-md-8">
            <input id="invoice_no" class="form-control " >
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputPassword" class="col-md-4 control-label">注文書No:</label>
          <div class="col-md-8">
          <input id="order_id" class="form-control " >
          </div>
        </div>
      </div>
		
      <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="input7" class="col-md-4 control-label">起票者:</label>
          <div class="col-md-8">
            <select id="user_id" class="form-control">
              <option></option>
              <?php foreach($user_list as $user){ ?>
              <option value="<?php echo($user->{U_ID}) ?>"><?php echo($user->{U_NAME}) ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
      </div>
		<div class="clearfix"></div>
    <div class="clearfix"></div>

    <div class="clearfix visible-lg-block visible-md-block"></div>
		<div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="inputPassword" class="col-md-4 control-label">売上(納品)日:</label>
          <div class="col-md-8">
            <span class="form-control form-control-input">
            <input readonly id="ship_date_start">
           <span class=" icon-large icon-calendar "></span>
            </span>    
            
          </div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group ">
          <label  class="col-md-4 control-label center" style="line-height:2.5;padding-top:0;"> <span id="character">~</span></label>
          <div class="col-md-8">
           <span class="form-control form-control-input">
            <input readonly id="ship_date_end">
           <span class=" icon-large icon-calendar "></span>
            </span>    
          </div>
        </div>
      </div>
	 <div class="clearfix visible-lg-block visible-md-block"></div>
		
		
		
     <div class="col-sm-12 col-md-4 col-lg-4" style="margin-top:5px;">
        <div class="form-group">
          <label for="input9" class="col-md-4 control-label">お得意先:</label>
          <div class="col-md-8">
              <select id="customer_id" class="form-control">
                <option value="none"></option>
                <?php foreach($customer_list as $customer){ ?>
                <option value="<?php echo($customer->{CUS_ID}) ?>"><?php echo($customer->{CUS_CUSTOMER_NAME}) ?></option>
                <?php } ?>
              </select>
          </div>
        </div>
      </div>
   <div class="col-sm-12 col-md-4 col-lg-4">
        <div class="form-group">
          <label for="input9" class="col-md-4 control-label " style="line-height:2;">部署名:</label>
          <div class="col-md-8">
              <select id="department_id" class="form-control" style="margin-bottom:0;margin-top:5px;">
                <option></option>
                <?php foreach($department_list as $department){ ?>
                <option value="<?php echo($department->{DL_DEPARTMENT_CODE}) ?>"><?php echo($department->{DL_DEPARTMENT_NAME}) ?></option>
                <?php } ?>
              </select>
          </div>
        </div>
      </div>
	 
    </div>
  </form>
</div>

       

<div class="row">
           <a class="print left search">検索</a>
</div>
<div class="row first-row">
         
                    <a class="print export_csv">CSV出力</a>
</div>
<div class="row sec-row margin-bottom-table">
       <div style="overflow-x:auto !important;">
<table class="display datatable-call responsive cell-border" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>請求書No</th>
            <th>作成日</th>
            <th>お得意先</th>
            <th>部署名</th>
            <!--<th>期間</th>-->
            <th>備考</th>
            <th>請求金額</th>
        </tr>
    </thead>
	
		<tbody>
      <?php foreach($invoice_list as $invoice){ ?>
        <tr>
            <td class="invoice_no"><?php echo($invoice->{I_ID}) ?></td>
            <td><?php echo($invoice->date_created) ?></td>
            <td><?php echo($invoice->customer) ?></td>
            <td><?php echo($invoice->department) ?></td>
            <td><?php echo($invoice->{I_REMARKS}) ?></td>
            <td><?php echo($invoice->price) ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table> 



</div><!--End tab content -->
</div><!--End row-->
</div>
<script>
  var base_url = '<?php echo(base_url()) ?>';
</script>
