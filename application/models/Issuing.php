<?php

class Issuing extends VV_Model {

	function __construct() {
		parent::__construct();
		$this->table_name = 'issuing';
	}
	public function get_product_list($array) {
		if (empty($array)) {
			$sql = "
			SELECT *
			FROM
			(
			SELECT *,
			(@num:=IF(@dateorder = `issuing_id`, @num +1, IF(@dateorder := `issuing_id`, 1, 1))) row_number
			FROM `issuing_detail` AS b
			CROSS JOIN (SELECT @num:=0, @dateorder:=NULL) c
			WHERE b.issuing_id IN(NULL)
			ORDER BY `issuing_id` DESC
			) AS X
			WHERE x.row_number <= 20;
		";
		} else {
			$sql = "
			SELECT *
			FROM
			(
			SELECT *,
			(@num:=IF(@dateorder = `issuing_id`, @num +1, IF(@dateorder := `issuing_id`, 1, 1))) row_number
			FROM `issuing_detail` AS b
			CROSS JOIN (SELECT @num:=0, @dateorder:=NULL) c
			WHERE b.issuing_id IN(" . implode(',', $array) . ")
			ORDER BY `issuing_id` DESC
			) AS X
			WHERE x.row_number <= 20;
		";
		}

		$result = $this->db->query($sql);
		return $result->result();
	}

	public function get_order_list_by_date() {
		$sql = "
			SELECT
			t1.id,t1.code,t1.created_at,t1.note,t1.status,CAST(created_at AS DATE) AS order_date
			FROM
			(
			SELECT *,CAST(created_at AS DATE) AS date1
			FROM
			(
			   SELECT *,
				  (@num3:=IF(@dateorder3 = CAST(created_at AS DATE), @num3 +1, IF(@dateorder3 := CAST(created_at AS DATE), 1, 1))) row_number
			  FROM `issuing` t
			  CROSS JOIN (SELECT @num3:=0, @dateorder3:=NULL) c
			  ORDER BY CAST(created_at AS DATE) DESC
			) AS X
			WHERE x.row_number <= 2
			) AS t1
			INNER JOIN
			(
			SELECT  CAST(t.created_at AS DATE) AS date2
			FROM `issuing` AS t
			GROUP BY CAST(created_at AS DATE)
			ORDER BY CAST(created_at AS DATE)  DESC
			LIMIT 1
			) AS t2
			ON t1.date1 = t2.date2
			ORDER BY t1.created_at DESC
		";

		$this->db->query("SET @num3:=0;");
		$this->db->query("SET @dateorder3:=NULL;");
		$result = $this->db->query($sql);
		return $result->result();
	}

	public function get_order_id_list() {
		$sql = "
			SELECT
			t1.id
			FROM
			(
			SELECT *,CAST(created_at AS DATE) AS date1
			FROM
			(
			   SELECT *,
				  (@num3:=IF(@dateorder3 = CAST(created_at AS DATE), @num3 +1, IF(@dateorder3 := CAST(created_at AS DATE), 1, 1))) row_number
			  FROM `issuing` t
			  CROSS JOIN (SELECT @num3:=0, @dateorder3:=NULL) c
			  ORDER BY CAST(created_at AS DATE) DESC
			) AS X
			WHERE x.row_number <= 2
			) AS t1
			INNER JOIN
			(
			SELECT  CAST(t.created_at AS DATE) AS date2
			FROM `issuing` AS t
			GROUP BY CAST(created_at AS DATE)
			ORDER BY CAST(created_at AS DATE)  DESC
			LIMIT 2
			) AS t2
			ON t1.date1 = t2.date2
			ORDER BY t1.created_at DESC
		";
		$this->db->query("SET @num3:=0;");
		$this->db->query("SET @dateorder3:=NULL;");
		$result = $this->db->query($sql);
		return $result->result_array();
	} //End function

}