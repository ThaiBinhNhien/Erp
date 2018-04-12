<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

// CONFIG
define('CONFIG_CONSUMPTION_TAX',0.08);
define('CONFIG_NUM_CONTWEIGHT',80);
define('HANDLING_FEE',0.01);
define('EXP_USABILITY',3);
define('EXP_USABILITY_LIMIT',5000);
define('MAX_CONTAINER',100);
define('DEPARTMENT_SHIPMENT_COPY_ORDER',99);
define('TOKEN_SOCKET','zXkRE3w4i1b7AERiFkgyCCg7UQaV4ReT');
define('SORT_MASTER',"ASC");

// CONFIG SHIPMENT
define('DEFAULT_SHIPMENT_SHIP',1);

//CUSTOMER
define('CUSTOMER','得意先');
define('CUS_ID','得意先コード');
define('CUS_READING','ﾌﾘｶﾞﾅ'); 
define('CUS_CUSTOMER_NAME','得意先名');
define('CUS_CUSTOMER_SHORT_NAME','得意先略称');
//define('CUS_USER_ID','担当者');
define('CUS_POSTAL_CODE','郵便番号');
define('CUS_ADDRESS_1','住所1');
define('CUS_ADDRESS_2','住所2');
define('CUS_PHONE_NUMBER','電話番号');
define('CUS_FACSIMILE','ファクシミリ');
define('CUS_CLOSING_DATE_CODE','締日コード');
define('CUS_GREEN_PARK_SEGMENT','グリーンパーク区分');
define('CUS_TYPE_CUSTOMER','得意先区分');
define('CUS_ACCOUNT_ID','外注');

//PRODUCT SET [order]
define('PRODUCT_SET','商品セット名');
define('PS_PRODUCT_SET_NAME','商品セット名');
define('PS_PRODUCT_SET_CODE','商品セットコード');

//PRODUCT SET [shipment]
define('PRODUCT_SET_SHIPMENT','商品セット名m');
define('PSS_PRODUCT_SET_NAME','商品セット名');
define('PSS_PRODUCT_SET_CODE','商品セットコードm');

define('PRODUCT_SET_CUSTOMER','基本顧客が設定した商品');
define('PSC_PRODUCT_SET_CODE','商品セットコード');
define('PSC_CUSTOMER_ID','得意先コード');
define('PSC_BASE_CODE','拠点コード');

//PRODUCT
define('PRODUCT_LEDGER','商品'); 
define('PL_PRODUCT_ID','商品ID');
define('PL_COLOR_TONE','色調');
define('PL_STANDARD','規格');
define('PL_ORGANIZATION_PILE','素材');
define('PL_ORGANIZATION_WEIGHT','組織_ﾊﾟｲﾙ･経･緯･目付'); // trọng lượng
define('PL_MAIN_USE','主な使用先');
define('PL_REMARKS','備考');
define('PL_REMARKS_2','備考_社外秘');
define('PL_STANDARD_STOCK_NUMBER','標準在庫数');
//define('PL_YUKATA_CLASSIFICATION_FOR_SALE','売却用浴衣区分');
define('PL_WASH_CLASSIFICATION','耐洗区分'); //phan loai rua :0: 1年未満  --> dùng 1 năm hết,1: 2年以内 --> dùng 2 năm hết
define('PL_LAUNDRY_SEGMENT','洗濯区分ID');//phan loai giat theo cot db
define('PL_CATEGORIES','商品区分');  // 1: 仕入品、hàng mua vào, 2: 洗剤 bột giặt -> 1 : Hang tolinen, 2: bot giat , null: hàng bán (không mua)
define('PL_DRY_PRESS_LAUNDRY_CLASSIFICATION','ドライ_プレス_ランドリー区分');
define('PL_1_CONTAINER_UPPER_LIMIT_MOUNTING_AMOUNT','１コンテナ上限搭載量');
define('PL_T_CATALOGUE','種目区分'); // hang muc mua 
define('PL_T_PRODUCT_CATEGORY_ID','カテゴリー仕入');//category mua //->GUI:  仕入区分コード
define('PL_SPECIAL','単価修正の有無');
//define('PL_USE_SALE','売却用区分');// 0 : ko dùng để bán , 1 : dùng để bán 
define('PL_PRODUCT_CODE_SALE','販売商品コード');
define('PL_PRODUCT_CODE_BUY','仕入商品コード'); 
define('PL_PRODUCT_NAME','販売商品名');
define('PL_PRODUCT_NAME_BUY','仕入商品名');
define('PL_PRODUCTION_SUMMARY_CODE','生産概要区分');
define('PL_NUMBER_PACKAGE','結束単位');//số lượng 1 gói

//define('PL_EVENT_CATEGORY','種目区分');//Hang muc ban
define('PL_PRODUCT_CATEGORY_ID','区分ｺｰﾄﾞ_売上');// 区分ｺｰﾄﾞ_売上 category ban ->GUI:  販売区分コード 
//define('PL_ORGANIZATION_CAL','組織_番手');
//define('PL_ORGANIZATION_DATE','組織_目付');
//define('PL_UNIT','単位');
//define('PL_PRODUCT_TYPE','単価修正の有無');// 0 : sản phẩm bình thường, 1 : sản phẩm đặc biệt // -->GUI: 種類
//define('PL_SELL_PRODUCT_ID','販売商品コード');  
//define('PL_BUY_PRODUCT_ID','仕入商品コード'); 
//define('PL_SELL_PRODUCT_NAME','販売商品名');
//define('PL_BUY_PRODUCT_NAME','仕入商品名');
//define('PL_TOKYO_FLAG','東京工場仕上げフラグ');
define('PL_TYPE_SHOW_ORDER','予備レコード'); //Phân biệt sản phẩm hiển thị bên bán hay không. Nếu = 1 ko hiển thị
 

// PRODUCT PRICE
define('PRODUCT_BASE','拠点別商品情報');
define('BB_ID', 'id');
define('BB_PRODUCT_CODE','商品コード');
define('BB_BASE_CODE','拠点コード');
define('BB_CUSTOMER_NUMBER','得意先コード');
define('BB_UNIT_SELLING_PRICE','販売単価');
define('BB_GAICHYU_PRICE','外注の単価');
define('BB_PRODUCT_NAME','商品名');

