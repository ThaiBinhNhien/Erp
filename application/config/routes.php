<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| ---------------------------------------------------
----------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'AdminController';

$route['login'] = 'UserController/login';
$route['logout'] = 'UserController/logout';

$route['receive-order'] = 'OrderController/index';
$route['receive-order/export'] = 'OrderController/export';
$route['receive-order/checklist'] = 'OrderController/check_list';
$route['receive-order/checklist/pdf_checklist'] = 'OrderController/pdf_checklist';
$route['order/detail-order'] = 'OrderController/detail_order'; 
$route['order/pdf-floor'] = 'OrderController/pdf_floor';
$route['order/pdf-delivery'] = 'OrderController/pdf_delivery';
$route['order/pdf-order'] = 'OrderController/pdf_order';
$route['order/edit-order'] = 'OrderController/edit_order'; 
$route['order/detail-order-2'] = 'OrderController/detail_order2';
$route['order/edit-order-2'] = 'OrderController/edit_order_2';

$route['order/create-order'] = 'OrderController/create_order';
$route['order/create-order-2'] = 'OrderController/create_order_2';
$route['order/get-department'] = 'OrderController/get_deparment_by_customer';
$route['order/get-customer'] = 'OrderController/get_customer_by_department';
$route['order/get-order-view'] = 'OrderController/get_order_view';
$route['order/delete-order'] = 'OrderController/delete_order';
$route['order/checklist'] = 'OrderController/check_list_post';

/* Delivery */
$route['order/edit-delivery-order'] = 'OrderController/edit_delivery_order';
$route['order/edit-delivery-post'] = 'OrderController/edit_delivery_post';
$route['order/get-checklist-view'] = 'OrderController/get_checklist_view';
$route['order/copy_order_to_shipment'] = 'OrderController/copy_order_to_shipment';

/* Shipment */
$route['shipment'] = 'ShipmentController'; 
$route['shipment/get-shipment-view'] = 'ShipmentController/get_shipment_view';
$route['shipment/get-customer-by-classification'] = 'ShipmentController/get_customer_by_classification';
$route['shipment/get-set-product'] = 'ShipmentController/get_set_product';
$route['shipment/get-my-one-touch'] = 'ShipmentController/get_my_one_touch';
$route['shipment/get-detail-set-one-touch'] = 'ShipmentController/get_detail_set_one_touch'; 
$route['shipment/get-detail-product'] = 'ShipmentController/get_detail_product';
$route['shipment/get-container-shipment'] = 'ShipmentController/get_container_shipment';
$route['shipment/add'] = 'ShipmentController/add_shipment';
$route['shipment/add-shipment-post'] = 'ShipmentController/add_shipment_post';
//$route['shipment/detail_order'] = 'ShipmentController/detail_order';
$route['shipment/detail_order_confirm'] = 'ShipmentController/detail_order_confirm';
$route['shipment/detail_order_confirm_post'] = 'ShipmentController/detail_order_confirm_post';
$route['shipment/detail_shipment'] = 'ShipmentController/detail_shipment';
$route['shipment/delete'] = 'ShipmentController/delete_shipment';
$route['shipment/edit_shipment'] = 'ShipmentController/edit_shipment';
$route['shipment/getCustomerByClassification'] = 'ShipmentController/getCustomerByClassification';
$route['shipment/edit-shipment-post'] = 'ShipmentController/edit_shipment_post';
$route['shipment/get-department'] = 'ShipmentController/get_deparment_by_customer';
$route['shipment/get-customer'] = 'ShipmentController/get_customer_by_department';

/* Report Shipment */
$route['shipment/export'] = 'ShipmentController/export';
$route['shipment/bill-shipment'] = 'ShipmentController/report_bill_shipment';
$route['shipment/report-shipment'] = 'ShipmentController/report_status_shipment';
$route['shipment/report-shipment-customer'] = 'ShipmentController/report_status_shipment_customer';
$route['shipment/report-set-container'] = 'ShipmentController/report_set_container';

/* Delivery */
$route['user/get-user-type'] = 'UserController/get_user_type';

$route['sale/back']['POST'] = 'SaleController/back';
$route['sale'] = 'SaleController/index';
$route['sale/update_person_charge_cus_dep'] = 'SaleController/update_person_charge_cus_dep';
$route['sale/add-sale']['POST'] = 'SaleController/add_sale';
$route['sale/add-sale-2'] = 'SaleController/add_sale_2';
$route['sale/detail-sale'] = 'SaleController/view_sale';
$route['sale/edit-sale'] = 'SaleController/edit_sale';
$route['sale/created_sale'] = 'SaleController/created_sale';
$route['sale/edit_createdsale'] = 'SaleController/edit_createdSale';
$route['sale/detail-sale-2'] = 'SaleController/detail_sale_2';
$route['sale/print-invoice'] = 'SaleController/print_sale';
$route['sale/ajax_create_list']['POST'] = 'SaleController/ajax_create_list';
$route['sale/ajax_save_sale']['POST'] = 'SaleController/ajax_save_sale';
$route['sale/ajax_list_order_CSV']['POST'] = 'SaleController/ajax_list_order_CSV';
$route['sale/ajax_export_csv_created'] = 'SaleController/ajax_export_csv_created';

