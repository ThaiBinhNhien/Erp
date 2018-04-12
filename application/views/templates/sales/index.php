<style>
input[type="radio"]
	{
		width:auto !important;
	}
</style>
<style>
#purchase .center-2{
        width:100px;
        text-align: right;
    }
    ul.dropdown-menu a{
        color:white;

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
.wrapper-contain form{
  margin-left:0 !important;
}
</style>
<div class="wrapper-contain order" id="revenues">
	<div class="row">
		<div class="col-md-6"><h3>未請求注文伝票（納品数チェック済み）</h3></div>

		<div class="right">
			<a href="<?php echo site_url('sale/created_sale'); ?>" class="print top-print print-auto">作成済請求書一覧</a>
		</div>

	</div>
<div class="row first-row">
    <form class="form-horizontal" role="form">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="" class="col-md-4 control-label">注文伝票No:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control order_no" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="" class="col-md-4 control-label">売上(納品)日:</label>
                    <div class="col-md-8">
                        <span class="form-control form-control-input">
                            <input  class="ship_date_start" readonly>
                            <span class="icon-large icon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group ">
                    <label  class="col-md-4 control-label center"> <span id="character">~</span></label>
                    <div class="col-md-8">
                        <span class="form-control form-control-input">
                            <input  class="ship_date_end" readonly>
                            <span class="icon-large icon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="" class="col-md-4 control-label">ユーザ名:</label>
                    <div class="col-md-8">
                        <select class="form-control user_name">
                            <option></option>
                            <?php foreach ($user_list as $user) {?>
                            <option value="<?php echo ($user->{U_ID}) ?>"><?php echo ($user->{U_NAME}) ?></option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="" class="col-md-4 control-label">注文日:</label>
                    <div class="col-md-8">
                        <span class="form-control form-control-input">
                            <input class="order_date_start" readonly>
                            <span class="icon-large icon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group ">
                    <label class="col-md-4 control-label center"> <span id="character">~</span></label>
                    <div class="col-md-8">
                        <span class="form-control form-control-input">
                            <input class="order_date_end" readonly>
                            <span class="icon-large icon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="" class="col-md-4 control-label">お得意先:</label>
                    <div class="col-md-8">
                        <select class="form-control customer">
                            <option></option>
                            <?php foreach ($customer_list as $customer) {
	if ($customer->{CUS_ID} != 0) {
		?>

                            <option value="<?php echo ($customer->{CUS_ID}) ?>">
                                <?php echo ($customer->{CUS_CUSTOMER_NAME}) ?>
                                </option>
                            <?php }}?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="" class="col-md-4 control-label">部署名:</label>
                    <div class="col-md-8">
                        <select class="form-control department">
                            <option></option>
                            <?php foreach ($department_list as $department) {?>
                            <option value="<?php echo ($department->{DL_DEPARTMENT_CODE}) ?>">
                                <?php echo ($department->{DL_DEPARTMENT_NAME}) ?>
                            </option>
                            <?php }?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
 </div><!--End form-horizontal-->
<div class="row">
	<div class="row">
		<a class="print left search">検索</a>
	</div>
</div>
<div class="row first-row">
		<a class="print left export_csv">CSV出力</a>
		<a class="print left create_list">請求書一括作成</a>
		<a class="print right add-sale" style="margin-right:26px;">請求書作成</a>
	</div>
<div class="row third-row margin-bottom-table" >

    <form method="POST" action="<?php echo (base_url('sale/add-sale')) ?>" id="form">
    <table  class="display datatable responsive cell-border" cellspacing="0" width="100%" id="revenues-table">
    <thead>
        <tr>
            <th width="6%">請求</th>
            <th width="20%">お得意先</th>
            <th width="10%">注文No</th>
            <th width="20%">部署名</th>
            <th width="12%">起票者</th>
            <th width="10%">注文数</th>
            <th width="12%">売上確定日</th>
            <th width="10%">納品数</th>
        </tr>
    </thead>


    <tbody>
        <?php $i = 0;?>
        <?php foreach ($list_order as $order) {
	?>
            <tr>
                <td>
                <?php if ($i == 0) {?>
                    <input type="radio" name="cus_and_inv" value="<?php echo 'cus' . $order->customer_id . 'inv' . $order->{IGD_ID_INVOICE_GROUP} ?>">
                <?php }?>
                <?php if ($i > 0) {
		if ($list_order[$i]->customer_id != $list_order[$i - 1]->customer_id | $list_order[$i]->{IGD_ID_INVOICE_GROUP} != $list_order[$i - 1]->{IGD_ID_INVOICE_GROUP}) {
			?>
                    <input type="radio" name="cus_and_inv" value="<?php echo 'cus' . $order->customer_id . 'inv' . $order->{IGD_ID_INVOICE_GROUP} ?>">
                <?php }}?>
                </td>
                <td>
                    <?php
if ($i == 0) {
		echo $order->{CUS_CUSTOMER_NAME};
	}

	if ($i > 0) {
		if ($list_order[$i]->customer_id != $list_order[$i - 1]->customer_id | $list_order[$i]->{IGD_ID_INVOICE_GROUP} != $list_order[$i - 1]->{IGD_ID_INVOICE_GROUP}) {
			echo $order->{CUS_CUSTOMER_NAME};
		}
	}

	?>
                </td>
                <td><?php echo $order->{SL_ID} ?></td>
                <input type="hidden" value="<?php echo $order->{SL_ID} ?>" name="<?php echo 'cus' . $order->customer_id . 'inv' . $order->{IGD_ID_INVOICE_GROUP} ?>[]">
                <td><?php echo $order->{DL_DEPARTMENT_NAME} ?></td>
                <td><?php echo $order->{SL_USER_ID} ?></td>
                <td><?php echo $order->amount_order ?></td>
                <td><?php echo $order->ship_date ?></td>
                <td><?php echo $order->amount_ship ?></td>
            </tr>
            <?php $i++;?>
        <?php }?>
    </tbody>
	</table>
    </form>
</div><!--End row table-->
<form id="export_csv" method="POST" action="<?php echo base_url('sale/ajax_list_order_CSV') ?>">
    <input type="hidden" id="json_list_order" name="json_list_order" value='<?php echo $json_list_order ?>'>
</form>
</div><!--End wrapper-contain-->
<script>
    var base_url = "<?php echo (base_url()) ?>";
    var json_list_order = <?php echo $json_list_order ?>;
    var error_message = "<?php echo $this->lang->line("message_add_error") ?>";
</script>