<style>
img{
    height:22px;

}
caption{
    background:none;
}
table,th,td{
    border:1px solid #a3a3a3;
    word-wrap:break-word;

}
table{
    padding:4px;
     border:1px solid #a3a3a3;
    table-layout:fixed;
}
tr,td{
    padding:10px;

}
th{
    padding:5px;

 text-align:center;
}
table select{
    width: 50% !important;
    float: right;
    margin-left: 10px;
    margin-right:35%;
}
table:first-child caption{
    text-align:left;
}
</style>
<div class="wrapper-contain " id="receive-order">
  <div class="col-md-8 third-row">
        <h3>請求書グループ　編集</h3>
    </div>
    <form class="form-horizontal" role="form" id="form">
    <div class="first-row">
  
    
        <div class="row">
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">グループID :</label>
                    <div class="col-md-8">
                        <input disabled="true" class="form-control " name="id" id="id" value="<?= $group_invoice[IG_ID] ?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">グループ名:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " value="<?= $group_invoice[IG_INVOICE_NAME] ?>" name="name" id="name" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">請求書上に表示名:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <input class="form-control " value="<?= $group_invoice[IG_DISPLAY_NAME] ?>" name="display_name" id="display_name" >
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">郵便番号:</label>
                    <div class="col-md-8">
                        <input class="form-control " value="<?= $group_invoice[IG_POST_OFFICE] ?>" name="post_office" id="post_office">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">住所:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " value="<?= $group_invoice[IG_STREET_ADDRESS] ?>" name="address" id="address">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">住所2:</label>
                    <div class="col-md-8">
                        <input class="form-control " value="<?= $group_invoice[IG_STREET_ADDRESS_2] ?>" name="address2" id="address2">
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">TEL:</label>
                    <div class="col-md-8">
                        <input class="form-control " value="<?= $group_invoice[IG_TELEPHONE] ?>" name="phone" id="phone">
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">FAX:</label>
                    <div class="col-md-8">
                        <input class="form-control " value="<?= $group_invoice[IG_FAX] ?>" name="fax" id="fax">
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">締日:</label>
                    <div class="col-md-8">
                        <select class="form-control " name="closing_date" id="closing_date">
                            <option></option>
                            <option value="1" <?= $group_invoice[IG_CLOSING_DATE] == 1?'selected':'' ?> >末</option>
                            <option value="2" <?= $group_invoice[IG_CLOSING_DATE] == 2?'selected':'' ?>>15日</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label" style="padding-left:0px">請求書の総定額(￥):</label>
                    <div class="col-md-8">
                          <input class="form-control " value="<?= $group_invoice[IG_FIXED_AMOUNT] ?>" name="fixed_amount" id="fixed_amount" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">割引(%):</label>
                    <div class="col-md-8">
                        <input class="form-control " value="<?= $group_invoice[IG_DISCOUNT] ?>" name="discount" id="discount" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">一括出力:</label>
                    <div class="col-md-8">
                        <select class="form-control " name="collection_ouput" id="collection_ouput">
                            <option value="1" <?= $group_invoice[IG_COLLECTIVE_OUTPUT] == 1?'selected':'' ?> >月末</option>
                            <option value="2" <?= $group_invoice[IG_COLLECTIVE_OUTPUT] == 1?'selected':'' ?> >日々</option>
                        </select>
                    </div>
                </div>
            </div>
         
            
            <div class="clearfix"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">集計:</label>
                    <div class="col-md-8">
                        <input type="checkbox" class="form-check-input" name="aggregate" id="aggregate" <?= $group_invoice[IG_AGGREGATE] == 1?'checked':'' ?> style="width:20px;height:20px">

                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">補充費(%):<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <div class="col-md-2">
                            <input  type="checkbox" <?= $group_invoice[IG_ENVIRONMENTAL_CHECK] == 1?'checked':'' ?>  name="environment_fee_check" id="environment_fee_check" style="margin-top:12px">
                        </div>
                        <div class="col-md-10" style="padding-right: 0;">
                            <input class="form-control " value="<?= $group_invoice[IG_ENVIRONMENTAL_LOAD] ?>"  name="environment_fee" id="environment_fee" style="margin-top:7px" >
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">税込(%):<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <div class="col-md-2">
                            <input type="checkbox" name="tax_check" <?= $group_invoice[IG_TAX_CHECK] == 1?'checked':'' ?> id="tax_check" style="margin-top:12px" >
                        </div>
                        <div class="col-md-10" style="padding-right: 0;">
                                <input class="form-control " value="<?= $group_invoice[IG_TAX] ?>" name="tax" id="tax" style="margin-top:7px" >
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">担当者:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control " name="user" id="user">
                             <option></option>
                             <?php foreach ($lstUser as $key => $value) {
                                echo '<option value="'.$value[U_ID].'" '.($value[U_ID]==$group_invoice[TG_USER_ID]?'selected':'').'>'.$value[U_NAME].'</option>';
                             } ?> 
                        </select>

                    </div>
                </div>
            </div>
        </div>

    
    </div>
    <div class="row third-row">

     <div class="col-md-5">        
        <table   width="100%">
        <caption>得意先 
            <select  class="form-control selectpicker" name="customer" data-live-search="true" id="customer" >
                <option></option>
                <?php foreach ($customer as $key => $value) { ?>
                    <option value="<?= $value[CUS_ID] ?>" <?= $cus_id == $value[CUS_ID]?'selected':'' ?> ><?= $value[CUS_CUSTOMER_NAME] ?></option>
                <?php }?>
            </select>
        </caption>
            <thead>
                <tr>
                    <th>部署コード</th>
                    <th>部署名 </th>
                </tr>
            </thead>
        
        
         <tbody id="department">
               <?php 
                    if($department != null)
                    {
                     foreach ($department as $key => $value) { ?>
                        <?php if(in_array($value[CUS_DE_ID], $cus_dep) == true){ ?>
                            <tr>
                            <td><input type="hidden" class="id_dp" value="<?= $value[CUS_DE_ID]?>" /><?= $value[CD_DEPARTMENT_CODE] ?></td>
                            <td><?= $value[DL_DEPARTMENT_NAME] ?></td>
                        <?php } ?>
                    </tr>
                <?php }} ?>
            </tbody>
        </table>
        
    </div> 
    <div class="col-md-2"> 
    <section id="iconSelectPullDown">
    
    <img src="<?php echo site_url('asset/img/');?>arrow_right.png" id="right"/>
    <div class="clearfix"></div>
    <img src="<?php echo site_url('asset/img/');?>arrow_all_right.png" id="right_all"/>
    <div class="clearfix"></div>
    <br>
    <div class="clearfix"></div>
    <img src="<?php echo site_url('asset/img/');?>arrow_left.png" id="left"/>
    <div class="clearfix"></div>
    <img src="<?php echo site_url('asset/img/');?>arrow_all_left.png" id="left_all"/>
    
    </section>
    </div>
        <div class="col-md-5">        
        <table  width="100%" style="margin-top:9px;">
            <caption>得意先</caption>
            <thead>
                <tr>
                    <th>部署コード</th>
                    <th>部署名 </th>
                </tr>
            </thead>
        
        
         <tbody id="detail">
                <?php 
                    if($detail != null)
                    {
                     foreach ($detail as $key => $value) { ?>
                    <tr>
                    <td><input type="hidden" class="id_dp" value="<?= $value[IGD_ID_DEPARTMENT_CUSTOMER]?>" /><?= $value[CD_DEPARTMENT_CODE] ?></td>
                    <td><?= $value[DL_DEPARTMENT_NAME] ?></td>
                    </tr>
                <?php }} ?>
            </tbody>
        </table>
        
    </div> 

    
    </div>
    </form>
    <div class="clearfix"></div>
     <div class="row third-row" style="text-align:center;">
        <a href="#" id="save" class="print">保存</a>
        <!-- <a href="<?php echo site_url('order/checklist'); ?>" class="print">新規作成</a> -->
    </div>
    
</div>
<style>
button{
    margin: 0px
}
.bootstrap-select>.dropdown-toggle{
    width:250px;
}
.dropdown-menu{
    background-color: #ffffff;
    z-index:99999;
}
.form-group button {
    background: #fff;
    border-radius: 2px;
    margin: 0;
}
.form-group .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) .dropdown-toggle{
    width:250px;
    line-height: 18px;
}
td .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
    width: 250px;
    line-height: 18px;
}
.bootstrap-select button{
    height: 30px;
}
.bootstrap-select {
    width: 250px !important; 
}
table tr:nth-child(even){
    background-color: white !important
}
</style>
<script>
var editUrl = "<?= base_url('group-invoice/edit')?>";
var cuspartUrl = "<?= base_url('customer/get-department')?>";
var viewUrl = "<?= base_url('master/group-invoice')?>";
var id = <?= $group_invoice[IG_ID] ?>;
</script>