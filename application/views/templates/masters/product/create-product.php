<style>
img{
    height:22px;
}
.inp-product input{
    width:auto !important;
    float:left;
    margin-top: 2px;
    margin-left:5px;
}
.inp-product label{
    margin-right:10%;
}
.label-form-request {
    padding: 2px 5px 2px 9px;
}
.imageAdd{
  float: right;
    margin-top: -35px;
    margin-right: -40px;
}
.randomkey {
   pointer-events: none;
   cursor: default;
}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>商品マスター 新規作成</h3>
    </div>

    <div class="first-row">


    <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;">
            <div class="form-group">
            <label class="col-md-1 control-label" for="IsSmallBusiness" style="margin-left: 55px; width: 106px;">商品カテゴリ:</label>
            <div class="col-md-8 inp-product">
               
                <?php 
    $checked1= "checked";
    $checked2= "";
    $checked3= "";
        if($list_pl_categories == 1 || $list_pl_categories == "1") {
            $checked1= "checked";
    $checked2= "";
    $checked3= "";
        } else if($list_pl_categories == 2 || $list_pl_categories == "2") {
            $checked1= "";
            $checked2= "checked";
            $checked3= "";
        } else if($list_pl_categories == 3 || $list_pl_categories == "3") {
            $checked1= "";
    $checked2= "";
    $checked3= "checked";
        }
    ?>
                <label>&nbsp;リネンサプライ<input type="radio" <?php echo $checked1; ?> name="optradio" value="1"></label>
                
                <label>&nbsp;クリーニング他<input type="radio" <?php echo $checked3; ?> name="optradio" value="3"></label>
                <label>&nbsp;洗剤等<input type="radio" <?php echo $checked2; ?> name="optradio" value="2"></label>
                </div>
            </div>
    </div>
    <form class="form-horizontal" role="form"  id="product_form">

      
        <div class="row">