//$route['sale/ajax_save_sale_2']['POST'] = 'SaleController/ajax_save_sale_2';

$route['sale/ajax_save_sale_2'] = 'SaleController/ajax_save_sale_2';

$route['sale/ajax_search_order']['POST'] = 'SaleController/ajax_search_order';
$route['sale/ajax_search_created']['POST'] = 'SaleController/ajax_search_created';
$route['sale/ajax_edit_sale']['POST'] = 'SaleController/ajax_edit_sale';
$route['sale/ajax_edit_sale_no_order']['POST'] = 'SaleController/ajax_edit_sale_no_order';
$route['sale/ajax_del_sale']['POST'] = 'SaleController/ajax_del_sale';
$route['sale/ajax_get_list_department_by_customer']['POST'] = 'SaleController/ajax_get_list_department_by_customer';
$route['sale/ajax_get_list_product']['POST'] = 'SaleController/ajax_get_list_product';//lấy danh sách sản phẩm theo mã khách hàng và mã cứ điểm của user
$route['sale/print-sale'] = 'SaleController/print_sale';

$route['purchase'] = 'PurchaseController/index';
$route['purchase/get_number_import'] = 'PurchaseController/get_number_import';
$route['purchase/detail-purchase'] = 'PurchaseController/detail_purchase';
$route['purchase/print_purchase_order'] = 'PurchaseController/print_purchase_order';
$route['purchase/print_pdf_purchase_order']['POST'] = 'PurchaseController/print_pdf_purchase_order';
$route['purchase/add-purchase'] = 'PurchaseController/add_purchase';
$route['purchase/processing-purchase'] = 'PurchaseController/processing_import';
$route['purchase/export-purchase'] = 'PurchaseController/warehouse';
$route['purchase/checklist'] = 'PurchaseController/checklist';
$route['purchase/ajax-export-purchase']['POST'] = 'PurchaseController/ajax_warehouse';
$route['purchase/add-export-purchase'] = 'PurchaseController/add_warehouse';
$route['purchase/ajax_get_list_product']['POST'] = 'PurchaseController/ajax_get_list_product';
$route['purchase/ajax_get_list_product_2']['POST'] = 'PurchaseController/ajax_get_list_product_2';
$route['purchase/ajax_get_info_export']['POST'] = 'PurchaseController/ajax_get_info_export';
$route['purchase/ajax_add_warehouse']['POST'] = 'PurchaseController/ajax_add_warehouse';
$route['purchase/ajax_save_move_stock']['POST'] = 'PurchaseController/ajax_save_move_stock';
$route['purchase/ajax_correct_stock']['POST'] = 'PurchaseController/ajax_correct_stock';
$route['purchase/ajax_edit_export_order']['POST'] = 'PurchaseController/ajax_edit_export_order';
$route['purchase/ajax_del_export_order']['POST'] = 'PurchaseController/ajax_del_export_order';
$route['purchase/ajax_get_list_product_by_supplier']['POST'] = 'PurchaseController/ajax_get_list_product_by_supplier';
$route['purchase/ajax_save_order']['POST'] = 'PurchaseController/ajax_save_order';
$route['purchase/ajax_edit_purchase_order']['POST'] = 'PurchaseController/ajax_edit_purchase_order';
$route['purchase/ajax_confirm_order_purchase']['POST'] = 'PurchaseController/ajax_confirm_order_purchase';
$route['purchase/ajax_del_purchase_order']['POST'] = 'PurchaseController/ajax_del_purchase_order';
$route['purchase/ajax_save_processing_import']['POST'] = 'PurchaseController/ajax_save_processing_import';
$route['purchase/ajax_search_order_purchase']['POST'] = 'PurchaseController/ajax_search_order_purchase';

//--Export purchase csv
$route['purchase/export-purchase-csv'] = 'PurchaseController/export_purchase_csv';
$route['purchase/export-warehouse-csv'] = 'PurchaseController/export_warehouse_csv';
//--Export delivery note
$route['purchase/export-delivery-note'] = 'PurchaseController/export_delivery_note';
$route['purchase/get-order-list'] = 'PurchaseController/get_order_list';


$route['purchase/pdf-checklist'] = 'PurchaseController/pdf_checklist';

$route['purchase/ajax_csv'] = 'PurchaseController/ajax_csv';


$route['purchase/editOrder'] = 'PurchaseController/edit_purchase_order';
$route['purchase/detail-export-purchase'] = 'PurchaseController/detail_export_order/$1';
$route['purchase/edit-export-purchase'] = 'PurchaseController/edit_export_order/$1';
$route['purchase/debt'] = 'PurchaseController/debt';
$route['purchase/check_price'] = 'PurchaseController/check_price';
$route['purchase/pdf_check_price'] = 'PurchaseController/pdf_check_price';
$route['purchase/detailDebt'] = 'PurchaseController/detailDebt';
$route['business-management'] = 'BusinessController/index';
$route['business/inventory'] = 'BusinessController/inventory';
$route['business/produce'] = 'BusinessController/produce';
$route['master'] = 'MasterController/index';

$route['operation/business'] = 'OperationController/business';