// ORDER
define('SALES_LEDGER','売上台帳');
define('SL_ID','伝票番号');
define('SL_CUSTOMER_ID','得意先コード');
define('SL_DEPARTMENT_CODE','部署コード');
define('SL_USER_ID','登録ユーザ'); // user đăng ký
define('SL_SALES_DATE','売上日'); // ngày order
define('SL_DELIVERY_DATE','納品予定日'); // ngày dự định giao hàng
define('SL_REVENUE_DATE','納品日'); // ngày giao hàng
define('SL_BASE_CODE','拠点コード');
define('SL_SUMMARY','摘要');
define('SL_TAX','消費税');
define('SL_ORDER_AMOUNT','注文金額合計');
define('SL_DELIVERY_AMOUNT','納品金額合計'); // tổng tiền giao hàng
define('SL_STATUS','形態'); // lưu, lưu tạm
define('SL_ORDER_CLASSIFICATION','注文区分とる');
define('SL_CLAIM_CHECK','請求書');
define('SL_CLAIM_CHECK_GAICHYU', '外注請求書形態'); //tình trạng tạo giấy đòi tiền của gaichyu
define('SL_DELIVERY_NOTE','納品備考');
define('SL_DATE_CHANGE','日の変更');
define('SL_NUMBER_ORDER_MODIFY','請求書変更の数');
define('SL_NUMBER_DELIVERY_MODIFY','納品回数の変更');
define('SL_FLG_COPY_SHIPMENT','Flg受発注取り込み');
define('SL_UPDATE_DATE', '更新日');

// 
define('DEPARTMENT_LEDGER','部署台帳');
define('DL_DEPARTMENT_CODE','部署コード');
define('DL_DEPARTMENT_NAME','部署名');
define('DL_AGGREGATION_CODE','集計ｺｰド');

// department shipment 
define('DEPARTMENT_SHIPMENT_LEDGER','部署m');
define('DSL_DEPARTMENT_CODE','部署ID');
define('DSL_DEPARTMENT_NAME','部署名');

//
define('CUSTOMER_DEPARTMENT','得意先部署');
define('CUS_DE_ID', 'id');
define('CD_CUSTOMER_ID','得意先コード');
define('CD_DEPARTMENT_CODE','部署コード');
define('CD_NOT_ASK_MONEY','請求書不要');
define('CD_USER_ID','担当者');
define('CD_FL_COPY_SHIPMENT','Flg受発注取り込み');

// for shipment
define('CUSTOMER_DEPARTMENT_SHIPMENT','得意先_部署m');
define('CDS_DE_ID','id');
define('CDS_CUSTOMER_ID','得意先');
define('CDS_DEPARTMENT_CODE','部署ID');

//
define('CALCULATION_CLASSIFICATION_LEDGER','集計区分台帳');
define('CCL_CATEGORY_CODE','区分コード');
define('CCL_CATEGORY_NAME','区分名'); 

// PRODUCT SET - PRODUCT
define('PRODUCT_SET_PRODUCT','商品セット');
define('PSP_PRODUCT_SET_CODE','商品セットコード');
define('PSP_PRODUCT_CODE','商品コード');
define('PSP_SERIAL_NUMBER','連番'); 

// PRODUCT SET - PRODUCT - shipment
define('PRODUCT_SET_PRODUCT_SHIPMENT','商品セットm');
define('PSPS_PRODUCT_ID','id');
define('PSPS_PRODUCT_SET_CODE','商品セットコードm');
define('PSPS_PRODUCT_CODE','商品コード');
define('PSPS_SERIAL_NUMBER','連番'); 

//
define('CATEGORIES','商品区分');
define('CATE_CATEGORY_CODE','商品区分ID');
define('CATE_CATEGORY_NAME','商品区分名');

//
define('ITEM_CLASSIFICATION_REGISTER','種目区分台帳');
define('ICR_EVENT_CATEGORY','種目区分');
define('ICR_ITEM_CATEGORY_NAME','種目区分名');

//
define('DRY_PRESS_LAUNDRY_CLASSIFICATION','ドライ_プレス_ランドリー区分');
define('DPLC_ID','ドライ_プレス_ランドリー区分');
define('DPLC_NAME','ドライ_プレス_ランドリー区分名');

// order detail
define('ORDER_DETAIL','注文伝票明細');
define('OD_ID','id');
define('OD_ORDER_ID','伝票番号');
define('OD_PRODUCT_CODE','商品コード');
define('OD_UNIT_PRICE','単価');
define('OD_QUANTITY','数量');
define('OD_ADD','追加');
define('OD_PRODUCT_NAME','商品名');

// delivery detail
define('DELIVERY_DETAIL','納品詳細');
define('DD_ID','id');
define('DD_ORDER_DETAIL_ID','注文伝票明細ID');
define('DD_ORDER_ID','伝票番号');
define('DD_PRODUCT_CODE','商品コード');
define('DD_UNIT_PRICE','単価');
define('DD_QUANTITY','数量');
define('DD_CHECK','チェック');
define('DD_DELIVERY_AMOUNT','納品金額');
define('DD_GAICHYU_PRICE','外注の単価');
define('DD_PRODUCT_NAME','商品名');

//
define('FLOOR','フロア');
define('F_ID','id');
define('F_FLOOR_CODE','フロアコード');
define('F_DETAIL_ID','明細番号');
define('F_FLOOR_NAME','フロア名');
define('F_QUANTITY','数量');

//Supplier 
define('T_SUPPLIER','t_仕入先');
define('SUP_ID','id');
define('SUP_SUPPLIER_COMPANY_NAME','仕入先会社名');
define('SUP_ADDRESS_1','住所1');
define('SUP_ADDRESS_2','住所2');
define('SUP_POSTAL_CODE','郵便番号');
define('SUP_PHONE_NUMBER','電話番号');
define('SUP_FAX_NUMBER','FAX番号');
define('SUP_CLOSING_DATE','締日');
define('SUP_PAYMENT_SITE','支払ｻｲﾄ');
define('SUP_USER_ID','ユーザID');
define('SUP_VENDOR_ID','仕入先区分ID');

