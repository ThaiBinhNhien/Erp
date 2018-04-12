<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Migration_Alter_schema extends CI_Migration {

  public function up()
  {

    $this->load->dbforge();

    $fields = array(
      'author_first_name VARCHAR(50) DEFAULT NULL',
      'author_last_name VARCHAR(50) DEFAULT NULL'
    );

    $this->dbforge->add_column('blog', $fields);
  }

  public function down()
  {
    
    $this->load->dbforge();

    $this->dbforge->drop_column('blog', 'author_first_name');
    $this->dbforge->drop_column('blog', 'author_last_name');
  }
}
?>