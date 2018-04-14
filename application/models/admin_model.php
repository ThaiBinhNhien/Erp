<?php
class Admin_model extends VV_Model{
          public function __construct()
        {
                parent::__construct();
                // Your own constructor code
        }
    public function verify_user($email,$password)
    {
        $q=$this->db
            ->where('email',$email)
            ->where('password',sha1($password))
            ->limit(1)
            ->get('users');
        if($q->num_rows >0)
        {
            return ($q->row());
        }
       // return false;
    }
    public function getList()
    {
        $q = $this->db->get('users');
           if($q->num_rows >0)
        {
            return ($q->row());
        }
        return false;
    }
}