//Processing content
define('T_PROCESSING_CONTENT','t_処理内容');
define('PC_ID','id');
define('PC_PROCESSING_CONTENT','処理内容');
define('PC_ORDER_CLASSIFICATION','発注区分');
define('PC_GOODS_RECEIPT_CLASSIFICATION','入庫区分');
define('PC_SHIPMENT_CATEGORY','出荷区分');
define('PC_PROCESSING_CONTENT_CLASSIFICATION','処理内容区分');

//
define('T_SALES_DESTINATION','t_販売先');
define('TSD_ID','id');
define('TSD_DISTRIBUTOR_NAME','販売先名');
define('TSD_POSTAL_CODE','郵便番号');
define('TSD_ADDRESS_1','住所1');
define('TSD_ADDRESS_2','住所2');
define('TSD_PHONE_NUMBER','電話番号');
define('TSD_FAX_NUMBER','FAX番号');
define('TSD_OUTSOURCING','外注');
define('TSD_USER_ID','ユーザID');
define('TSD_SELLERS_CATEGORY','販売先区分');

//
define('T_STOCK_PLACE','t_在庫場所');
define('TSP_ID','id');
define('TSP_INVENTORY_LOCATION','在庫場所');

//
define('USER_MASTER','ユーザマスタ');
define('U_ID','ユーザID'); // This is username
define('U_PASSWORD','パスワード');
define('U_NAME','氏名');
define('U_SHIMEI','シメイ');
define('U_BASE_CODE','拠点コード');
define('U_POSITION','役職');
define('U_EXTENSION_NUMBER','内線番号');
define('U_COMPANY_DIRECT_LINE_TEL','会社直通TEL');
define('U_USER_GROUP','ユーザグループ');
define('U_UPDATE_DATE', '更新日');

//
define('T_SUPPLIER_CLASSIFICATION','t_仕入先区分');
define('TSC_ID','id');
define('TSC_NAME','仕入先区分名');

//
define('T_PRODUCT_CATEGORY','t_商品区分');
define('ID','id');
define('TPC_NAME','商品区分名');

//
define('T_YUKATA_CLASSIFICATION','t_売却用浴衣区分');
define('TYC_ID','id');
define('TYC_NAME','T_売却用浴衣区分名');

//
define('T_EVENT','t_種目');  
define('TE_ID','id');
define('TE_ITEM_CATEGORY_NAME','種目区分名');
define('TE_TYPE_EVENT','Flg種目');
define('TE_FLG_OUTSOURCE','Flg外注分');

//
//define('T_SHIPMENT','T_出荷');// bảng xuất kho
define('T_ISSUE','t_出荷');
define('SHIP_ID','id');
define('SHIP_SHIPMENT_CONTENTS','出荷内容');
define('SHIP_DISTRIBUTOR_ID','販売先ID');
define('SHIP_EMPLOYEE_ID','社員ID');
define('SHIP_SHIP_DATE','出荷日');
define('SHIP_REQUEST_DATE','要求日');
define('SHIP_PROMISED_DATE','約束日');
define('SHIP_REGISTERED_USER','登録ユーザ');
define('SHIP_BASE_CODE','拠点コード');
define('SHIP_INVENTORY_LOCATION_ID','在庫場所ID');
define('SHIP_ISSUER','出庫者');
define('SHIP_GO_TO','移動先');
define('SHIP_REMARKS','備考');
define('SHIP_GOODS_RECEIPT_SLIP_ID','入庫伝票ID');
define('SHIP_SAVE_STATUS', '形態');
define('SHIP_UPDATE_DATE', '更新日');

//
define('BASE_MASTER','拠点マスタ'); 
define('BM_BASE_CODE','拠点コード'); 
define('BM_BASE_NAME','拠点名');
define('BM_COMPANY_NAME','会社名');
define('BM_POSTAL_CODE','郵便番号');
define('BM_PREFECTURES','都道府県');
define('BM_ADDRESS_1','住所1');
define('BM_ADDRESS_2','住所2');
define('BM_PHONE_NUMBER','電話番号');
define('BM_FAX_NUMBER','FAX番号');
define('BM_CLOSING_DATE','締日');
define('BM_BILLING_CLASSIFICATION','請求区分');
define('BM_PAYEE_1_BANK_NAME','振込先１＿銀行名');
define('BM_BANK_TRANSFER_1__BANK_NAME__ENGLISH','振込先１＿銀行名＿英語');
define('BM_PAYEE_1_BRANCH_NAME','振込先１＿支店名');
define('BM_PAYEE_1__BRANCH_NAME__ENGLISH','振込先１＿支店名＿英語');
define('BM_TRANSFER_DESTINATION_1__ACCOUNT_CLASSIFICATION','振込先１＿口座区分');
define('BM_PAYEE_1__ACCOUNT_NUMBER','振込先１＿口座番号');
define('BM_TRANSFER_DESTINATION_2_BANK_NAME','振込先２＿銀行名');
define('BM_TRANSFER_DESTINATION_2__BANK_NAME__ENGLISH','振込先２＿銀行名＿英語');
define('BM_BANK_TRANSFER_2_BRANCH_NAME','振込先２＿支店名');
define('BM_BANK_TRANSFER_2__BRANCH_NAME__ENGLISH','振込先２＿支店名＿英語');
define('BM_TRANSFER_DESTINATION_2_ACCOUNT_CLASSIFICATION','振込先２＿口座区分');
define('BM_TRANSFER_DESTINATION_2_ACCOUNT_NUMBER','振込先２＿口座番号');
define('BM_TRANSFER_DESTINATION_3_BANK_NAME','振込先３＿銀行名');
define('BM_TRANSFER_DESTINATION_3__BANK_NAME__ENGLISH','振込先３＿銀行名＿英語');
define('BM_PAYEE_3_BRANCH_NAME','振込先３＿支店名');
define('BM_TRANSFER_DESTINATION_3__BRANCH_NAME__ENGLISH','振込先３＿支店名＿英語');
define('BM_TRANSFER_DESTINATION_3_ACCOUNT_CLASSIFICATION','振込先３＿口座区分');
define('BM_TRANSFER_DESTINATION_3_ACCOUNT_NUMBER','振込先３＿口座番号');
define('BM_MASTER_CHECK','外注先Flg');

