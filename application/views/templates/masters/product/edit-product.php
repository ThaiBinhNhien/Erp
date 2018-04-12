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
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3>商品マスター　編集</h3>
    </div>

    <div class="first-row">
    <div class="col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;">
            <div class="form-group">
            <label class="col-md-1 control-label" for="IsSmallBusiness" style="margin-left: 55px;width: 106px;">商品カテゴリ:</label>
            <div class="col-md-8 inp-product">
               
                <?php 

                if($master[PL_CATEGORIES] == "" || $master[PL_CATEGORIES] == null) {
                    $master[PL_CATEGORIES] = 3;
                }
                    $checked1= "checked";
                    $checked2= "";
                    $checked3= "";
                        if($master[PL_CATEGORIES] == "1") {
                            $checked1= "checked";
                            $checked2= "";
                            $checked3= "";
                        } else if($master[PL_CATEGORIES] == "2") {
                            $checked1= "";
                            $checked2= "checked";
                            $checked3= "";
                        } else if($master[PL_CATEGORIES] == "3") {
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
<!--             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">商品名:</label>
                    <div class="col-md-8">
                         <input class="form-control " name="product_name"  id="product_name" value="" >
                    </div>
                </div>
            </div> -->




             <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-buying">仕入商品ｺｰﾄﾞ:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <input class="form-control " disabled="true"  id="buy_product_id" name="buy_product_id" value="<?= $master[PL_PRODUCT_CODE_BUY] ?>">
                                        
                    </div>
                </div>
            </div>
              <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-sales">売上商品ｺｰﾄﾞ:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <input class="form-control " disabled="true" id="sell_product_id" name="sell_product_id" value="<?= $master[PL_PRODUCT_CODE_SALE] ?>">
                                        
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                <label for="input9" class="col-md-4 control-label">種目区分:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control "  name="t_catalogue"  id="t_catalogue">
                            <option></option>>
                           <?php 
                           if(isset($list_t_catalogue)) {
                           foreach ($list_t_catalogue as $key => $value) {
                                echo '<option value="'.$value[TE_ID].'" '.($value[TE_ID]==$master[PL_T_CATALOGUE]?'selected':'').'  data-flg="'.$value[TE_FLG_OUTSOURCE].'" >'.$value[TE_ITEM_CATEGORY_NAME].'</option>';
                             } }
                              ?>  
                        </select>
                    </div>
                </div>
            </div>
            

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-buying">仕入商品名:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <input class="form-control " id="buy_product_name" name="buy_product_name" value="<?= $master[PL_PRODUCT_NAME_BUY] ?>">
                                        
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-sales">売上商品名:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <input class="form-control " id="sell_product_name" name="sell_product_name" value="<?= $master[PL_PRODUCT_NAME] ?>">
                                        
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4"> 
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">予備レコード:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <select class="form-control "  name="t_type_order"  id="t_type_order" >
                        <?php 
                        $selected_type1 = "selected";
                        $selected_type2 = "";
                        if($master[PL_TYPE_SHOW_ORDER] != null && $master[PL_TYPE_SHOW_ORDER] != "") {
                            if($master[PL_TYPE_SHOW_ORDER] == 1 || $master[PL_TYPE_SHOW_ORDER] == "1") {
                                $selected_type2 = "selected";
                            }
                        } ?>
                        <option></option>
                           <option value="2" <?php echo $selected_type1; ?>>通常</option>
                           <option value="1" <?php echo $selected_type2; ?>>予備</option>
                        </select>
                    </div>
                </div>
            </div>

            

            <!-- <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">単位:</label>
                    <div class="col-md-8">
                        <input class="form-control " name="product_unit" id="product_unit" value="<?= $master[PL_STANDARD] ?>">
                    </div>
                </div> 
            </div> -->

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label label-buying">素材:</label>
                    <div class="col-md-8">
                        <input class="form-control " name="product_organization_pile" id="product_organization_pile" value="<?= $master[PL_ORGANIZATION_PILE] ?>">
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-sales">結束単位:</label>
                    <div class="col-md-8">
                         <input  class="form-control " id="product_number_package" name="product_number_package"  value="<?= $master[PL_NUMBER_PACKAGE] ?>">
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label">規格(単位):</label>
                    <div class="col-md-8">
                          <input class="form-control " name="product_standard" id="product_standard" value="<?= $master[PL_STANDARD] ?>" >
                    </div>
                </div>
            </div>

            

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label label-buying" style="padding-left: 0;font-size: 91%;">組織(ﾊﾟｲﾙ･経･緯･目付):<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                        <input class="form-control " name="product_organization_weight" id="product_organization_weight" value="<?= $master[PL_ORGANIZATION_WEIGHT] ?>">
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
                                echo '<option value="'.$key.'" '.(($master[PL_SPECIAL] != null && $key ==$master[PL_SPECIAL])?'selected':'').'>'.$value.'</option>';
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
                        <input type="text" class="form-control" name="product_color_tone" id="product_color_tone" value="<?= $master[PL_COLOR_TONE] ?>" >
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-buying">仕入区分ｺｰﾄﾞ:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <select class="form-control " id="t_category" name="t_category">
                            <option></option>
                             <?php 
                             if(isset($list_t_category)) {
                             foreach ($list_t_category as $key => $value) {
                                echo '<option value="'.$value[ID].'" '.($value[ID]==$master[PL_T_PRODUCT_CATEGORY_ID]?'selected':'').'>'.$value[TPC_NAME].'</option>';
                             } } ?>   
                        </select>                        
                    </div>
                </div>
            </div>

            

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-sales">売上区分ｺｰﾄﾞ:<span class="label-form-request">*</span></label>
                    <div class="col-md-8">
                         <select class="form-control" id="category" name="category">
                            <option></option>
                            <?php 
                            if(isset($list_category)) {
                            foreach ($list_category as $key => $value) {
                                echo '<option value="'.$value[CATE_CATEGORY_CODE].'" '.($value[CATE_CATEGORY_CODE]==$master[PL_PRODUCT_CATEGORY_ID]?'selected':'').' >'.$value[CATE_CATEGORY_NAME].'</option>';
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
                         <select class="form-control" id="product_laundry_segment" name="product_laundry_segment">
                            <option></option>
                              <?php 
                              if(isset($list_laundry_segment)) {
                              foreach ($list_laundry_segment as $key => $value) {
                                echo '<option value="'.$value[TLG_ID].'" '.($value[TLG_ID] ==$master[PL_LAUNDRY_SEGMENT]?'selected':'').'>'.$value[TLG_NAME].'</option>';
                             } }
                              ?>  
                        </select>    
                    </div>
                </div>
            </div>

            

            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label label-buying">標準在庫数:</label>
                    <div class="col-md-8">
                          <input class="form-control "  name="product_standard_stock_number" id="product_standard_stock_number" value="<?= $master[PL_STANDARD_STOCK_NUMBER] ?>">
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
                            <option value="<?= $value[POC_PRODUCTION_SUMMARY_CODE]?>" <?= $value[POC_PRODUCTION_SUMMARY_CODE] == $master[PL_PRODUCTION_SUMMARY_CODE]?'selected':''?> ><?= $value[POC_CATEGORY_NAME]?></option>
                        <?php } } ?>
                    </select>
                    </div>
                </div>
            </div>

            <div class="col-sm-12 col-md-4 col-lg-4" style="padding-left: 0;">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label" style="padding-right: 0;padding-left: 0;padding-top:0">ドライ_プレス_ランドリー区分:</label>
                    <div class="col-md-8" style="padding-left: 12px;">
                         <select class="form-control " name="product_dry_press_laundry" id="product_dry_press_laundry">
                            <option></option>
                             <?php 
                             if(isset($list_dry_press_laundry)) {
                             foreach ($list_dry_press_laundry as $key => $value) {
                                echo '<option value="'.$value[DPLC_ID].'" '.($value[DPLC_ID]==$master[PL_DRY_PRESS_LAUNDRY_CLASSIFICATION]?'selected':'').'>'.$value[DPLC_NAME].'</option>';
                             } } ?>   
                        </select>
                         
                    </div>
                </div>
            </div>

            <div class="clearfix"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                <label for="input9" class="col-md-4 control-label label-buying">償却区分:</label>
                    <div class="col-md-8">
                         <select class="form-control " name="product_wash_classification" id="product_wash_classification">
                              <option></option>
                              <?php 
                              if(isset($list_wash)) {
                              foreach ($list_wash as $key => $value) {
                                echo '<option value="'.$key.'" '.(($master[PL_WASH_CLASSIFICATION] != null && $key ==$master[PL_WASH_CLASSIFICATION])?'selected':'').'>'.$value.'</option>';
                             } } ?>  
                        </select>
                    </div>
                </div>
            </div>
             
            <!-- <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">組織(目付):</label>
                    <div class="col-md-8">
                         <input class="form-control " name="product_organization_date" id="product_organization_date" value="">
                    </div>
                </div>
            </div> -->

           

            
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                <label for="input9" class="col-md-4 control-label label-sales" style="padding-left: 0;padding-right: 0;font-size: 98%;">１コンテナ上限搭載量:</label>
                    <div class="col-md-8">
                        <input class="form-control "  name="container_upper_mouting_amount" id="container_upper_mouting_amount" value="<?= $master[PL_1_CONTAINER_UPPER_LIMIT_MOUNTING_AMOUNT] ?>">
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
                                echo '<option value="'.$value[ICR_EVENT_CATEGORY].'" '.($value[ICR_EVENT_CATEGORY]==$master[PL_T_CATALOGUE]?'selected':'').'>'.$value[ICR_ITEM_CATEGORY_NAME].'</option>';
                             }*/ ?>  
                        </select>
                    </div>
                </div>
            </div> -->
              <!-- <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">組織(緯糸):</label>
                    <div class="col-md-8">
                         <input class="form-control " name="product_organization_cal" id="product_organization_cal" value="">
                    </div>
                </div>
            </div> -->
             
              <div class="clearfix"></div>
              <!-- <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">商品区分_XOA:</label>
                    <div class="col-md-8">
                         <select class="form-control" id="product_pl_categories" name="product_pl_categories">
                           <option></option>
                           <?php /*foreach ($list_pl_categories as $key => $value) {
                                echo '<option value="'.$key.'" '.($key ==$master[PL_CATEGORIES]?'selected':'').'>'.$value.'</option>';
                             }*/ ?>  
                        </select> 
                    </div>
                </div>
            </div> -->
          <!--    <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">売却用区分</label>
                    <div class="col-md-8">
                        <select class="form-control " id="use_sale" name="use_sale">

                        </select>
                        
                    </div>
                </div>
            </div> -->

            
             <!--  <div class="clearfix"></div>   -->

            
           <!--  <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                   <label for="input9" class="col-md-4 control-label">売却用浴衣区分:</label>
                    <div class="col-md-8">
                         <select class="form-control " id="product_yurata_classification_for_sale" name="product_yurata_classification_for_sale">
                            <option></option>
                         
                        </select>
                         
                    </div>
                </div>
            </div> -->
            


            
           <!--    <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label">主な使用先:</label>
                    <div class="col-md-8">
                         <input class="form-control " name="product_main_use" id="product_main_use" value="">
                    </div>
                </div>
            </div> -->
            
            
          <!--   <div class="clearfix"></div>   -->
            <!-- <div class="col-sm-12 col-md-4 col-lg-4"  style="padding-left: 0;">
                <div class="form-group">
                    <label for="input9" class="col-md-4 control-label" style="padding-right: 0;padding-left: 0;">東京工場仕上げフラグ:</label>
                    <div class="col-md-8" style="padding-left: 12px;">
                    <select id="tokyo_flag" name="tokyo_flag">
                    </select>
                    </div> 
                </div>
            </div> -->
            
            <div class="clearfix"></div>  
           <div class="col-sm-12 col-md-8 col-lg-8">
                <div class="form-group">
                    <label for="input9" class="col-md-2 control-label">備考:</label>
                    <div class="col-md-10" style="padding-left: 10px;">
                        <input class="form-control " id="product_remark" value="<?= $master[PL_REMARKS] ?>" style="    width: 96%;">
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
            <div class="col-sm-12 col-md-8 col-lg-8">
                <div class="form-group">
                    <label for="input9" class="col-md-2 control-label">備考（社外秘）:</label>
                    <div class="col-md-10" style="padding-left: 10px;">
                        <input class="form-control " id="product_remark_2" value="<?= $master[PL_REMARKS_2] ?>" style="    width:96%;">
                    </div>
                </div>
            </div>
           <?php }else{?>
              <div class="col-sm-12 col-md-8 col-lg-8"  hidden="true">
                <div class="form-group">
                    <label for="input9" class="col-md-2 control-label">備考（社外秘）:</label>
                    <div class="col-md-10" style="padding-left: 10px;">
                        <input class="form-control " id="product_remark_2" value="<?= $master[PL_REMARKS_2] ?>" style="    width: 96%;">
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
        <a href="#dialog-form" id="save_product" class="print save_product">保存</a>
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
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var editUrl = "<?= site_url('/master/product/edit-product')?>";
    var master_id = "<?= $master[PL_PRODUCT_ID]?>";
    var message_confirm_save_field = "<?= $this->lang->line('message_confirm_save_field')?>";
    var typeProduct = "<?= $master[PL_CATEGORIES]?>";
    var urlIndex = "<?= base_url("master/product") ?>"; 
</script>