<?php

class Request_For_Payment extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = 'request_for_payment';
	}
	public function get_product_list($array)
	{
		if(empty($array))
		{
			$sql="
			SELECT *
			FROM 
			(
			SELECT *,
			(@num:=IF(@dateorder = `rfp_id`, @num +1, IF(@dateorder := `rfp_id`, 1, 1))) row_number 
			FROM `request_for_payment_detail` AS b 
			CROSS JOIN (SELECT @num:=0, @dateorder:=NULL) c
			WHERE b.rfp_id IN(NULL) 
			ORDER BY `rfp_id` DESC
			) AS X 
			WHERE x.row_number <= 20;		
		";
		}
		else
		{
			$sql="
			SELECT *
			FROM 
			(
			SELECT *,
			(@num:=IF(@dateorder = `rfp_id`, @num +1, IF(@dateorder := `rfp_id`, 1, 1))) row_number 
			FROM `request_for_payment_detail` AS b 
			CROSS JOIN (SELECT @num:=0, @dateorder:=NULL) c
			WHERE b.rfp_id IN(".implode(',',$array).") 
			ORDER BY `rfp_id` DESC
			) AS X 
			WHERE x.row_number <= 20;		
		";
		}
		$result = $this->db->query($sql);
		return $result->result();
	}
	public function get_meta_list($meta,$array)
	{
		if(empty($meta)&&empty($array))
		{
					$sql="
SELECT code,customer_name,request_for_payment.`id` as id FROM request_for_payment INNER JOIN meta_request_for_payment ON request_for_payment.`meta_id`=meta_request_for_payment.`id`
WHERE request_for_payment.`meta_id` IN(NULL)	and request_for_payment.`id`  IN(NULL)
		";
		}
		else
		{
					$sql="
SELECT code,customer_name,request_for_payment.`id` as id FROM request_for_payment INNER JOIN meta_request_for_payment ON request_for_payment.`meta_id`=meta_request_for_payment.`id`
WHERE request_for_payment.`meta_id` IN(".implode(',',$meta).")	and request_for_payment.`id`  IN(".implode(',',$array).")
		";
		}

		$result = $this->db->query($sql);
		return $result->result();
	}
	public function get_order_list_by_date()
	{
		$sql="
			SELECT 
			t1.id,t1.meta_id,t1.created_at,t1.deparment_name,t1.status,CAST(created_at AS DATE) AS order_date
			FROM
			(
			SELECT *,CAST(created_at AS DATE) AS date1
			FROM 
			(
			   SELECT *,
				  (@num3:=IF(@dateorder3 = CAST(created_at AS DATE), @num3 +1, IF(@dateorder3 := CAST(created_at AS DATE), 1, 1))) row_number 
			  FROM `request_for_payment` t
			  CROSS JOIN (SELECT @num3:=0, @dateorder3:=NULL) c
			  ORDER BY CAST(created_at AS DATE) DESC
			) AS X 
			WHERE x.row_number <= 3
			) AS t1
			INNER JOIN
			(
			SELECT  CAST(t.created_at AS DATE) AS date2
			FROM `request_for_payment` AS t
			GROUP BY CAST(created_at AS DATE)
			ORDER BY CAST(created_at AS DATE)  DESC
			LIMIT 3
			) AS t2
			ON t1.date1 = t2.date2
			ORDER BY t1.created_at DESC
		";

		$this->db->query("SET @num3:=0;");
		$this->db->query("SET @dateorder3:=NULL;");
		$result = $this->db->query($sql);
		return $result->result();
	}
	
	public function get_order_id_list()
	{
		$sql="
			SELECT 
			t1.id
			FROM
			(
			SELECT *,CAST(created_at AS DATE) AS date1
			FROM 
			(
			   SELECT *,
				  (@num3:=IF(@dateorder3 = CAST(created_at AS DATE), @num3 +1, IF(@dateorder3 := CAST(created_at AS DATE), 1, 1))) row_number 
			  FROM `shipment` t
			  CROSS JOIN (SELECT @num3:=0, @dateorder3:=NULL) c
			  ORDER BY CAST(created_at AS DATE) DESC
			) AS X 
			WHERE x.row_number <= 3
			) AS t1
			INNER JOIN
			(
			SELECT  CAST(t.created_at AS DATE) AS date2
			FROM `shipment` AS t
			GROUP BY CAST(created_at AS DATE)
			ORDER BY CAST(created_at AS DATE)  DESC
			LIMIT 3
			) AS t2
			ON t1.date1 = t2.date2
			ORDER BY t1.created_at DESC
		";
		$this->db->query("SET @num3:=0;");
		$this->db->query("SET @dateorder3:=NULL;");
		$result = $this->db->query($sql);
		return $result->result_array();
	}//End function
	public function get_order_meta_id_list()
	{
		$sql="
			SELECT 
			t1.meta_id
			FROM
			(
			SELECT *,CAST(created_at AS DATE) AS date1
			FROM 
			(
			   SELECT *,
				  (@num4:=IF(@dateorder4 = CAST(created_at AS DATE), @num4 +1, IF(@dateorder4 := CAST(created_at AS DATE), 1, 1))) row_number 
			  FROM `request_for_payment` t
			  CROSS JOIN (SELECT @num4:=0, @dateorder4:=NULL) c
			  ORDER BY CAST(created_at AS DATE) DESC
			) AS X 
			WHERE x.row_number <= 3
			) AS t1
			INNER JOIN
			(
			SELECT  CAST(t.created_at AS DATE) AS date2
			FROM `request_for_payment` AS t
			GROUP BY CAST(created_at AS DATE)
			ORDER BY CAST(created_at AS DATE)  DESC
			LIMIT 3
			) AS t2
			ON t1.date1 = t2.date2
			ORDER BY t1.created_at DESC
		";
		$this->db->query("SET @num4:=0;");
		$this->db->query("SET @dateorder4:=NULL;");
		$result = $this->db->query($sql);
		return $result->result_array();
	}//End function
}