//Information of warehouse
define('T_GOODS_RECEIPT_INFORMATION','t_入出庫情報');
define('TGRI_ID','id');
define('TGRI_ACCRUAL_DATE','発生日');
define('TGRI_PRODUCT_ID','商品ID');
define('TGRI_PRODUCT_NAME','商品名'); 
define('TGRI_INVENTORY_LOCATION_ID','在庫場所ID');
define('TGRI_ORDER_SLIP_ID','発注伝票ID');
define('TGRI_GOODS_RECEIPT_SLIP_ID','入庫伝票ID');
define('TGRI_OUTBOUND_SLIP_ID','出荷伝票ID');
define('TGRI_PROCESSING_CONTENT','処理内容');
define('TGRI_UNIT_PRICE','仕入単価'); // Giá mua vào
define('TGRI_UNIT_PRICE_SELL','販売単価'); // Giá bán ra
define('TGRI_NUMBER_OF_ORDERS','発注数');
define('TGRI_GOODS_RECEIPT','入庫数');
define('TGRI_NUMBER_OF_GOODS_ISSUED','出庫数');
define('TGRI_NUMBER_OF_RETURNS','返品数');
define('TGRI_REMARKS','備考');
define('TGRI_A_DISPOSAL_DAY','処理日');
define('TGRI_GOODS_MOVE_OUT_CHECK','入出庫確認');
define('TGRI_REGISTERED_USER','登録ユーザ');
define('TGRI_BASE_CODE','拠点コード');
define('TGRI_DELETE_FLAG','削除フラグ');
define('TGRI_CUMULATIVE_GOODS_RECEIPT','入庫累計');
define('TGRI_NUMBER_HAS_EXPORT', '出庫数量_注文');//số lượng đã xuất của hóa đơn mua vào
define('TGRI_WAREHOUSE_HAS_EXPORT', '出庫済の出庫伝票ID');// id hóa đơn xuất kho đã lấy
define('TGRI_CHECK_PRICE','単価チェック');
define('TGRI_ID_RECEIPT_BY_EXPORT','出庫用入庫伝票ID');
define('TGRI_ID_SUPPLIER','仕入先ID');
define('TGRI_SALES_DES_ID', '販売先ID');

//Order 
define('T_ORDER','t_発注');
define('TO_ID','id');
define('TO_ORDER_DETAIL','発注内容ID');
define('TO_VENDOR_ID','仕入先ID');
define('TO_EMPLOYEE_ID','社員ID');
define('TO_ORDER_DATE','発注日');
define('TO_REQUEST_DATE','要求日');
define('TO_PROMISED_DATE','約束日');
define('TO_REGISTERED_USER','登録ユーザ');
define('TO_BASE_CODE','拠点コード');
define('TO_FORM','形態');
define('TO_RECEIPT','入庫');
define('TO_AUTHORIZER','承認者');
define('TO_DISCOUNT','割引');
define('TO_STREET_ADDRESS','住所');
define('TO_DELIVERY_DATE','納品日');
define('TO_REMARKS','備考');
define('TO_INVENTORY_LOCATION_ID','在庫場所ID');
define('TO_SALES_DESTINATION', '販売先ID');
define('TO_UPDATE_DATE', '更新日');

//Import order
define('T_GOODS_RECEIPT','t_入庫');
define('GR_ID','id');
define('GR_GOODS_RECEIPT_DETAIL','入庫内容');
define('GR_VENDOR_ID','仕入先ID');
define('GR_EMPLOYEE_ID','社員ID');
define('GR_ARRIVAL_DAY','入荷日');
define('GR_REQUEST_DATE','要求日');
define('GR_PROMISED_DATE','約束日');
define('GR_REGISTERED_USER','登録ユーザ');
define('GR_BASE_CODE','拠点コード');
define('GR_ORDER_SLIP_ID','発注伝票ID');
define('GR_INVENTORY_LOCATION_ID','在庫場所ID');
define('GR_UPDATE_DATE', '更新日');

//
define('T_PRODUCT_NUMBER_FOR_SUPPLIER','t_仕入先別商品コード');
define('TPNS_ID','id');
define('TPNS_VENDOR_ID','仕入先ID');
define('TPNS_ID_PRODUCT','商品ID');
define('TPNS_PURCHASE_PRICE','仕入単価');
define('TPNS_REMARKS','備考');

//
define('T_DESTINATION_PRODUCT_CODE_BY_TARGETED_PARTY','t_販売先別商品コード');
define('TPCT_ID','id');
define('TPCT_PRODUCT_ID','商品ID');
define('TPCT_SALEROOM','販売先ID');
define('TPCT_UNIT_SELLING_PRICE','販売単価');
define('TPCT_REMARKS','備考');

//
define('T_LAUNDRY_SEGMENT','t_洗濯区分');
define('TLG_ID','id');
define('TLG_NAME','洗濯区分名');

//
define('STOCK','在庫');
define('S_ID','id');
define('S_INVENTORY_LOCATION_ID','在庫場所ID');
define('S_PRODUCT_ID','商品ID');
define('S_STOCK_QUANTITY','在庫数量');

