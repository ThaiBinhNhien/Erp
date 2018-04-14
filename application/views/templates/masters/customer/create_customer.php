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
<div class="wrapper-contain" >
  <div class="col-md-8 third-row">
        <h3>得意先　新規追加 </h3>
    </div>
<form class="form-horizontal" role="form" id="form" autocomplete="off">
    <div class="first-row">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">得意先ID:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " name="id" id="id" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">得意先名:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " name="name" id="name" >
                    </div>
                </div>
            </div>
           <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">得意先区分 :</label>
                    <div class="col-md-8">
                         <select class="form-control " name="classification" id="classification">
                            <option value="1">ホテル</option>
                            <option value="2">テナント</option>
                         </select>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">住所1:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " name="address1" id="address1">
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">住所2:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " name="address2" id="address2">
                    </div>
                </div>
            </div>
           <!--  <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">担当者:</label>
                    <div class="col-md-8">
                        <select  class="form-control selectpicker" name="user" data-live-search="true" id="user" >
                        <option></option>

                        </select>
                    </div>
                </div>
            </div> -->
           
            
         <!--   <div class="clearfix"></div> -->
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">電話番号:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <input class="form-control " name="phone_number" id="phone_number">
                    </div>
                </div>
            </div>
               <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">FAX番号:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <input class="form-control " name="fax" id="fax">
                    </div>
                </div>
            </div>
            <!-- <div class="clearfix visible-lg-block visible-md-block"></div> -->
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">締日コード:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                          <input class="form-control " name="end_code" id="end_code">
                    </div>
                </div>
            </div>
           
            <div class="clearfix"></div> 
            <div class="col-sm-12 col-md-4 col-lg-4"  >
                <div class="form-group" >
                    <label for="input9" class="col-md-4 control-label">ユーザー名:</label>
                    <div class="col-md-8">
                         <input class="form-control " data-have-account="0" name="username" id="username">
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-4 col-lg-4" >
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label" >パスワード:</label>
                    <div class="col-md-8">
                         <input class="form-control " data-have-account="0" type="password" autocomplete="new-password"  name="password" id="password">
                    </div>
                </div>
            </div>
           
          

            
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
                    <tr>
                     <td width="20%"><input type="hidden" value="<?= $value[DL_DEPARTMENT_CODE] ?>" class="id_dp" /> <?= $value[DL_DEPARTMENT_CODE] ?></td>
                     <td><?= $value[DL_DEPARTMENT_NAME] ?></td>
                     </tr>
                   <?php } } ?>
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
  
                </tbody>
            </table>
        </div>
    </div> 

    
    </div>
</form>   
    <div class="clearfix"></div>
     <div class="row third-row" style="text-align:center;">
        <a href="#dialog-form" class="print" id="save">保存</a>
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
var createUrl = "<?= base_url('customer/create')?>";
var checkProductTypeUrl =  "<?= base_url('user/get-user-type')?>";
var viewUrl = "<?= base_url('master/customer')?>";
// <?php
//     echo "var list_product = ". json_encode($lstUser) . ";";
//     ?>
// var lst = JSON.parse(list_product);
// alert(lst.length);
<?php
    echo "var lstUser = ". json_encode($lstUser) . ";";
    ?>
</script>