//master user
$route['master/user'] = 'UserController/index';
$route['master/user/import'] = 'UserController/import';
$route['master/user/export'] = 'UserController/export';
$route['master/user/get_list'] = 'UserController/get_list';
$route['master/user/add'] = 'UserController/add';
$route['master/user/add_post'] = 'UserController/add_post';
$route['master/user/edit'] = 'UserController/edit';
$route['master/user/edit_post'] = 'UserController/edit_post';
$route['master/user/delete_post'] = 'UserController/delete_post';
$route['master/user/check-existed'] = 'UserController/isUserExisted'; 

$route['productset/get-information'] = 'ProductSetController/get_info';

$route['product/get'] = 'ProductController/get';
$route['product/search-by-sale-code'] = 'ProductController/search_by_sale_code';
$route['product/search-by-name'] = 'ProductController/search_by_name';
$route['product/search-by-sale-code-not-special'] = 'ProductController/search_by_sale_code_not_special';
$route['product/search-by-sale-code-with-special'] = 'ProductController/search_by_sale_code_with_special';

$route['customer/search-by-name'] = 'CustomerController/search_by_name';
$route['customer/get-customer-view'] = 'CustomerController/get_customer_view';
$route['customer/get-department'] = 'CustomerController/get_deparment_by_customer';
$route['customer/get-product'] = 'CustomerController/get_product_by_customer';
$route['customer/get-productset'] = 'CustomerController/get_product_set_by_customer';
$route['customer/create'] = 'CustomerController/create';
$route['customer/remove'] = 'CustomerController/remove';
$route['customer/edit'] = 'CustomerController/edit';

$route['department/get-by-customer'] = 'DepartmentController/get_by_customer';
$route['department/get-department-view'] = 'DepartmentController/get_department_view';
$route['department/create'] = 'DepartmentController/create';
$route['department/remove'] = 'DepartmentController/remove';
$route['department/edit'] = 'DepartmentController/edit';

$route['warehouse/get-warehouse-view'] = 'WarehouseController/get_warehouse_view';
$route['warehouse/create'] = 'WarehouseController/create';
$route['warehouse/remove'] = 'WarehouseController/remove';
$route['warehouse/edit'] = 'WarehouseController/edit';

$route['washing-category/get-washing-category-view'] = 'WashingCategoryController/get_washing_category_view';
$route['washing-category/create'] = 'WashingCategoryController/create';
$route['washing-category/remove'] = 'WashingCategoryController/remove';
$route['washing-category/edit'] = 'WashingCategoryController/edit';

$route['machine/get-machine-view'] = 'MachineController/get_machine_view';
$route['machine/create'] = 'MachineController/create';
$route['machine/remove'] = 'MachineController/remove';
$route['machine/edit'] = 'MachineController/edit';

$route['washing-powder/get-washing-powder-view'] = 'WashingPowderController/get_washing_powder_view';
$route['washing-powder/create'] = 'WashingPowderController/create';
$route['washing-powder/remove'] = 'WashingPowderController/remove';
$route['washing-powder/edit'] = 'WashingPowderController/edit';

$route['group-invoice/get-group-invoice-view'] = 'GroupInvoiceController/get_group_invoice_view';
$route['group-invoice/create'] = 'GroupInvoiceController/create';
$route['group-invoice/edit'] = 'GroupInvoiceController/edit';
$route['group-invoice/remove'] = 'GroupInvoiceController/remove';


$route['operation'] = 'OperationController/index';
$route['operation/produce'] = 'OperationController/produce';
$route['operation/produce/pdf-produce-shipment'] = 'OperationController/pdf_produce_shipment';
$route['operation/produce/pdf-produce-shipment-cus'] = 'OperationController/pdf_produce_shipment_cus';
$route['operation/produce/pdf-produce-quantity-used-by-device'] = 'OperationController/pdf_produce_quantity_used_by_device';
$route['operation/produce/pdf-produce-washing-amount'] = 'OperationController/pdf_produce_washing_amount';
$route['operation/produce/pdf-produce-weight-by-device'] = 'OperationController/pdf_produce_weight_by_device';
$route['operation/produce/pdf-produce-actual-by-cus'] = 'OperationController/pdf_produce_actual_by_cus';
$route['operation/produce/pdf-produce-actual-by-product'] = 'OperationController/pdf_produce_actual_by_product';
$route['operation/produce/pdf-produce-enegy-used'] = 'OperationController/pdf_produce_enegy_used';
$route['operation/produce/pdf-produce-enegy-graph'] = 'OperationController/pdf_produce_enegy_graph';
$route['operation/produce/pdf-produce-finishing-situation'] = 'OperationController/pdf_produce_finishing_situation';
$route['operation/produce/pdf-produce-business'] = 'OperationController/pdf_produce_business';
$route['operation/produce/pdf-produce-amount-powder-used-by-device'] = 'OperationController/pdf_produce_amount_powder_used_by_device';
$route['operation/produce/csv-produce-shipment'] = 'OperationController/csv_produce_shipment';
$route['operation/produce/csv-produce-shipment-cus'] = 'OperationController/csv_produce_shipment_cus';
$route['operation/produce/csv-produce-quantity-used-by-device'] = 'OperationController/csv_produce_quantity_used_by_device';
$route['operation/produce/csv-produce-washing-amount'] = 'OperationController/csv_produce_washing_amount';
$route['operation/produce/csv-produce-weight-by-device'] = 'OperationController/csv_produce_weight_by_device';
$route['operation/produce/csv-produce-actual-by-cus'] = 'OperationController/csv_produce_actual_by_cus';
$route['operation/produce/csv-produce-actual-by-product'] = 'OperationController/csv_produce_actual_by_product';
$route['operation/produce/csv-produce-enegy-used'] = 'OperationController/csv_produce_enegy_used';
$route['operation/produce/csv-produce-finishing-situation'] = 'OperationController/csv_produce_finishing_situation';
$route['operation/produce/csv-produce-business'] = 'OperationController/csv_produce_business';
$route['operation/produce/csv-produce-amount-powder-used-by-device'] = 'OperationController/csv_produce_amount_powder_used_by_device';