//INVOICE
define('INVOICE', '請求書');
define('I_ID', 'ID');
define('I_INVOICE_NUMBER', '請求書番号');
define('I_CUSTOMER_ID', '得意先コード');
//__Add 2018-01-18
define('I_OTHER_CUSTOMER', '得意先他');
define('I_DATE_CREATE', '作成日時');
define('I_REMARKS', '備考');
define('I_STREET_ADDRESS','住所');
define('I_HAVE_ORDER', '請求書を指定する');
define('I_USER_ID', 'ユーザID');
define('I_DEPARTMENT_ID', '部署ID');
define('I_TOTAL_PRICE', '金額');
define('I_PAID_DATE_START', 'お支払いの開始日');
define('I_PAID_DATE_END', '支払い終了日');
define('I_STATUS', '形態');
define('I_CHECK_UPDATE', '更新');
define('I_INVOICE_GROUP_ID', 'グループID');//nhóm giấy đòi tiền
define('I_DISCOUNT', '割引');
define('I_UPDATE_DATE', '更新日');

//INVOICE DETAIL
define('INVOICE_DETAIL', '請求書詳細');
define('ID_INVOICE_ID', '請求書ID');
define('ID_ORDER_ID', '注文ID');
define('ID_DISCOUNT_SUPPLIER','割引1'); //chiết khấu linen supplier
define('ID_DISCOUNT_ORTHER','割引2'); //chiết khấu linen khác

//INVOICE ORDER DETAIL(liên kết giấy đòi tiền ko chỉ định hóa đơn order và sản phẩm)
define('INVOICE_ORDER_DETAIL', '請求書発注詳細');
define('IOD_ID', 'ID');
define('IOD_INVOICE_ID', '請求書ID');
define('IOD_PRODUCT_ID', '商品ID');
define('IOD_AMOUNT', '数量');
define('IOD_PRICE', '単価');
define('IOD_SUM_PRICE', '金額');
define('IOD_PRODUCT_NAME','商品名');

define('INVOICE_GROUP','請求書グループ');
define('IG_ID','ID');
define('IG_INVOICE_NAME','請求書名');
define('IG_DISPLAY_NAME','請求書上に表示名');
define('IG_STREET_ADDRESS','住所');
define('IG_STREET_ADDRESS_2','住所2');
define('IG_DISCOUNT','割引');
define('IG_ENVIRONMENTAL_LOAD','補充費');
define('IG_ENVIRONMENTAL_CHECK','補充費チェック');
define('IG_FIXED_AMOUNT','請求書上に総定額');
define('IG_TAX','消費税');
define('IG_TAX_CHECK','消費税チェック');
define('IG_POST_OFFICE','郵便局');
define('IG_TELEPHONE','電話');
define('IG_FAX','ファックス');
define('IG_CLOSING_DATE','締日');
define('IG_AGGREGATE','集計');
define('IG_COLLECTIVE_OUTPUT','一括出力');
define('TG_USER_ID','担当者');

//
define('INVOICE_GROUP_DETAIL','請求書グループ詳細');
define('IGD_ID','詳細ID');
define('IGD_ID_INVOICE_GROUP','請求書グループID');
define('IGD_ID_DEPARTMENT_CUSTOMER','得意先部署ID');
define('IGD_STATISTICS_TYPE','集計区分');

//
define('USER_GROUP','ユーザーグループ');
define('UG_ID','id');
define('UG_NAME','ユーザーグループ名');

//
define('PRODUCTION_OVERVIEW_GROUP_M','生産概要グループｍ'); 
define('POG_CODE','生産概要グループコード');
define('POG_NAME','生産概要グループ名称');

//
define('PRODUCTION_OVERVIEW_CATEGORY_M','生産概要区分ｍ');
define('POC_PRODUCTION_SUMMARY_CODE','生産概要区分コード');
define('POC_PRODUCTION_OVERVIEW_GROUP_CODE','生産概要グループコード');// ma nhom khai quat sx
define('POC_DISPLAY_ORDER','表示順');
define('POC_CATEGORY_NAME','区分名称');

//
define('CONVERSION_PRODUCTION_OVERVIEW','変換・生産概要');
define('CPO_EQUIPMENT_CODE','機器コード');
define('CPO_LAUNDRY_CODE','洗濯コード');
define('CPO_PRODUCTION_SUMMARY_CODE','生産概要区分コード');

//
define('LAUNDRY_REGISTER','洗濯台帳');
define('LR_SEQUENCE_NO','シーケンスNo');
define('LR_EQUIPMENT_CODE','機器コード');
define('LR_IMPLEMENTATION_TIME','実施時刻');
define('LR_LAUNDRY_CODE','洗濯コード');
define('LR_TACT','タクト');
define('LR_LAUNDRY_WEIGHT','洗濯重量');
define('LR_REGISTRATION_DATE','登録日');
define('LR_REGISTERED_PERSON','登録者');
define('LR_EXCESS_WATER_AMOUNT','過水量');
define('LR_AMOUNT_OF_DETERGENT','洗剤量');

//
define('DRIVING_SITUATION_DATA','運転状況データ');
define('DSD_DRIVING_DATE','運転年月日');
define('DSD_WEATHER_MORNING','天候朝');
define('DSD_WEATHER_DAYTIME','天候昼');
define('DSD_WEATHER_NIGHT','天候夜');
define('DSD_TEMPERATURE','気温');
define('DSD_HUMIDITY','湿度');
define('DSD_SUPPLY_OIL','当日給油量');
define('DSD_REMAINING_OIL','当日残油量');
define('DSD_OPERATING_TIME_1','運転時間１号');
define('DSD_OPERATING_TIME_2','運転時間２号');
define('DSD_WORKING_TIME_1','稼働時間１号');
define('DSD_WORKING_TIME_2','稼働時間２号');
define('DSD_BLOW_AMOUNT_1','ブロー量１号');
define('DSD_BLOW_AMOUNT_2','ブロー量２号');
define('DSD_HOT_WELL_USAGE','ホットウェル使用量');
define('DSD_DRAIN_RECOVERY_RATE','ドレン回収率');
define('DSD_WATER_SUPPLY_NO1_USAGE','給水１号使用量');
define('DSD_WATER_SUPPLY_NO2_USAGE','給水２号使用量');
define('DSD_OIL_QUANTITY_NO1_USAGE','油量１号使用量');
define('DSD_OIL_QUANTITY_NO2_USAGE','油量２号使用量');
define('DSD_TOTAL_WATER_USAGE','給水使用量合計');
define('DSD_AMOUNT_OIL_USED','油量使用量合計');
define('DSD_POWER_USAGE','電力使用量');
define('DSD_PREFECTURE_WATER_CONSUMPTION','県水使用量');
define('DSD_WELL_WATER_CONSUMPTION','井水使用量');
define('DSD_WATER_METER_NO1','井水メーターNo1');
define('DSD_WATER_METER_NO2','井水メーターNo2');
define('DSD_GAS_METER_NO1','ガスメーターNo1');
define('DSD_GAS_METER_NO2','ガスメーターNo2');
define('DSD_LAUNDRY_VOLUME','洗濯量');
define('DSD_REGISTRATION_DATE','登録日');
define('DSD_REGISTERED_PERSON','登録者');
define('DSD_INOUE_METER_STAR_PHARMACEUTICAL','井水メーター星製薬');
define('DSD_WORKING_TIME_3','稼働時間3号');
define('DSD_UPTIME_4','稼働時間4号');
define('DSD_GAS_METER_BOILER','ガスメーターボイラー');
define('DSD_GAS_METER_GHP','ガスメーターGHP');
define('DSD_GAS_METER_REST_ROOM','ガスメーター休憩室');