<!--             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">商品ID:</label>
                    <div class="col-md-8">
                        <input class="form-control "  name="product_id"  id="product_id"  >
                    </div>
                </div>
            </div> -->
           <!--  <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">商品名:</label>
                    <div class="col-md-8">
                         <input class="form-control " name="product_name"  id="product_name" >
                    </div>
                </div> 
            </div> -->
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-buying">仕入商品ｺｰﾄﾞ:<span class="label-form-request">*</span></label>
                    <div class="col-md-6">
                         <input class="form-control"  id="buy_product_id" name="buy_product_id" style="width: 190px;">
                        <a class="btnRandomKeyBuy" ><img 
                        class="imageAdd" src="<?= site_url('asset/img/')?>/add.png"></a>        
                    </div>
                   
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-sales">売上商品ｺｰﾄﾞ:<span class="label-form-request">*</span></label>
                    <div class="col-md-6">
                         <input class="form-control " id="sell_product_id" name="sell_product_id" style="width: 190px;">
                           <a class="btnRandomKeySale"><img 
                            class="imageAdd" src="<?= site_url('asset/img/')?>/add.png"></a>                
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4"> 
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">種目区分:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control "  name="t_catalogue"  id="t_catalogue" ></select>
                    </div>
                </div>
            </div>

            

            
            

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-buying">仕入商品名:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <input class="form-control " id="buy_product_name" name="buy_product_name">
                                        
                    </div>
                </div>
            </div>

             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-sales">売上商品名:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <input class="form-control " id="sell_product_name" name="sell_product_name">
                                        
                    </div>
                </div> 
            </div> 

            <div class="col-sm-12 col-md-4 col-lg-4"> 
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">予備レコード:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control "  name="t_type_order"  id="t_type_order" >
                           <option value="2">通常</option>
                           <option value="1">予備</option>
                        </select>
                    </div>
                </div>
            </div>

            
            
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label label-buying">素材:</label>
                    <div class="col-md-8">
                        <input class="form-control " id="product_organization_pile" name="product_organization_pile">
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-sales">結束単位:</label>
                    <div class="col-md-8">
                         <input  class="form-control " id="product_number_package" name="product_number_package">
                    </div>
                </div>
            </div>
            
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">規格(単位):</label>
                    <div class="col-md-8">
                          <input class="form-control " id="product_standard" name="product_standard">
                    </div>
                </div>
            </div>

            

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label label-buying" style="padding-left: 0;font-size: 91%;">組織(ﾊﾟｲﾙ･経･緯･目付):<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " id="product_organization_weight" name="product_organization_weight">
                    </div>
                </div>
            </div>


            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-sales">単価修正の有無:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        
                        <select class="form-control" id="product_type" name="product_type">
                            <option></option>
                              <?php 
                              if(isset($list_product_type)) {
                              foreach ($list_product_type as $key => $value) {
                                echo '<option value="'.$key.'">'.$value.'</option>';
                             } }
                              ?>  
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">色調:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="product_color_tone" name="product_color_tone">
                    </div>
                </div>
            </div>

            

 

         <!--    //pass
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">組織(目付):</label>
                    <div class="col-md-8">
                         <input class="form-control " id="product_organization_date" name="product_organization_date">
                    </div>
                </div>
            </div>

 -->
            
                
           
            <!-- <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">組織(目付):</label>
                    <div class="col-md-8">
                         <input class="form-control " id="product_organization_date" name="product_organization_date">
                    </div>
                </div>
            </div> -->
            
              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-buying">仕入区分ｺｰﾄﾞ:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <select class="form-control" id="t_category" name="t_category">
                           <option ></option>
                             <?php 
                             if(isset($list_t_category)) {
                             foreach ($list_t_category as $key => $value) {
                                echo '<option value="'.$value[ID].'">'.$value[TPC_NAME].'</option>';
                             } }
                              ?>   
                        </select>                        
                    </div>
                </div>
            </div>
             
            
            

            

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-sales">売上区分ｺｰﾄﾞ:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <select class="form-control" id="category" name="category">
                            <option ></option>
                            <?php 
                            if(isset($list_category)) {
                            foreach ($list_category as $key => $value) {
                                echo '<option value="'.$value[CATE_CATEGORY_CODE].'">'.$value[CATE_CATEGORY_NAME].'</option>';
                             } }
                              ?>       
                        </select> 
                    </div>
                </div>
            </div>

             
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">洗濯区分:</label>
                    <div class="col-md-8">
                        <select class="form-control " id="product_laundry_segment" name="product_laundry_segment">
                            <option></option>
                              <?php 
                              if(isset($list_laundry_segment)) {
                              foreach ($list_laundry_segment as $key => $value) {
                                echo '<option value="'.$value[TLG_ID].'">'.$value[TLG_NAME].'</option>';
                             } } ?>  
                        </select>
                    </div> 
                </div>
            </div> 


             
            

            <!-- <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">売上種目区分:</label>
                    <div class="col-md-8">
                        <select class="form-control " id="catalogue" name="catalogue">
                            <option></option>
                              <?php /*foreach ($list_catalogue as $key => $value) {
                                echo '<option value="'.$value[ICR_EVENT_CATEGORY].'">'.$value[ICR_ITEM_CATEGORY_NAME].'</option>';
                             }*/ ?>  
                        </select>
                    </div>
                </div>
            </div> -->

             <!-- <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">組織(緯糸):</label>
                    <div class="col-md-8">
                         <input class="form-control " id="product_organization_cal" name="product_organization_cal">
                    </div>
                </div>
            </div> -->
   
            
            <div class="clearfix"></div>
            <!--  <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">商品区分_XOA:</label>
                    <div class="col-md-8">

                         <select class="form-control" id="product_pl_categories" name="product_pl_categories">
                            <option></option>
                            <?php /*foreach ($list_pl_categories as $key => $value) {
                                echo '<option value="'.$key.'">'.$value.'</option>';
                             }*/ ?>  
                        </select> 
                    </div>
                </div>
            </div>
 -->
        


         <!--    <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">売却用区分</label>
                    <div class="col-md-8">
                        <select class="form-control " id="use_sale" name="use_sale">

                        </select>
                        
                    </div>
                </div>
            </div>
 -->


            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-buying">標準在庫数:</label>
                    <div class="col-md-8">
                          <input class="form-control "  id="product_standard_stock_number" name="product_standard_stock_number">
                    </div>
                </div>
            </div>


            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-sales">生産概要区分:</label>
                    <div class="col-md-8">
                    <select class="form-control" name="production_sumary_code" id="production_sumary_code">
                        <option></option> 
                        <?php 
                        if(isset($production_sumary)) {
                        foreach ($production_sumary as $key => $value) { ?>
                            <option value="<?= $value[POC_PRODUCTION_SUMMARY_CODE]?>"><?= $value[POC_CATEGORY_NAME]?></option>
                        <?php } } ?>
                    </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4" style="padding-left: 0;">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label" style="padding-right: 0;padding-left: 0;padding-top: 0;">ドライ_プレス_ランドリー区分:</label>
                    <div class="col-md-8" style="padding-left: 12px;">
                         <select class="form-control " id="product_dry_press_laundry" name="product_dry_press_laundry">
                            <option></option>
                                 <?php 
                                 if(isset($list_dry_press_laundry)) {
                                 foreach ($list_dry_press_laundry as $key => $value) {
                                echo '<option value="'.$value[DPLC_ID].'">'.$value[DPLC_NAME].'</option>';
                             } } ?>   
                        </select>
                         
                    </div>
                </div>
            </div>
            
             
           <!--    <div class="clearfix"></div>    -->

            




