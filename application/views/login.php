<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Login - TOLinen system</title>

        <!-- CSS -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/login-style/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url(); ?>/asset/login-style/css/form-elements.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>/asset/login-style/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>

        <!-- Top content -->
        <div class="top-content">
        	
            <div class="inner-bg">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>株式会社テーオーリネンサプライ</h3>
                            		<p>ユーザー名及びパスワードをご入力ください。:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-lock"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                    <form role="form" action="" method="post" class="login-form">
			                    	<div class="form-group">
			                    		<label class="sr-only" for="form-username">ユーザー名</label>
			                        	<input type="text" name="username" placeholder="ユーザー名..." class="form-username form-control" id="form-username">
			                        </div>
			                        <div class="form-group">
			                        	<label class="sr-only" for="form-password">パスワード</label>
			                        	<input type="password" name="password" placeholder="パスワード..." class="form-password form-control" id="form-password">
			                        </div>
			                        <button type="submit" class="btn">ログイン</button>
			                    </form>
                                <?php if($hasError) { ?>
                                <div class="err-mes">ユーザー名又はパスワードは正しくありません。再度入力してください。</div>
                                <?php } ?>
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- Javascript -->
        <script src="<?php echo base_url(); ?>/asset/js/jquery-1.12.4.min.js"></script>
        <script src="<?php echo base_url(); ?>/asset/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>/asset/login-style/js/scripts.js"></script>
        
        <!--[if lt IE 10]>
            <script src="<?php echo base_url(); ?>/asset/login-style/js/placeholder.js"></script>
        <![endif]-->

    </body>

</html>