// Report Sale
$route['pdf_daily_schedule_a'] = 'BusinessController/pdf_daily_schedule_a';
$route['pdf_daily_schedule_b'] = 'BusinessController/pdf_daily_schedule_b';
$route['pdf_sales_score'] = 'BusinessController/pdf_sales_score';
$route['pdf_sales_product'] = 'BusinessController/pdf_sales_product';
$route['pdf_sales_customer'] = 'BusinessController/pdf_sales_customer';

// Report Inventory
$route['pdf_inventory_list'] = 'InventoryController/pdf_inventory_list';
$route['pdf_warehouse_status'] = 'InventoryController/pdf_warehouse_status';
$route['pdf_delivery_achievement_rate'] = 'InventoryController/pdf_delivery_achievement_rate';

/* 仕入台帳 */ 
$route['pdf_purchase_ledger_collective'] = 'InventoryController/pdf_purchase_ledger_collective';
$route['pdf_purchase_ledger_individual'] = 'InventoryController/pdf_purchase_ledger_individual';
$route['pdf_purchase_ledger_collective_diff_format'] = 'InventoryController/pdf_purchase_ledger_collective_diff_format';
$route['pdf_delivery_number_confirm'] = 'InventoryController/pdf_delivery_number_confirm';
$route['pdf_delivery_number_confirm_year'] = 'InventoryController/pdf_delivery_number_confirm_year';
$route['pdf_delivery_number_confirm_sale'] = 'InventoryController/pdf_delivery_number_confirm_sale';

/* 洗剤等使用状況 */
$route['pdf_detergent_condition'] = 'InventoryController/pdf_detergent_condition';

/* 仕入品金額明細 */
$route['pdf_details_buy'] = 'InventoryController/pdf_details_buy';

/*  */
$route['pdf_initial_inventory'] = 'InitialInventoryController/pdf_initial_inventory';

// Access denied
$route['access-denied'] = 'ErrorController/AccessDenied';
$route['error-database'] = 'ErrorController/ErrorDatabase';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//###For all master
//master product
$route['master/product'] = 'masters/ProductController/index';
$route['master/product/edit-product'] = 'masters/ProductController/edit_product';
$route['master/product/get_product_view'] = 'masters/ProductController/get_product_view';
$route['master/product/create-product'] = 'masters/ProductController/create_product';
$route['master/product/delete-product'] = 'masters/ProductController/delete_product';
$route['master/product/import'] = 'masters/ProductController/import';
$route['master/product/export'] = 'masters/ProductController/export';
$route['master/product/get_key_random'] = 'masters/ProductController/get_key_random';

//master product_category
$route['master/product_category'] = 'masters/Product_CategoryController/index';
$route['master/product_category/edit_product_category'] = 'masters/Product_CategoryController/edit_product_category';


//master location
$route['master/location'] = 'masters/LocationController/index';
$route['master/location/import'] = 'masters/LocationController/import';
$route['master/location/export'] = 'masters/LocationController/export';
$route['master/location/get_list'] = 'masters/LocationController/get_list';
$route['master/location/add'] = 'masters/LocationController/add';
$route['master/location/edit'] = 'masters/LocationController/edit';
$route['master/location/add_post'] = 'masters/LocationController/add_post';
$route['master/location/edit_post'] = 'masters/LocationController/edit_post';
$route['master/location/delete_post'] = 'masters/LocationController/delete_post';

//master supplier

$route['master/supplier'] = 'masters/SupplierController/index';
$route['master/supplier/edit_supplier'] = 'masters/SupplierController/edit_supplier';
$route['master/supplier/search_supplier'] = 'masters/SupplierController/search_supplier';
$route['master/supplier/create_supplier'] = 'masters/SupplierController/create_supplier';
$route['master/supplier/delete_supplier'] = 'masters/SupplierController/delete_supplier';
$route['master/supplier/import'] = 'masters/SupplierController/import';
$route['master/supplier/export'] = 'masters/SupplierController/export';

