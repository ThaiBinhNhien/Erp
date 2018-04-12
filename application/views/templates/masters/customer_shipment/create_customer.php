<style>
img{
    height:22px;

}
caption{
    background:none;
}
table,th,td{
    border:1px solid #a3a3a3


}
table{
    padding:4px;
     border:1px solid #a3a3a3
}
tr,td{
    padding:10px; 

}
th{
    padding:5px;

 text-align:center;
}
</style>
<div class="wrapper-contain order" >
  <div class="col-md-8 third-row">
        <h3>受発注専用得意先M　新規追加 </h3> 
    </div>
<form class="form-horizontal" role="form" id="form_add_category">
    <div class="first-row">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="col-md-4 control-label">受発注専用得意先ID:<span class="label-form-request">*</span></label>
                    <div class="col-md-5">
                        <input class="form-control " type="number" name="group_id" id="group_id" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="col-md-3 control-label">受発注専用得意先名:<span class="label-form-request">*</span></label>
                    <div class="col-md-5">
                        <input class="form-control " name="group_name" id="group_name" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-6">
                <div class="form-group">
                    <label class="col-md-4 control-label">得意先 :</label>
                    <div class="col-md-5">
                        <select class="form-control selectpicker"  name="group_customer"  id="group_customer" data-live-search="true" multiple>
                                <?php 
                                if(isset($list_customer)) {
                                foreach ($list_customer as $key => $value) {
                                        echo '<option value="'.$value[CUS_ID].'" title="'.$value[CUS_CUSTOMER_NAME].'">'.$value[CUS_CUSTOMER_NAME].'</option>';
                                } 
                            }
                                ?>
                            </select>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="row third-row">

     <div class="col-md-5">  
        <div style="margin-right:17px">      
            <table   width="100%">
            <caption>未追加部署Ｍ  </caption>
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
                     <td width="20%"><input type="hidden" value="<?= $value[DSL_DEPARTMENT_CODE] ?>" class="id_dp" /> <?= $value[DSL_DEPARTMENT_CODE] ?></td>
                     <td><?= $value[DSL_DEPARTMENT_NAME] ?></td>
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
        <div class="col-md-5">        
         <div style="margin-right:17px">      
            <table   width="100%">
            <caption>追加済部署Ｍ  </caption>
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
                <tbody id="detail" >
  
                </tbody>
            </table>
        </div>
    </div> 
    </div>
</form>   
    <div class="clearfix"></div>
     <div class="row third-row" style="text-align:center;">
        <a class="print" id="save">保存</a>
    </div>
    
</div>
<style>
button{
    margin: 0px
}
.bootstrap-select>.dropdown-toggle{
    width:88%;
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
var addPostLink = "<?= base_url('master/customer_shipment/add_post')?>";
var urlIndex = "<?= base_url('master/customer_shipment')?>";
</script>