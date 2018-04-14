<?php
    $type_list = $this->input->get('type'); 
    if($type_list == "" && $type_list == null) {
        $type_list = 1;
    }
?>
<style> 
img{
    height:22px; 

}
.radio-price-inline span {
    display: inline-block;
    padding-left: 30px;
    vertical-align: middle;
}
.radio-price-inline input { 
    margin-top: 2px;
}
.radio-price-inline {
    display: inline-block;
    margin-bottom: 10px !important;
}
.form-control {
    margin-bottom: 9px;
}
label{
    padding-top: 7px;
}
select#sale_base_gaichyn {
    -webkit-appearance: none;
    -moz-appearance: none;
}
.inputpicker-div input {
    margin-bottom: 9px;
}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div class="col-md-8 third-row">
        <h3><?php echo $title; ?></h3>
    </div>

	<div class="first-row">
  
    <!-- <form class="form-horizontal" role="form"> -->

    <div class="col-sm-12 col-md-12 col-lg-12">
            <label class="col-md-1 control-label" for="IsSmallBusiness">単価区分</label>
            <div class="col-md-9">
                <div class="form-group">
                <?php 
    $checked1= "checked";
    $checked2= "";
    $checked3= "";
        if($type_list == 1 || $type_list == "1") {
            $checked1= "checked";
    $checked2= "";
    $checked3= "";
        } else if($type_list == 2 || $type_list == "2") {
            $checked1= "";
            $checked2= "checked";
            $checked3= "";
        } else if($type_list == 3 || $type_list == "3") {
            $checked1= "";
    $checked2= ""; 
    $checked3= "checked"; 
        }
    ?>
                <label class="radio-inline radio-price-inline"><input type="radio" <?php echo $checked1; ?> name="type" value="1"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;売上単価</span></label>
                <label class="radio-inline radio-price-inline"><input type="radio" <?php echo $checked2; ?> name="type" value="2"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;仕入単価</span></label>
                <label class="radio-inline radio-price-inline"><input type="radio" <?php echo $checked3; ?> name="type" value="3"><span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;出庫単価</span></label>
                </div></div>
            </div>

            
            <?php if($type_list == 1 || $type_list == "1") { ?>
                <div class="col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group">
                        <label class="col-md-1 control-label">拠点</label>
                        <div class="col-md-2">
                        <select class="form-control"  name="inputLabelBase"  id="inputLabelBase" >
                        <option value=""></option>
                            <?php 
                            if(isset($list_base_all)) {
                            foreach ($list_base_all as $key => $value) {
                                        echo '<option value="'.$value[BM_BASE_CODE].'" title="'.$value[BM_BASE_NAME].'">'.$value[BM_BASE_NAME].'</option>';
                                    } } ?>
                            </select>
                        </div>
                        <label class="col-md-1 control-label">商品コード</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="inputLabelProduct" >
                        </div>
                        <label class="col-md-1 control-label">得意先</label>
                        <div class="col-md-2">
                            <input type="text" class="form-control" id="inputLabelCustomer" >
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label class="col-md-4 control-label"><?= $this->lang->line('label_input_search')?></label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="inputLabel4" >
                    </div>
                </div>
                </div>
            <?php } ?>
            
    <!-- </form> -->
    </div>
    <div class="clearfix"></div>
    <div class="row left third-row">
        <a class="print" id="btnSearch">検索 </a>
    </div>
    <div class="clearfix"></div>
    <div class="col-sm-12 col-md-10 col-lg-9">   
            <form class="form-horizontal" role="form" id="form_import_csv_price" method="POST" enctype="multipart/form-data">    
                <div class="col-md-4">
                    <input type="file" class="form-control-file validation-required" name="import_file" id="import_file" required />
                </div>
                <div class="col-md-2"> 
                    <input id="btnImport2" type="submit" class="print" value="CSV入力"  />
                    <!-- <a id="btnImport" class="print">CSV入力</a> -->
                </div>
            </form>
        <div class="col-md-2">
            <a id="btnExportPrice" class="print">CSV出力</a>
        </div>
    </div>
    <div class="row right third-row">
         <a id="btnInsert" class="print">新規追加</a>
    </div>
    
    <?php 
    $display_css1= "";
    $display_css2= "display: none;";
    $display_css3= "display: none;";
        if($type_list == 1 || $type_list == "1") {
            $display_css1= "display: block;";
            $display_css2= "display: none;";
            $display_css3= "display: none;";
        } else if($type_list == 2 || $type_list == "2") {
            $display_css1= "display: none;";
            $display_css2= "display: block;";
            $display_css3= "display: none;";
        } else if($type_list == 3 || $type_list == "3") {
            $display_css1= "display: none;";
            $display_css2= "display: none;";
            $display_css3= "display: block;";
        }
    ?>
    <!-- Sale -->
	<div class="row third-row" id="price-product-sale" style="<?php echo $display_css1; ?>">
        <table  class="display datatable dataTable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width="10%">ID</th>
                    <th width="10%">商品コード</th>
                    <th>商品名</th>
                    <th>拠点</th>
                    <th>得意先</th>
                    <th>売上単価</th>
                    <th>外注専用単価</th>
                    <th width="8%">操作</th>
                </tr>
            </thead>
		
		
		 <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><a href="#"><img src="<?php echo site_url('asset/img/');?>edit.png"/></a>  <a href="#"><img src="<?php echo site_url('asset/img/');?>del.png"/></a></td>
                </tr>
            </tbody>
        </table>
    </div> 
    
    <!-- Nhập kho -->
	<div class="row third-row" id="price-product-import" style="<?php echo $display_css2; ?>">
        <table  class="display datatable dataTable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                <th width="10%">ID</th>
                    <th>仕入先</th>
                    <th>商品コード</th>
                    <th>商品名 </th>
                    <th>仕入単価</th>
                    <th>備考</th>
                    <th width=10%>操作</th>
                </tr>
            </thead>
		
		
		 <tbody>
                <tr>
                <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><a href="#"><img src="<?php echo site_url('asset/img/');?>edit.png"/></a>  <a href="#"><img src="<?php echo site_url('asset/img/');?>del.png"/></a></td>
                </tr>
            </tbody>
        </table>
    </div> 

    <!-- xuất kho -->
	<div class="row third-row" id="price-product-export" style="<?php echo $display_css3; ?>">
        <table  class="display datatable dataTable responsive cell-border" cellspacing="0" width="100%">
            <thead>
                <tr>
                <th width="10%">ID</th>
                    <th>売上先</th>
                    <th>商品コード</th>
                    <th>商品名 </th>
                    <th>売上単価</th>
                    <th>備考</th>
                    <th width=10%>操作</th>
                </tr>
            </thead>
		
		
		 <tbody>
                <tr>
                <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><a href="#"><img src="<?php echo site_url('asset/img/');?>edit.png"/></a>  <a href="#"><img src="<?php echo site_url('asset/img/');?>del.png"/></a></td>
                </tr>
            </tbody>
        </table>
    </div> 

