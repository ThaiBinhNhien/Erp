<?php
/**
* --------------------------------
* Role detail
* --------------------------------
* This file explain which request each role-group can be access.
* Structure: request => array(role-group => level)
*          -------------
* There are 2 level:
*    F: full, can access all data.
*    P: personal, can access only his own data. 
*/

/* Shipment */
$config['roleOf']['shipment'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F', 
    GR_TOKYO_OTHER_ORDERING_PERSON => 'F',
    GR_ATSUGI_FACTORY_PERSONNEL => 'F'
);
$config['roleOf']['shipment/get-shipment-view'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F', 
    GR_TOKYO_OTHER_ORDERING_PERSON => 'F',
    GR_ATSUGI_FACTORY_PERSONNEL => 'F'
);
$config['roleOf']['shipment/export'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F', 
    GR_TOKYO_OTHER_ORDERING_PERSON => 'F',
    GR_ATSUGI_FACTORY_PERSONNEL => 'F'
);
$config['roleOf']['shipment/add'] = array( 
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_TOKYO_OTHER_ORDERING_PERSON => 'F'
);
$config['roleOf']['shipment/detail_order_confirm'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ATSUGI_FACTORY_PERSONNEL => 'F'
);
$config['roleOf']['shipment/detail_shipment'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_TOKYO_OTHER_ORDERING_PERSON => 'F',
    GR_ATSUGI_FACTORY_PERSONNEL => 'F'
);
$config['roleOf']['shipment/edit_shipment'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_TOKYO_OTHER_ORDERING_PERSON => 'F'
);
$config['roleOf']['shipment/delete'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_TOKYO_OTHER_ORDERING_PERSON => 'F'
);
$config['roleOf']['shipment/bill-shipment'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_TOKYO_OTHER_ORDERING_PERSON => 'F',
    GR_ATSUGI_FACTORY_PERSONNEL => 'F'
);
$config['roleOf']['shipment/report-shipment'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ATSUGI_FACTORY_PERSONNEL => 'F'
);
$config['roleOf']['shipment/report-shipment-customer'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ATSUGI_FACTORY_PERSONNEL => 'F'
);
$config['roleOf']['shipment/shipment/report-set-container'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ATSUGI_FACTORY_PERSONNEL => 'F'
);

