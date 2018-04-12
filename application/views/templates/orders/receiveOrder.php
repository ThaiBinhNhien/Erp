<style>
table.dataTable{table-layout: auto !important}
</style>
<div class="wrapper-contain order" id="receive-order">
	<div class="first-row">
    <form class="form-horizontal" role="form">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">発注No:</label>
                    <div class="col-md-8">
                        <input class="form-control " id="order_no" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">注文日:</label>
                    <div class="col-md-8">
                        <span class="form-control form-control-input">
                            <input  class="" id="order_from" readonly>
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
                            <input  class="" id="order_to" readonly >
                            <span class="icon-large icon-calendar"></span>
                        </span>    
                    </div>
                </div>
            </div>
            <div class="clearfix"></div> 
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">起票者:</label>
                    <div class="col-md-8">
                        <select class="form-control" id="user">
                        <option value=''></option>
                        <?php foreach ($list_user as $key => $value) {
                            echo '<option value="'.$value[U_ID].'">'.$value[U_NAME].'</option>';
                        } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">売上(納品)日:</label>
                    <div class="col-md-8">
                        <span class="form-control form-control-input">
                            <input class="" id="delivery_from" readonly >
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
                            <input class="" id="delivery_to" readonly>
                            <span class="icon-large icon-calendar"></span>
                        </span>    
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">お得意先:</label>
                    <div class="col-md-8" >
                        <select class="form-control" id="customer">
                        <option value=''></option>
                        <?php foreach ($list_cus as $key => $value) {
                            echo '<option value="'.$value[CUS_ID].'">'.$value[CUS_CUSTOMER_NAME].'</option>';
                        } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">部署名:</label>
                    <div class="col-md-8">
                        <select class="form-control" id="department">
                            <option></option>
                            <?php foreach ($list_department as $key => $value) { ?>
                                <option value="<?=$value[DL_DEPARTMENT_CODE] ?>"><?=$value[DL_DEPARTMENT_NAME] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="clearfix visible-lg-block visible-md-block"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">形態:</label>
                    <div class="col-md-8">
                        <select class="form-control no-bottom-margin" id="status">
                            <option value=''></option>
                            <option value=1>保存</option>
                            <option value=2>一時保存</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">請求:</label>
                    <div class="col-md-8">
                        <select class="form-control  no-bottom-margin" id="claim_check">
                            <option value=''></option>
                            <option value=0>未</option>
                            <option value=1>済</option>
                        </select>
                    </div>
                </div>
            </div> 
        </div>
    </form>
	</div>
    <div class="row left"> 
        <a class="print" id="search">検索 </a>
        <a class="print" href="<?php echo site_url('receive-order');?>/checklist" target="_blank">チェックリスト</a>
    </div>
    <div class="clearfix"></div>
    <div class="row first-row" style="margin-right:18px;">
        <a id="btnExportList" class="print left">CSV出力</a>
        <?php if($cus_type != 0 ) {
            if($cus_type == 1)
                echo '<a href="'.site_url('order/create-order').'" class="print right">新規作成<br>（客室用）</a>';
            if($cus_type == 2)
                echo '<a href="'.site_url('order/create-order-2').'" class="print right">新規作成<br>（客室他用）</a>';
        }else{
            echo '<a href="'.site_url('order/create-order-2').'" class="print right">新規作成<br>（客室他用）</a>';
            echo '<a href="'.site_url('order/create-order').'" class="print right">新規作成<br>（客室用）</a>';
        } ?>
             
    </div>
	<div class="row third-row" id="order-table" >
        <table  class="display datatable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr id="table_header">
                    <th>注文No</th>
                    <th>注文日</th>
                    <th>お得意先</th> 
                    <th>部署名</th>
                    <th>起票者</th>
                    <th>形態</th>
                    <th>注文数</th>
                    <th>納品数</th>
                    <th>売上(納品)日</th>
                </tr>
            </thead>
		
		
		    <tbody id="detail_data"> 
               
            </tbody>
        </table>
		
		</div> 

    <div class="row sec-row not-pad-table" id="check_list_panel" style="display:none">
        <table class="checklist-table" id="checklist-table" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>注文No</th>
                    <th>売上(納品)日</th>
                    <th>得意先</th>
                    <th>部署名</th>
                    <th>商品コード</th>
                    <th>商品名</th>
                    <th>注文数</th>
                    <th>納品数</th>
                    <th>単価</th>
                    <th>金額</th>
                    <th>チェック<br><input type="checkbox" id="checkAll"></th>
                </tr>
            </thead> 

            <tbody id="detail_delivery"> 
               
            </tbody>
        </table>
        <div class="row first-row">
            <div class="right">
                <a href="#dialog-form" id="save_checklist" class="print">保存</a>
            </div>
        </div>

    </div>
</div>
<script>
var orderViewUrl = "<?= base_url("order/get-order-view") ?>";
var checklistViewUrl = "<?= base_url("order/get-checklist-view") ?>";
var detailUrl1 = "<?= base_url("order/detail-order") ?>";
var detailUrl2 = "<?= base_url("order/detail-order-2") ?>";
var checkListUrl = "<?= base_url("order/checklist") ?>";
var customerDepartmentUrl = "<?= base_url("order/get-department") ?>";
var departmentCustomerUrl = "<?= base_url("order/get-customer") ?>"; 
var editUrl = "<?= site_url('order/edit-order')?>";
var editDeliveryUrl = "<?= site_url('order/edit-delivery-order')?>";
var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
var notCheckData = "<?= $this->lang->line('message_error_not_checked')?>";
var notSelectDateChecklist = "<?= $this->lang->line('message_error_select_date_checklist')?>";
var listDepartment = JSON.parse('<?= json_encode($list_department) ?>');
var url_export_checklist = "<?= base_url("receive-order/checklist/pdf_checklist") ?>";
var url_export = "<?= base_url("receive-order/export") ?>";
var message_error_not_data_checked = "<?= $this->lang->line('message_error_not_data_checked')?>";
var message_success_checklist_diff_search = "<?= $this->lang->line('message_success_checklist_diff_search')?>";
</script>