//
define('OPERATING_SITUATION_DATA','稼働状況データ');
define('OSD_EQUIPMENT_CODE','機器コード');
define('OSD_IMPLEMENTATION_TIME','実施時刻');
define('OSD_LAUNDRY_CODE','洗濯コード');
define('OSD_TACT','タクト');
define('OSD_REGISTRATION_DATE','登録日');
define('OSD_REGISTERED_PERSON','登録者');

//
define('EQUIPMENT_M','機器ｍ');
define('EQ_CODE','機器コード');
define('EQ_NAME','機器名');

//
define('LAUNDRY_M','洗濯品ｍ');
define('LM_CODE','洗濯コード');
define('LM_ITEM_NAME_1','洗濯品名１');
define('LM_ITEM_NAME_2','洗濯品名２');
define('LM_WEIGHT','洗濯重量');
define('LM_WASHING_TEMPERATURE','洗濯温度');

//
define('CONVERSION_USAGE','変換・使用量');
define('CU_EQUIPMENT_CODE','機器コード');
define('CU_LAUNDRY_CODE','洗濯コード');
define('CU_PROCESS_CODE','工程コード');
define('CU_DETERGENT_CODE','洗剤コード');
define('CU_AMOUNT_TO_USE','使用量');

//
define('DETERGENT_LEDGER','洗剤台帳');
define('DEL_CODE','洗剤コード');
define('DEL_NAME','洗剤名');
define('DEL_UNIT_PRICE','単価');

//
define('LAUNDRY_DETAIL','洗濯明細');
define('LD_SEQUENCE_NO','シーケンスNo');
define('LD_DETERGENT_CODE','洗剤コード');
define('LD_AMOUNT_TO_USE','使用量');

//
define('FINISHING_SITUATION_DATA','仕上状況データ');
define('FSD_DATE','日付');
define('FSD_SHEET','シーツ');
define('FSD_SHEETS_2','シーツ2');
define('FSD_CANCEL','キャンセル');
define('FSD_SHEETS','シーツしみ');
define('FSD_SHEET_WASH_AGAIN','シーツ洗直し');
define('FSD_SHEET_BREAKING','シーツ破れ');
define('FSD_TOP','TOP');
define('FSD_TOP_2','TOP2');
define('FSD_TOP_STAINS','TOPしみ');
define('FSD_TOP_WASH_AGAIN','TOP洗直し');
define('FSD_TOP_BREAK','TOP破れ');
define('FSD_DUVE','デュベ');
define('FSD_DUVE_2','デュベ2');
define('FSD_DUVES_STAIN','デュベしみ');
define('FSD_DUVET_WASH_AGAIN','デュベ洗直し');
define('FSD_DUVE_TEAR','デュベ破れ');
define('FSD_PIROCASE','ピロケース');
define('FSD_NIGHTGOWN','ナイトガウン');
define('FSD_FSD_YUKATA','浴衣');
define('FSD_TRAINER_AND_OTHERS','トレーナー他');
define('FSD_SOCKS','靴下');
define('FSD_NAPKIN_AND_OTHERS','ナプキン他');
define('FSD_TD_CROSS_2','TDクロス2');
define('FSD_SHORT_SCALE_2','短尺他2');
define('FSD_SHORT_STUBBLE_2','短尺他しみ2');
define('FSD_SHORT_SCALE_OTHER_WASH_2','短尺他洗直し2');
define('FSD_SHORT_SCALE_OTHER_CRACK_2','短尺他破れ2');
define('FSD_OTHERS','長尺他');
define('FSD_LONG_LENGTH_STAIN_2','長尺他しみ2');
define('FSD_LONG_LENGTH_WASH_AGAIN_2','長尺他洗直し2');
define('FSD_LONG_RAKE_OTHER_TEAR_2','長尺他破れ2');
define('FSD_POLYCLOTH_2','ポリクロス2');
define('FSD_WHITE_COAT','白衣');
define('FSD_PANTS','ズボン');
define('FSD_HAT','帽子');
define('FSD_ONE_PIECE','ワンピース');
define('FSD_FRONT_HANGING','前掛');
define('FSD_TRIANGULAR_CLOTH','三角布');
define('FSD_APRON','エプロン');
define('FSD_STAR_PHARMACEUTICAL','星製薬');
define('FSD_SLIPPER','スリッパ');
define('FSD_BT','BT');
define('FSD_FT','FT');
define('FSD_WT','WT');
define('FSD_BM','BM');
define('FSD_CT','CT');
define('FSD_BATHROBES','バスローブ');
define('FSD_BASING','ベーシング');
define('FSD_DT','DT');
define('FSD_AKASURI','アカスリ');
define('FSD_JINBEI_UPPER','甚平_上');
define('FSD_JINPING_BOTTOM','甚平_下');