</div>

<!-- Modal sale -->
<div id="myModalSale" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title modal-title-add" style="display: none;">新規作成</h4>
        <h4 class="modal-title modal-title-edit" style="display: none;">編集</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" id="form_add_price_sale">
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label class="col-md-3 control-label">得意先:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control" name="sale_customer"  id="sale_customer" value="" />
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label class="col-md-3 control-label">拠点 :<span class="label-form-request">*</span></label>
                        <div class="col-md-8 box_input_base">
                            <select class="form-control sale_base" id="sale_base"  name="sale_base" disabled>
                            </select>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 col-lg-4">
                    <div class="form-group">
                        <label class="col-md-3 control-label">担当者:</label>
                        <div class="col-md-8">
                            <input class="form-control sale_price_user" id="sale_price_user" name="sale_price_user" disabled >
                        </div>
                    </div>
                </div>

                


<div class="clearfix"></div>

<div id="getBoxRowSale">
    <div class="boxRowPriceExport">
    <div class="col-md-11">
    <div class="col-sm-12 col-md-12 col-lg-12">
                        <hr style="margin-top: 0px;margin-bottom: 10px;border-top: 1px solid #e5e5e5;">
                        </div>
    <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">商品コード:<span class="label-form-request">*</span></label>
                        <div class="col-md-8 box_input_product">
                                <input class="form-control sale_product_add" name="sale_product_add" value="" />
                                <span></span>
                        </div>
                    </div>
                </div>
                
                

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">売上単価:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control sale_price" name="sale_price" >
                        </div>
                    </div>
                </div>
                </div>
                <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">商品名:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control product_sale_name" name="product_sale_name" disabled >
                        </div>
                    </div>
                </div>
                

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label" style="padding-left: 0;">外注専用単価:<span class="label-form-request">*</span></label>
                        <div class="col-md-8 box_input_product_price_gaichyu">
                            <input class="form-control sale_price_gaichyu" name="sale_price_gaichyu" disabled >
                        </div>
                    </div>
                </div>

                
                </div>
    </div>
    <div class="col-md-1">
    <a class="btnDeleteBoxRowSale">
    <img style="margin-top: 34px;" src="<?= base_url("asset/img/del.png") ?>">
    </a>                     
    </div>
    </div>