//master catalogue
$route['master/catalogue_buy'] = 'masters/CatalogueBuyController/index';
$route['master/catalogue_buy/import'] = 'masters/CatalogueBuyController/import';
$route['master/catalogue_buy/export'] = 'masters/CatalogueBuyController/export';
$route['master/catalogue_buy/get_list'] = 'masters/CatalogueBuyController/get_list';
$route['master/catalogue_buy/add_post'] = 'masters/CatalogueBuyController/add_post';
$route['master/catalogue_buy/edit_post'] = 'masters/CatalogueBuyController/edit_post';
$route['master/catalogue_buy/delete_post'] = 'masters/CatalogueBuyController/delete_post';
$route['master/catalogue_sale'] = 'masters/CatalogueSaleController/index';
$route['master/catalogue_sale/import'] = 'masters/CatalogueSaleController/import';
$route['master/catalogue_sale/export'] = 'masters/CatalogueSaleController/export';
$route['master/catalogue_sale/get_list'] = 'masters/CatalogueSaleController/get_list';
$route['master/catalogue_sale/add_post'] = 'masters/CatalogueSaleController/add_post';
$route['master/catalogue_sale/edit_post'] = 'masters/CatalogueSaleController/edit_post';
$route['master/catalogue_sale/delete_post'] = 'masters/CatalogueSaleController/delete_post';

//master setting_product
$route['master/setting_product'] = 'masters/Setting_ProductController/index';
$route['master/setting_product/add'] = 'masters/Setting_ProductController/add';
$route['master/setting_product/edit'] = 'masters/Setting_ProductController/edit';
$route['master/setting_product/get_list'] = 'masters/Setting_ProductController/get_list';
$route['master/setting_product/add_post'] = 'masters/Setting_ProductController/add_post';
$route['master/setting_product/edit_post'] = 'masters/Setting_ProductController/edit_post';
$route['master/setting_product/delete_post'] = 'masters/Setting_ProductController/delete_post';
$route['master/setting_product/import'] = 'masters/Setting_ProductController/import';
$route['master/setting_product/export'] = 'masters/Setting_ProductController/export';

//master setting_shipment_product 
$route['master/setting_shipment_product'] = 'masters/Setting_Shipment_ProductController/index';
$route['master/setting_shipment_product/add'] = 'masters/Setting_Shipment_ProductController/add';
$route['master/setting_shipment_product/edit'] = 'masters/Setting_Shipment_ProductController/edit';
$route['master/setting_shipment_product/get_list'] = 'masters/Setting_Shipment_ProductController/get_list';
$route['master/setting_shipment_product/add_post'] = 'masters/Setting_Shipment_ProductController/add_post';
$route['master/setting_shipment_product/edit_post'] = 'masters/Setting_Shipment_ProductController/edit_post';
$route['master/setting_shipment_product/delete_post'] = 'masters/Setting_Shipment_ProductController/delete_post';
$route['master/setting_shipment_product/import'] = 'masters/Setting_Shipment_ProductController/import';
$route['master/setting_shipment_product/export'] = 'masters/Setting_Shipment_ProductController/export';

//master buying_product_category
$route['master/buying_product_category'] = 'masters/Buying_Product_CategoryController/index';
$route['master/buying_product_category/search_category'] = 'masters/Buying_Product_CategoryController/search_category';
$route['master/buying_product_category/delete_category'] = 'masters/Buying_Product_CategoryController/delete_category';
$route['master/buying_product_category/create_category'] = 'masters/Buying_Product_CategoryController/create_category';
$route['master/buying_product_category/edit_category'] = 'masters/Buying_Product_CategoryController/edit_category';

$route['master/buying_product_category/export'] = 'masters/Buying_Product_CategoryController/export';
$route['master/buying_product_category/import'] = 'masters/Buying_Product_CategoryController/import';
//master selling_product_category
$route['master/selling_product_category'] = 'masters/Selling_Product_CategoryController/index';
$route['master/selling_product_category/search_category'] = 'masters/Selling_Product_CategoryController/search_category';
$route['master/selling_product_category/delete_category'] = 'masters/Selling_Product_CategoryController/delete_category';
$route['master/selling_product_category/create_category'] = 'masters/Selling_Product_CategoryController/create_category';
$route['master/selling_product_category/edit_category'] = 'masters/Selling_Product_CategoryController/edit_category';

$route['master/selling_product_category/import'] = 'masters/Selling_Product_CategoryController/import';
$route['master/selling_product_category/export'] = 'masters/Selling_Product_CategoryController/export';
//master province
$route['master/province'] = 'masters/ProvinceController/index';

//master place_of_sales
$route['master/place_of_sales'] = 'masters/Place_Of_SalesController/index';
$route['master/place_of_sales/edit'] = 'masters/Place_Of_SalesController/edit';
$route['master/place_of_sales/search'] = 'masters/Place_Of_SalesController/search';
$route['master/place_of_sales/create'] = 'masters/Place_Of_SalesController/create';
$route['master/place_of_sales/delete'] = 'masters/Place_Of_SalesController/delete';
$route['master/place_of_sales/import'] = 'masters/Place_Of_SalesController/import';
$route['master/place_of_sales/export'] = 'masters/Place_Of_SalesController/export';

//master customer
$route['master/customer'] = 'masters/CustomerController/index';
$route['master/customer/edit-customer'] = 'masters/CustomerController/edit_customer';
$route['master/customer/create-customer'] = 'masters/CustomerController/create_customer';
$route['master/customer/import'] = 'masters/CustomerController/import_master';
$route['master/customer/export'] = 'masters/CustomerController/export_master';
$route['master/customer-department/import'] = 'masters/CustomerController/import_detail_1';
$route['master/customer-department/export'] = 'masters/CustomerController/export_detail_1';