// 
define('DELIVERY_CLASSIFICATION','配送便'); 
define('DC_ID','id');
define('DC_NAME','配送便区分名');
define('DC_NUMBER_CONTAINER','コンテナ上限台数');
define('DC_NUMBER_TRUCK','トラック台数');
define('DC_NUMBER_MAX_TRUCK','トラック最大積載量');

//
define('DELIVERYCLASSIFICATION_CUSTOMER','配送便_得意先'); 
define('DCC_DELIVERY_CLASSIFICATION','配送便区分');
define('DCC_CUSTOMER_ID','得意先');

//
define('DELIVERY_BASE','配送便_拠点マスタ');
define('DB_DELIVERY_CLASSIFICATION','配送便区分');
define('DB_BASE_CODE','拠点コード');

//
define('MY_ONE_TOUCH','マイワンタッチヘ');
define('MOT_ID','id');
define('MOT_USER_ID','ユーザID');
define('MOT_NAME','ワンタッチ名');
define('MOT_DELIVERY_CLASSIFICATION','配送便区分');

//
define('MY_ONE_TOUCH_DETAIL','マイワンタッチ明細');
define('MOTD_ID','id');
define('MOTD_MOT_ID','マイワンタッチヘID'); 
define('MOTD_USER_ID','ユーザID');
define('MOTD_STT_SHOW','表示順'); 
define('MOTD_CUSTOMER_ID','得意先ID');
define('MOTD_DEPARTMENT_ID','部署ID');
define('MOTD_PRODUCT_CODE','商品コード');
//define('MOTD_PRODUCT_NAME','商品名');
//define('MOTD_STANDARD','規格');
//define('MOTD_COLOR','color');
//define('MOTD_WEIGHT','重量');
//define('MOTD_UNIT','単位');
//define('MOTD_NUMBER_PER_CONTAINER','１コンテナ上限搭載量');
//define('MOTD_CATEGORY_CODE','区分コード');
define('MOTD_QUANTITY','発注数'); 
define('MOTD_CONTAINER1','コンテナ');
define('MOTD_CONTAINER2','コンテナ2');
define('MOTD_COMMENT','コメント');

// setproduct-shipment
define('CUSTOMER_PRODUCTSET','得意先_商品セットm');
define('CP_CUSTOMER','得意先');
define('CP_PRODUCT_SET','商品セットコードm');

// ship ment
define('ORDER_SHIPMENT','注文発送'); 
define('OS_ID','id');
define('OS_CODE','コード');
define('OS_DELIVERY_CLASSIFICATION','配送便区分');
define('OS_ORDER_DATE','発注日'); 
define('OS_DELIVERY_DATE','納品日'); 
/*
* 1:一時保存 (lưu tạm),  
* 3: 再依頼 (yêu cầu lại),  
* 4: 出荷確定(不足) (xác định xuất hàng không đủ),
* 5: 出荷確定 (xác định xuất hàng)
* 2: 出荷未確定 (chưa xác định xuất hàng) Bao gồm(1:一時保存, 3: 再依頼,  4: 出荷確定(不足))
 */
define('OS_STATUS','形態'); 
define('OS_ORDERER','発注者'); // người tạo đơn yêu cầu xuất hàng
define('OS_SHIPPER','出荷者'); // người xác định xuất hàng
define('OS_ORDER_CONFIRMATION','発注確定');
define('OS_FINAL_DELIVERY','出荷確定');
define('OS_NOTE','備考'); 
define('OS_ORDER_CONFIRMATION_DATETIME','発注確定日時');
define('OS_SHIPMENT_DECISION_DATETIME','出荷確定日時');
define('OS_TOTAL_NUMBER_CONTAINERS','コンテナ台数合計');
define('OS_GROSS_WEIGHT','総重量');
define('OS_GROSS_WEIGHT_SHIPPING','総重量出荷');
define('OS_NUMBER_TRUCKS','トラック台数');
define('OS_NUMBER_TRAIN','臨車台数');
define('OS_NUMBER_REQUEST','再依頼');
define('OS_FLAG_FLICKER', '点滅Flg');
define('OS_UPDATE_DATE', '更新日');
define('OS_FLAG_COPY_DELIVERY', 'Flg受発注取り込み');

// SHIPMENT DETAIL
define('ORDER_SHIPMENT_DETAIL','注文発送詳細');
define('OSHD_ID','id');
define('OSHD_ORDER_ID','注文ID');
define('OSHD_CUSTOMER_ID','得意先ID');
define('OSHD_DEPARTMENT_ID','部署ID');
define('OSHD_PRODUCT_CODE','商品コード');
define('OSHD_QUANTITY','発注数');
define('OSHD_QUANTITY_CHANGE','変更数');
define('OSHD_DELIVERY','出荷数');
define('OSHD_CONTAINER1','コンテナ1');
define('OSHD_CONTAINER2','コンテナ2');
define('OSHD_COMMENT','コメント');
define('OSHD_UPDATE_DATE', '更新日');

//
define('CATEGORY_SHIPMENT_PRODUCT','商品_項目コード');
define('CSP_ID','id');
define('CSP_PRODUCT_ID','商品コード');
define('CSP_CATEGORY_ID','項目コード');

//
define('CATEGORY_SHIPMENT','項目コード');
define('CS_ID','id');
define('CS_NAME','項目コード名');
define('CS_WEIGHT','計算重量');

// report - set-container
define('CATEGORY_DELIVERYCLASSIFICATION','配送便区分');
define('CD_ID','id');
define('CD_NAME','name');
define('CD_CLASSIFICATION','配送便ID');
define('CD_NUMBER_OF_DELIVERY','number_of_delivery');

// Group Report
define('GROUP_REPORT','集計台帳'); 
define('GR_GROUP_CODE','グループコード');
define('GR_GROUP_NAME','グループ');
define('GR_GROUP_TYPE','タイプ');
define('GR_GROUP_SCHEDULE','日計表');

// CUSTOMER_SHIPMENT
define('CUSTOMER_SHIPMENT','受発注専用得意先m');  
define('CSHIPMENT_ID','得意先'); 
define('CSHIPMENT_NAME','得意先名');