</div>
    <div id="setBoxRowSale">
        </div>
                <div class="modal-footer">
                <div class="col-sm-12 col-md-12 col-lg-12" style="text-align:center;margin-top: 10px;">
                    <a id="btnAddPriceSale" class="print print-add" style="display: none;">保存</a>
                    <input type="button" id="addRowSale" class="print" value="行挿入"  style="display: none;">
                </div>
            </div>
        </form>
      </div>
    </div>
 
  </div>
</div>

<div id="myModalSaleEdit" class="modal fade" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title modal-title-add" style="display: none;">新規作成</h4>
        <h4 class="modal-title modal-title-edit" style="display: none;">編集</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" id="form_edit_price_sale">
            <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">得意先:</label>
                        <div class="col-md-8">
                            <input class="form-control" name="sale_customer_edit"  id="sale_customer_edit" value="" />
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    &nbsp;
                </div>
                </div>
            <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-6">
            <div class="form-group">
                        <label class="col-md-4 control-label">商品コード:</label>
                        <div class="col-md-8">
                        <input class="form-control" name="product_sale_code"  id="product_sale_code" disabled value="" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">商品名:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                                <input class="form-control" name="sale_product_edit"  id="sale_product_edit" value="" />
                                <span></span>
                        </div>
                    </div>
                </div>
            
                <div class="col-sm-12 col-md-6 col-lg-6 flag-base" style="display: none">
                    <div class="form-group">
                        <label class="col-md-4 control-label label-base">拠点 :</label>
                        <label class="col-md-4 control-label label-base-to">TO拠点 :</label>
                        <label class="col-md-4 control-label label-base-gaichyu">外注先 :</label>
                        <div class="col-md-8">
                            <select class="form-control"  name="sale_base_edit"  id="sale_base_edit">
                            </select>
                            <span></span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6 flag-to flag-gaichyn" style="display: none">
                    <div class="form-group">
                        <label class="col-md-4 control-label">売上単価:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control " name="sale_price_edit"  id="sale_price_edit" disabled >
                        </div>
                    </div>
                </div>
                </div>
                <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6 flag-to flag-gaichyn" style="display: none">
                    <div class="form-group">
                        <label class="col-md-4 control-label">担当者:</label>
                        <div class="col-md-8">
                            <label id="sale_price_user_edit"></label>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6 flag-gaichyn" style="display: none">
                    <div class="form-group">
                        <label class="col-md-4 control-label">外注専用単価:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control " name="sale_price_gaichyu_edit"  id="sale_price_gaichyu_edit" disabled >
                        </div>
                    </div>
                </div>

                
                </div>
                <div class="row">
                <div class="col-sm-12 col-md-12 col-lg-12" style="text-align:center;margin-top: 10px;">
                    <input type="hidden" id="sale_id_price_edit" >
                    <a id="btnEditPriceSale" class="print print-edit" style="display: none;">保存</a>
                </div>
            </div>
        </form>
      </div>
    </div>
 
  </div>
</div>
 
<!-- Modal import -->
<div id="myModalImport" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title modal-title-add" style="display: none;">新規作成</h4>
        <h4 class="modal-title modal-title-edit" style="display: none;">編集</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" id="form_add_price_import">
            <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">仕入先:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control"  name="import_place_buy"  id="import_place_buy">
                            <?php 
                            if(isset($list_buy)) {
                            foreach ($list_buy as $key => $value) {
                                        echo '<option value="'.$value[SUP_ID].'" title="'.$value[SUP_SUPPLIER_COMPANY_NAME].'">'.$value[SUP_SUPPLIER_COMPANY_NAME].'</option>';
                                    } } ?>
                            </select>
                            <span></span>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div id="getBoxRowImport">
                    <div class="boxRowPriceExport">
                    <div class="col-md-11">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                        <hr style="margin-top: 0px;margin-bottom: 10px;border-top: 1px solid #e5e5e5;">
                        </div>

                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label class="col-md-4 control-label">商品コード:<span class="label-form-request">*</span></label>
                                <div class="col-md-8">
                                <input class="form-control import_product" name="import_product" >
                                    <span></span>
                                </div>
                            </div>
                        </div>
                        
                        

                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label class="col-md-4 control-label">仕入単価:<span class="label-form-request">*</span></label>
                                <div class="col-md-8">
                                    <input class="form-control import_price" name="import_price" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label class="col-md-4 control-label">備考:</label>
                                <div class="col-md-8">
                                    <input class="form-control import_note" name="import_note" >
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-1">
                    <a class="btnDeleteBoxRowImport">
                    <img style="margin-top: 16px;" src="<?= base_url("asset/img/del.png") ?>">
                    </a>                     
                    </div>
                    </div>
                </div>
                <div id="setBoxRowImport">
                </div>

                <div class="modal-footer col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
                    <a id="btnAddPriceImport" class="print print-add" style="display: none;">保存</a>
                    <input type="button" id="addRowImport" class="print" value="行挿入">
                </div>
            </div>
        </form>
      </div>
    </div>
 
  </div>