/* Order */ 
$config['roleOf']['receive-order/checklist'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ORDER_MANAGEMENT_PERSONNEL => 'P',
    GR_ORDER_MANAGEMENT_OFFICER => "F",
    //GR_SUBCONTRACTOR_LOCAL => 'P',
    //GR_SUBCONTRACTOR_TENANT => 'P',
);
$config['roleOf']['receive-order/checklist/pdf_checklist'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ORDER_MANAGEMENT_PERSONNEL => 'P',
    GR_ORDER_MANAGEMENT_OFFICER => "F", 
    //GR_SUBCONTRACTOR_LOCAL => 'P',
    //GR_SUBCONTRACTOR_TENANT => 'P',
);
$config['roleOf']['receive-order'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ORDER_MANAGEMENT_PERSONNEL => 'P',
    GR_ORDER_MANAGEMENT_OFFICER => "F",
    GR_CUSTOMERS => "P",
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P',
);
$config['roleOf']['order/get-order-view'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ORDER_MANAGEMENT_PERSONNEL => 'P',
    GR_ORDER_MANAGEMENT_OFFICER => "F",
    GR_CUSTOMERS => "P",
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P',
);
$config['roleOf']['receive-order/export'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ORDER_MANAGEMENT_PERSONNEL => 'P',
    GR_ORDER_MANAGEMENT_OFFICER => "F",
    GR_CUSTOMERS => "P",
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P',
);
$config['roleOf']['order/create-order'] = array( 
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ORDER_MANAGEMENT_PERSONNEL => "P",
    GR_ORDER_MANAGEMENT_OFFICER => "F",
    GR_CUSTOMERS => "P",
    GR_SUBCONTRACTOR_LOCAL => "P",
    GR_SUBCONTRACTOR_TENANT => "P"
);
$config['roleOf']['order/create-order-2'] = array( 
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ORDER_MANAGEMENT_PERSONNEL => "P",
    GR_ORDER_MANAGEMENT_OFFICER => "F",
    GR_CUSTOMERS => "P",
    GR_SUBCONTRACTOR_LOCAL => "P",
    GR_SUBCONTRACTOR_TENANT => "P"
);
$config['roleOf']['order/detail-order'] = array( 
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ORDER_MANAGEMENT_PERSONNEL => "P",
    GR_ORDER_MANAGEMENT_OFFICER => "F",
    GR_CUSTOMERS => "P",
    GR_SUBCONTRACTOR_LOCAL => "P",
    GR_SUBCONTRACTOR_TENANT => "P"
);
$config['roleOf']['order/copy_order_to_shipment'] = array( 
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ORDER_MANAGEMENT_PERSONNEL => "P",
    GR_ORDER_MANAGEMENT_OFFICER => "F"
);
$config['roleOf']['order/detail-order-2'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ORDER_MANAGEMENT_PERSONNEL => "P",
    GR_ORDER_MANAGEMENT_OFFICER => "F",
    GR_CUSTOMERS => "P",
    GR_SUBCONTRACTOR_LOCAL => "P",
    GR_SUBCONTRACTOR_TENANT => "P"
);
$config['roleOf']['order/edit-order'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ORDER_MANAGEMENT_PERSONNEL => "P",
    GR_ORDER_MANAGEMENT_OFFICER => "F",
    GR_CUSTOMERS => "P",
    GR_SUBCONTRACTOR_LOCAL => "P",
    GR_SUBCONTRACTOR_TENANT => "P"
);
$config['roleOf']['order/edit-order-2'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ORDER_MANAGEMENT_PERSONNEL => "P",
    GR_ORDER_MANAGEMENT_OFFICER => "F",
    GR_CUSTOMERS => "P",
    GR_SUBCONTRACTOR_LOCAL => "P",
    GR_SUBCONTRACTOR_TENANT => "P"
);

/* Delivery */
$config['roleOf']['order/edit-delivery-order'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ORDER_MANAGEMENT_PERSONNEL => 'P', 
    GR_ORDER_MANAGEMENT_OFFICER => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P',
);
$config['roleOf']['order/get-checklist-view'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ORDER_MANAGEMENT_PERSONNEL => 'P',
    GR_ORDER_MANAGEMENT_OFFICER => "F",
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P',
);

/* Home */
$config['roleOf'][''] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    /* Order */
    GR_ORDER_MANAGEMENT_PERSONNEL => 'P',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P',
    GR_CUSTOMERS => 'P',
    GR_ORDER_MANAGEMENT_OFFICER => 'F',

    /* Sales */
    GR_SALES_MANAGEMENT_PERSONNEL => 'P',
    /* Shipment */
    GR_TOKYO_OTHER_ORDERING_PERSON => 'F',
    GR_ATSUGI_FACTORY_PERSONNEL => 'F',
    /* Buy */
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'F',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F',
    /* Orther */
   
    GR_SALES_MANAGEMENT_OFFICER => 'F',
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'F',
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOfHome']['1'] = array( 
    /* Order */
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_ORDER_MANAGEMENT_PERSONNEL => 'P',
    GR_ORDER_MANAGEMENT_OFFICER => 'F',
    GR_CUSTOMERS => 'P',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P'
);
$config['roleOfHome']['2'] = array(
    /* Sales */
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_SALES_MANAGEMENT_PERSONNEL => 'P'
);
$config['roleOfHome']['3'] = array(
    /* Shipment */
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_TOKYO_OTHER_ORDERING_PERSON => 'F',
    GR_ATSUGI_FACTORY_PERSONNEL => 'F'
);
$config['roleOfHome']['4'] = array( 
    /* Buy */
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'F',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F'
);
$config['roleOf']['sale'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SALES_MANAGEMENT_PERSONNEL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P',
    GR_SALES_MANAGEMENT_OFFICER => 'F',
);
$config['roleOf']['sale/ajax_search_order'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SALES_MANAGEMENT_PERSONNEL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P',
    GR_SALES_MANAGEMENT_OFFICER => 'F',
);
$config['roleOf']['sale/add-sale-2'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SALES_MANAGEMENT_PERSONNEL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P',
    GR_SALES_MANAGEMENT_OFFICER => 'F'
);
$config['roleOf']['sale/add-sale'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SALES_MANAGEMENT_PERSONNEL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P',
    GR_SALES_MANAGEMENT_OFFICER => 'F'
);
$config['roleOf']['sale/detail-sale'] = array(
    GR_SALES_MANAGEMENT_OFFICER => 'F',
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SALES_MANAGEMENT_PERSONNEL => 'F',
    GR_SUBCONTRACTOR_TENANT => 'P'
);
$config['roleOf']['sale/edit-sale'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_SALES_MANAGEMENT_PERSONNEL => 'P',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P'
);
$config['roleOf']['sale/created_sale'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_SALES_MANAGEMENT_PERSONNEL => 'P',
    GR_SALES_MANAGEMENT_OFFICER => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P'
);
$config['roleOf']['sale/ajax_search_created'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_SALES_MANAGEMENT_PERSONNEL => 'P',
    GR_SALES_MANAGEMENT_OFFICER => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P'
);

