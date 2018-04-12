<?php

class Buying_Detail extends VV_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->table_name = 'buying_detail';
	}
	public function insert_order($products){
        foreach($products as $product){
        $field='';
        $values='';
           foreach($product as $key => $val)
        {
          $field.=$key.',';
          $values.="'".$val."',";
        }
        $fields= rtrim($field,',');
        $value1= rtrim($values,','); 
        $sql="insert into t_入出庫情報(".$fields.") values (".$value1.")";
        $result = $this->db->query($sql);
        } 
	}
}