//master deparment
$route['master/department'] = 'masters/DeparmentController/index';
$route['master/department/import'] = 'masters/DeparmentController/import';
$route['master/department/export'] = 'masters/DeparmentController/export';

//master deparment shipment
$route['master/department_shipment'] = 'masters/DeparmentShipmentController/index';
$route['master/department_shipment/import'] = 'masters/DeparmentShipmentController/import';
$route['master/department_shipment/export'] = 'masters/DeparmentShipmentController/export';
$route['master/department_shipment/edit'] = 'masters/DeparmentShipmentController/edit';
$route['master/department_shipment/create'] = 'masters/DeparmentShipmentController/create';
$route['master/department_shipment/remove'] = 'masters/DeparmentShipmentController/remove';
$route['master/department_shipment/get-department-view'] = 'masters/DeparmentShipmentController/get_department_view';

//master warehouse
$route['master/warehouse'] = 'masters/WarehouseController/index';

//master washing_category
$route['master/washing-category'] = 'masters/Washing_CategoryController/index';
$route['master/washing-category/import'] = 'masters/Washing_CategoryController/import';
$route['master/washing-category/export'] = 'masters/Washing_CategoryController/export';

//master group_invoice
$route['master/group-invoice'] = 'masters/GroupInvoiceController/index';
$route['master/group-invoice/create'] = 'masters/GroupInvoiceController/create_group_invoice';
$route['master/group-invoice/edit'] = 'masters/GroupInvoiceController/edit_group_invoice';
$route['master/group-invoice/import'] = 'masters/GroupInvoiceController/import_master';
$route['master/group-invoice/export'] = 'masters/GroupInvoiceController/export_master';
$route['master/group-invoice-detail/import'] = 'masters/GroupInvoiceController/import_detail';
$route['master/group-invoice-detail/export'] = 'masters/GroupInvoiceController/export_detail';

//master M_machine
$route['master/machine'] = 'masters/MachineController/index';
$route['master/machine/import'] = 'masters/MachineController/import';
$route['master/machine/export'] = 'masters/MachineController/export';

$route['master/m_machine/search'] = 'masters/M_machineController/search';
$route['master/m_machine/delete'] = 'masters/M_machineController/delete';
$route['master/m_machine/create'] = 'masters/M_machineController/create';
$route['master/m_machine/edit'] = 'masters/M_machineController/edit';



//master powder_main
$route['master/washing-powder'] = 'masters/WashingPowderController/index';
$route['master/washing-powder/import'] = 'masters/WashingPowderController/import';
$route['master/washing-powder/export'] = 'masters/WashingPowderController/export';

//master M_washing
$route['master/M_washing'] = 'masters/M_washingController/index';
$route['master/M_washing/search'] = 'masters/M_washingController/search';
$route['master/M_washing/delete'] = 'masters/M_washingController/delete';
$route['master/M_washing/edit'] = 'masters/M_washingController/edit';
$route['master/M_washing/create'] = 'masters/M_washingController/create';
$route['master/M_washing/export'] = 'masters/M_washingController/export';
$route['master/M_washing/import'] = 'masters/M_washingController/import';

//master my_one_touch
$route['master/my_one_touch'] = 'masters/My_one_touchController/index';
$route['master/my_one_touch/get_list'] = 'masters/My_one_touchController/get_list';
$route['master/my_one_touch/add'] = 'masters/My_one_touchController/add';
$route['master/my_one_touch/add_post'] = 'masters/My_one_touchController/add_post';
$route['master/my_one_touch/edit'] = 'masters/My_one_touchController/edit';
$route['master/my_one_touch/edit_post'] = 'masters/My_one_touchController/edit_post';
$route['master/my_one_touch/delete_post'] = 'masters/My_one_touchController/delete_post';
$route['master/my_one_touch/import'] = 'masters/My_one_touchController/import';
$route['master/my_one_touch/export'] = 'masters/My_one_touchController/export';

//master setting_product_location
$route['master/setting_product_location'] = 'masters/Setting_Product_LocationController/index';
$route['master/setting_product_location/import'] = 'masters/Setting_Product_LocationController/import';
$route['master/setting_product_location/export'] = 'masters/Setting_Product_LocationController/export';
$route['master/setting_product_location/add_post'] = 'masters/Setting_Product_LocationController/add_post';
$route['master/setting_product_location/load_set_product_by_base_customer'] = 'masters/Setting_Product_LocationController/load_customer_by_set_product_base';

//master setting_product_customer
$route['master/setting_product_customer'] = 'masters/Setting_Product_CustomerController/index';
$route['master/setting_product_customer/import'] = 'masters/Setting_Product_CustomerController/import';
$route['master/setting_product_customer/export'] = 'masters/Setting_Product_CustomerController/export';
$route['master/setting_product_customer/add_post'] = 'masters/Setting_Product_CustomerController/add_post';
$route['master/setting_product_customer/load_set_product_by_customer'] = 'masters/Setting_Product_CustomerController/load_set_product_by_customer';

