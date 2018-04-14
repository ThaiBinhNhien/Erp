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
    padding:3px;
     border:1px solid #a3a3a3;
    table-layout:fixed;
}
tr,td{
    padding:10px;
    text-align: center;

}
th{
    padding:5px;

 text-align:center;
}
</style>
<div class="wrapper-contain " id="receive-order">
  <div class="col-md-8 third-row">
        <h3>得意先　編集 </h3>
    </div>
    <form class="form-horizontal" role="form" id="form" autocomplete="off">
    <div class="first-row">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">得意先ID  :</label>
                    <div class="col-md-8">
                        <input disabled="true" class="form-control " id="id" value="<?= $customer[CUS_ID]?>" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">得意先名:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " id="name" value="<?= $customer[CUS_CUSTOMER_NAME]?>" >
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">得意先区分 :</label>
                    <div class="col-md-8">
                         <select class="form-control " name="classification" id="classification">
                            <option value="1" <?=  $customer[CUS_TYPE_CUSTOMER]==1?'selected':'' ?>>ホテル</option>
                            <option value="2" <?=  $customer[CUS_TYPE_CUSTOMER]==2?'selected':'' ?>>テナント</option>
                         </select>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">住所1:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " id="address1" value="<?= $customer[CUS_ADDRESS_1]?>">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">住所2:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " id="address2" value="<?= $customer[CUS_ADDRESS_2]?>">
                    </div>
                </div>
            </div>
           
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">電話番号:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <input class="form-control " id="phone_number" value="<?= $customer[CUS_PHONE_NUMBER]?>">
                    </div>
                </div>
            </div>
            <div class="clearfix"></div> 
             
            
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">FAX番号:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <input class="form-control " id="fax" value="<?= $customer[CUS_FACSIMILE]?>">
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">締日コード:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                          <input class="form-control " id="end_code" value="<?= $customer[CUS_CLOSING_DATE_CODE]?>">
                    </div>
                </div>
            </div>
            <?php if($userInfo == NULL) {?>
                <div class="clearfix"></div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label for="input9" class="col-md-4 control-label">ユーザー名:</label>
                        <div class="col-md-8">
                             <input class="form-control " data-have-account="0" name="username" id="username">
                        </div>
                    </div>
                </div>
                 <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label for="input9" class="col-md-4 control-label" >パスワード:</label>
                        <div class="col-md-8">
                             <input class="form-control " data-have-account="0" type="text" autocomplete="new-password" name="password" id="password">
                        </div>
                    </div>
                </div>
            <?php }else{ ?>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label for="input9" class="col-md-4 control-label">ユーザー名:</label>
                        <div class="col-md-8">
                             <input class="form-control " disabled value="<?= $customer[CUS_ACCOUNT_ID] ?>" name="username" id="username">
                        </div>
                    </div>
                </div>
            <?php } ?>
            
           
        </div>


    </div>
    <div class="row third-row">

     <div class="col-md-4">  
        <div style="margin-right:17px">      
            <table   width="100%">
            <caption>未追加部署  </caption>
                <thead>
                    <tr>
                        <th width="20%">部署ID </th>
                        <th>部署名 </th>
                    </tr>
                </thead>
            </table>
        </div>
        <div style="height:400px;overflow-y:scroll">
            <table  width="100%" >
                <tbody id="department" >
                   <?php 
                   if(isset($lstDepartment)) {
                   foreach ($lstDepartment as $key => $value) {?>
                    <?php if(!in_array($value[DL_DEPARTMENT_CODE],array_column($department,CD_DEPARTMENT_CODE))) {?>
                    <tr>
                     <td width="20%"><input type="hidden" value="<?= $value[DL_DEPARTMENT_CODE] ?>" class="id_dp" /> <?= $value[DL_DEPARTMENT_CODE] ?></td>
                     <td><?= $value[DL_DEPARTMENT_NAME] ?></td>
                     </tr>
                   <?php }} } ?>
                </tbody>
            </table>
        </div>
        
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
        <div class="col-md-6">        
         <div style="margin-right:17px">      
            <table   width="100%">
            <caption>追加済部署  </caption>
                <thead>
                    <tr>
                        <th width="15%">部署ID </th>
                        <th>部署名 </th>
                        <th width="15%">請求書不要</th>
                        <th width="15%">担当者</th>
                        <th width="24%">Flg受発注取り込み </th>
                    </tr>
                </thead>
            </table>
        </div>
        <div style="height:400px;overflow-y:scroll">
            <table  width="100%" >
                <tbody id="detail" >
                    <?php 
                    if(isset($department)) {
                    foreach ($department as $key => $value) {?>
                        <tr>
                         <td width="15%"><input type="hidden" value="<?= $value[DL_DEPARTMENT_CODE] ?>" class="id_dp" /> <?= $value[DL_DEPARTMENT_CODE] ?></td>
                         <td><?= $value[DL_DEPARTMENT_NAME] ?></td>
                         <td width="15%"><input type="checkbox" class="not_ask_money" <?= $value[CD_NOT_ASK_MONEY] == 1?'checked':'' ?> </td>
                         <td width="15%" style="padding:4px 4px 0px 4px "> 
                            <select class="form-control" style="margin-bottom:4px " name="user"  id="user">
                            <?php foreach ($lstUser as  $item) { ?>
                                <option <?= $item[U_ID] == $value[CD_USER_ID] ?'selected':'' ?> value="<?= $item[U_ID] ?>" > <?= $item[U_ID] ?></option>
                            <?php } ?>
                                
                            </select>
                         </td>
                          <td width="24%"><input type="checkbox" class="flag" <?= $value[CD_FL_COPY_SHIPMENT] == 1?'checked':'' ?> </td>
                         </tr>
                   <?php } } ?>
                </tbody>
            </table>
        </div>
    </div> 

    
    </div>
    </form>
    <div class="clearfix"></div>
     <div class="row third-row" style="text-align:center;">
        <a href="#" class="print" id="save">保存</a>
        <!-- <a href="<?php echo site_url('order/checklist'); ?>" class="print">新規作成</a> -->
    </div>
    
</div>
<style>
button{
    margin: 0px
}
.bootstrap-select>.dropdown-toggle{
    width:88%;
}
.form-group button {
    background: #fff;
    border-radius: 2px;
    margin: 0;
}
.form-group .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) .dropdown-toggle{
    width:100px;
    line-height: 18px;
}
td .bootstrap-select:not([class*=col-]):not([class*=form-control]):not(.input-group-btn) {
    width: 100px;
    line-height: 18px;
}
.bootstrap-select button{
    height: 30px;
}

</style>
<script>
var editUrl = "<?= base_url('customer/edit')?>";
var cusId = <?= $customer[CUS_ID] ?>;
var viewUrl = "<?= base_url('master/customer')?>";
<?php
    echo "var lstUser = ". json_encode($lstUser) . ";";
    ?>
</script>