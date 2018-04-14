<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-04-04 17:51:40 --> Query error: Unknown column '拠点マスタ.外注先Flg' in 'field list' - Invalid query: 
			SELECT 
			SL.*,
			CS.`得意先名`,
			PB.`部署名`, 
			SL.`納品日` , 
			`拠点マスタ`.`外注先Flg` AS is_gaichyu, 
			`ユーザマスタ`.`拠点コード` AS base_code  
			FROM `売上台帳` SL
			INNER JOIN `得意先` CS ON CS.`得意先コード` = SL.`得意先コード`
			INNER JOIN `部署台帳` PB ON PB.`部署コード` = SL.`部署コード`
			INNER JOIN `得意先部署` KB ON KB.`得意先コード` = SL.`得意先コード` 
			AND KB.`部署コード` = SL.`部署コード` 
			LEFT JOIN `ユーザマスタ` US ON KB.`担当者` = `ユーザマスタ`.`ユーザID`
			LEFT JOIN `拠点マスタ` CD ON `ユーザマスタ`.`拠点コード` = `拠点マスタ`.`拠点コード`
			
			WHERE CAST(SL.`伝票番号` AS  CHAR(512))='322'	
				AND KB.`担当者` = 'gaichyu_hotel'
				
			GROUP BY SL.`伝票番号`
		
ERROR - 2018-04-04 17:51:42 --> Query error: Unknown column '拠点マスタ.外注先Flg' in 'field list' - Invalid query: 
			SELECT 
			SL.*,
			CS.`得意先名`,
			PB.`部署名`, 
			SL.`納品日` , 
			`拠点マスタ`.`外注先Flg` AS is_gaichyu, 
			`ユーザマスタ`.`拠点コード` AS base_code  
			FROM `売上台帳` SL
			INNER JOIN `得意先` CS ON CS.`得意先コード` = SL.`得意先コード`
			INNER JOIN `部署台帳` PB ON PB.`部署コード` = SL.`部署コード`
			INNER JOIN `得意先部署` KB ON KB.`得意先コード` = SL.`得意先コード` 
			AND KB.`部署コード` = SL.`部署コード` 
			LEFT JOIN `ユーザマスタ` US ON KB.`担当者` = `ユーザマスタ`.`ユーザID`
			LEFT JOIN `拠点マスタ` CD ON `ユーザマスタ`.`拠点コード` = `拠点マスタ`.`拠点コード`
			
			WHERE CAST(SL.`伝票番号` AS  CHAR(512))='322'	
				AND KB.`担当者` = 'gaichyu_hotel'
				
			GROUP BY SL.`伝票番号`
		
ERROR - 2018-04-04 18:13:49 --> Severity: Notice --> Undefined variable: result F:\PROJECT_SVN\ERP_TOLINEN\Source\erp-tolinen\application\controllers\UserController.php 50
ERROR - 2018-04-04 18:37:32 --> Severity: Notice --> Undefined variable: result F:\PROJECT_SVN\ERP_TOLINEN\Source\erp-tolinen\application\controllers\masters\LocationController.php 89