</div>

<div id="myModalImportEdit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title modal-title-add" style="display: none;">新規作成</h4>
        <h4 class="modal-title modal-title-edit" style="display: none;">編集</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" id="form_edit_price_import">
            <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">商品名:</label>
                        <div class="col-md-8">
                            <select class="form-control" name="import_product_edit"  id="import_product_edit">
                                    <?php 
                                    if(isset($list_product)) {
                                    foreach ($list_product as $key => $value) {
                                        echo '<option value="'.$value[PL_PRODUCT_ID].'" title="'.$value[PL_PRODUCT_NAME_BUY].'">'.$value[PL_PRODUCT_NAME_BUY].'</option>';
                                    } }
                                     ?>
                            </select>
                            <span></span>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">仕入先:</label>
                        <div class="col-md-8">
                            <select class="form-control"  name="import_place_buy_edit"  id="import_place_buy_edit">
                            <?php 
                            if(isset($list_buy)) {
                            foreach ($list_buy as $key => $value) {
                                        echo '<option value="'.$value[SUP_ID].'" title="'.$value[SUP_SUPPLIER_COMPANY_NAME].'">'.$value[SUP_SUPPLIER_COMPANY_NAME].'</option>';
                                    } }
                                     ?>
                            </select>
                            <span></span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">仕入単価:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control " name="import_price_edit"  id="import_price_edit" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">備考:</label>
                        <div class="col-md-8">
                            <input class="form-control " name="import_note_edit"  id="import_note_edit" >
                        </div>
                    </div>
                </div>
                <div class="modal-footer col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
                    <input type="hidden" id="import_id_price_edit" >
                    <a id="btnEditPriceImport" class="print print-edit" style="display: none;">保存</a>
                </div>
            </div>
        </form>
      </div>
    </div>
 
  </div>
</div>


<!-- Modal Export -->
<div id="myModalExport" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!-- Modal content-->
    <div class="modal-content"> 
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title modal-title-add" style="display: none;">新規作成</h4>
        <h4 class="modal-title modal-title-edit" style="display: none;">編集</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" id="form_add_price_export">
            <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">売上先:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <select class="form-control"  name="export_place_sale"  id="export_place_sale">
                            <?php 
                            if(isset($list_sell)) {
                            foreach ($list_sell as $key => $value) {
                                        echo '<option value="'.$value[TSD_ID].'" title="'.$value[TSD_DISTRIBUTOR_NAME].'">'.$value[TSD_DISTRIBUTOR_NAME].'</option>';
                                    } }
                                     ?>
                            </select>
                            <span></span>
                        </div>
                    </div> 
                </div>
                <div class="clearfix"></div>

                <div id="getBoxRow">
                    <div class="boxRowPriceExport">
                    <div class="col-md-11">
                        <div class="col-sm-12 col-md-12 col-lg-12">
                        <hr style="margin-top: 0px;margin-bottom: 10px;border-top: 1px solid #e5e5e5;">
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label class="col-md-4 control-label">商品コード:<span class="label-form-request">*</span></label>
                                <div class="col-md-8">
                                    <input class="form-control export_product" name="export_product" >
                                    <span></span>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label class="col-md-4 control-label">売上単価:<span class="label-form-request">*</span></label>
                                <div class="col-md-8">
                                    <input class="form-control export_price" name="export_price" >
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label class="col-md-4 control-label">備考:</label>
                                <div class="col-md-8">
                                    <input class="form-control export_note" name="export_note" >
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1">
                    <a class="btnDeleteBoxRowExport">
                    <img style="margin-top: 16px;" src="<?= base_url("asset/img/del.png") ?>">
                    </a>                     
                    </div>
                    </div>
                </div>
                <div id="setBoxRow">
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
                    <a id="btnAddPriceExport" class="print print-add" style="display: none;">保存</a>

                    <input type="button" id="addRow" class="print" value="行挿入">
                </div>
            </div>
        </form>
      </div>
    </div>
 
  </div>