$config['roleOf']['sale'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_SALES_MANAGEMENT_PERSONNEL => 'P',
    GR_SALES_MANAGEMENT_OFFICER => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P'
);
$config['roleOf']['sale/ajax_search_order'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_SALES_MANAGEMENT_PERSONNEL => 'P',
    GR_SALES_MANAGEMENT_OFFICER => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P'
);
$config['roleOf']['sale/edit-sale'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_SALES_MANAGEMENT_PERSONNEL => 'P',
    GR_SALES_MANAGEMENT_OFFICER => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P'
);
$config['roleOf']['sale/detail-sale'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_SALES_MANAGEMENT_PERSONNEL => 'P',
    GR_SALES_MANAGEMENT_OFFICER => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P'
);
$config['roleOf']['sale/ajax_del_sale'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_SALES_MANAGEMENT_PERSONNEL => 'P',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P'
);
$config['roleOf']['sale/ajax_create_list'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P',
    GR_SALES_MANAGEMENT_PERSONNEL => 'P',
    GR_SUBCONTRACTOR_TENANT => 'P',
    GR_SALES_MANAGEMENT_OFFICER => 'F'
);

/*----------------------------------- Master ------------------------------*/
$config['roleOf']['master'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
// USER
$config['roleOf']['master/user'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/user/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/user/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/user/get_list'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/user/add'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/user/add_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/user/edit'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/user/edit_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/user/delete_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/user/check-existed'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master product
$config['roleOf']['master/product'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product/edit-product'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product/get_product_view'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product/create-product'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product/delete-product'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master product_category
$config['roleOf']['master/product_category'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product_category/edit_product_category'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);


//master location
$config['roleOf']['master/location'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/location/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/location/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/location/get_list'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/location/add'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/location/edit'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/location/add_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/location/edit_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/location/delete_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master supplier

$config['roleOf']['master/supplier'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/supplier/edit_supplier'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/supplier/search_supplier'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/supplier/create_supplier'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/supplier/delete_supplier'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/supplier/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/supplier/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master catalogue
$config['roleOf']['master/catalogue_buy'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/catalogue_buy/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/catalogue_buy/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/catalogue_buy/get_list'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/catalogue_buy/add_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/catalogue_buy/edit_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/catalogue_buy/delete_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/catalogue_sale'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/catalogue_sale/import'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/catalogue_sale/export'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/catalogue_sale/get_list'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/catalogue_sale/add_post'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/catalogue_sale/edit_post'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/catalogue_sale/delete_post'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master setting_product
$config['roleOf']['master/setting_product'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product/add'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product/edit'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product/get_list'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product/add_post'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product/edit_post'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product/delete_post'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product/import'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product/export'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master buying_product_category
$config['roleOf']['master/buying_product_category'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/buying_product_category/search_category'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/buying_product_category/delete_category'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/buying_product_category/create_category'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/buying_product_category/edit_category'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

$config['roleOf']['master/buying_product_category/export'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/buying_product_category/import'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
//master selling_product_category
$config['roleOf']['master/selling_product_category'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/selling_product_category/search_category'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/selling_product_category/delete_category'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/selling_product_category/create_category'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/selling_product_category/edit_category'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

$config['roleOf']['master/selling_product_category/import'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/selling_product_category/export'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
//master province
$config['roleOf']['master/province'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master place_of_sales
$config['roleOf']['master/place_of_sales'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/place_of_sales/edit'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/place_of_sales/search'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/place_of_sales/create'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/place_of_sales/delete'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/place_of_sales/import'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/place_of_sales/export'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master customer
$config['roleOf']['master/customer'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/customer/edit-customer'] =array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/customer/create-customer'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/customer/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/customer/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master deparment
$config['roleOf']['master/department'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/department/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/department/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master warehouse
$config['roleOf']['master/warehouse'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master washing_category
$config['roleOf']['master/washing-category'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/washing-category/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/washing-category/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master group_invoice
$config['roleOf']['master/group-invoice'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/group-invoice/create'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/group-invoice/edit'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/group-invoice/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/group-invoice/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master M_machine
$config['roleOf']['master/machine'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/machine/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/machine/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

$config['roleOf']['master/m_machine/search'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/m_machine/delete'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/m_machine/create'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/m_machine/edit'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);



//master powder_main
$config['roleOf']['master/washing-powder'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/washing-powder/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/washing-powder/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master M_washing
$config['roleOf']['master/M_washing'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/M_washing/search'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/M_washing/delete'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/M_washing/edit'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/M_washing/create'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/M_washing/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/M_washing/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master my_one_touch
$config['roleOf']['master/my_one_touch'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/my_one_touch/get_list'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/my_one_touch/add'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/my_one_touch/add_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/my_one_touch/edit'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/my_one_touch/edit_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/my_one_touch/delete_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/my_one_touch/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/my_one_touch/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master setting_product_location
$config['roleOf']['master/setting_product_location'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product_location/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product_location/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product_location/add_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product_location/load_set_product_by_base_customer'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master setting_product_customer
$config['roleOf']['master/setting_product_customer'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product_customer/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product_customer/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product_customer/add_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/setting_product_customer/load_set_product_by_customer'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master shipment
$config['roleOf']['master/shipment_courier'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/shipment_courier/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/shipment_courier/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/shipment_courier/add'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/shipment_courier/add_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/shipment_courier/edit'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/shipment_courier/edit_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/shipment_courier/get_list'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/shipment_courier/delete'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master category
$config['roleOf']['master/category'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/category/edit_category'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master overview_cagegory_m
$config['roleOf']['master/overview_category_m'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/overview_category_m/create'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/overview_category_m/search'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/overview_category_m/delete'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/overview_category_m/edit'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/overview_category_m/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/overview_category_m/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
//master other
$config['roleOf']['master/other'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master supplier_category
$config['roleOf']['master/supplier_category'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/supplier_category/search_category'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/supplier_category/delete_category'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/supplier_category/create_category'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/supplier_category/edit_category'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

$config['roleOf']['master/supplier_category/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/supplier_category/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
// master price product
$config['roleOf']['master/product_price'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product_price/add_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product_price/edit_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product_price/delete_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product_price/get_product_price_sale'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product_price/get_product_price_import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product_price/get_product_price_export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product_price_sale/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product_price_sale/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product_price_import/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product_price_import/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product_price_export/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/product_price_export/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
 
//master statistical_group
$config['roleOf']['master/statistical_group'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/statistical_group/get_list'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/statistical_group/add'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/statistical_group/add_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/statistical_group/edit'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/statistical_group/edit_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/statistical_group/delete_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/statistical_group/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/statistical_group/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master 受発注専用得意先
$config['roleOf']['master/customer_shipment'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/customer_shipment/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/customer_shipment/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/customer_shipment/get_list'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/customer_shipment/add_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/customer_shipment/edit_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/customer_shipment/delete_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

//master タオル商品
$config['roleOf']['master/towel'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/towel/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/towel/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/towel/get_list'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/towel/add_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/towel/edit_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/towel/delete_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

// Log
$config['roleOf']['master/log'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

// overview_group_m
$config['roleOf']['master/overview_group_m'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/overview_group_m/export'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/overview_group_m/import'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/overview_group_m/get_list'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/overview_group_m/add_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/overview_group_m/edit_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);
$config['roleOf']['master/overview_group_m/delete_post'] = array(
    GR_MASTER_ADMINISTRATOR => 'F'
);

/*----------------------------------- End Master ------------------------------*/


/*----------------------------------- Report ------------------------------*/

// Quản lý kinh doanh
$config['roleOf']['business-management'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'P'
);
$config['roleOf']['pdf_daily_schedule_a'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'P'
);
$config['roleOf']['pdf_daily_schedule_b'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'P'
);
$config['roleOf']['pdf_sales_score'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'P'
);
$config['roleOf']['pdf_sales_product'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'P'
);
$config['roleOf']['pdf_sales_customer'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'P'
);

// Quản lý tồn kho
$config['roleOf']['business/inventory'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'P'
);
$config['roleOf']['pdf_inventory_list'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'P'
);
$config['roleOf']['pdf_warehouse_status'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'P'
);
$config['roleOf']['pdf_delivery_achievement_rate'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'P'
);
$config['roleOf']['pdf_detergent_condition'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'P'
);
$config['roleOf']['pdf_details_buy'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'P'
);
$config['roleOf']['pdf_purchase_ledger_collective'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'P'
);
$config['roleOf']['pdf_delivery_achievement_rate'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'P'
);

// Quản lý sản suất
$config['roleOf']['operation/produce'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F',
    GR_MANAGEMENT_DATA_PERSONAL => 'P'
);

/*----------------------------------- End Report ------------------------------*/


/*----------------------------------- Purchase ------------------------------*/
// View list orders
$config['roleOf']['purchase'] = array( 
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'F',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P'
);
$config['roleOf']['purchase/ajax_search_order_purchase'] = array( 
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'F',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P'
);
// View order detail
$config['roleOf']['purchase/detail-purchase'] = array( 
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'F',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P'
);
// Add
$config['roleOf']['purchase/add-purchase'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F', 
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'F',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P'
);
// Edit
$config['roleOf']['purchase/editOrder'] = array( 
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'P',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P'
);
$config['roleOf']['purchase/ajax_edit_purchase_order'] = array( 
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'P',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P'
);
// Delete
$config['roleOf']['purchase/ajax_del_purchase_order'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F', 
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'P',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F',
    GR_SUBCONTRACTOR_LOCAL => 'P'
);
// Confirm
$config['roleOf']['purchase/ajax_confirm_order_purchase'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F', 
    //GR_PURCHASING_MANAGEMENT_PERSONNEL => 'P',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F'
);
/*-----------------------------------End Purchase ------------------------------*/

/*----------------------------------- Sale ------------------------------*/
// View list of products
$config['roleOf']['purchase/export-purchase'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F', 
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'F',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F'
);

$config['roleOf']['purchase/ajax-export-purchase'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F', 
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'F',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F'
);
// View order detail
$config['roleOf']['purchase/detail-export-purchase'] = array( 
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'F',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F'
);
$config['roleOf']['purchase/ajax_del_export_order'] = array( 
    GR_SYSTEM_ADMINISTRATOR => 'F',
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'P',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F'
);
// Add
$config['roleOf']['purchase/add-export-purchase'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F', 
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'F',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F'
);
$config['roleOf']['purchase/edit-export-purchase'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F', 
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'P',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F'
);

//
$config['roleOf']['purchase/debt'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F', 
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'F',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F'
);
$config['roleOf']['pdf_details_buy_buying'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F', 
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'F',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F'
);
$config['roleOf']['purchase/detailDebt'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F', 
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'F',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F'
);
$config['roleOf']['purchase/pdf_check_price'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F', 
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'F',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F'
);

$config['roleOf']['purchase/processing-purchase'] = array(
    GR_SYSTEM_ADMINISTRATOR => 'F', 
    GR_PURCHASING_MANAGEMENT_PERSONNEL => 'P',
    GR_PURCHASE_MANAGEMENT_OFFICER => 'F'
);

// OPERATION PRODUCE
$config['roleOf']['operation/produce/pdf-produce-shipment'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F', 
    GR_MANAGEMENT_DATA_PERSONAL => 'P',
);
$config['roleOf']['operation/produce/csv-produce-shipment'] = $config['roleOf']['operation/produce/pdf-produce-shipment'];

$config['roleOf']['operation/produce/pdf-produce-shipment-cus'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F', 
    GR_MANAGEMENT_DATA_PERSONAL => 'P',
);
$config['roleOf']['operation/produce/csv-produce-shipment-cus'] = $config['roleOf']['operation/produce/pdf-produce-shipment-cus'];

$config['roleOf']['operation/produce/pdf-produce-quantity-used-by-device'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F', 
    GR_MANAGEMENT_DATA_PERSONAL => 'P',
);
$config['roleOf']['operation/produce/csv-produce-quantity-used-by-device'] = $config['roleOf']['operation/produce/pdf-produce-quantity-used-by-device'];

$config['roleOf']['operation/produce/pdf-produce-washing-amount'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F', 
    GR_MANAGEMENT_DATA_PERSONAL => 'P',
);
$config['roleOf']['operation/produce/csv-produce-washing-amount'] = $config['roleOf']['operation/produce/pdf-produce-washing-amount'];

$config['roleOf']['operation/produce/pdf-produce-weight-by-device'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F', 
    GR_MANAGEMENT_DATA_PERSONAL => 'P',
);
$config['roleOf']['operation/produce/csv-produce-weight-by-device'] = $config['roleOf']['operation/produce/pdf-produce-weight-by-device'];

$config['roleOf']['operation/produce/pdf-produce-actual-by-cus'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F', 
    GR_MANAGEMENT_DATA_PERSONAL => 'P',
);
$config['roleOf']['operation/produce/csv-produce-actual-by-cus'] = $config['roleOf']['operation/produce/pdf-produce-actual-by-cus'];

$config['roleOf']['operation/produce/pdf-produce-actual-by-product'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F', 
    GR_MANAGEMENT_DATA_PERSONAL => 'P',
);
$config['roleOf']['operation/produce/csv-produce-actual-by-product'] = $config['roleOf']['operation/produce/pdf-produce-actual-by-product'];

$config['roleOf']['operation/produce/pdf-produce-enegy-used'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F', 
    GR_MANAGEMENT_DATA_PERSONAL => 'P',
);
$config['roleOf']['operation/produce/csv-produce-enegy-used'] = $config['roleOf']['operation/produce/pdf-produce-enegy-used'];

$config['roleOf']['operation/produce/pdf-produce-enegy-graph'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F', 
    GR_MANAGEMENT_DATA_PERSONAL => 'P',
);

$config['roleOf']['operation/produce/pdf-produce-finishing-situation'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F', 
    GR_MANAGEMENT_DATA_PERSONAL => 'P',
);
$config['roleOf']['operation/produce/csv-produce-finishing-situation'] = $config['roleOf']['operation/produce/pdf-produce-finishing-situation'];

$config['roleOf']['operation/produce/pdf-produce-business'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F', 
    GR_MANAGEMENT_DATA_PERSONAL => 'P',
);
$config['roleOf']['operation/produce/csv-produce-business'] = $config['roleOf']['operation/produce/pdf-produce-business'];

$config['roleOf']['operation/produce/pdf-produce-amount-powder-used-by-device'] = array(
    GR_MANAGEMENT_DATA_ALL => 'F', 
    GR_MANAGEMENT_DATA_PERSONAL => 'P',
);
$config['roleOf']['operation/produce/csv-produce-amount-powder-used-by-device'] = $config['roleOf']['operation/produce/pdf-produce-amount-powder-used-by-device'];