//master shipment
$route['master/shipment_courier'] = 'masters/MsShipmentController/courier';
$route['master/shipment_courier/import'] = 'masters/MsShipmentController/import';
$route['master/shipment_courier/export'] = 'masters/MsShipmentController/export';
$route['master/shipment_courier/add'] = 'masters/MsShipmentController/courier_add';
$route['master/shipment_courier/add_post'] = 'masters/MsShipmentController/courier_add_post';
$route['master/shipment_courier/edit'] = 'masters/MsShipmentController/courier_edit';
$route['master/shipment_courier/edit_post'] = 'masters/MsShipmentController/courier_edit_post';
$route['master/shipment_courier/get_list'] = 'masters/MsShipmentController/get_shipment_classification';
$route['master/shipment_courier/delete'] = 'masters/MsShipmentController/delete_shipment_classification';

//master category
$route['master/category'] = 'masters/CategoryController/index';
$route['master/category/edit_category'] = 'masters/CategoryController/edit_category';

// //master type_product  ==>overview_cagegory_m
// $route['master/type_product'] = 'masters/Type_ProductController/index';

//master overview_cagegory_m
$route['master/overview_category_m'] = 'masters/Overview_Category_MController/index';
$route['master/overview_category_m/create'] = 'masters/Overview_Category_MController/create';
$route['master/overview_category_m/search'] = 'masters/Overview_Category_MController/search';
$route['master/overview_category_m/delete'] = 'masters/Overview_Category_MController/delete';
$route['master/overview_category_m/edit'] = 'masters/Overview_Category_MController/edit';
$route['master/overview_category_m/import'] = 'masters/Overview_Category_MController/import';
$route['master/overview_category_m/export'] = 'masters/Overview_Category_MController/export';
//master other
$route['master/other'] = 'masters/OtherController/index';

//master supplier_category
$route['master/supplier_category'] = 'masters/Supplier_CategoryController/index';
$route['master/supplier_category/search_category'] = 'masters/Supplier_CategoryController/search_category';
$route['master/supplier_category/delete_category'] = 'masters/Supplier_CategoryController/delete_category';
$route['master/supplier_category/create_category'] = 'masters/Supplier_CategoryController/create_category';
$route['master/supplier_category/edit_category'] = 'masters/Supplier_CategoryController/edit_category';

$route['master/supplier_category/import'] = 'masters/Supplier_CategoryController/import';
$route['master/supplier_category/export'] = 'masters/Supplier_CategoryController/export';
// master price product
$route['master/product_price'] = 'masters/PriceProductController/index';
$route['master/product_price/add_post'] = 'masters/PriceProductController/add_post';
$route['master/product_price/edit_post'] = 'masters/PriceProductController/edit_post';
$route['master/product_price/delete_post'] = 'masters/PriceProductController/delete_post';
$route['master/product_price/get_product_price_sale'] = 'masters/PriceProductController/get_product_price_sale';
$route['master/product_price/get_product_price_import'] = 'masters/PriceProductController/get_product_price_import';
$route['master/product_price/get_product_price_export'] = 'masters/PriceProductController/get_product_price_export';
$route['master/product_price_sale/import'] = 'masters/PriceProductController/import_price_sale';
$route['master/product_price_sale/export'] = 'masters/PriceProductController/export_price_sale';
$route['master/product_price_import/import'] = 'masters/PriceProductController/import_price_import';
$route['master/product_price_import/export'] = 'masters/PriceProductController/export_price_import';
$route['master/product_price_export/import'] = 'masters/PriceProductController/import_price_export';
$route['master/product_price_export/export'] = 'masters/PriceProductController/export_price_export';
 
//master statistical_group
$route['master/statistical_group'] = 'masters/StatisticalGroupController/index';
$route['master/statistical_group/get_list'] = 'masters/StatisticalGroupController/get_list';
$route['master/statistical_group/add'] = 'masters/StatisticalGroupController/add';
$route['master/statistical_group/add_post'] = 'masters/StatisticalGroupController/add_post';
$route['master/statistical_group/edit'] = 'masters/StatisticalGroupController/edit';
$route['master/statistical_group/edit_post'] = 'masters/StatisticalGroupController/edit_post';
$route['master/statistical_group/delete_post'] = 'masters/StatisticalGroupController/delete_post';
$route['master/statistical_group/import'] = 'masters/StatisticalGroupController/import';
$route['master/statistical_group/export'] = 'masters/StatisticalGroupController/export';

//master 受発注専用得意先
$route['master/customer_shipment'] = 'masters/CustomerShipmentController/index';
$route['master/customer_shipment/export'] = 'masters/CustomerShipmentController/export';
$route['master/customer_shipment/import'] = 'masters/CustomerShipmentController/import';
$route['master/customer_shipment/get_list'] = 'masters/CustomerShipmentController/get_list';
$route['master/customer_shipment/add_post'] = 'masters/CustomerShipmentController/add_post';
$route['master/customer_shipment/edit_post'] = 'masters/CustomerShipmentController/edit_post';
$route['master/customer_shipment/delete_post'] = 'masters/CustomerShipmentController/delete_post';
$route['master/customer_shipment/edit-customer'] = 'masters/CustomerShipmentController/edit_customer';
$route['master/customer_shipment/create-customer'] = 'masters/CustomerShipmentController/create_customer';