// CUSTOMER - CUSTOMER SHIPMENT
define('CUSTOMER_CUSTOMERSHIPMENT','得意先_受発注専用得意先m'); 
define('CCS_CUSTOMER_SHIPMENT','得意先');
define('CCS_CUSTOMER','得意先ID');

// PRODUCT TOWEL
define('PRODUCT_TOWEL','タオル商品m'); 
define('PT_PRODUCT_CODE','生産概要商品コード');
define('PT_PRODUCT_NAME','商品名');
define('PT_PRODUCT_WEIGHT','商品重量');
define('PT_PRODUCT_TYPE','生産概要区分');

// RESULT TOWEL
define('PRODUCTION_RESULT_TOWEL','タオル生産実績'); 
define('PRT_DATE','日付');
define('PRT_PRODUCT_CODE','生産概要商品コード');
define('PRT_BASE','拠点コード'); //1: tokyo, 2: atsugi
define('PRT_NUMBER_RESULT','仕上げ枚数');

/* authorization group
* define('Key', ID);
*/
define('GR_SYSTEM_ADMINISTRATOR', 1); // システム管理者
define('GR_ORDER_MANAGEMENT_PERSONNEL', 2); // 注文管理担当者
define('GR_ORDER_MANAGEMENT_OFFICER', 3); // 注文管理責任者
define('GR_SALES_MANAGEMENT_PERSONNEL', 4); // 売上管理担当者
define('GR_SALES_MANAGEMENT_OFFICER', 5); // 売上管理責任者
define('GR_TOKYO_OTHER_ORDERING_PERSON', 6); // 東京他 発注担当者 
define('GR_ATSUGI_FACTORY_PERSONNEL', 7); // 厚木出荷担当者 
define('GR_PURCHASING_MANAGEMENT_PERSONNEL', 8); // 仕入管理担当者
define('GR_PURCHASE_MANAGEMENT_OFFICER', 9); // 仕入管理責任者
define('GR_CUSTOMERS', 10); // 得意先
define('GR_SUBCONTRACTOR_LOCAL', 11); // 外注先（地方他)
define('GR_SUBCONTRACTOR_TENANT', 12); // 外注先（テナント)
define('GR_MANAGEMENT_DATA_ALL', 13); // 管理データ（全部）
define('GR_MANAGEMENT_DATA_PERSONAL', 14); // 管理データ（拠点）
define('GR_MASTER_ADMINISTRATOR', 15); // マスタ管理者

//views
define('USER_VIEW', 'ユーザービュー'); 
define('PAGE_SIZE', 20);
define('PAGE_SIZE_SELECTBOX', 20);
define('SEARCH_MASTER', 'AND ');

// Information TOLINEN
define('TOLINEN_POST_OFFICE', '102-8578'); 
define('TOLINEN_ADDRESS', '千代田区紀尾井町４－１'); 
define('TOLINEN_ADDRESS_HOTEL', 'ホテルニューオータニ内');
define('TOLINEN_COMPANY_NAME', '株式会社テーオーリネンサプライ'); 

define('EXCEL_TYPE', 'CSV'); 
define('EXCEL_PATH', 'asset/excel_template/'); 

// Year king
define('YEAR_KING_JAPAN', '平成');
define('YEAR_KING_NUMBER', '30'); 
define('YEAR_KING_START', '2018'); 

// Towel ITEM
define('TOWEL_ITEM','タオル商品m');
define('TOWEL_CODE','生産概要商品コード');
define('TOWEL_NAME','商品名');
define('TOWEL_WEIGHT','商品重量');
define('TOWEL_TYPE','生産概要区分');

//Towel Production Result
define('TOWEL_RESULT','タオル生産実績');
define('TOWEL_DATE','日付');
define('TOWEL_PLACE','拠点コード');
define('TOWEL_FINISHED_NUMBER','仕上げ枚数');

//FEE_OF_GAICHYU"  chi phí bán cho gaichyu
define('FEE_OF_GAICHYU','管理業務料'); 
define('FG_ID','id');
define('FG_CUSTOMER_ID','得意先');
define('FG_GAICHYU_BASE_ID','担当外注先');
define('FG_CONTACT_USER_ID','担当者');
define('FG_TONINEN_FEE','ﾘﾈﾝｻﾌﾟﾗｲ売上');
define('FG_ENVIROMENT_FEE','ﾘﾈﾝ補充費');
define('FG_LAUNDRY_FEE','ｸﾘｰﾆﾝｸﾞ他売上');
define('FG_DEPARTMENT_ID','管理費免除部署');

//期首の棚卸 : kiểm kê số lượng đầu kỳ
define('INITIAL_INVENTORY','期首の棚卸');
define('IN_ID','id');
define('IN_DATE','日付');
define('IN_BASE_CODE','拠点コード');
define('IN_PRODUCT','商品ID');
define('IN_INITIAL_AMOUNT','棚卸');

//期首の棚卸_廃棄 : kiểm kê số lượng hỏng đầu kỳ
define('DISPOSAL_INVENTORY','期首の棚卸_廃棄');
define('DI_ID','id');
define('DI_DATE','日付');
define('DI_BASE_CODE','拠点コード');
define('DI_PRODUCT','商品ID');
define('DI_DISPOSAL_NUMBER','廃棄');

//Người xuất kho 出庫者
define('USER_STOCK_EXPORT','出庫者');
define('UX_ID','id');
define('UX_NAME','氏名');
define('UX_NAME1','シメイ');
define('UX_BASE_CODE','拠点コード');
define('UX_REGENCY','役職');
define('UX_ADDRESS','住所');
define('UX_NUMBER','電話番号');

// notification
define('TAB_NOTIFICATION','お知らせ');
define('TN_ID','ID');
define('TN_USER','ユーザID');
define('TN_SUBJECT','タイトル');
define('TN_MESSAGE','内容');
define('TN_DATE_CREATER','作成日');
define('TN_STATUS','状態');

define('ACCESS_DENIDED', 'アクセス拒否');

//
define('DEPARTMENT_MAINROOM','4445');
define('DEPARTMENT_TOWER','2356');