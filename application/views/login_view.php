<!DOCTYPE html>
<html>
<head>
<title>Login</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/asset/css/bootstrap.min.css">
</head>
<body>

<h1>Login</h1>
<p>This is a paragraph.</p>
<?php echo form_open('admin');?>
    <p>
    <?php
        echo form_label('Email Adress','email_address');
        echo form_input('email_address','','id="email_address"');
    ?>
    
    </p>
        <p>
    <?php
        echo form_label('Password','password');
        echo form_input('password','','id="password"');
    ?>
            <?php echo form_submit('submit','Login');?>
    <?php echo form_close();?>
    </p>
<?php echo form_close();?>
    <div class='errors'><?php echo validation_errors();?></div>
    <script src="<?php echo base_url(); ?>asset/js/jquery-1.11.3.min.js"></script>
    <script src="<?php echo base_url(); ?>asset/js/bootstrap.min.js"></script>
</body>
</html>