//master タオル商品
$route['master/towel'] = 'masters/TowelController/index'; 
$route['master/towel/export'] = 'masters/TowelController/export';
$route['master/towel/import'] = 'masters/TowelController/import';
$route['master/towel/get_list'] = 'masters/TowelController/get_list';
$route['master/towel/add_post'] = 'masters/TowelController/add_post';
$route['master/towel/edit_post'] = 'masters/TowelController/edit_post';
$route['master/towel/delete_post'] = 'masters/TowelController/delete_post';

// overview_group_m
$route['master/overview_group_m'] = 'masters/OverviewGroupMController/index';
$route['master/overview_group_m/export'] = 'masters/OverviewGroupMController/export';
$route['master/overview_group_m/import'] = 'masters/OverviewGroupMController/import';
$route['master/overview_group_m/get_list'] = 'masters/OverviewGroupMController/get_list';
$route['master/overview_group_m/add_post'] = 'masters/OverviewGroupMController/add_post';
$route['master/overview_group_m/edit_post'] = 'masters/OverviewGroupMController/edit_post';
$route['master/overview_group_m/delete_post'] = 'masters/OverviewGroupMController/delete_post';

// Log
$route['master/log'] = 'masters/LogController/index';
$route['master/get_log'] = 'masters/LogController/get_view_log';

//master fee_of_gaichyu
$route['master/fee_of_gaichyu'] = 'masters/Fee_Of_GaichyuController/index';
$route['master/fee_of_gaichyu/search'] = 'masters/Fee_Of_GaichyuController/search';
$route['master/fee_of_gaichyu/delete'] = 'masters/Fee_Of_GaichyuController/delete';
$route['master/fee_of_gaichyu/create'] = 'masters/Fee_Of_GaichyuController/create';
$route['master/fee_of_gaichyu/edit'] = 'masters/Fee_Of_GaichyuController/edit';
$route['master/fee_of_gaichyu/import'] = 'masters/Fee_Of_GaichyuController/import';
$route['master/fee_of_gaichyu/export'] = 'masters/Fee_Of_GaichyuController/export';


//master initial_inventory
$route['master/initial_inventory'] = 'masters/Initial_InventoryController/index';
$route['master/initial_inventory/search'] = 'masters/Initial_InventoryController/search';
$route['master/initial_inventory/delete'] = 'masters/Initial_InventoryController/delete';
$route['master/initial_inventory/create'] = 'masters/Initial_InventoryController/create';
$route['master/initial_inventory/edit'] = 'masters/Initial_InventoryController/edit';
$route['master/initial_inventory/import'] = 'masters/Initial_InventoryController/import';
$route['master/initial_inventory/export'] = 'masters/Initial_InventoryController/export';
//master user_stock_export
$route['master/user_stock_export'] = 'masters/User_Stock_ExportController/index';
$route['master/user_stock_export/search'] = 'masters/User_Stock_ExportController/search';
$route['master/user_stock_export/delete'] = 'masters/User_Stock_ExportController/delete';
$route['master/user_stock_export/create'] = 'masters/User_Stock_ExportController/create';
$route['master/user_stock_export/edit'] = 'masters/User_Stock_ExportController/edit';
$route['master/user_stock_export/import'] = 'masters/User_Stock_ExportController/import';
$route['master/user_stock_export/export'] = 'masters/User_Stock_ExportController/export';


//master DISPOSAL_INVENTORY
$route['master/disposal_inventory'] = 'masters/Disposal_InventoryController/index';
$route['master/disposal_inventory/search'] = 'masters/Disposal_InventoryController/search';
$route['master/disposal_inventory/delete'] = 'masters/Disposal_InventoryController/delete';
$route['master/disposal_inventory/create'] = 'masters/Disposal_InventoryController/create';
$route['master/disposal_inventory/edit'] = 'masters/Disposal_InventoryController/edit';
$route['master/disposal_inventory/import'] = 'masters/Disposal_InventoryController/import';
$route['master/disposal_inventory/export'] = 'masters/Disposal_InventoryController/export';

//dashboard page
$route['getDetailOrder'] = 'AdminController/get_detail_order';
$route['getDetailOrder_revenue_1'] = 'AdminController/get_product_revenue';
$route['getDetailODPD'] = 'AdminController/get_product_of_shipment';
$route['getPurcharDetail'] = 'AdminController/get_purchar_detail';
$route['editFlicker'] = 'AdminController/edit_flicker';

$route['exportexcel'] = 'CSVController/exportExcel';
$route['importexcel'] = 'CSVController/importExcel';

// SelectBox server side
$route['product/get_product_selectbox'] = 'masters/ProductController/get_product_selectbox';
$route['customer/get_customer_selectbox'] = 'masters/CustomerController/get_customer_selectbox';
$route['customer/get_infor_customer'] = 'masters/CustomerController/get_infor_of_customer';

// NotificationController
$route['notification'] = 'NotificationController/index';
$route['notification/add'] = 'NotificationController/add_post_notification';
$route['notification/get_list'] = 'NotificationController/get_list_notification';
$route['notification/update_ready'] = 'NotificationController/update_ready_notification';