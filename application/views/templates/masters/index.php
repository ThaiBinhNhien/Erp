<style>
.master ul{
    list-style: none;

}
.master li{
    display: inline-block;

    padding: 15px;
    border-radius: 2px;
    background: #2e4350;
    margin-bottom:3px;
    width:212px;
}
.master li a{
color:white;
}
.master li .fa{

    vertical-align: middle;
    font-size:30px;
    color: #f7dda0;
        margin-right: 5px;
}
.form-group button.print {
    background: linear-gradient(#7d9f7d, #3c763d);
}
.form-group button.print[disabled] {
    background: linear-gradient(#c3c3c3, #c3c3c3);
    border-color: #c3c3c3;
}
</style>
<div class="wrapper-contain master">

<div class="first-row">
<ul>
        <li><i class="fa fa-cubes"></i><a href="<?php echo site_url('master/product');?>">商品マスター</a></li>
        <li><i class="fa fa-cubes"></i><a href="<?php echo site_url('master/towel');?>">タオル商品</a></li>
        <li><i class="fa fa-cogs"></i><a href="<?php echo site_url('master/setting_product');?>">商品セット</a></li>
        <li><i class="fa fa-cogs"></i><a href="<?php echo site_url('master/setting_product_location');?>">商品セット_拠点_得意先</a></li> 
         <li><i class="fa fa-cogs"></i><a href="<?php echo site_url('master/setting_shipment_product');?>">商品セットM</a></li>
         <li><i class="fa fa-cogs"></i><a href="<?php echo site_url('master/setting_product_customer');?>">商品セットM_得意先 </a></li>  
       <li><i class="fa fa-align-center"></i><a href="<?php echo site_url('master/catalogue_buy');?>">種目区分</a></li>
        <!-- <li><i class="fa fa-align-center"></i><a  href="<?php echo site_url('master/catalogue_sale');?>">売上種目</a></li> -->
        <li><i class="fa fa-object-group"></i><a href="<?php echo site_url('master/buying_product_category');?>">仕入商品区分 </a></li>
         <li><i class="fa fa-object-group"></i><a href="<?php echo site_url('master/selling_product_category');?>">売上商品区分</a></li>
          <li><i class="fa fa-building"></i><a href="<?php echo site_url('master/supplier');?>">仕入先</a></li> 
           <li><i class="fa fa-building-o"></i><a href="<?php echo site_url('master/place_of_sales');?>">売上先</a></li>
        <li><i class="fa fa-recycle"></i><a href="<?php echo site_url('master/supplier_category');?>">仕入先区分</a></li>
        <li><i class="fa fa-users"></i><a href="<?php echo site_url('master/customer');?>">得意先台帳</a></li>
        <li><i class="fa fa-users"></i><a href="<?php echo site_url('master/customer_shipment');?>">受発注専用得意先M</a></li>      
        <li><i class="fa fa-server"></i><a href="<?php echo site_url('master/department');?>">部署台帳</a></li>
        <li><i class="fa fa-server"></i><a href="<?php echo site_url('master/department_shipment');?>">部署Ｍ</a></li>
        <li><i class="fa fa-cube"></i><a href="<?php echo site_url('master/M_washing');?>">洗濯品Ｍ</a></li>
        <li><i class="fa fa-archive"></i><a href="<?php echo site_url('master/machine');?>">機器Ｍ</a></li>
        <li><i class="fa fa-recycle"></i><a href="<?php echo site_url('master/washing-category');?>">洗濯区分</a></li>
        <li><i class="fa fa-book"></i><a href="<?php echo site_url('master/washing-powder');?>">洗剤台帳</a></li>
        <li><i class="fa fa-book"></i><a href="<?php echo site_url('master/statistical_group');?>">集計台帳</a></li>
        <li><i class="fa fa-sticky-note-o"></i><a href="<?php echo site_url('master/group-invoice');?>">請求書グループ</a></li>

        <li><i class="fa fa-usd"></i><a href="<?php echo site_url('master/product_price');?>">商品単価</a></li>
        <li><i class="fa fa-object-group"></i><a href="<?php echo site_url('master/overview_group_m');?>">生産概要グループＭ</a></li>
        <li><i class="fa fa-object-group"></i><a href="<?php echo site_url('master/overview_category_m');?>">生産概要区分Ｍ</a></li>
        
        <li><i class="fa fa-exchange"></i><a href="<?php echo site_url('master/shipment_courier');?>">配送便</a></li>

        <li><i class="fa fa-hand-o-up"></i><a href="<?php echo site_url('master/my_one_touch');?>">マイワンタッチ</a></li>
        
        <li><i class="fa fa-map-marker"></i><a href="<?php echo site_url('master/location');?>">拠点マスタ</a></li>
        <li><i class="fa fa-user"></i><a href="<?php echo site_url('master/user_stock_export');?>">出庫者</a></li>
        
        <li><i class="fa fa-user"></i><a href="<?php echo site_url('master/user');?>">ユーザ</a></li>
      
        <li><i class="fa fa-cog"></i><a href="<?php echo site_url('master/initial_inventory');?>">期首の棚卸</a></li>
        <li><i class="fa fa-cog"></i><a href="<?php echo site_url('master/disposal_inventory');?>">廃棄数</a></li>
        <li><i class="fa fa-cog"></i><a href="<?php echo site_url('master/fee_of_gaichyu');?>">管理業務料</a></li>
        <li><i class="fa fa-history"></i><a href="<?php echo site_url('master/log');?>">ログ</a></li>
    </ul>

</div>

<form method="post" enctype="multipart/form-data" id="formImportCsv" >
<div class="row" style="margin-top:9px;">

    <div class="col-md-12 form-inline" style="    padding-left: 15px;">
        <div class="col-md-12">
            <div class="col-md-2 form-group" style="padding-left: 50px;">
                <label class="radio-inline">
                    <input type="radio" name="data" value="production" checked class="data">生産データ
                </label>
            </div>
            <div class="col-md-4 form-group">
                <select class="form-control" name="production_data" id="production_data" style="margin-bottom: 0;">
                    <option data-type="" value="laundry_register">連洗機</option>
                    <option data-type="" value="laundry_detail_atsugi">洗脱機（厚木）</option>
                    <option data-type="" value="laundry_detail_tokyo">洗脱機（東京）</option>
                    <option data-type="" value="towel">仕上げ（タオル）</option>
                    <option data-type="" value="roller">仕上げ（ローラー）</option>
                </select>
            </div>
            <div class="col-md-4 form-group">

            </div>
        </div>

        <div class="col-md-12" style="min-height: 30px;">
            <div class="col-md-2 form-group" style="padding-left: 50px;">
                <label class="radio-inline">
                    <input type="radio" name="data" value="boiler" class="data">ボイラーデータ
                </label>
            </div>
            <div class="col-md-4 form-group">
                
            </div>
            <div class="col-md-4 form-group">

            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-2 form-group" style="padding-left: 50px;">
                <label class="radio-inline">
                    <input type="radio" name="data" value="master" class="data">マスターデータ 
                </label>
            </div>
            <div class="col-md-2 form-group">
                <select class="form-control" style="max-width: 100%;" id="value_url_master" disabled>
                    <option data-type="" value="<?= base_url('master/product');?>">商品マスター</option>
                    <option data-type="" value="<?= base_url('master/towel');?>">タオル商品</option>
                    <option data-type="1" value="<?= base_url('master/setting_product');?>">商品セット</option>
                    <option data-type="2" value="<?= base_url('master/setting_product');?>">商品セット-商品</option>
                    <option data-type="" value="<?= base_url('master/setting_product_location');?>">商品セット_拠点_得意先</option>
                    <option data-type="1" value="<?= base_url('master/setting_shipment_product');?>">商品セットM</option>
                    <option data-type="2" value="<?= base_url('master/setting_shipment_product');?>">商品セットM-商品</option>
                    <option data-type="" value="<?= base_url('master/setting_product_customer');?>">商品セットM_得意先</option>
                    <option data-type="" value="<?= base_url('master/catalogue_buy');?>">種目区分</option>
                    <!-- <option data-type="" value="<?= base_url('master/catalogue_sale');?>">売上種目</option> -->
                    <option data-type="" value="<?= base_url('master/buying_product_category');?>">仕入商品区分 </option>
                    <option data-type="" value="<?= base_url('master/selling_product_category');?>">売上商品区分</option>
                    <option data-type="" value="<?= base_url('master/supplier');?>">仕入先</option> 
                    <option data-type="" value="<?= base_url('master/place_of_sales');?>">売上先</option>
                    <option data-type="" value="<?= base_url('master/supplier_category');?>">仕入先区分</option>
                    <option data-type="" value="<?= base_url('master/customer');?>">得意先台帳</option>
                    <option data-type="" value="<?= base_url('master/customer-department');?>">得意先部署</option>
                    <option data-type="1" value="<?= base_url('master/customer_shipment');?>">受発注専用得意先M</option>
                    <option data-type="2" value="<?= base_url('master/customer_shipment');?>">受発注専用得意先M-部署Ｍ</option>      
                    <option data-type="" value="<?= base_url('master/department');?>">部署台帳</option>
                    <option data-type="" value="<?= base_url('master/department_shipment');?>">部署Ｍ</option>
                    <option data-type="" value="<?= base_url('master/M_washing');?>">洗濯品Ｍ</option>
                    <option data-type="" value="<?= base_url('master/machine');?>">機器Ｍ</option>
                    <option data-type="" value="<?= base_url('master/washing-category');?>">洗濯区分</option>
                    <option data-type="" value="<?= base_url('master/washing-powder');?>">洗剤台帳</option>
                    <option data-type="" value="<?= base_url('master/statistical_group');?>">集計台帳</option>
                    <option data-type="" value="<?= base_url('master/group-invoice');?>">請求書グループ</option>
                    <option data-type="" value="<?= base_url('master/group-invoice-detail');?>">請求書グループ-得意先部署</option>
                    <option data-type="" value="<?= base_url('master/product_price_sale');?>">商品単価_売上単価</option>
                    <option data-type="" value="<?= base_url('master/product_price_import');?>">商品単価_入庫単価</option>
                    <option data-type="" value="<?= base_url('master/product_price_export');?>">商品単価_出庫単価</option>
                    <option data-type="" value="<?= base_url('master/overview_group_m');?>">生産概要グループＭ</option>
                    <option data-type="" value="<?= base_url('master/overview_category_m');?>">生産概要区分Ｍ</option>
                    <option data-type="1" value="<?= base_url('master/shipment_courier');?>">配送便</option>
                    <option data-type="2" value="<?= base_url('master/shipment_courier');?>">配送便 - 得意先</option>
                    <option data-type="3" value="<?= base_url('master/shipment_courier');?>">配送便 - 拠点マスタ</option>
                    <option data-type="1" value="<?= base_url('master/my_one_touch');?>">マイワンタッチ</option>
                    <option data-type="2" value="<?= base_url('master/my_one_touch');?>">マイワンタッチ明細</option>
                    <option data-type="" value="<?= base_url('master/location');?>">拠点マスタ</option>
                    <option data-type="" value="<?= base_url('master/user_stock_export');?>">出庫者</option>
                    <option data-type="" value="<?= base_url('master/user');?>">ユーザ</option>
                    <option data-type="" value="<?= base_url('master/initial_inventory');?>">期首の棚卸</option>
                    <option data-type="" value="<?= base_url('master/disposal_inventory');?>">廃棄数</option>
                    <option data-type="" value="<?= base_url('master/fee_of_gaichyu');?>">管理業務料</option>
                </select> 
            </div> 
            <div class="col-md-4 form-group">
            <button type="button" class="exportcsv print" id="clickExportCSV" disabled style="height: 30px;">CSV出力</button>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-4 form-group" style="padding-right:0;padding-left: 50px;">
                <input type="hidden" name="get_type_csv" id="get_type_csv">
                <input class="form-control" style="width: 100%;padding: 3px;" type="file" required name="import_file" id="import_file" >
            </div>
            <div class="col-md-4 form-group">
                <button type="submit" class="importcsv print" style="height: 30px;">CSV入力</button>
            </div>
        </div>

    </div>


<div class="clearfix">&nbsp;</div>

</div>

</div>
</form>
<script>
    var base_url = "<?= base_url(); ?>";
    var dataexport = document.getElementsByClassName("data");
    function ExportCSV()
    {
        for(var i = 0; i < dataexport.length; i++)
        {
            if(dataexport[i].checked == true)
            {
                if(dataexport[i].value == "boiler")
                {
                    window.location= base_url+"exportexcel";
                }
                else
                {
                    alert('Dữ liệu này hiện không tồn tại');
                }     
            }
        }
    }

    var url_import_csv = "<?= base_url('importexcel') ?>";
</script>
