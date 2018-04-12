<style>
.user .right-75 {
    float: right;
    margin-right: 10%;
    height: 30px;
}
.box-disabled-role {
    pointer-events: none;
    opacity: 0.7;
}
</style>
<div class="wrapper-contain user">
    <div class="row">
        <div class="col-sm-12"> 
            <h3><?php echo $page_name; ?></h3>
        </div>  
    </div> 
    
    <form action="" method="POST" id="form_add_user">
        <div class="row first-row">
            <div class="col-md-4 col-sm-6 col-md-offset-2">
                <label class="label-form" >ユーザ名:</label> <?php if($disable_user){ echo "<input id='form_username' class='right-75' value='{$user[U_ID]}' disabled name='".U_ID."' required>"; } else {?><input  id="form_username" class="right-75"  value="<?php echo isset($user)? $user[U_ID] : ''; ?>" name="<?php echo U_ID; ?>">  <?php } ?>
            </div>
            <div class="col-md-4 col-sm-6">
                <label class="label-form">役職:</label><input class="right-75" value="<?php echo isset($user)? $user[U_POSITION] : ''; ?>" name="<?php echo U_POSITION; ?>">  
            </div>
            <div class="col-md-4 col-sm-6 col-md-offset-2">
                <label class="label-form">氏名:<span class="label-form-request">*</span></label><input class="right-75" id="form_user_name" value="<?php echo isset($user)? $user[U_NAME] : ''; ?>" name="<?php echo U_NAME; ?>">   
            </div>
            <div class="col-md-4 col-sm-6">
                <label class="label-form">シメイ:</label><input class="right-75" value="<?php echo isset($user)? $user[U_SHIMEI] : ''; ?>" name="<?php echo U_SHIMEI; ?>">   
            </div>
             <div class="col-md-4 col-sm-6 col-md-offset-2">
                <label class="label-form">パスワード:</label><input class="right-75" value="" name="<?php echo U_PASSWORD; ?>" type="password">  
            </div>
             <div class="col-md-4 col-sm-6">
                <label class="label-form">パスワード確認:</label><input class="right-75" value="" name="confirm-password" type="password"> 
            </div>

            <div class="col-md-4 col-sm-6 col-md-offset-2">
                <label class="label-form">内線番号:</label><input class="right-75" id="form_user_phone" value="<?php echo isset($user)? $user[U_EXTENSION_NUMBER] : ''; ?>" name="<?php echo U_EXTENSION_NUMBER; ?>">  
            </div>
             <div class="col-md-4 col-sm-6">
                <label class="label-form">直通TEL:</label><input class="right-75" id="form_user_tel" value="<?php echo isset($user)? $user[U_COMPANY_DIRECT_LINE_TEL] : ''; ?>" name="<?php echo U_COMPANY_DIRECT_LINE_TEL; ?>">  
            </div>
             <div class="col-md-4 col-sm-6 col-md-offset-2">
                <label class="label-form">拠点コード:<span class="label-form-request">*</span></label>
                <?php
                $disableUser = "";
                $styleUser = "";
                if($user['customer_id'] != null && $user['customer_id'] != "") {
                    $disableUser = "disabled";
                    $styleUser = "background-color: rgb(235, 235, 228);";
                }
                ?>
                <select class="form-control right-75" style="<?php echo $styleUser; ?>" id="form_base" <?php echo $disableUser; ?> name="<?php echo U_BASE_CODE; ?>">
                    <option></option>
                    <?php 
                    if(isset($baseMaster)) {
                    foreach($baseMaster as $base) { ?>
                    <option value="<?php echo $base[BM_BASE_CODE]; ?>" <?php if(isset($user) and $user[U_BASE_CODE] == $base[BM_BASE_CODE]) echo 'selected'; ?>><?php echo $base[BM_BASE_NAME]; ?></option>
                    <?php } } ?>
                </select>
            </div>
           

           
           
        </div>
        <div class="wrapper">
            <div class="title"><h3><?php echo $this->lang->line('user_permission'); ?></h3></div>
            <div class="content">
                <?php if($user[U_ID] == $user_id) { ?>
                <div class="row lst-checkbox box-disabled-role">
                <?php } else { ?> 
                    <div class="row lst-checkbox">
                <?php } ?>
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group custom-form-group">
                            <input type="checkbox" name="gr[<?php echo GR_SYSTEM_ADMINISTRATOR; ?>]" id="fancy-checkbox-primary<?php echo GR_SYSTEM_ADMINISTRATOR; ?>" autocomplete="off" value="<?php echo GR_SYSTEM_ADMINISTRATOR; ?>" <?php if(isset($user) and isset($user[U_USER_GROUP][GR_SYSTEM_ADMINISTRATOR])){echo 'checked';} ?>>
                            <div class="btn-group">
                                <label for="fancy-checkbox-primary<?php echo GR_SYSTEM_ADMINISTRATOR; ?>" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span>&nbsp;</span>
                                </label>
                                <label for="fancy-checkbox-primary<?php echo GR_SYSTEM_ADMINISTRATOR; ?>" class="btn-text-role btn btn-default active">
                                    システム管理者
                                </label>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-4 col-sm-6">
                        <div class="form-group custom-form-group">
                            <input type="checkbox" name="gr[<?php echo GR_TOKYO_OTHER_ORDERING_PERSON; ?>]" id="fancy-checkbox-primary<?php echo GR_TOKYO_OTHER_ORDERING_PERSON; ?>" autocomplete="off" value="<?php echo GR_TOKYO_OTHER_ORDERING_PERSON; ?>" <?php if(isset($user) and isset($user[U_USER_GROUP][GR_TOKYO_OTHER_ORDERING_PERSON])){echo 'checked';} ?>>
                            <div class="btn-group">
                                <label for="fancy-checkbox-primary<?php echo GR_TOKYO_OTHER_ORDERING_PERSON; ?>" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span>&nbsp;</span>
                                </label>
                                <label for="fancy-checkbox-primary<?php echo GR_TOKYO_OTHER_ORDERING_PERSON; ?>" class="btn-text-role btn btn-default active">
                                    東京他 発注担当者
                                </label>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-4 col-sm-6">
                        <div class="form-group custom-form-group">
                            <input type="checkbox" name="gr[<?php echo GR_SUBCONTRACTOR_LOCAL; ?>]" id="fancy-checkbox-primary<?php echo GR_SUBCONTRACTOR_LOCAL; ?>" autocomplete="off" value="<?php echo GR_SUBCONTRACTOR_LOCAL; ?>" <?php if(isset($user) and isset($user[U_USER_GROUP][GR_SUBCONTRACTOR_LOCAL])){echo 'checked';} ?>>
                            <div class="btn-group">
                                <label for="fancy-checkbox-primary<?php echo GR_SUBCONTRACTOR_LOCAL; ?>" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span>&nbsp;</span>
                                </label>
                                <label for="fancy-checkbox-primary<?php echo GR_SUBCONTRACTOR_LOCAL; ?>" class="btn-text-role btn btn-default active">
                                    外注先（地方他)
                                </label>
                            </div>
                        </div>
                    </div>
                  
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group custom-form-group">
                            <input type="checkbox" name="gr[<?php echo GR_ORDER_MANAGEMENT_PERSONNEL; ?>]" id="fancy-checkbox-primary<?php echo GR_ORDER_MANAGEMENT_PERSONNEL; ?>" autocomplete="off" value="<?php echo GR_ORDER_MANAGEMENT_PERSONNEL; ?>" <?php if(isset($user) and isset($user[U_USER_GROUP][GR_ORDER_MANAGEMENT_PERSONNEL])){echo 'checked';} ?>>
                            <div class="btn-group">
                                <label for="fancy-checkbox-primary<?php echo GR_ORDER_MANAGEMENT_PERSONNEL; ?>" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span>&nbsp;</span>
                                </label>
                                <label for="fancy-checkbox-primary<?php echo GR_ORDER_MANAGEMENT_PERSONNEL; ?>" class="btn-text-role btn btn-default active">
                                    注文管理担当者
                                </label>
                            </div>
                        </div>
                    </div>
                      <div class="col-md-4 col-sm-6">
                        <div class="form-group custom-form-group">
                            <input type="checkbox" name="gr[<?php echo GR_ATSUGI_FACTORY_PERSONNEL; ?>]" id="fancy-checkbox-primary<?php echo GR_ATSUGI_FACTORY_PERSONNEL; ?>" autocomplete="off" value="<?php echo GR_ATSUGI_FACTORY_PERSONNEL; ?>" <?php if(isset($user) and isset($user[U_USER_GROUP][GR_ATSUGI_FACTORY_PERSONNEL])){echo 'checked';} ?>>
                            <div class="btn-group">
                                <label for="fancy-checkbox-primary<?php echo GR_ATSUGI_FACTORY_PERSONNEL; ?>" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span>&nbsp;</span>
                                </label>
                                <label for="fancy-checkbox-primary<?php echo GR_ATSUGI_FACTORY_PERSONNEL; ?>" class="btn-text-role btn btn-default active">
                                    厚木出荷担当者
                                </label>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-4 col-sm-6">
                        <div class="form-group custom-form-group">
                            <input type="checkbox" name="gr[<?php echo GR_SUBCONTRACTOR_TENANT; ?>]" id="fancy-checkbox-primary<?php echo GR_SUBCONTRACTOR_TENANT; ?>" autocomplete="off" value="<?php echo GR_SUBCONTRACTOR_TENANT; ?>" <?php if(isset($user) and isset($user[U_USER_GROUP][GR_SUBCONTRACTOR_TENANT])){echo 'checked';} ?>>
                            <div class="btn-group">
                                <label for="fancy-checkbox-primary<?php echo GR_SUBCONTRACTOR_TENANT; ?>" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span>&nbsp;</span>
                                </label>
                                <label for="fancy-checkbox-primary<?php echo GR_SUBCONTRACTOR_TENANT; ?>" class="btn-text-role btn btn-default active">
                                    外注先（テナント)
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group custom-form-group">
                            <input type="checkbox" name="gr[<?php echo GR_ORDER_MANAGEMENT_OFFICER; ?>]" id="fancy-checkbox-primary<?php echo GR_ORDER_MANAGEMENT_OFFICER; ?>" autocomplete="off" value="<?php echo GR_ORDER_MANAGEMENT_OFFICER; ?>" <?php if(isset($user) and isset($user[U_USER_GROUP][GR_ORDER_MANAGEMENT_OFFICER])){echo 'checked';} ?>>
                            <div class="btn-group">
                                <label for="fancy-checkbox-primary<?php echo GR_ORDER_MANAGEMENT_OFFICER; ?>" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span>&nbsp;</span>
                                </label>
                                <label for="fancy-checkbox-primary<?php echo GR_ORDER_MANAGEMENT_OFFICER; ?>" class="btn-text-role btn btn-default active">
                                    注文管理責任者
                                </label>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-4 col-sm-6">
                        <div class="form-group custom-form-group">
                            <input type="checkbox" name="gr[<?php echo GR_PURCHASING_MANAGEMENT_PERSONNEL; ?>]" id="fancy-checkbox-primary<?php echo GR_PURCHASING_MANAGEMENT_PERSONNEL; ?>" autocomplete="off" value="<?php echo GR_PURCHASING_MANAGEMENT_PERSONNEL; ?>" <?php if(isset($user) and isset($user[U_USER_GROUP][GR_PURCHASING_MANAGEMENT_PERSONNEL])){echo 'checked';} ?>>
                            <div class="btn-group">
                                <label for="fancy-checkbox-primary<?php echo GR_PURCHASING_MANAGEMENT_PERSONNEL; ?>" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span>&nbsp;</span>
                                </label>
                                <label for="fancy-checkbox-primary<?php echo GR_PURCHASING_MANAGEMENT_PERSONNEL; ?>" class="btn-text-role btn btn-default active">
                                    仕入管理担当者
                                </label>
                            </div>
                        </div>
                    </div>
                      <div class="col-md-4 col-sm-6">
                        <div class="form-group custom-form-group">
                            <input type="checkbox" name="gr[<?php echo GR_MANAGEMENT_DATA_ALL; ?>]" id="fancy-checkbox-primary<?php echo GR_MANAGEMENT_DATA_ALL; ?>" autocomplete="off" value="<?php echo GR_MANAGEMENT_DATA_ALL; ?>" <?php if(isset($user) and isset($user[U_USER_GROUP][GR_MANAGEMENT_DATA_ALL])){echo 'checked';} ?>>
                            <div class="btn-group">
                                <label for="fancy-checkbox-primary<?php echo GR_MANAGEMENT_DATA_ALL; ?>" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span>&nbsp;</span>
                                </label>
                                <label for="fancy-checkbox-primary<?php echo GR_MANAGEMENT_DATA_ALL; ?>" class="btn-text-role btn btn-default active">
                                    管理データ（全部）
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group custom-form-group">
                            <input type="checkbox" name="gr[<?php echo GR_SALES_MANAGEMENT_PERSONNEL; ?>]" id="fancy-checkbox-primary<?php echo GR_SALES_MANAGEMENT_PERSONNEL; ?>" autocomplete="off" value="<?php echo GR_SALES_MANAGEMENT_PERSONNEL; ?>" <?php if(isset($user) and isset($user[U_USER_GROUP][GR_SALES_MANAGEMENT_PERSONNEL])){echo 'checked';} ?>>
                            <div class="btn-group">
                                <label for="fancy-checkbox-primary<?php echo GR_SALES_MANAGEMENT_PERSONNEL; ?>" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span>&nbsp;</span>
                                </label>
                                <label for="fancy-checkbox-primary<?php echo GR_SALES_MANAGEMENT_PERSONNEL; ?>" class="btn-text-role btn btn-default active">
                                    売上管理担当者
                                </label>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-4 col-sm-6">
                        <div class="form-group custom-form-group">
                            <input type="checkbox" name="gr[<?php echo GR_PURCHASE_MANAGEMENT_OFFICER; ?>]" id="fancy-checkbox-primary<?php echo GR_PURCHASE_MANAGEMENT_OFFICER; ?>" autocomplete="off" value="<?php echo GR_PURCHASE_MANAGEMENT_OFFICER; ?>" <?php if(isset($user) and isset($user[U_USER_GROUP][GR_PURCHASE_MANAGEMENT_OFFICER])){echo 'checked';} ?>>
                            <div class="btn-group">
                                <label for="fancy-checkbox-primary<?php echo GR_PURCHASE_MANAGEMENT_OFFICER; ?>" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span>&nbsp;</span>
                                </label>
                                <label for="fancy-checkbox-primary<?php echo GR_PURCHASE_MANAGEMENT_OFFICER; ?>" class="btn-text-role btn btn-default active">
                                    仕入管理責任者
                                </label>
                            </div>
                        </div>
                    </div>
                     <div class="col-md-4 col-sm-6">
                        <div class="form-group custom-form-group">
                            <input type="checkbox" name="gr[<?php echo GR_MANAGEMENT_DATA_PERSONAL; ?>]" id="fancy-checkbox-primary<?php echo GR_MANAGEMENT_DATA_PERSONAL; ?>" autocomplete="off" value="<?php echo GR_MANAGEMENT_DATA_PERSONAL; ?>" <?php if(isset($user) and isset($user[U_USER_GROUP][GR_MANAGEMENT_DATA_PERSONAL])){echo 'checked';} ?>>
                            <div class="btn-group">
                                <label for="fancy-checkbox-primary<?php echo GR_MANAGEMENT_DATA_PERSONAL; ?>" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span>&nbsp;</span>
                                </label>
                                <label for="fancy-checkbox-primary<?php echo GR_MANAGEMENT_DATA_PERSONAL; ?>" class="btn-text-role btn btn-default active">
                                    管理データ（拠点）
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group custom-form-group">
                            <input type="checkbox" name="gr[<?php echo GR_SALES_MANAGEMENT_OFFICER; ?>]" id="fancy-checkbox-primary<?php echo GR_SALES_MANAGEMENT_OFFICER; ?>" autocomplete="off" value="<?php echo GR_SALES_MANAGEMENT_OFFICER; ?>" <?php if(isset($user) and isset($user[U_USER_GROUP][GR_SALES_MANAGEMENT_OFFICER])){echo 'checked';} ?>>
                            <div class="btn-group">
                                <label for="fancy-checkbox-primary<?php echo GR_SALES_MANAGEMENT_OFFICER; ?>" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span>&nbsp;</span>
                                </label>
                                <label for="fancy-checkbox-primary<?php echo GR_SALES_MANAGEMENT_OFFICER; ?>" class="btn-text-role btn btn-default active">
                                    売上管理責任者
                                </label>
                            </div>
                        </div>
                    </div>
                   
                  
                   
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group custom-form-group">
                            <input type="checkbox" name="gr[<?php echo GR_CUSTOMERS; ?>]" id="fancy-checkbox-primary<?php echo GR_CUSTOMERS; ?>" autocomplete="off" value="<?php echo GR_CUSTOMERS; ?>" <?php if(isset($user) and isset($user[U_USER_GROUP][GR_CUSTOMERS])){echo 'checked';} ?>>
                            <div class="btn-group">
                                <label for="fancy-checkbox-primary<?php echo GR_CUSTOMERS; ?>" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span>&nbsp;</span>
                                </label>
                                <label for="fancy-checkbox-primary<?php echo GR_CUSTOMERS; ?>" class="btn-text-role btn btn-default active">
                                    得意先
                                </label>
                            </div>
                        </div>
                    </div>
                   
                   
                   
                    <div class="col-md-4 col-sm-6">
                        <div class="form-group custom-form-group">
                            <input type="checkbox" name="gr[<?php echo GR_MASTER_ADMINISTRATOR; ?>]" id="fancy-checkbox-primary<?php echo GR_MASTER_ADMINISTRATOR; ?>" autocomplete="off" value="<?php echo GR_MASTER_ADMINISTRATOR; ?>" <?php if(isset($user) and isset($user[U_USER_GROUP][GR_MASTER_ADMINISTRATOR])){echo 'checked';} ?>>
                            <div class="btn-group">
                                <label for="fancy-checkbox-primary<?php echo GR_MASTER_ADMINISTRATOR; ?>" class="btn btn-primary">
                                    <span class="glyphicon glyphicon-ok"></span>
                                    <span>&nbsp;</span>
                                </label>
                                <label for="fancy-checkbox-primary<?php echo GR_MASTER_ADMINISTRATOR; ?>" class="btn-text-role btn btn-default active">
                                    マスタ管理者
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:18px;margin-bottom:9px;">
            <div class="wrap-table" style="display:none;margin:0 auto;">
                <b>担当設定</b>
                <div class="row" style="display:table;margin:0 auto;">
                    <label>種別:</label> <select><option>得意先</option></select>
                    <input type="checkbox" class=""  value="" style="margin-left:5px;" ><lable>東京</lable>
                    <input type="checkbox" class=""  value="" ><lable>幕張</lable>
                    <input type="checkbox" class=""  value="" ><lable>横浜</lable>
                    <input type="checkbox" class=""  value="" ><lable>大阪</lable>
                    <input type="checkbox" class=""  value="" ><lable>博多</lable>								
                    <button>対象リスト表示</button>
                </div>
                <div class="row" style="">
                    <table style="display:table;margin:0 auto;margin-top:9px;">
                        <tr>
                            <td>対象リスト</td>
                            <td></td>
                            <td>担当設定</td>
                        </tr>
                        <tr>
                            <td style="width:250px;height:250px;border:1px solid #838383;background:#eaeaea;border-radius:4px;"></td>
                            <td style="background:white;">
                                <a href="#" style="padding:10px 5px 10px 5px ;"><i class="fa fa-arrow-right" aria-hidden="true"></i></a><br/><a href="#" style="padding:10px 5px 10px 5px ;">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                </a>
                            </td>
                            <td style="width:250px;height:250px;border:1px solid #838383;background:#eaeaea;border-radius:4px;"></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="row third-row" style="text-align:center;">
                <!-- <input type="submit" class="print" onclick="return validateSubmit()" value="保存"> -->
                <a id="onClickAdd" class="print" style="width: 105px;">保存</a>
            </div>
        </div>
        <input type="hidden" id="username" name="username" value="<?= $this->input->get('i')?>" >
    </form>
</div>
<div id="forNotification"></div>
<script type="text/javascript">
    var editPostMasterUser = "<?= base_url("master/user/edit_post") ?>";
    var invalid_user_registration = '<?php echo $this->lang->line('invalid_user_registration'); ?>';
    var password_not_match = '<?php echo $this->lang->line('password-not-match-confirm'); ?>';
    var u_id = '<?php echo U_ID; ?>';
    var u_password = '<?php echo U_PASSWORD; ?>';
    var message = "<?php echo isset($successMessage)? $successMessage : isset($errorMessage)? $errorMessage : ''; ?>";
    var user_already_existed = '<?php echo $this->lang->line('user_existed'); ?>';
    var errorAjax = "<?= $this->lang->line('message_error_ajax')?>";
    var urlIndex = "<?= base_url("master/user") ?>";
</script>