</div>

<div id="myModalExportEdit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content"> 
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title modal-title-add" style="display: none;">新規作成</h4>
        <h4 class="modal-title modal-title-edit" style="display: none;">編集</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" role="form" id="form_edit_price_export">
            <div class="row">

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">商品名:</label>
                        <div class="col-md-8">
                            <select class="form-control" name="export_product_edit"  id="export_product">
                                    <?php 
                                    if(isset($list_product)) {
                                    foreach ($list_product as $key => $value) {
                                        echo '<option value="'.$value[PL_PRODUCT_ID].'" title="'.$value[PL_PRODUCT_NAME_BUY].'">'.$value[PL_PRODUCT_NAME_BUY].'</option>';
                                    } }
                                     ?>
                                </select>
                            </select>
                            <span></span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">売上先:</label>
                        <div class="col-md-8">
                            <select class="form-control"  name="export_place_sale_edit"  id="export_place_sale_edit">
                            <?php 
                            if(isset($list_sell)) {
                            foreach ($list_sell as $key => $value) {
                                        echo '<option value="'.$value[TSD_ID].'" title="'.$value[TSD_DISTRIBUTOR_NAME].'">'.$value[TSD_DISTRIBUTOR_NAME].'</option>';
                                    } } ?>
                            </select>
                            <span></span>
                        </div>
                    </div> 
                </div>

                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">売上単価:<span class="label-form-request">*</span></label>
                        <div class="col-md-8">
                            <input class="form-control " name="export_price_edit"  id="export_price" >
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <label class="col-md-4 control-label">備考:</label>
                        <div class="col-md-8">
                            <input class="form-control " name="export_note_edit"  id="export_note" >
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="modal-footer col-sm-12 col-md-12 col-lg-12" style="text-align:center;">
                    <input type="hidden" id="export_id_price_edit" >
                    <a id="btnEditPriceExport" class="print print-edit" style="display: none;">保存</a>
                </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    var priceProductSale = "<?= base_url("master/product_price/get_product_price_sale") ?>";
    var priceProductImport = "<?= base_url("master/product_price/get_product_price_import") ?>";
    var priceProductExport = "<?= base_url("master/product_price/get_product_price_export") ?>";
    var editPriceProductSale = "<?= base_url("master/product_price/edit") ?>";
    var addPriceProductSale = "<?= base_url("master/product_price/add") ?>";
    var addPostPriceProductSale = "<?= base_url("master/product_price/add_post") ?>";
    var editPostPriceProductSale = "<?= base_url("master/product_price/edit_post") ?>";
    var deletePostPriceProductSale = "<?= base_url("master/product_price/delete_post") ?>";
    var urlImage = "<?= site_url('asset/img/') ?>";
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var message_confirm_delete_field = "<?= $this->lang->line('message_confirm_delete_field')?>";
    var message_exits_id_error = "<?= $this->lang->line('message_exits_id_error')?>";
    var jquery_validation_extension = "<?= $this->lang->line('jquery_validation_extension')?>";
    var urlIndex = "<?= base_url("master/product_price") ?>";
    var type_list = "<?= $this->input->get('type'); ?>";

    var url_export_sale = "<?= base_url("master/product_price_sale/export") ?>";
    var url_import_sale = "<?= base_url("master/product_price_sale/import") ?>";
    var url_export_import = "<?= base_url("master/product_price_import/export") ?>";
    var url_import_import = "<?= base_url("master/product_price_import/import") ?>";
    var url_export_export = "<?= base_url("master/product_price_export/export") ?>";
    var url_import_export = "<?= base_url("master/product_price_export/import") ?>";
    var CUS_ID = "<?= CUS_ID ?>";
    var CUS_CUSTOMER_NAME = "<?= CUS_CUSTOMER_NAME ?>";
    var BM_BASE_CODE = "<?= BM_BASE_CODE ?>";
    var BM_BASE_NAME = "<?= BM_BASE_NAME ?>";
    var get_product_selectbox = "<?= base_url("product/get_product_selectbox") ?>";
    var get_customer_selectbox = "<?= base_url("customer/get_customer_selectbox") ?>";
    var get_infor_customer = "<?= base_url("customer/get_infor_customer") ?>";
    var getDetailProduct = "<?= base_url("shipment/get-detail-product") ?>";
</script>