<!--             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                   <label for="input9" class="col-md-4 control-label">売却用浴衣区分:</label>
                    <div class="col-md-8">
                         <select class="form-control " id="product_yurata_classification_for_sale" name="product_yurata_classification_for_sale">
                            <option></option>
                                 <?php /*foreach ($list_yukata as $key => $value) {
                                echo '<option value="'.$value[TYC_ID].'">'.$value[TYC_NAME].'</option>';
                             }*/ ?>   
                        </select>
                         
                    </div>
                </div>
            </div> -->
            <div class="clearfix"></div>
             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-buying">償却区分:</label>
                    <div class="col-md-8">

                         <select class="form-control" id="product_wash_classification" name="product_wash_classification">
                             <option></option>
                              <?php 
                              if(isset($list_wash)) {
                              foreach ($list_wash as $key => $value) {
                                echo '<option value="'.$key.'">'.$value.'</option>';
                             } } ?>  
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-sales" style="    padding-left: 0;
    padding-right: 0;
    font-size: 98%;">１コンテナ上限搭載量:</label>
                    <div class="col-md-8">
                        <input class="form-control "  id="container_upper_mouting_amount" name="container_upper_mouting_amount">
                    </div>
                </div>
            </div>

            
           
             
           <!--   <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">主な使用先:</label>
                    <div class="col-md-8">
                         <input class="form-control " id="product_main_use" name="product_main_use">
                    </div>
                </div>
            </div> -->
            
           <!--   <div class="clearfix"></div>   -->
            <!-- <div class="col-sm-12 col-md-4 col-lg-4" style="padding-left: 0;">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label" style="padding-right: 0;padding-left: 0;">東京工場仕上げフラグ:</label>
                    <div class="col-md-8" style="padding-left: 12px;">
                    <select class="form-control " id="tokyo_flag" name="tokyo_flag">
                        <option></option>
                       <option value="0">不</option>
                        <option value="1">有</option>
                    </select>
                    </div>
                </div> 
            </div> -->
         <!--    <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">結束単位:</label>
                    <div class="col-md-8">
                         <input  class="form-control " id="product_number_package" name="product_number_package">
                    </div>
                </div>
            </div>
            -->
            
            

            <div class="clearfix"></div>  
            <div class="col-sm-12 col-md-8 col-lg-8">
                    <div class="form-group">
                        <label for="input9" class="col-md-2 control-label">備考:</label>
                        <div class="col-md-10" style="padding-left: 10px;">
                            <input class="form-control " id="product_remark" name="product_remark" style="    width: 96%;" >
                        </div>
                    </div>
            </div>
            <div class="col-md-3 col-md-offset-1">
                <div class="form-group col-md-12">
                    <label for="input9" class="col-md-2 control-label label-buying">&nbsp;</label>
                    <div class="col-md-8" style="padding-top: 6px;font-weight: 600;">仕入専用</div>
                </div>
            </div>

            <?php 
            if($is_tolinen == 0){ ?>
                <div  class="col-sm-12 col-md-8 col-lg-8"   >
                    <div class="form-group">
                        <label for="input9" class="col-md-2 control-label">備考（社外秘）:</label>
                        <div class="col-md-10" style="padding-left: 10px;">
                            <input class="form-control " id="product_remark_2" name="product_remark_2" style="    width: 96%;" >
                        </div>
                    </div>
                </div>
           <?php }else{?>
                 <div  class="col-sm-12 col-md-8 col-lg-8"  hidden="true">
                    <div class="form-group">
                        <label for="input9" class="col-md-2 control-label">備考（社外秘）:</label>
                        <div class="col-md-10" style="padding-left: 10px;">
                            <input class="form-control " id="product_remark_2" name="product_remark_2" style="    width: 96%;" >
                        </div>
                    </div>
                </div>
            <?php } ?>

            

            <div class="col-md-3 col-md-offset-1">
                <div class="form-group col-md-12">
                    <label for="input9" class="col-md-2 control-label label-sales">&nbsp;</label>
                    <div class="col-md-8" style="padding-top: 6px;font-weight: 600;">売上専用</div>
                </div>
            </div>

        </div>

    </form>
    </div>
    <div class="row third-row" style="text-align:center;">
        <a href="#dialog-form" class="print save-new-product">保存</a>
    </div>
    <!-- <div class="row third-row">
        <div class="col-md-6">
            <div class="form-group col-md-12">
                <label for="input9" class="col-md-1 control-label label-buying">&nbsp;</label>
                <div class="col-md-8" style="padding-top: 3px;font-weight: 600;">仕入専用</div>
            </div>
            <div class="form-group col-md-12">
                <label for="input9" class="col-md-1 control-label label-sales">&nbsp;</label>
                <div class="col-md-8" style="padding-top: 3px;font-weight: 600;">売上専用</div>
            </div>
        </div>
    </div> -->
    <div class="clearfix"></div>
    
    
</div>
<script>
    var createUrl =   "<?= site_url('/master/product/create-product')?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var message_confirm_save_field = "<?= $this->lang->line('message_confirm_save_field')?>";
    var urlIndex = "<?= base_url("master/product") ?>"; 
    var get_infor_event_buy = "<?= base_url("master/catalogue_buy/get_list") ?>";
    var get_key_random = "<?= base_url("master/product/get_key_random") ?>";
    var assetImgUrl = "<?= site_url('asset/img/')?>";
</script>