<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class InventoryController extends VV_Controller {

	// Construct function
	public function __construct()  
    { 
        parent::__construct();
		$this->load->library('helper','helper');
		$this->load->model('Inventory','inventory_model');
		$this->load->model('Initial_Inventory','initial_inventory_model'); 
		$this->load->library('mpdf');
		$this->load->model('ImportExportCsv');
    }

	/**
	* Function: function_inventory_list
	* @access public
	* @return Array
	*/
	public function function_inventory_list($dataModel) {
		$datadetail = array();
		$arrFactory = array();
		$arrCompany = array();
		$arrCompanyOnly = array();
		$arrCategoryCompany = array();
		$arrCategor = array();
		$arrEvent = array();

		if($dataModel != NULL) {
			foreach ($dataModel as $key => $value) {
				array_push(
					$arrCompany,
					array(
						"factory_id" => $value["base_code"],
						"product_category_id" => $value["product_category_buy_id"],
						"category_buy_id" => $value["event_id"],
						"company_id" => $value["place_buy_id"],
						"company_name" => $value["place_buy_name"]
					)
				);

				array_push(
					$arrCompanyOnly,
					array(
						"company_id" => $value["place_buy_id"],
						"company_name" => $value["place_buy_name"]
					)
				);

				array_push(
					$arrCategoryCompany,
					array(
						"company_id" => $value["place_buy_id"],
						"category_buy_id" => $value["event_id"],
						"category_buy_name" => $value["event_name"]
					)
				);

				array_push(
					$arrCategor,
					array(
						"factory_id" => $value["base_code"],
						"product_category_id" => $value["product_category_buy_id"],
						"category_buy_id" => $value["event_id"],
						"category_buy_name" => $value["event_name"]
					)
				);

				array_push(
					$arrEvent,
					array(
						"factory_id" => $value["base_code"],
						"product_category_id" => $value["product_category_buy_id"],
						"product_category_name" => $value["product_category_buy_name"]
					)
				);

				array_push(
					$arrFactory,
					array(
						"factory_id" => $value["base_code"],
						"factory_name" => $value["base_name"]
					)
				);
			}

			// Group BY
			$arrFactory = array_map("unserialize", array_unique(array_map("serialize", $arrFactory)));
			$arrFactory = array_values($arrFactory);

			$arrCategor = array_map("unserialize", array_unique(array_map("serialize", $arrCategor)));
			$arrCategor = array_values($arrCategor);

			$arrCompany = array_map("unserialize", array_unique(array_map("serialize", $arrCompany)));
			$arrCompany = array_values($arrCompany);

			$arrEvent = array_map("unserialize", array_unique(array_map("serialize", $arrEvent)));
			$arrEvent = array_values($arrEvent);

			$arrCompanyOnly = array_map("unserialize", array_unique(array_map("serialize", $arrCompanyOnly)));
			$arrCompanyOnly = array_values($arrCompanyOnly);

			$arrCategoryCompany = array_map("unserialize", array_unique(array_map("serialize", $arrCategoryCompany)));
			$arrCategoryCompany = array_values($arrCategoryCompany);

			array_push($datadetail,
				array(
					"factory"=>$arrFactory,
					"category"=>$arrCategor,
					"company"=>$arrCompany,
					"company_only"=>$arrCompanyOnly,
					"category_company"=>$arrCategoryCompany,
					"product_category"=>$arrEvent,
					"detail"=>$dataModel
				)
			);
		}
		
		return $datadetail;
	}

	/**
	* Function: function_warehouse_status
	* @access public
	* @return Array
	*/
	public function function_warehouse_status($dataModel) {
		$arrProduct = array();
		$datadetail = array();

		if($dataModel != NULL) {
			foreach ($dataModel as $key => $value) {
				array_push(
					$arrProduct,
					array(
						"product_code" => $value["product_buy_code"],
						"product_name" => $value["place_buy_name"],
						"product_color" => $value["product_color"],
						"product_format" => $value["product_format"],
						"product_price" => (!empty($value["id_order"]) && !empty($value["id_import"])) ? $value["price_buy"] : $value["price_sell"],
						"company_buy_id" => $value["place_buy_id"],
						"company_buy_name" => $value["place_buy_name"],
						"company_sale_id" => $value["place_sale_id"],
						"company_sale_name" => $value["place_sale_name"]
					)
				);
			}

			// Group BY
			$arrProduct = array_map("unserialize", array_unique(array_map("serialize", $arrProduct)));
			$arrProduct = array_values($arrProduct);

			array_push($datadetail,
				array(
					"product"=>$arrProduct,
					"detail"=>$dataModel
				)
			);
		}

		return $datadetail;
	}

	/**
	* Function: function_purchase_ledger
	* @access public
	* @return Array
	*/
	public function function_purchase_ledger($dataModel){

		$arrFactory = array();
		$arrEvent = array();
		$arrCompany = array();
		$datadetail = array();

		if($dataModel != null) {

			foreach ($dataModel as $key => $value) {
				array_push(
					$arrFactory,
					array(
						"stock_id" => $value["stock_id"],
						"stock_name" => $value["stock_name"]
					)
				);

				array_push(
					$arrEvent,
					array(
						"stock_id" => $value["stock_id"],
						"product_event_id" => $value["product_event_id"],
						"product_event_name" => $value["product_event_name"]
					)
				);

				array_push(
					$arrCompany,
					array(
						"stock_id" => $value["stock_id"],
						"product_event_id" => $value["product_event_id"],
						"company_id" => $value["company_id"],
						"company_name" => $value["company_name"]
					)
				);
			}

			// Group BY
			$arrFactory = array_map("unserialize", array_unique(array_map("serialize", $arrFactory)));
			$arrFactory = array_values($arrFactory);

			$arrEvent = array_map("unserialize", array_unique(array_map("serialize", $arrEvent)));
			$arrEvent = array_values($arrEvent);

			$arrCompany = array_map("unserialize", array_unique(array_map("serialize", $arrCompany)));
			$arrCompany = array_values($arrCompany);

			array_push($datadetail,
				array(
					"factory"=>$arrFactory,
					"event"=>$arrEvent,
					"company"=>$arrCompany,
					"detail"=>$dataModel,
				)
			);
		}

		return $datadetail;

	}

	/**
	* Function: function_export_details
	* @access public
	* @return Array
	*/
	public function function_export_details($dataModel){
		$arrPlaceSales = array();
		$arrPlaceBuy = array();
		$arrBaseBank = array();
		$datadetail = array();

		if($dataModel != null) {
			
			foreach ($dataModel as $key => $value) {
				array_push(
					$arrPlaceSales,
					array(
						"place_sale_id" => $value["place_sale_id"],
						"place_sale_name" => $value["place_sale_name"],
						"place_sale_postage" => $value["place_sale_postal"],
						"place_sale_address1" => $value["place_sale_address1"],
						"place_sale_address2" => $value["place_sale_address2"],
						"place_sale_phone" => $value["place_sale_phone"],
						"place_sale_fax" => $value["place_sale_fax"]
					)
				);

				array_push(
					$arrPlaceBuy,
					array(
						"place_sale_id" => $value["place_sale_id"],
						"place_buy_id" => $value["place_buy_id"],
						"place_buy_name" => $value["place_buy_name"]
					)
				);

				array_push(
					$arrBaseBank,
					array(
						"place_sale_id" => $value["place_sale_id"],
						"base_bank" => $value["base_bank1"],
						"base_brach" => $value["base_brach1"],
						"base_number" => $value["base_number1"]
					)
				);

				array_push(
					$arrBaseBank,
					array(
						"place_sale_id" => $value["place_sale_id"],
						"base_bank" => $value["base_bank2"],
						"base_brach" => $value["base_brach2"],
						"base_number" => $value["base_number2"]
					)
				);

				array_push(
					$arrBaseBank,
					array(
						"place_sale_id" => $value["place_sale_id"],
						"base_bank" => $value["base_bank3"],
						"base_brach" => $value["base_brach3"],
						"base_number" => $value["base_number3"]
					)
				);


			}

			// Group BY
			$arrPlaceBuy = array_map("unserialize", array_unique(array_map("serialize", $arrPlaceBuy)));
			$arrPlaceBuy = array_values($arrPlaceBuy);

			$arrPlaceSales = array_map("unserialize", array_unique(array_map("serialize", $arrPlaceSales)));
			$arrPlaceSales = array_values($arrPlaceSales);

			$arrBaseBank = array_map("unserialize", array_unique(array_map("serialize", $arrBaseBank)));
			$arrBaseBank = array_values($arrBaseBank);

			array_push($datadetail,
				array(
					"place_buy"=>$arrPlaceBuy,
					"place_sales"=>$arrPlaceSales,
					"base_bank"=>$arrBaseBank,
					"detail"=>$dataModel
				)
			);
		}

		return $datadetail;
	}

    /**
	* Function: pdf_inventory_list
	* @access public
	* @return PDF,CSV
	*/
	public function pdf_inventory_list() {  
		$csv = $this->input->get('csv');

		$getType = $this->input->get('type');
		$getReport = $this->input->get('report');
		
		if($getType == 1) {
			if($csv !== 'true') {
				$pdf = new mPDF('utf8','A3','','',15,15,15,16,9,9);
			}
			if($getReport == 1) {
				$title=$this->lang->line('pdf_inventory_line');
			} else {
				$title=$this->lang->line('pdf_inventory_order');
			}
			
		}
		else if($getType == 2) {
			if($getReport == 1 || $getReport == 2) {
				if($getReport == 1) {
					$title=$this->lang->line('pdf_inventory_detergent');
				} else {
					$title=$this->lang->line('pdf_inventory_order');
				}
				if($csv !== 'true') {
					$pdf = new mPDF('utf8','A4','','',15,15,15,16,9,9); 
				}
			} else {
				$title=$this->lang->line('pdf_inventory_vendor');
				if($csv !== 'true') {
					$pdf = new mPDF('utf8','A4','','',15,15,15,16,9,9); 
				}
			}
		}
		
		if($csv !== 'true') {
			$pdf->SetTitle($title);
		}
		$data = array();
		$data['title'] = $title;
		$data['date_report_now'] = date("y/m/d H:i:s");
		$data['date_report_footer'] = $this->helper->readDateNotText(date("Y/m/d"));

		// Data
		$getPrint = $this->input->get('print'); 
		$getStock = $this->input->get('stock');
		$getDate = $this->input->get('date');
		if($getReport == 2) {
			$dataModel = $this->inventory_model->getListInventory($getStock, $getType, $getDate,true,NULL,NULL,NULL,NULL);
		}
		else {
			$dataModel = $this->inventory_model->getListInventory($getStock, $getType, $getDate,NULL,NULL,NULL,NULL,NULL);
		}
		
		$data['detail'] = $this->function_inventory_list($dataModel);

		// End Data
		if($getType == 1) {
			// [mua vào]
			$data['date_report_now'] = date("y/m/d");
			if($csv !== 'true') {
				$html= $this->load->view('templates/business/report_inventory/pdf_inventory_line', $data, true);
			}
		}
		else if($getType == 2) {

			// [bột giặt]
			if($getReport == 1 || $getReport == 2) {
				$data['date_report_now'] = date("y/m/d");
				if($csv !== 'true') {
					$html= $this->load->view('templates/business/report_inventory/pdf_inventory_detergent', $data, true);
				}
			} else {
				// Danh sách tồn kho nơi mua vào
				if($csv !== 'true') {
					$html= $this->load->view('templates/business/report_inventory/pdf_inventory_vendor', $data, true);
				}
			}
		}
		
		if($csv !== 'true') {
			// write the HTML into the PDF
			$pdf->WriteHTML($html);
			
			// Set footer
			$htmlFooter= $this->load->view('templates/business/report_inventory/pdf_inventory_footer', $data, true);
			$pdf->SetHTMLFooter($htmlFooter);

			$output = $title.'.pdf';
			
			if($getPrint === 'true') {
				$pdf->SetJS('this.print();');
			}
			if($dataModel == null || count($dataModel) <= 0) {
				$pdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
			}
			$pdf->Output("$output", 'I'); 
		} else {
			// Export csv
			$detail = $data['detail'];
			$data_export = array();
			array_push(
				$data_export,
				array(mb_convert_encoding($data['title'], "UTF-8"))
			);
			array_push(
				$data_export,
				array(mb_convert_encoding($data['date_report_now'], "UTF-8"))
			);
			if($getType == 1) {
				// Danh sách tồn kho từng sản phẩm [mua vào]
				if(isset($detail) && isset($detail[0]["factory"])) {
					$totalQuantity = 0;
					$totalAmount = 0;
					foreach ($detail[0]["factory"] as $key => $value) {
						$totalQuantityFactory = 0;
						$totalAmountFactory = 0;

						array_push(
							$data_export,
							array("")
						);

						array_push(
							$data_export,
							array(mb_convert_encoding("拠点", "UTF-8"), mb_convert_encoding($value['factory_name'], "UTF-8"))
						);

						if(isset($detail[0]["category"])) {
							foreach ($detail[0]["category"] as $keyEvent => $valueEvent) {
								if($value["factory_id"] == $valueEvent["factory_id"]) {
									$totalQuantityCategory = 0;
									$totalAmountCategory = 0;

									array_push(
										$data_export,
										array(mb_convert_encoding("種目別", "UTF-8"), mb_convert_encoding($valueEvent['category_buy_name'], "UTF-8"))
									);

									if(isset($detail[0]["product_category"])) { 
										foreach ($detail[0]["product_category"] as $keyCategory => $valueCategory) {
											if($value["factory_id"] == $valueCategory["factory_id"] && $valueEvent["product_category_id"] == $valueCategory["product_category_id"]) {
												array_push(
													$data_export,
													array(mb_convert_encoding("商品区分名", "UTF-8"), mb_convert_encoding($valueCategory['product_category_name'], "UTF-8"))
												);

												if(isset($detail[0]["company"])) {
													array_push(
														$data_export,
														array(
															mb_convert_encoding("仕 入 先 名", "UTF-8"),
															mb_convert_encoding("商品コード", "UTF-8"),
															mb_convert_encoding("商品名", "UTF-8"),
															mb_convert_encoding("ＣＯＬＯＲ", "UTF-8"),
															mb_convert_encoding("規格", "UTF-8"),
															mb_convert_encoding("備考", "UTF-8"),
															mb_convert_encoding("主な使用先", "UTF-8"),
															mb_convert_encoding("在庫数", "UTF-8"),
															mb_convert_encoding("単価", "UTF-8"),
															mb_convert_encoding("金 額", "UTF-8"),
														)
													);
													foreach ($detail[0]["company"] as $keyCompany => $valueCompany) {
														if($value["factory_id"] == $valueCompany["factory_id"] && $valueEvent["category_buy_id"] == $valueCompany["category_buy_id"] && $valueCategory["product_category_id"] == $valueCompany["product_category_id"]) {
														
															if(isset($detail[0]['detail'])) {
																foreach ($detail[0]['detail'] as $keyProduct => $valueProduct) {
																	if($value["factory_id"] == $valueProduct["base_code"] && $valueEvent["category_buy_id"] == $valueProduct["event_id"] && $valueCompany["company_id"] == $valueProduct["place_buy_id"] && $valueCompany["product_category_id"] == $valueProduct["product_category_buy_id"]) {
																		$product_amount = (float)$valueProduct['price_buy'] * (float)$valueProduct['zaikosu'];
																		$totalQuantityFactory += $valueProduct['zaikosu'];
																		$totalAmountFactory += $product_amount;
																		$totalQuantityCategory += $valueProduct['zaikosu'];
																		$totalAmountCategory += $product_amount;
																		$totalQuantity += $valueProduct['zaikosu'];
																		$totalAmount += $product_amount;
																	
																		array_push(
																			$data_export,
																			array(
																				mb_convert_encoding($valueCompany['company_name'], "UTF-8"),
																				mb_convert_encoding($valueProduct['product_buy_code'], "UTF-8"),
																				mb_convert_encoding($valueProduct['product_buy_name'], "UTF-8"),
																				mb_convert_encoding($valueProduct['product_color'], "UTF-8"),
																				mb_convert_encoding($valueProduct['product_format'], "UTF-8"),
																				mb_convert_encoding($valueProduct['product_note'], "UTF-8"),
																				mb_convert_encoding($valueProduct['product_common_use'], "UTF-8"),
																				mb_convert_encoding($valueProduct['zaikosu'], "UTF-8"),
																				mb_convert_encoding($valueProduct['price_buy'], "UTF-8"),
																				mb_convert_encoding($product_amount, "UTF-8"),
																			)
																		);
																	}
																}
															}
														}
													}
												}
											}
										}
									}

									array_push(
										$data_export,
										array(
											"",
											"",
											"",
											"",
											"",
											"",
											mb_convert_encoding($valueEvent["category_buy_name"]."の合計", "UTF-8"),
											mb_convert_encoding($totalQuantityCategory, "UTF-8"),
											"",
											mb_convert_encoding($totalAmountCategory, "UTF-8"),
										)
									);
								}
							}
						}

						array_push(
							$data_export,
							array(
								"",
								"",
								"",
								"",
								"",
								"",
								mb_convert_encoding($value['factory_name']."の合計", "UTF-8"),
								mb_convert_encoding($totalQuantityFactory, "UTF-8"),
								"",
								mb_convert_encoding($totalAmountFactory, "UTF-8"),
							)
						);
					}
					array_push(
						$data_export,
						array(
							"",
							"",
							"",
							"",
							"",
							"",
							mb_convert_encoding("総　　合　　計", "UTF-8"),
							mb_convert_encoding($totalQuantity, "UTF-8"),
							"",
							mb_convert_encoding($totalAmount, "UTF-8"),
						)
					);
				}
			}
			else if($getType == 2) {
				// Danh sách tồn kho từng sản phẩm [bột giặt]
				if($getReport == 1 || $getReport == 2) {
					if(isset($detail) && isset($detail[0]["factory"])) {
						$totalQuantity = 0;
						$totalAmount = 0;
						foreach ($detail[0]["factory"] as $key => $value) {
							$totalQuantityFactory = 0;
							$totalAmountFactory = 0;

							array_push(
								$data_export,
								array("")
							);

							array_push(
								$data_export,
								array(mb_convert_encoding("拠点", "UTF-8"), mb_convert_encoding($value['factory_name'], "UTF-8"))
							);

							if(isset($detail[0]["category"])) {
								foreach ($detail[0]["category"] as $keyCategory => $valueCategory) {
									if($value["factory_id"] == $valueCategory["factory_id"]) {
										$totalQuantityCategory = 0;
										$totalAmountCategory = 0;
										array_push(
											$data_export,
											array(mb_convert_encoding("種目別", "UTF-8"), mb_convert_encoding($valueCategory['category_buy_name'], "UTF-8"))
										);
										if(isset($detail[0]['detail'])) {
											array_push(
												$data_export,
												array(
													mb_convert_encoding("商品コード", "UTF-8"),
													mb_convert_encoding("商品名", "UTF-8"),
													mb_convert_encoding("備考", "UTF-8"),
													mb_convert_encoding("主な使用先", "UTF-8"),
													mb_convert_encoding("在庫数", "UTF-8"),
													mb_convert_encoding("単価", "UTF-8"),
													mb_convert_encoding("金 額", "UTF-8"),
													mb_convert_encoding("仕 入 先 名", "UTF-8"),
												)
											);
											foreach ($detail[0]['detail'] as $keyProduct => $valueProduct) {
												if($value["factory_id"] == $valueProduct["base_code"] && $valueCategory["category_buy_id"] == $valueProduct["event_id"]) {
													$product_amount = (float)$valueProduct['price_buy'] * (float)$valueProduct['zaikosu'];
													$totalQuantityFactory += $valueProduct['zaikosu'];
													$totalAmountFactory += $product_amount;
													$totalQuantityCategory += $valueProduct['zaikosu'];
													$totalAmountCategory += $product_amount;
													$totalQuantity += $valueProduct['zaikosu'];
													$totalAmount += $product_amount;

													array_push(
														$data_export,
														array(
															mb_convert_encoding($valueProduct['product_buy_code'], "UTF-8"),
															mb_convert_encoding($valueProduct['product_buy_name'], "UTF-8"),
															mb_convert_encoding($valueProduct['product_note'], "UTF-8"),
															mb_convert_encoding($valueProduct['product_common_use'], "UTF-8"),
															mb_convert_encoding($valueProduct['zaikosu'], "UTF-8"),
															mb_convert_encoding($valueProduct['product_price'], "UTF-8"),
															mb_convert_encoding($product_amount, "UTF-8"),
															mb_convert_encoding($valueProduct['place_buy_name'], "UTF-8"),
														)
													);
												}
											}
										}

										array_push(
											$data_export,
											array(
												"",
												"",
												"",
												mb_convert_encoding($valueCategory['category_buy_name']."の合計", "UTF-8"),
												mb_convert_encoding($totalQuantityCategory, "UTF-8"),
												"",
												mb_convert_encoding("¥".$totalAmountCategory, "UTF-8"),
												"",
											)
										);
									}
								}
							}

							array_push(
								$data_export,
								array(
									"",
									"",
									"",
									mb_convert_encoding($value['factory_name']."の合計", "UTF-8"),
									mb_convert_encoding($totalQuantityFactory, "UTF-8"),
									"",
									mb_convert_encoding("¥".$totalAmountFactory, "UTF-8"),
									"",
								)
							);
						}

						array_push(
							$data_export,
							array(
								"",
								"",
								"",
								mb_convert_encoding("総　合　計", "UTF-8"),
								mb_convert_encoding($totalQuantity, "UTF-8"),
								"",
								mb_convert_encoding("¥".$totalAmount, "UTF-8"),
								"",
							)
						);
					}
				} else {
					// Danh sách tồn kho nơi mua vào
					if(isset($detail[0]["company_only"])) {
						$totalQuantity = 0;
						$totalAmount = 0;
						foreach ($detail[0]["company_only"] as $keyCompany => $valueCompany) {
							$totalQuantityFactory = 0;
							$totalAmountFactory = 0;

							array_push(
								$data_export,
								array("")
							);
							array_push(
								$data_export,
								array(mb_convert_encoding("仕 入 先 名", "UTF-8"), mb_convert_encoding($valueCompany['company_name'], "UTF-8"))
							);
							if(isset($detail[0]["category_company"])) {
								foreach ($detail[0]["category_company"] as $keyCategory => $valueCategory) {
									if($valueCompany["company_id"] == $valueCategory["company_id"]){
										$totalQuantityCategory = 0;
										$totalAmountCategory = 0;

										array_push(
											$data_export,
											array(mb_convert_encoding("種目別", "UTF-8"), mb_convert_encoding($valueCategory['category_buy_name'], "UTF-8"))
										);

										if(isset($detail[0]['detail'])) {
											array_push(
												$data_export,
												array(
													mb_convert_encoding("商品コード", "UTF-8"),
													mb_convert_encoding("商品名", "UTF-8"),
													mb_convert_encoding("備考", "UTF-8"),
													mb_convert_encoding("主な使用先", "UTF-8"),
													mb_convert_encoding("在庫数", "UTF-8"),
													mb_convert_encoding("単価", "UTF-8"),
													mb_convert_encoding("金 額", "UTF-8"),
													mb_convert_encoding("拠点", "UTF-8")
												)
											);
											foreach ($detail[0]['detail'] as $keyProduct => $valueProduct) {
												if($valueCompany["company_id"] == $valueProduct["place_buy_id"] && $valueCategory["category_buy_id"] == $valueProduct["event_id"]) {
													$product_amount = (float)$valueProduct['price_buy'] * (float)$valueProduct['zaikosu'];
													$totalQuantityFactory += $valueProduct['zaikosu'];
													$totalAmountFactory += $product_amount;
													$totalQuantityCategory += $valueProduct['zaikosu'];
													$totalAmountCategory += $product_amount;
													$totalQuantity += $valueProduct['zaikosu'];
													$totalAmount += $product_amount;

													array_push(
														$data_export,
														array(
															mb_convert_encoding($valueProduct['product_buy_code'], "UTF-8"),
															mb_convert_encoding($valueProduct['product_buy_name'], "UTF-8"),
															mb_convert_encoding($valueProduct['product_note'], "UTF-8"),
															mb_convert_encoding($valueProduct['product_common_use'], "UTF-8"),
															mb_convert_encoding($valueProduct['zaikosu'], "UTF-8"),
															mb_convert_encoding($valueProduct['price_buy'], "UTF-8"),
															mb_convert_encoding($product_amount, "UTF-8"),
															mb_convert_encoding($valueProduct['base_name'], "UTF-8")
														)
													);
												}
											}
										}

										array_push(
											$data_export,
											array(
												"",
												"",
												"",
												mb_convert_encoding("小 計", "UTF-8"),
												mb_convert_encoding($totalQuantityCategory, "UTF-8"),
												"",
												mb_convert_encoding("¥".$totalAmountCategory, "UTF-8"),
												""
											)
										);
									}
								}
							}

							array_push(
								$data_export,
								array(
									"",
									"",
									"",
									mb_convert_encoding("合 計", "UTF-8"),
									mb_convert_encoding($totalQuantityFactory, "UTF-8"),
									"",
									mb_convert_encoding("¥".$totalAmountFactory, "UTF-8"),
									""
								)
							);
						}

						array_push(
							$data_export,
							array(
								"",
								"",
								"",
								mb_convert_encoding("総　合　計", "UTF-8"),
								mb_convert_encoding($totalQuantity, "UTF-8"),
								"",
								mb_convert_encoding("¥".$totalAmount, "UTF-8"),
								""
							)
						);
					}
				}
			}
			
			$this->ImportExportCsv->download_send_header_csv($data['title']);
			echo $this->ImportExportCsv->array_to_csv($data_export);
		}
	}

	/**
	* Function: pdf_warehouse_status
	* @access public
	* @return PDF,CSV
	*/
	public function pdf_warehouse_status() {
		$csv = $this->input->get('csv');

		if($csv !== 'true') {
			$pdf = new mPDF('utf8','A3-L','','',15,15,15,16,9,9); 
		}
		
		$title=$this->lang->line('pdf_warehouse_status');
		if($csv !== 'true') {
			$pdf->SetTitle($title);
		}
		$data = array();
		$data['title'] = $title;
		$data['date_report_now'] = $this->helper->readDateNotText(date("Y/m/d"));

		// Data
		$data['exp_from'] = $this->input->get("exp_from");
		$data['exp_to'] = $this->input->get("exp_to");
		$getProduct = $this->input->get("product");
		$getProductType = $this->input->get("type");

		$keyword['product_id'] = $getProduct;
		$keyword['product_type_buy'] = $getProductType;
		$keyword['date_from'] = $data['exp_from'];
		$keyword['date_to'] = $data['exp_to'];

		$dataModel = $this->inventory_model->getListInforReceipt($keyword);
		$data['detail'] = $this->function_warehouse_status($dataModel);
		// End Data

		if($csv !== 'true') {
			$html= $this->load->view('templates/business/report_inventory/pdf_warehouse_status', $data, true);
			
			// Set footer
			$htmlFooter= $this->load->view('templates/business/report_inventory/pdf_warehouse_status_footer', $data, true);
			$pdf->SetHTMLFooter($htmlFooter);
			
			// write the HTML into the PDF
			$pdf->WriteHTML($html);
			$output = $title.'.pdf';
			if($dataModel == null || count($dataModel) <= 0) {
				$pdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
			}
			$pdf->Output("$output", 'I'); 
		} else {
			// Export Csv
			$detail = $data['detail'];
			$data_export = array();
			array_push(
				$data_export,
				array(mb_convert_encoding($data['title'], "UTF-8"))
			);
			array_push(
				$data_export,
				array(mb_convert_encoding("対象期間 ".$data['date_from']." ～ ".$data['date_to'], "UTF-8"))
			);

			if(isset($detail)) {
                if(isset($detail[0]["product"])) {
					foreach ($detail[0]["product"] as $key => $value) {
						array_push(
							$data_export,
							array("")
						);
						array_push(
							$data_export,
							array(
								mb_convert_encoding("商品ID", "UTF-8"),
								mb_convert_encoding("商 品 名", "UTF-8"),
								mb_convert_encoding("色調", "UTF-8"),
								mb_convert_encoding("規格", "UTF-8"),
								mb_convert_encoding("単価", "UTF-8"),
								mb_convert_encoding("備考", "UTF-8"),
								mb_convert_encoding("仕入先名", "UTF-8"),
								mb_convert_encoding("販売先名", "UTF-8")
							)
						);
						array_push(
							$data_export,
							array(
								mb_convert_encoding($value['product_code'], "UTF-8"),
								mb_convert_encoding($value['product_name'], "UTF-8"),
								mb_convert_encoding($value['product_color'], "UTF-8"),
								mb_convert_encoding($value['product_format'], "UTF-8"),
								mb_convert_encoding($value['product_price'], "UTF-8"),
								mb_convert_encoding($value['product_note'], "UTF-8"),
								mb_convert_encoding($value['company_buy_name'], "UTF-8"),
								mb_convert_encoding($value['company_sale_name'], "UTF-8")
							)
						);

						if(isset($detail[0]['detail'])) {
							array_push(
								$data_export,
								array(
									mb_convert_encoding("発注伝票ID", "UTF-8"),
									mb_convert_encoding("入庫伝票ID", "UTF-8"),
									mb_convert_encoding("出荷伝票ID", "UTF-8"),
									mb_convert_encoding("処理", "UTF-8"),
									mb_convert_encoding("日付", "UTF-8"),
									mb_convert_encoding("発注", "UTF-8"),
									mb_convert_encoding("入荷", "UTF-8"),
									mb_convert_encoding("出荷", "UTF-8"),
									mb_convert_encoding("返品", "UTF-8")
								)
							);
							foreach ($detail[0]['detail'] as $keyDetail => $valueDetail) {
								$product_price = (!empty($valueDetail["id_order"]) && !empty($valueDetail["id_import"])) ? $valueDetail["price_buy"] : $valueDetail["price_sell"];
								if($value["product_code"] == $valueDetail["product_buy_code"] && $value["product_price"] == $product_price && $value["company_buy_id"] == $valueDetail["place_buy_id"] && $value["company_sale_id"] == $valueDetail["place_sale_id"]) {
									
									array_push(
										$data_export,
										array(
											mb_convert_encoding($valueDetail['id_order'], "UTF-8"),
											mb_convert_encoding($valueDetail['id_import'], "UTF-8"),
											mb_convert_encoding($valueDetail['id_export'], "UTF-8"),
											mb_convert_encoding($valueDetail['process_content_name'], "UTF-8"),
											mb_convert_encoding($valueDetail['date_creater'], "UTF-8"),
											mb_convert_encoding($valueDetail['number_order'], "UTF-8"),
											mb_convert_encoding($valueDetail['number_import'], "UTF-8"),
											mb_convert_encoding($valueDetail['number_export'], "UTF-8"),
											mb_convert_encoding($valueDetail['number_repay'], "UTF-8")
										)
									);
								}
							}
						}
					}
				}
			}

			$this->ImportExportCsv->download_send_header_csv($data['title']);
			echo $this->ImportExportCsv->array_to_csv($data_export);
		}
	}

	/**
	* Function: pdf_delivery_achievement_rate
	* Báo cáo tỷ lệ hoàn thành giao hàng
	* @access public
	* @return PDF,CSV
	*/
	public function pdf_delivery_achievement_rate() {
		$csv = $this->input->get('csv');

		if($csv !== 'true') {
			$pdf = new mPDF('utf8','A4-L','','',15,15,15,15,9,9);  
		}
		
		$title=$this->lang->line('pdf_delivery_achievement_rate');
		if($csv !== 'true') {
			$pdf->SetTitle($title);
		}
		$data = array();
		$data['title'] = $title;
		$data['date_report_now'] = $this->helper->readDateNotText(date("Y/m/d"));

		// Data Dummy
		$data['exp_from'] = $this->input->get("from");
		$data['exp_to'] = $this->input->get("to");
		$getProduct = $this->input->get("product");
		$data['detail'] = $this->inventory_model->getListShipmentStatus($data['exp_from'],$data['exp_to'],$getProduct);
		// End Data

		if($csv !== 'true') {
			if(!empty($getProduct)) {
				$html= $this->load->view('templates/business/report_inventory/pdf_delivery_achievement_rate_product', $data, true);
			} else {
				$html= $this->load->view('templates/business/report_inventory/pdf_delivery_achievement_rate', $data, true);
			}
			
			
			// Set footer
			$htmlFooter= $this->load->view('templates/business/report_inventory/pdf_warehouse_status_footer', $data, true);
			$pdf->SetHTMLFooter($htmlFooter);
			
			// write the HTML into the PDF
			$pdf->WriteHTML($html);
			
			$getPrint = $this->input->get('print');
			if($getPrint === 'true') { 
				$pdf->SetJS('this.print();');
			}
			$output = $title.'.pdf';
			if($data['detail'] == null || count($data['detail']) <= 0) {
				$pdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
			}
			$pdf->Output("$output", 'I'); 
		} else {
			// Export csv
			$detail = $data['detail'];
			$data_export = array();
			array_push(
				$data_export,
				array(mb_convert_encoding($data['title'], "UTF-8"))
			);
			array_push(
				$data_export,
				array(mb_convert_encoding("対象期間 ".$data['exp_from']." ～ ".$data['exp_to'], "UTF-8"))
			);
			array_push(
				$data_export,
				array("")
			);

			if(!empty($getProduct)) {
				array_push(
					$data_export,
					array(
						mb_convert_encoding("商品コード", "UTF-8"),
						mb_convert_encoding("商品名", "UTF-8"),
						mb_convert_encoding("規格", "UTF-8"),
						mb_convert_encoding("カラー", "UTF-8")
					)
				);
				if(isset($detail) && count($detail) > 0) {
					array_push(
						$data_export,
						array(
							mb_convert_encoding($detail[0]['product_code_sell'], "UTF-8"),
							mb_convert_encoding($detail[0]['product_name_sell'], "UTF-8"),
							mb_convert_encoding($detail[0]['product_format'], "UTF-8"),
							mb_convert_encoding($detail[0]['product_color'], "UTF-8")
						)
					);
				}

				array_push(
					$data_export,
					array(
						mb_convert_encoding("出荷日", "UTF-8"),
						mb_convert_encoding("得意先", "UTF-8"),
						mb_convert_encoding("部署", "UTF-8"),
						mb_convert_encoding("納品数", "UTF-8"),
						mb_convert_encoding("注文数", "UTF-8"),
						mb_convert_encoding("達成率", "UTF-8")
					)
				);
				$dem = 0;
				$total_rate = 0;
				if(isset($detail)) {
					foreach ($detail as $key => $value) {
						$rate = 0;
						$number_order = (!empty($value['number_order'])) ? $value['number_order'] : 0;
						$number_delivery = (!empty($value['number_delivery'])) ? $value['number_delivery'] : 0;
						if($number_delivery >= $number_order) {
							$rate = 100;
						} else {
							$rate = $number_delivery/$number_order * 100;
						}

						$dem ++;
						$total_rate += $rate;
						
						$date_update = new DateTime($value['date_update']);

						array_push(
							$data_export,
							array(
								mb_convert_encoding($date_update->format('Y-m-d'), "UTF-8"),
								mb_convert_encoding($value['customer_name'], "UTF-8"),
								mb_convert_encoding($value['department_name'], "UTF-8"),
								mb_convert_encoding($number_delivery, "UTF-8"),
								mb_convert_encoding($number_order, "UTF-8"),
								mb_convert_encoding(round($rate)."%", "UTF-8")
							)
						);
					}
				}

				array_push(
					$data_export,
					array(
						"",
						"",
						"",
						"",
						mb_convert_encoding("平均：", "UTF-8"),
						mb_convert_encoding(((!empty($total_rate)) ? round(($total_rate/$dem))."%" : ""), "UTF-8")
					)
				);
			} else {
				array_push(
					$data_export,
					array(mb_convert_encoding("対象商品：", "UTF-8"),mb_convert_encoding("全商品", "UTF-8"))
				);
				array_push(
					$data_export,
					array(
						mb_convert_encoding("商品コード", "UTF-8"),
						mb_convert_encoding("商品名", "UTF-8"),
						mb_convert_encoding("納品数", "UTF-8"),
						mb_convert_encoding("注文数", "UTF-8"),
						mb_convert_encoding("達成率", "UTF-8")
					)
				);
				$dem = 0;
				$total_rate = 0;
				if(isset($detail)) {
					foreach ($detail as $key => $value) {
						$rate = 0;
						$number_order = (!empty($value['number_order'])) ? $value['number_order'] : 0;
						$number_delivery = (!empty($value['number_delivery'])) ? $value['number_delivery'] : 0;
						if($number_delivery >= $number_order) {
							$rate = 100;
						} else {
							$rate = $number_delivery/$number_order * 100;
						}

						$dem ++;
						$total_rate += $rate;

						array_push(
							$data_export,
							array(
								mb_convert_encoding($value['product_code_sell'], "UTF-8"),
								mb_convert_encoding($value['product_name_sell'], "UTF-8"),
								mb_convert_encoding($number_delivery, "UTF-8"),
								mb_convert_encoding($number_order, "UTF-8"),
								mb_convert_encoding(round($rate)."%", "UTF-8")
							)
						);
					}
				}

				array_push(
					$data_export,
					array(
						"",
						"",
						"",
						mb_convert_encoding("平均：", "UTF-8"),
						mb_convert_encoding(((!empty($total_rate)) ? round(($total_rate/$dem))."%" : ""), "UTF-8")
					)
				);
			}

			$this->ImportExportCsv->download_send_header_csv($data['title']);
			echo $this->ImportExportCsv->array_to_csv($data_export);
		}
	}

	/**
	* Function: function_purchase_ledger_collective
	* @access public
	* @return Array
	*/
	public function function_purchase_ledger_collective($dataModel){
		$arrSaleBuy = array();
		$arrOnlyBuy = array();
		$arrSaleFromBuy = array();
		$datadetail = array();
		$dataEvent = array();

		if($dataModel != null) {
			
			foreach ($dataModel as $key => $value) {
				array_push($arrSaleBuy,
					array(
						"place_buy_id"=>$value["place_buy_id"],
						"place_buy_name"=>$value["place_buy_name"],
						"place_sale_id"=>$value["place_sale_id"],
						"place_sale_name"=>$value["place_sale_name"],
						"event_id"=>$value["event_id"],
					)
				);

				array_push($dataEvent,
					array(
						"event_id"=>$value["event_id"],
						"event_name"=>$value["event_name"]
					)
				);

				array_push($arrSaleFromBuy,
					array(
						"place_buy_id"=>$value["place_buy_id"],
						"place_sale_id"=>$value["place_sale_id"],
						"place_sale_name"=>$value["place_sale_name"]
					)
				);

				array_push($arrOnlyBuy,
					array(
						"place_buy_id"=>$value["place_buy_id"],
						"place_buy_name"=>$value["place_buy_name"]
					)
				);
			}

			// Group BY
			$arrSaleBuy = array_map("unserialize", array_unique(array_map("serialize", $arrSaleBuy)));
			$arrSaleBuy = array_values($arrSaleBuy);

			$dataEvent = array_map("unserialize", array_unique(array_map("serialize", $dataEvent)));
			$dataEvent = array_values($dataEvent);

			$arrOnlyBuy = array_map("unserialize", array_unique(array_map("serialize", $arrOnlyBuy)));
			$arrOnlyBuy = array_values($arrOnlyBuy);

			$arrSaleFromBuy = array_map("unserialize", array_unique(array_map("serialize", $arrSaleFromBuy)));
			$arrSaleFromBuy = array_values($arrSaleFromBuy);

			array_push($datadetail,
				array(
					"place_only_buy"=>$arrOnlyBuy,
					"place_sale_from_buy"=>$arrSaleFromBuy,
					"place_buy_sale"=>$arrSaleBuy,
					"data_event"=>$dataEvent,
					"detail"=>$dataModel,
				)
			);
		}
		
		return $datadetail;
	}

	/**
	* Function: pdf_purchase_ledger_collective
	* @access public
	* @return PDF,CSV
	*/
	public function pdf_purchase_ledger_collective() {
		$csv = $this->input->get('csv');

		if($csv !== 'true') {
			$pdf = new mPDF('utf8','A4','','',10,10,10,10,9,9); 
		}
		
		// GET
		$data = array();
		$data['date_from'] = $this->input->get("date_from");
		$data['date_to'] = $this->input->get("date_to");
		$getImportExport = $this->input->get("import_export");
		$getProductType = $this->input->get("product_type");
		$getFormReport = $this->input->get("type_report");
		$getPlaceBuy = $this->input->get("place_buy");
		$getPlaceSale = $this->input->get("place_sale");
		$getTypeExport = $this->input->get("type_export");
		$data["purchase_ledger_individual"] = 0;

		$title=$this->lang->line('pdf_purchase_ledger_collective');
		if($getImportExport == 1 && $getFormReport == 1) {
			if($getPlaceBuy != "" && $getPlaceSale != "") {
				$title=$this->lang->line('pdf_purchase_ledger_individual');
				$data["purchase_ledger_individual"] = 1;
			}
		} else if($getImportExport == 2 && $getFormReport == 1) {
			$title=$this->lang->line('pdf_delivery_number_confirm');
			if($getTypeExport == 2) {
				$data["title2"]=$this->lang->line('pdf_delivery_number_confirm_wash');
			} else if($getTypeExport == 3) {
				$data["title2"]=$this->lang->line('pdf_delivery_number_confirm_sale');
			}
		} else if($getImportExport == 2 && $getFormReport == 2) {
			$title=$this->lang->line('pdf_purchase_ledger_collective_diff_format');
			if($csv !== 'true') {
				$pdf = new mPDF('utf8','A4-L','','',10,10,10,10,9,9); 
			}
		}
		if($csv !== 'true') {
			$pdf->SetTitle($title);
		} else {
			// Export Csv
			$data_export = array();
			array_push(
				$data_export,
				array(mb_convert_encoding($title, "UTF-8"))
			);
		}
		$data['title'] = $title;
		$data['date_report_now'] = date("Y/m/d");
		if($getImportExport == 2 && $getFormReport == 1){
			$data['date_report_now'] = $this->helper->readDateNotText(date("Y/m/d"));
		}

		// Nhập + thông thường 
		if($getImportExport == 1 && $getFormReport == 1) {
			$keyword['date_import_from'] = $data['date_from'];
			$keyword['date_import_to'] = $data['date_to'];
			$keyword['product_type_buy'] = $getProductType;
			$keyword['place_sale'] = $getPlaceSale;
			$keyword['place_buy'] = $getPlaceBuy;
			$dataModel = $this->inventory_model->getListInforImport($keyword);
			$data['detail'] = $this->function_purchase_ledger_collective($dataModel);
			if($csv !== 'true') {
				$html= $this->load->view('templates/business/report_purchase_ledger/pdf_purchase_ledger_import', $data, true);
				$output = $title.'_洗剤等.pdf';
				if($getProductType == 1 || $getProductType == "1") {
					$output = $title.'_ﾘﾈﾝ.pdf';
				}
			} else {
				$detail = $data['detail'];
				array_push(
					$data_export,
					array(mb_convert_encoding("対象期間 ".$data['date_from']." ～ ".$data['date_to'], "UTF-8"))
				);
				if($data["purchase_ledger_individual"] == 0) {
					$totalAll = 0;
					$numberAll = 0;
					if(isset($detail) && isset($detail[0]["data_event"])) {
						foreach ($detail[0]["data_event"] as $keyEvent => $valueEvent) {
							$totalEvent = 0;
							$numberEvent = 0;
							array_push(
								$data_export,
								array("")
							);
							array_push(
								$data_export,
								array(mb_convert_encoding("種目区分名 :", "UTF-8"),mb_convert_encoding($valueEvent["event_name"], "UTF-8"))
							);
							if(isset($detail) && isset($detail[0]["place_buy_sale"])) {
								foreach ($detail[0]["place_buy_sale"] as $keyPlace => $valuePlace) {
									if($valueEvent["event_id"] == $valuePlace["event_id"]) {
										$totalPlace = 0;
										$numberPlace = 0;
										array_push(
											$data_export,
											array("")
										);
										array_push(
											$data_export,
											array(mb_convert_encoding("仕入先名", "UTF-8"),mb_convert_encoding("販売先名", "UTF-8"))
										);
										array_push(
											$data_export,
											array(mb_convert_encoding($valuePlace["place_buy_name"], "UTF-8"),mb_convert_encoding($valuePlace["place_sale_name"], "UTF-8"))
										);

										if(isset($detail) && isset($detail[0]["detail"])) {
											array_push(
												$data_export,
												array(
													mb_convert_encoding("日付", "UTF-8"),
													mb_convert_encoding("商品コード", "UTF-8"),
													mb_convert_encoding("商品名", "UTF-8"),
													mb_convert_encoding("備考", "UTF-8"),
													mb_convert_encoding("色調", "UTF-8"),
													mb_convert_encoding("規格", "UTF-8"),
													mb_convert_encoding("数量", "UTF-8"),
													mb_convert_encoding("仕入単価", "UTF-8"),
													mb_convert_encoding("支払金額", "UTF-8"),
												)
											);
											foreach ($detail[0]["detail"] as $keyDetail => $valueDetail) {
												if($valuePlace["event_id"] == $valueDetail["event_id"] && $valuePlace["place_buy_id"] == $valueDetail["place_buy_id"] && $valuePlace["place_sale_id"] == $valueDetail["place_sale_id"]) {
													$totalAll += $valueDetail["number_import"] * $valueDetail["price"];
													$totalEvent += $valueDetail["number_import"] * $valueDetail["price"];
													$totalPlace += $valueDetail["number_import"] * $valueDetail["price"];
													$numberAll += $valueDetail["number_import"];
													$numberEvent += $valueDetail["number_import"];
													$numberPlace += $valueDetail["number_import"];

													array_push(
														$data_export,
														array(
															mb_convert_encoding($valueDetail["detail_date"], "UTF-8"),
															mb_convert_encoding($valueDetail["product_buy_code"], "UTF-8"),
															mb_convert_encoding($valueDetail["product_buy_name"], "UTF-8"),
															mb_convert_encoding($valueDetail["product_note"], "UTF-8"),
															mb_convert_encoding($valueDetail["product_color"], "UTF-8"),
															mb_convert_encoding($valueDetail["product_format"], "UTF-8"),
															mb_convert_encoding($valueDetail["number_import"], "UTF-8"),
															mb_convert_encoding($valueDetail["price"], "UTF-8"),
															mb_convert_encoding(($valueDetail["number_import"] * $valueDetail["price"]), "UTF-8"),
														)
													);
												}
											}

											array_push(
												$data_export,
												array(
													"",
													"",
													"",
													"",
													"",
													"",
													mb_convert_encoding($numberPlace, "UTF-8"),
													mb_convert_encoding("仕入金額総合計", "UTF-8"),
													mb_convert_encoding("¥".$totalPlace, "UTF-8"),
												)
											);
											array_push(
												$data_export,
												array(
													"",
													"",
													"",
													"",
													"",
													"",
													"",
													mb_convert_encoding("消費税 8％", "UTF-8"),
													mb_convert_encoding("¥".($totalPlace * CONFIG_CONSUMPTION_TAX), "UTF-8"),
												)
											);
											array_push(
												$data_export,
												array(
													"",
													"",
													"",
													"",
													"",
													"",
													"",
													mb_convert_encoding("総合計", "UTF-8"),
													mb_convert_encoding("¥".($totalPlace + $totalPlace * CONFIG_CONSUMPTION_TAX), "UTF-8"),
												)
											);
										}
									}
								}
							}

							array_push(
								$data_export,
								array(
									"",
									"",
									"",
									"",
									"",
									"",
									mb_convert_encoding($numberEvent, "UTF-8"),
									mb_convert_encoding("仕入金額総合計", "UTF-8"),
									mb_convert_encoding("¥".$totalEvent, "UTF-8"),
								)
							);
							array_push(
								$data_export,
								array(
									"",
									"",
									"",
									"",
									"",
									"",
									"",
									mb_convert_encoding("消費税 8％", "UTF-8"),
									mb_convert_encoding("¥".($totalEvent * CONFIG_CONSUMPTION_TAX), "UTF-8"),
								)
							);
							array_push(
								$data_export,
								array(
									"",
									"",
									"",
									"",
									"",
									"",
									"",
									mb_convert_encoding("総合計", "UTF-8"),
									mb_convert_encoding("¥".($totalEvent + $totalEvent * CONFIG_CONSUMPTION_TAX), "UTF-8"),
								)
							);
						}
					}

					array_push(
						$data_export,
						array("")
					);
					array_push(
						$data_export,
						array(
							"",
							"",
							"",
							"",
							"",
							"",
							mb_convert_encoding($numberAll, "UTF-8"),
							mb_convert_encoding("仕入金額総合計", "UTF-8"),
							mb_convert_encoding("¥".$totalAll, "UTF-8"),
						)
					);
					array_push(
						$data_export,
						array(
							"",
							"",
							"",
							"",
							"",
							"",
							"",
							mb_convert_encoding("消費税 8％", "UTF-8"),
							mb_convert_encoding("¥".($totalAll * CONFIG_CONSUMPTION_TAX), "UTF-8"),
						)
					);
					array_push(
						$data_export,
						array(
							"",
							"",
							"",
							"",
							"",
							"",
							"",
							mb_convert_encoding("総合計", "UTF-8"),
							mb_convert_encoding("¥".($totalAll + $totalAll * CONFIG_CONSUMPTION_TAX), "UTF-8"),
						)
					);
				} else {
					$totalAll = 0;
					$numberAll = 0;
					if(isset($detail) && isset($detail[0]["place_buy_sale"])) {
						foreach ($detail[0]["place_buy_sale"] as $keyPlace => $valuePlace) {
							$totalPlace = 0;
							$numberPlace = 0;
							array_push(
								$data_export,
								array("")
							);
							array_push(
								$data_export,
								array(mb_convert_encoding("仕入先名", "UTF-8"),mb_convert_encoding("販売先名", "UTF-8"))
							);
							array_push(
								$data_export,
								array(mb_convert_encoding($valuePlace["place_buy_name"], "UTF-8"),mb_convert_encoding($valuePlace["place_sale_name"], "UTF-8"))
							);

							if(isset($detail) && isset($detail[0]["detail"])) {
								array_push(
									$data_export,
									array(
										mb_convert_encoding("日付", "UTF-8"),
										mb_convert_encoding("商品コード", "UTF-8"),
										mb_convert_encoding("商品名", "UTF-8"),
										mb_convert_encoding("備考", "UTF-8"),
										mb_convert_encoding("色調", "UTF-8"),
										mb_convert_encoding("規格", "UTF-8"),
										mb_convert_encoding("数量", "UTF-8"),
										mb_convert_encoding("仕入単価", "UTF-8"),
										mb_convert_encoding("支払金額", "UTF-8"),
									)
								);
								foreach ($detail[0]["detail"] as $keyDetail => $valueDetail) {
									if($valuePlace["event_id"] == $valueDetail["event_id"] && $valuePlace["place_buy_id"] == $valueDetail["place_buy_id"] && $valuePlace["place_sale_id"] == $valueDetail["place_sale_id"]) {
										$totalAll += $valueDetail["number_import"] * $valueDetail["price"];
										$totalPlace += $valueDetail["number_import"] * $valueDetail["price"];
										$numberAll += $valueDetail["number_import"];
										$numberPlace += $valueDetail["number_import"];

										array_push(
											$data_export,
											array(
												mb_convert_encoding($valueDetail["detail_date"], "UTF-8"),
												mb_convert_encoding($valueDetail["product_buy_code"], "UTF-8"),
												mb_convert_encoding($valueDetail["product_buy_name"], "UTF-8"),
												mb_convert_encoding($valueDetail["product_note"], "UTF-8"),
												mb_convert_encoding($valueDetail["product_color"], "UTF-8"),
												mb_convert_encoding($valueDetail["product_format"], "UTF-8"),
												mb_convert_encoding($valueDetail["number_import"], "UTF-8"),
												mb_convert_encoding($valueDetail["price"], "UTF-8"),
												mb_convert_encoding(($valueDetail["number_import"] * $valueDetail["price"]), "UTF-8"),
											)
										);
									}
								}

								array_push(
									$data_export,
									array(
										"",
										"",
										"",
										"",
										"",
										"",
										mb_convert_encoding($numberPlace, "UTF-8"),
										mb_convert_encoding("仕入金額総合計", "UTF-8"),
										mb_convert_encoding("¥".$totalPlace, "UTF-8"),
									)
								);
								array_push(
									$data_export,
									array(
										"",
										"",
										"",
										"",
										"",
										"",
										"",
										mb_convert_encoding("消費税 8％", "UTF-8"),
										mb_convert_encoding("¥".($totalPlace * CONFIG_CONSUMPTION_TAX), "UTF-8"),
									)
								);
								array_push(
									$data_export,
									array(
										"",
										"",
										"",
										"",
										"",
										"",
										"",
										mb_convert_encoding("総合計", "UTF-8"),
										mb_convert_encoding("¥".($totalPlace + $totalPlace * CONFIG_CONSUMPTION_TAX), "UTF-8"),
									)
								);
							}
						}
					}

					array_push(
						$data_export,
						array("")
					);
					array_push(
						$data_export,
						array(
							"",
							"",
							"",
							"",
							"",
							"",
							mb_convert_encoding($numberAll, "UTF-8"),
							mb_convert_encoding("仕入金額総合計", "UTF-8"),
							mb_convert_encoding("¥".$totalAll, "UTF-8"),
						)
					);
					array_push(
						$data_export,
						array(
							"",
							"",
							"",
							"",
							"",
							"",
							"",
							mb_convert_encoding("消費税 8％", "UTF-8"),
							mb_convert_encoding("¥".($totalAll * CONFIG_CONSUMPTION_TAX), "UTF-8"),
						)
					);
					array_push(
						$data_export,
						array(
							"",
							"",
							"",
							"",
							"",
							"",
							"",
							mb_convert_encoding("総合計", "UTF-8"),
							mb_convert_encoding("¥".($totalAll + $totalAll * CONFIG_CONSUMPTION_TAX), "UTF-8"),
						)
					);
				}
			}
			
		}
		else if($getImportExport == 2 && $getFormReport == 1){
			//$data_export = "true";
			$data_wash = "";
			$data_sale = "";
			$output = $title.'_ﾘﾈﾝ.pdf';
			if($getTypeExport == 2) {
				$data_wash = "1";
				$output = $title.'（耐洗一年未満の商品）_ﾘﾈﾝ.pdf';
			} else if($getTypeExport == 3) {
				$data_sale = "1";
				$output = $title.'（売却のため出庫した商品）_ﾘﾈﾝ.pdf';
			}

			$keyword['date_export_from'] = $data['date_from'];
			$keyword['date_export_to'] = $data['date_to'];
			$keyword['product_type_buy'] = $getProductType;
			$keyword['place_sale'] = $getPlaceSale;
			$keyword['place_buy'] = $getPlaceBuy;
			$keyword['product_use_wash'] = $data_wash;
			$keyword['product_use_sell'] = $data_sale;
			$dataModel = $this->inventory_model->getListInforExport($keyword);

			$data['detail'] = $this->function_purchase_ledger_collective($dataModel);
			if($csv !== 'true') {
				$html= $this->load->view('templates/business/report_purchase_ledger/pdf_delivery_number_confirm', $data, true);

				// Set footer
				$htmlFooter= $this->load->view('templates/business/report_inventory/pdf_warehouse_status_footer', $data, true);
				$pdf->SetHTMLFooter($htmlFooter);
			} else {
				// Export csv
				$detail = $data['detail'];
				array_push(
					$data_export,
					array(mb_convert_encoding("対象期間 ".$data['date_from']." ～ ".$data['date_to'], "UTF-8"))
				);
				$totalAmout = 0; 
           		$numberExport = 0;
                if(isset($detail) && isset($detail[0]["place_only_buy"])) {
                    foreach ($detail[0]["place_only_buy"] as $keyBuy => $valueBuy) {
                        $totalAmoutBuy = 0;
                        $numberExportBuy = 0;
						array_push(
							$data_export,
							array("")
						);
						array_push(
							$data_export,
							array(mb_convert_encoding("仕入先ID :", "UTF-8"),mb_convert_encoding($valueBuy["place_buy_id"], "UTF-8"))
						);
						array_push(
							$data_export,
							array(mb_convert_encoding("仕入先名 :", "UTF-8"),mb_convert_encoding($valueBuy["place_buy_name"], "UTF-8"))
						);
						array_push(
							$data_export,
							array(
								mb_convert_encoding("日付", "UTF-8"),
								mb_convert_encoding("伝票ID", "UTF-8"),
								mb_convert_encoding("商品ID", "UTF-8"),
								mb_convert_encoding("商 品 名", "UTF-8"),
								mb_convert_encoding("出荷数", "UTF-8"),
								mb_convert_encoding("単価", "UTF-8"),
								mb_convert_encoding("金額", "UTF-8"),
								mb_convert_encoding("拠点名", "UTF-8")
							)
						);

						if(isset($detail[0]["detail"])) {
							foreach ($detail[0]["detail"] as $keyDetail => $valueDetail) {
								if($valueBuy["place_buy_id"] == $valueDetail["place_buy_id"]) {
									$numberExport += $valueDetail["number_export"];
									$numberExportBuy += $valueDetail["number_export"];
									$totalAmout += ($valueDetail["number_export"] * $valueDetail["price"]);
									$totalAmoutBuy += ($valueDetail["number_export"] * $valueDetail["price"]);
								
									array_push(
										$data_export,
										array(
											mb_convert_encoding($valueDetail["date_export"], "UTF-8"),
											mb_convert_encoding($valueDetail["id_export"], "UTF-8"),
											mb_convert_encoding($valueDetail["product_buy_code"], "UTF-8"),
											mb_convert_encoding($valueDetail["product_buy_name"], "UTF-8"),
											mb_convert_encoding($valueDetail["number_export"], "UTF-8"),
											mb_convert_encoding("¥".$valueDetail["price"], "UTF-8"),
											mb_convert_encoding("¥".($valueDetail["price"] * $valueDetail["number_export"]), "UTF-8"),
											mb_convert_encoding($valueDetail["factory_name"], "UTF-8")
										)
									);
								}
							}
						}

						array_push(
							$data_export,
							array(
								"",
								"",
								"",
								mb_convert_encoding($valueBuy["place_buy_name"]."の小計", "UTF-8"),
								$numberExportBuy,
								"",
								mb_convert_encoding("¥".$totalAmoutBuy, "UTF-8"),
								"",
							)
						);
						
					}
				}

				array_push(
					$data_export,
					array("")
				);
				array_push(
					$data_export,
					array(
						"",
						"",
						"",
						mb_convert_encoding("総合計", "UTF-8"),
						$numberExport,
						"",
						mb_convert_encoding("¥".$totalAmout, "UTF-8"),
						"",
					)
				);
			}
		}
		else if($getImportExport == 2 && $getFormReport == 2){
			$keyword['date_export_from'] = $data['date_from'];
			$keyword['date_export_to'] = $data['date_to'];
			$keyword['product_type_buy'] = $getProductType;
			$keyword['place_sale'] = $getPlaceSale;
			$keyword['place_buy'] = $getPlaceBuy;
			$dataModel = $this->inventory_model->getListInforExport($keyword);
			$data['detail'] = $this->function_purchase_ledger_collective($dataModel);

			if($csv !== 'true') {
				$html= $this->load->view('templates/business/report_purchase_ledger/pdf_purchase_ledger_collective_diff_format', $data, true);

				$output = $title.'（一括差額形式）_ﾘﾈﾝ.pdf';
			} else {
				// Export csv
				$detail = $data['detail'];
				array_push(
					$data_export,
					array(mb_convert_encoding("対象期間 ".$data['date_from']." ～ ".$data['date_to'], "UTF-8"))
				);
				$totalSaleAll = 0;
				$totalBuyAll = 0;
				$numberAll = 0;
				if(isset($detail) && isset($detail[0]["place_only_buy"])) {
                    foreach ($detail[0]["place_only_buy"] as $keyBuy => $valueBuy) {
                        $totalSaleFromBuy = 0;
                        $totalBuyFromBuy = 0;
                        $numberBuy = 0;
						array_push(
							$data_export,
							array("")
						);
						array_push(
							$data_export,
							array(mb_convert_encoding("仕入先名 :", "UTF-8"),mb_convert_encoding($valueBuy["place_buy_name"], "UTF-8"))
						);
						array_push(
							$data_export,
							array(
								mb_convert_encoding("販売先名", "UTF-8"),
								mb_convert_encoding("日付", "UTF-8"),
								mb_convert_encoding("商品名", "UTF-8"),
								mb_convert_encoding("色調", "UTF-8"),
								mb_convert_encoding("規格", "UTF-8"),
								mb_convert_encoding("数量", "UTF-8"),
								mb_convert_encoding("販売単価", "UTF-8"),
								mb_convert_encoding("仕入単価", "UTF-8"),
								mb_convert_encoding("請求金額", "UTF-8"),
								mb_convert_encoding("支払金額", "UTF-8"),
								mb_convert_encoding("差 額", "UTF-8"),
							)
						);
						if(isset($detail[0]["place_sale_from_buy"])) {
							foreach ($detail[0]["place_sale_from_buy"] as $keySaleBuy => $valueSaleBuy) {
								if($valueBuy["place_buy_id"] == $valueSaleBuy["place_buy_id"]) {
									$coutBuy = 0;
									if(isset($detail[0]["detail"])) {
										foreach ($detail[0]["detail"] as $keyDetail => $valueDetail) {
											if($valueSaleBuy["place_buy_id"] == $valueDetail["place_buy_id"] && $valueSaleBuy["place_sale_id"] == $valueDetail["place_sale_id"]) {
												$coutBuy++;
												$numberBuy += $valueDetail["number_export"];
												$numberAll += $valueDetail["number_export"];
												$totalSaleFromBuy += ($valueDetail["number_export"] * $valueDetail["price"]);
												$totalBuyFromBuy += ($valueDetail["number_export"] * $valueDetail["price_buy"]);
												$totalSaleAll += ($valueDetail["number_export"] * $valueDetail["price"]);
												$totalBuyAll += ($valueDetail["number_export"] * $valueDetail["price_buy"]);
												$value_place_sale = ($coutBuy == 1) ? $valueDetail["place_sale_name"] : "";
												array_push(
													$data_export,
													array(
														mb_convert_encoding($value_place_sale, "UTF-8"),
														mb_convert_encoding($valueDetail["date_export"], "UTF-8"),
														mb_convert_encoding($valueDetail["product_buy_name"], "UTF-8"),
														mb_convert_encoding($valueDetail["product_buy_code"], "UTF-8"),
														mb_convert_encoding($valueDetail["product_format"], "UTF-8"),
														mb_convert_encoding($valueDetail["number_export"], "UTF-8"),
														mb_convert_encoding($valueDetail["price"], "UTF-8"),
														mb_convert_encoding($valueDetail["price_buy"], "UTF-8"),
														mb_convert_encoding(($valueDetail["number_export"] * $valueDetail["price"]), "UTF-8"),
														mb_convert_encoding(($valueDetail["number_export"] * $valueDetail["price_buy"]), "UTF-8"),
														mb_convert_encoding((($valueDetail["number_export"] * $valueDetail["price"]) - ($valueDetail["number_export"] * $valueDetail["price_buy"])), "UTF-8"),
													)
												);
											}
										}
									}
								}
							}
						}

						array_push(
							$data_export,
							array(
								"",
								"",
								"",
								"",
								"",
								"",
								"",
								$numberBuy,
								mb_convert_encoding("販売金額合計", "UTF-8"),
								mb_convert_encoding("¥".$totalSaleFromBuy, "UTF-8"),
								"",
							)
						);
						array_push(
							$data_export,
							array(
								"",
								"",
								"",
								"",
								"",
								"",
								"",
								"",
								mb_convert_encoding("仕入金額合計", "UTF-8"),
								mb_convert_encoding("¥".$totalBuyFromBuy, "UTF-8"),
								mb_convert_encoding("差額合計 ".($totalSaleFromBuy - $totalBuyFromBuy), "UTF-8"),
							)
						);
					}
				}

				array_push(
					$data_export,
					array(
						"",
						"",
						"",
						"",
						"",
						"",
						"",
						$numberAll,
						"",
						mb_convert_encoding("¥".$totalSaleAll, "UTF-8"),
						"",
					)
				);
				array_push(
					$data_export,
					array(
						"",
						"",
						"",
						"",
						"",
						"",
						"",
						"",
						"",
						mb_convert_encoding("¥".$totalBuyAll, "UTF-8"),
						mb_convert_encoding("差額合計 ".($totalSaleAll - $totalBuyAll), "UTF-8"),
					)
				);
			}
		}
		
		if($csv !== 'true') {
			// write the HTML into the PDF
			$pdf->WriteHTML($html);
			
			$getPrint = $this->input->get('print');
			if($getPrint === 'true') { 
				$pdf->SetJS('this.print();');
			}
			if($dataModel == null || count($dataModel) <= 0) {
				$pdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
			}
			$pdf->Output("$output", 'I'); 
		} else {
			$this->ImportExportCsv->download_send_header_csv($data['title']);
			echo $this->ImportExportCsv->array_to_csv($data_export);
		}
	}

	/**
	* Function: pdf_detergent_condition
	* @access public
	* @return PDF,CSV
	*/
	public function pdf_detergent_condition() {
		$csv = $this->input->get('csv');

		if($csv !== 'true') {
			$pdf = new mPDF('utf8','A3-L','','',10,10,10,10,9,9); 
		}
		
		$title=$this->lang->line('pdf_detergent_condition');
		if($csv !== 'true') {
			$pdf->SetTitle($title);
		}
		$data = array();
		$data['title'] = $title;
		$data['date_report_now'] = $this->helper->readDateNotText(date("Y/m/d"));

		// Data Dummy
		$dataDate = $this->input->get('date');
		if($dataDate != NULL) {
			$dataFrom = $this->helper->getFirtDayInMonth($dataDate.'/1');
			$dataTo = $this->helper->getLastDayInMonth($dataDate.'/1');
		} 
 
		$dataModel = $this->inventory_model->getListInventoryWashingPowder($dataFrom,$dataTo);
		$data['label_date'] = date("m",strtotime($dataDate.'/1'));
		$data['detail'] = $this->function_purchase_ledger($dataModel);
		// End Data

		if($csv !== 'true') {
			$html= $this->load->view('templates/business/report_inventory/pdf_detergent_condition', $data, true);
			
			// Set footer
			$htmlFooter= $this->load->view('templates/business/report_inventory/pdf_warehouse_status_footer', $data, true);
			$pdf->SetHTMLFooter($htmlFooter);

			// write the HTML into the PDF
			$pdf->WriteHTML($html);
			$output = $title.'.pdf';
			$getPrint = $this->input->get('print');
			if($getPrint === 'true') {
				$pdf->SetJS('this.print();');
			}
			if($dataModel == null || count($dataModel) <= 0) {
				$pdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
			}
			$pdf->Output("$output", 'I'); 
		} else {
			// Export csv
			$detail = $data['detail'];
			$data_export = array();
			array_push(
				$data_export,
				array(mb_convert_encoding($data['label_date']."月分洗剤等の使用状況等", "UTF-8"))
			);
			array_push(
				$data_export,
				array(mb_convert_encoding($data['date_report_now'], "UTF-8"))
			);
			array_push(
				$data_export,
				array("")
			);

			if(isset($detail)) {
                $total_amount_import_all = 0;
                $total_amount_export_all = 0;
                if(isset($detail[0]["factory"])) {
					foreach ($detail[0]["factory"] as $key => $value) {
						$total_amount_import_factory = 0;
						$total_amount_export_factory = 0;
						array_push(
							$data_export,
							array("")
						);
						array_push(
							$data_export,
							array(mb_convert_encoding("拠点", "UTF-8"),mb_convert_encoding($value['stock_name'], "UTF-8"))
						);

						if(isset($detail[0]["event"])) {
							foreach ($detail[0]["event"] as $keyEvent => $valueEvent) {
								if($value["stock_id"] == $valueEvent["stock_id"]) {
									$total_amount_import_event = 0;
									$total_amount_export_event = 0;
									array_push(
										$data_export,
										array(mb_convert_encoding("種目区", "UTF-8"),mb_convert_encoding($valueEvent['product_event_name'], "UTF-8"))
									);

									if(isset($detail[0]["company"])) {
										foreach ($detail[0]["company"] as $keyCompany => $valueCompany) {
											if($value["stock_id"] == $valueCompany["stock_id"] && $valueEvent["product_event_id"] == $valueCompany["product_event_id"]) {
												$total_amount_import_company = 0;
												$total_amount_export_company = 0;
												array_push(
													$data_export,
													array(mb_convert_encoding("仕入先会社名", "UTF-8"),mb_convert_encoding($valueCompany['company_name'], "UTF-8"))
												);
												if(isset($detail[0]["detail"])) {
													foreach ($detail[0]["detail"] as $keyDetail => $valueDetail) {
														if($value["stock_id"] == $valueDetail["stock_id"] && $valueEvent["product_event_id"] == $valueDetail["product_event_id"] && $valueCompany["company_id"] == $valueDetail["company_id"]) {
															$total_amount_import_company += $valueDetail["amount_import"];
															$total_amount_export_company += $valueDetail["amount_export"];
															$total_amount_import_event += $valueDetail["amount_import"];
															$total_amount_export_event += $valueDetail["amount_export"];
															$total_amount_import_factory += $valueDetail["amount_import"];
															$total_amount_export_factory += $valueDetail["amount_export"];
															$total_amount_import_all += $valueDetail["amount_import"];
															$total_amount_export_all += $valueDetail["amount_export"];

															array_push(
																$data_export,
																array(
																	mb_convert_encoding($valueDetail["product_code"], "UTF-8"),
																	mb_convert_encoding($valueDetail["product_name"], "UTF-8"),
																	mb_convert_encoding($valueDetail["product_unit"], "UTF-8"),
																	mb_convert_encoding($valueDetail["price"], "UTF-8"),
																	mb_convert_encoding($valueDetail["product_inventory_standard"], "UTF-8"),
																	mb_convert_encoding($valueDetail["number_last_inventory"], "UTF-8"),
																	mb_convert_encoding($valueDetail["number_import"], "UTF-8"),
																	mb_convert_encoding($valueDetail["amount_import"], "UTF-8"),
																	mb_convert_encoding($valueDetail["number_export"], "UTF-8"),
																	mb_convert_encoding($valueDetail["amount_export"], "UTF-8"),
																	mb_convert_encoding($valueDetail["number_inventory"], "UTF-8")
																)
															);
														}
													}
												}

												array_push(
													$data_export,
													array(
														"",
														"",
														"",
														"",
														"",
														"",
														mb_convert_encoding($valueCompany["company_name"]." 洗剤等の小計", "UTF-8"),
														mb_convert_encoding("¥".$total_amount_import_company, "UTF-8"),
														"",
														mb_convert_encoding("¥".$total_amount_export_company, "UTF-8"),
														""
													)
												);
											}
										}
									}

									array_push(
										$data_export,
										array(
											"",
											"",
											"",
											"",
											"",
											"",
											mb_convert_encoding($valueEvent["product_event_name"]."の合計", "UTF-8"),
											mb_convert_encoding("¥".$total_amount_import_event, "UTF-8"),
											"",
											mb_convert_encoding("¥".$total_amount_export_event, "UTF-8"),
											""
										)
									);
								}
							}
						}
						array_push(
							$data_export,
							array(
								"",
								"",
								"",
								"",
								"",
								"",
								mb_convert_encoding($value["stock_name"]."の合計", "UTF-8"),
								mb_convert_encoding("¥".$total_amount_import_factory, "UTF-8"),
								"",
								mb_convert_encoding("¥".$total_amount_export_factory, "UTF-8"),
								""
							)
						);

					}
				}
			}

			array_push(
				$data_export,
				array(
					"",
					"",
					"",
					"",
					"",
					"",
					mb_convert_encoding("総合計", "UTF-8"),
					mb_convert_encoding("¥".$total_amount_import_all, "UTF-8"),
					"",
					mb_convert_encoding("¥".$total_amount_export_all, "UTF-8"),
					""
				)
			);

			$this->ImportExportCsv->download_send_header_csv($data['title']);
			echo $this->ImportExportCsv->array_to_csv($data_export);
		}
	}

	/**
	* Function: pdf_details_buy
	* Giấy đòi tiền mua vào của công ty đó và order ngoài
	* @access public
	* @return PDF,CSV
	*/
	public function pdf_details_buy() {  
		$csv = $this->input->get('csv');

		if($csv !== 'true') {
			$pdf = new mPDF('utf8','A4','','',10,10,85,40,9,5); 
			$pdf->page = 0;
		}
		
		$get_report_type = $this->input->get("report");
		$title="";
		$data = array();
		if($get_report_type == 1) {
			$title = $this->lang->line('pdf_claim_company');
			$data['title'] = $title;
		}
		else if($get_report_type == 2) {
			$title = $this->lang->line('pdf_claim_purchase');
			$data['title'] = $title;
		}

		// Data
		$data["isOnlyMonth"] = false;
		$data['date_from'] = $this->input->get("date_from");
		$data['date_to'] = $this->input->get("date_to");
		$data['date_month'] = $this->input->get('date_month');
		
		// Date month
		if(isset($data['date_month']) && !empty($data['date_month'])) {
			$data['date_from'] = $data['date_month'] . "/1";
			$data['date_to'] = $data['date_month'] . "/31";
			$data["isOnlyMonth"] = true;
		}

		$get_product_type = $this->input->get("product_type"); 

		// Header 
		if($csv !== 'true') {
			$pdf->SetTitle($data['title']);
		}
		$data['date_report_now'] = $this->helper->readDateNotText(date("Y/m/d"));

		if($data["isOnlyMonth"] == true) {
			$data['exp_last_month'] = $this->helper->getLastDayInMonthDY(date($data['date_to']));
		}
		else {
			$data['exp_last_month'] = $this->helper->getLastDayInMonthDY(date("Y/m/d"));
		}

		// Search
		$keyword['date_delivery_from'] = $this->input->get('date_delivery_from');
    	$keyword['date_delivery_to'] = $this->input->get('date_delivery_to');
		$keyword['date_import_from'] = $data['date_from'];
		$keyword['date_import_to'] = $data['date_to'];
		$keyword['place_buy'] = $this->input->get('place_buy');
		$keyword['place_sale'] = $this->input->get('place_sale');
		$keyword['product_type_buy'] = $this->input->get('product_type');
		
		if($get_report_type == 1) {
			$keyword['type_report'] = "0";
		}
		else if($get_report_type == 2) {
			$keyword['type_report'] = "1";
		}

		$keyword["where_in_import"] = $this->inventory_model->getListCheckedPrice($keyword);
		if($keyword["where_in_import"] != "") {
			$dataModel = $this->inventory_model->getListInforImport($keyword);
		} else {
			$dataModel = null;
		}
		$data['detail'] = $this->function_export_details($dataModel);
		// End Data

		if($csv !== 'true') {
			$html= $this->load->view('templates/business/report_inventory/pdf_details_buy_css', $data, true);
			$pdf->WriteHTML($html);

			// 当 社 買
			if($get_report_type == 1) { 
				if($data['detail'] != null) {
					$arrReportView = $data['detail'][0]['place_sales'];
					foreach ($arrReportView as $key => $value) {
						$totalBuy = 0;
						foreach ($data['detail'][0]['detail'] as $keyBuy => $valueBuy) {
							if($value['place_sale_id'] == $valueBuy['place_sale_id']){
								$totalBuy += (float)$valueBuy['number_import'] * (float)$valueBuy['price'];
							}
						}
						$data['detail_sale'] = $value;
						$data['totalBuy'] = $totalBuy;
						$data['totalBuyTax'] = $totalBuy * CONFIG_CONSUMPTION_TAX;
						$data['totalPay'] = $data['totalBuy'] + $data['totalBuyTax'];

						// Set header
						$htmlHeader= $this->load->view('templates/business/report_inventory/pdf_details_buy_header', $data, true);
						$pdf->SetHTMLHeader($htmlHeader);

						// Set footer
						$htmlFooter= $this->load->view('templates/business/report_inventory/pdf_details_buy_footer', $data, true);
						$pdf->SetHTMLFooter($htmlFooter);

						$pdf->AddPage();
						$htmlPre= $this->load->view('templates/business/report_inventory/pdf_details_buy', $data, true);
						$pdf->WriteHTML($htmlPre);
					}
				}
			}
			else if($get_report_type == 2) {
				//外注分
				if($data['detail'] != null) {
					$arrReportView = $data['detail'][0]['place_sales'];
					foreach ($arrReportView as $key => $value) {
						$totalBuy = 0;
						foreach ($data['detail'][0]['detail'] as $keyBuy => $valueBuy) {
							if($value['place_sale_id'] == $valueBuy['place_sale_id']){
								$totalBuy += (float)$valueBuy['number_import'] * (float)$valueBuy['price'];
							}
						}
						$data['detail_sale'] = $value;
						$data['totalBuy'] = $totalBuy;
						$data['HANDLING_FEE']  = $totalBuy * HANDLING_FEE;
						$data['totalBuyTax'] = ($totalBuy + $data['HANDLING_FEE']) * CONFIG_CONSUMPTION_TAX;
						$data['totalPay'] = $totalBuy + $data['HANDLING_FEE']+$data['totalBuyTax'];

						// Set header
						$htmlHeader= $this->load->view('templates/business/report_inventory/pdf_details_buy_outside_header', $data, true);
						$pdf->SetHTMLHeader($htmlHeader);

						// Set footer
						$htmlFooter= $this->load->view('templates/business/report_inventory/pdf_details_buy_footer', $data, true);
						$pdf->SetHTMLFooter($htmlFooter);

						$pdf->AddPage();
						$htmlPre= $this->load->view('templates/business/report_inventory/pdf_details_buy_outside', $data, true);
						$pdf->WriteHTML($htmlPre);
					}
				}
			}
			
			// write the HTML into the PDF
			$pdf->DeletePages(1);
			$output = $title.'.pdf';
			
			$getPrint = $this->input->get('print');
			if($getPrint === 'true') { 
				$pdf->SetJS('this.print();');
			}

			if($dataModel == null || count($dataModel) <= 0) {
				$pdf->SetJS('app.alert("'.$this->lang->line('message_error_data_null').'");');
			}

			$pdf->Output("$output", 'I'); 
		} else {
			// Export csv
			$data_export = array();

			if($get_report_type == 1) {  
				if($data['detail'] != null) {
					$arrReportView = $data['detail'][0]['place_sales'];
					foreach ($arrReportView as $key => $value) {
						$totalBuy = 0;
						foreach ($data['detail'][0]['detail'] as $keyBuy => $valueBuy) {
							if($value['place_sale_id'] == $valueBuy['place_sale_id']){
								$totalBuy += (float)$valueBuy['number_import'] * (float)$valueBuy['price'];
							}
						}
						$detail_sale = $value;
						$totalBuy = $totalBuy;
						$totalBuyTax = $totalBuy * CONFIG_CONSUMPTION_TAX;
						$totalPay = $totalBuy + $totalBuyTax;

						// PDF
						array_push(
							$data_export,
							array(mb_convert_encoding($title, "UTF-8"))
						);
						array_push(
							$data_export,
							array("")
						);
						array_push(
							$data_export,
							array(mb_convert_encoding("お客様コード:", "UTF-8"), $detail_sale["place_sale_id"],"","","","","",$data['date_report_now'])
						);
						array_push(
							$data_export,
							array(mb_convert_encoding("〒 ".$detail_sale["place_sale_postage"], "UTF-8"),"","", "","","","","")
						);
						array_push(
							$data_export,
							array(mb_convert_encoding($detail_sale["place_sale_address1"], "UTF-8"),"","", "","","","","")
						);
						array_push(
							$data_export,
							array(mb_convert_encoding($detail_sale["place_sale_address2"], "UTF-8"),"","", "","","",mb_convert_encoding("〒".TOLINEN_POST_OFFICE, "UTF-8"),"")
						);
						array_push(
							$data_export,
							array(mb_convert_encoding($detail_sale["place_sale_name"], "UTF-8"),"","", "","","",mb_convert_encoding(TOLINEN_ADDRESS, "UTF-8"),"")
						);
						array_push(
							$data_export,
							array("","","", "","","",mb_convert_encoding(TOLINEN_ADDRESS_HOTEL, "UTF-8"),"")
						);
						array_push(
							$data_export,
							array("","","", "","","",mb_convert_encoding(TOLINEN_COMPANY_NAME, "UTF-8"),"")
						);
						array_push(
							$data_export,
							array("","","", "","","",mb_convert_encoding("平成".$data['exp_last_month'] . " 末日締切り", "UTF-8"),"")
						);

						array_push(
							$data_export,
							array("")
						);
						array_push(
							$data_export,
							array(mb_convert_encoding("今回御買上金額", "UTF-8"),mb_convert_encoding("今回消費税額", "UTF-8"),"","","","",mb_convert_encoding("今回御請求金額", "UTF-8"),"","")
						);
						array_push(
							$data_export,
							array($totalBuy,$totalBuyTax,"","","","",$totalPay,"","")
						);

						// Content
						if(isset($data['detail'][0]["place_buy"])) {
							foreach ($data['detail'][0]["place_buy"] as $keyBuy => $valueBuy) {
								if($valueBuy['place_sale_id'] == $detail_sale['place_sale_id']) {
									$totalQuantityFactory = 0;
									$totalAmountFactory = 0;
									array_push(
										$data_export,
										array("")
									);
									array_push(
										$data_export,
										array(mb_convert_encoding($valueBuy['place_buy_name'], "UTF-8"),mb_convert_encoding("対象期間 " .$data['date_from']. " ～ ".$data['date_to'], "UTF-8"))
									);

									if(isset($data['detail'][0]["detail"])) {
										$detail_date_a = "";
										foreach ($data['detail'][0]["detail"] as $keyDetail => $valueDetail) {
											if($valueBuy['place_sale_id'] == $valueDetail['place_sale_id'] && $valueBuy['place_buy_id'] == $valueDetail['place_buy_id']) {
												$amount_product = $valueDetail['price'] * $valueDetail['number_import'];
												$totalQuantityFactory += $valueDetail['number_import'];
												$totalAmountFactory += $amount_product;

												array_push(
													$data_export,
													array(
														mb_convert_encoding($valueDetail['product_sale_code'], "UTF-8"),
														mb_convert_encoding($valueDetail['product_sale_name'], "UTF-8"),
														mb_convert_encoding($valueDetail['product_color'], "UTF-8"),
														mb_convert_encoding($valueDetail['product_format'], "UTF-8"),
														mb_convert_encoding($valueDetail['note'], "UTF-8"),
														mb_convert_encoding($valueDetail['number_import'], "UTF-8"),
														mb_convert_encoding($valueDetail['price'], "UTF-8"),
														mb_convert_encoding($amount_product, "UTF-8"),
														mb_convert_encoding($valueDetail['base_name'], "UTF-8"),
													)
												);
											}
										}
									}

									array_push(
										$data_export,
										array(
											"",
											"",
											"",
											"",
											mb_convert_encoding("小 計 ", "UTF-8"),
											mb_convert_encoding($totalQuantityFactory, "UTF-8"),
											"",
											mb_convert_encoding($totalAmountFactory, "UTF-8"),
											"",
										)
									);
								}
							}
						}

						// Footer
						if(isset($data['detail'][0]["base_bank"])) {
							array_push(
								$data_export,
								array("")
							);
							array_push(
								$data_export,
								array(mb_convert_encoding("お振込みは右記の銀行にお 願い申し上げます。", "UTF-8"))
							);
							foreach ($data['detail'][0]["base_bank"] as $keyBank => $valueBank) {
								if($valueBank['place_sale_id'] == $detail_sale['place_sale_id']) {
									array_push(
										$data_export,
										array(mb_convert_encoding($valueBank['base_bank'], "UTF-8"),mb_convert_encoding($valueBank['base_brach'], "UTF-8"),mb_convert_encoding($valueBank['base_number'], "UTF-8"))
									);
								}
							}
						}
					}
				}
			}
			else if($get_report_type == 2) {
				//外注分
				if($data['detail'] != null) {
					$arrReportView = $data['detail'][0]['place_sales'];
					foreach ($arrReportView as $key => $value) {
						$totalBuy = 0;
						foreach ($data['detail'][0]['detail'] as $keyBuy => $valueBuy) {
							if($value['place_sale_id'] == $valueBuy['place_sale_id']){
								$totalBuy += (float)$valueBuy['number_import'] * (float)$valueBuy['price'];
							}
						}
						$detail_sale = $value;
						$totalBuy = $totalBuy;
						$HANDLING_FEE  = $totalBuy * HANDLING_FEE;
						$totalBuyTax = ($totalBuy + $HANDLING_FEE) * CONFIG_CONSUMPTION_TAX;
						$totalPay = $totalBuy + $HANDLING_FEE+$totalBuyTax;

						// PDF
						array_push(
							$data_export,
							array(mb_convert_encoding($title, "UTF-8"))
						);
						array_push(
							$data_export,
							array("")
						);
						array_push(
							$data_export,
							array(mb_convert_encoding("お客様コード:", "UTF-8"), $detail_sale["place_sale_id"],"","","","","",$data['date_report_now'])
						);
						array_push(
							$data_export,
							array(mb_convert_encoding("〒 ".$detail_sale["place_sale_postage"], "UTF-8"),"","","","","","","")
						);
						array_push(
							$data_export,
							array(mb_convert_encoding($detail_sale["place_sale_address1"], "UTF-8"),"","", "","","","","")
						);
						array_push(
							$data_export,
							array(mb_convert_encoding($detail_sale["place_sale_address2"], "UTF-8"),"","","","","",mb_convert_encoding("〒".TOLINEN_POST_OFFICE, "UTF-8"),"")
						);
						array_push(
							$data_export,
							array(mb_convert_encoding($detail_sale["place_sale_name"], "UTF-8"),"","", "","","",mb_convert_encoding(TOLINEN_ADDRESS, "UTF-8"),"")
						);
						array_push(
							$data_export,
							array("", "","", "","","",mb_convert_encoding(TOLINEN_ADDRESS_HOTEL, "UTF-8"),"")
						);
						array_push(
							$data_export,
							array("", "","", "","","",mb_convert_encoding(TOLINEN_COMPANY_NAME, "UTF-8"),"")
						);
						array_push(
							$data_export,
							array("", "","", "","","",mb_convert_encoding("平成".$data['exp_last_month'] . " 末日締切り", "UTF-8"),"")
						);

						array_push(
							$data_export,
							array("")
						);
						array_push(
							$data_export,
							array(
								mb_convert_encoding("今回御買上金額", "UTF-8"),
								mb_convert_encoding("取扱手数料", "UTF-8"),
								mb_convert_encoding("今回消費税額", "UTF-8"),"","","",mb_convert_encoding("今回御請求金額", "UTF-8"),"","","")
						);
						array_push(
							$data_export,
							array($totalBuy,$HANDLING_FEE,$totalBuyTax,"","","",$totalPay,"","","")
						);

						// Content
						if(isset($data['detail'][0]["place_buy"])) {
							foreach ($data['detail'][0]["place_buy"] as $keyBuy => $valueBuy) {
								if($valueBuy['place_sale_id'] == $detail_sale['place_sale_id']) {
									$totalQuantityFactory = 0;
									$totalAmountFactory = 0;
									array_push(
										$data_export,
										array("")
									);
									array_push(
										$data_export,
										array(mb_convert_encoding($valueBuy['place_buy_name'], "UTF-8"))
									);

									if(isset($data['detail'][0]["detail"])) {
										$detail_date_a = "";
										foreach ($data['detail'][0]["detail"] as $keyDetail => $valueDetail) {
											if($valueBuy['place_sale_id'] == $valueDetail['place_sale_id'] && $valueBuy['place_buy_id'] == $valueDetail['place_buy_id']) {
												$amount_product = $valueDetail['price'] * $valueDetail['number_import'];
												$totalQuantityFactory += $valueDetail['number_import'];
												$totalAmountFactory += $amount_product;

												// Date
												$detail_date_b = "";
												$view_date = "";
												if(empty($detail_date_a)) {
													$detail_date_a = $valueDetail['detail_date'];
												}
												else {
													$detail_date_b = $valueDetail['detail_date'];
												}
				
												if($detail_date_a != $detail_date_b) {
													$detail_date_a = $valueDetail['detail_date'];
													$detail_date_b = $detail_date_a;
													$view_date = $valueDetail['detail_date'];
												}

												array_push(
													$data_export,
													array(
														mb_convert_encoding($view_date, "UTF-8"),
														mb_convert_encoding($valueDetail['product_sale_code'], "UTF-8"),
														mb_convert_encoding($valueDetail['product_sale_name'], "UTF-8"),
														mb_convert_encoding($valueDetail['product_color'], "UTF-8"),
														mb_convert_encoding($valueDetail['product_format'], "UTF-8"),
														mb_convert_encoding($valueDetail['note'], "UTF-8"),
														mb_convert_encoding($valueDetail['number_import'], "UTF-8"),
														mb_convert_encoding($valueDetail['price'], "UTF-8"),
														mb_convert_encoding($amount_product, "UTF-8"),
														mb_convert_encoding($valueDetail['base_name'], "UTF-8"),
													)
												);
											}
										}
									}

									array_push(
										$data_export,
										array(
											"",
											"",
											"",
											"",
											"",
											mb_convert_encoding("小 計 ", "UTF-8"),
											mb_convert_encoding($totalQuantityFactory, "UTF-8"),
											"",
											mb_convert_encoding($totalAmountFactory, "UTF-8"),
											"",
										)
									);
								}
							}
						}

						// Footer
						if(isset($data['detail'][0]["base_bank"])) {
							array_push(
								$data_export,
								array("")
							);
							array_push(
								$data_export,
								array(mb_convert_encoding("お振込みは右記の銀行にお 願い申し上げます。", "UTF-8"))
							);
							foreach ($data['detail'][0]["base_bank"] as $keyBank => $valueBank) {
								if($valueBank['place_sale_id'] == $detail_sale['place_sale_id']) {
									array_push(
										$data_export,
										array(mb_convert_encoding($valueBank['base_bank'], "UTF-8"),mb_convert_encoding($valueBank['base_brach'], "UTF-8"),mb_convert_encoding($valueBank['base_number'], "UTF-8"))
									);
								}
							}
						}
					}
				}
			}

			$this->ImportExportCsv->download_send_header_csv($data['title']);
			echo $this->ImportExportCsv->array_to_csv($data_export);
		}
	}

	/**
	* Function: pdf_initial_inventory
	* Vòng xoáy bảng line
	* @access public
	* @return PDF,CSV
	*/
	public function pdf_initial_inventory() {
		$base_code = $this->input->get('base_code');
		$type_product = $this->input->get('type_product');
		$date_from = $this->input->get('from');
		$date_to = $this->input->get('to');
		$date_exp = $this->helper->readDateOneYear($date_to); // thời gian tìm kiếm vòng xoay trong vòng 1 năm

		$arrayNumberInitial = $this->initial_inventory_model->getListNumberInitial($date_to,$date_exp,$base_code,$type_product);
		$arrayProductInitial = array();
		foreach ($arrayNumberInitial as $key => $value) {
			$detailInitial = array();

			array_push(
				$arrayProductInitial,
				array(
					"product_id"=>$value["product_id"],
					"number_initial"=>$detailInitial,
				)
			);
		}
		echo json_encode($arrayProductInitial);
	}

}
