<?php 
$LOGIN_INFO = $this->session->userdata('login-info'); 
?>
<header> 
<audio id="notif_audio"><source src="<?php echo base_url('asset/sounds/notify.ogg');?>" type="audio/ogg"><source src="<?php echo base_url('asset/sounds/notify.mp3');?>" type="audio/mpeg"><source src="<?php echo base_url('asset/sounds/notify.wav');?>" type="audio/wav"></audio>
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= base_url(); ?>">売上管理システム</a>
        </div> 
       <ul class="nav navbar-nav navbar-right  navbar">
       <li role="presentation" class="dropdown-notification">
                  <a href="javascript:;" class=" info-number">
                    <i class="fa fa-envelope-o"></i>
                    <span class="badge bg-green" id="new_count_message"><?php echo $this->db->where(TN_STATUS,0)->where(TN_USER,$LOGIN_INFO[U_ID])->count_all_results(TAB_NOTIFICATION);?></span>
                  </a>
                  <ul id="list_message_notification" class="dropdown-menu list-unstyled msg_list" role="menu"></ul>
                  </li>
       <li><a><?php echo $LOGIN_INFO[BM_COMPANY_NAME]; ?></a></li>
           <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user"></i> <?php echo $LOGIN_INFO[U_ID]; ?> <b class="caret"></b></a>
               <ul class="dropdown-menu">
                   <li><a href="<?php echo base_url('logout');?>">ログアウト</a></li>
               </ul>
           </li>
           
        </ul>
   
	</div>
</header>
<nav id="navi">
<div class="container">   
	
    <ul>
        <li <?php if($this->router->fetch_class()=='AdminController'){ echo 'class="active"';} ?>><a href="<?php echo site_url(); ?>"><i class="icon-home"></i><span>Home</span> </a></li>
        <li <?php if($this->router->fetch_class()=='OrderController'){ echo 'class="active"';} ?> ><a target="_blank"    href="<?php echo site_url('receive-order');?>"><i class="icon-tag"></i><span> 注文管理 </span> </a>
        <a id="drop-1"class="down" href="#" ><span class="glyphicon glyphicon-chevron-left"></span></a>   
            <ul>
                <li><a target="_blank"   href="<?php echo site_url('receive-order');?>">注文伝票</a></li>
                <li><a target="_blank"   href="<?php echo site_url('receive-order');?>/checklist">チェックリスト</a></li>
            </ul>   
        
        </li> 
         <li <?php if($this->router->fetch_class()=='SaleController'){ echo 'class="active"';} ?>><a target="_blank"  href="<?php echo site_url('sale');?>"><i class="icon-money"></i><span>売上管理  </span> </a>
            <a id="drop-3"class="down" href="#" ><span class="glyphicon glyphicon-chevron-left"></span></a> 
            <ul>
                <li><a target="_blank"   href="<?php echo site_url('sale');?>">未請求注文伝票管理</a></li>
                <li><a target="_blank"   href="<?php echo site_url('sale');?>/created_sale">作成済請求書管理</a></li>
            </ul> 
        </li>


        
       
		<li <?php if($this->router->fetch_class()=='ShipmentController'){ echo 'class="active"';} ?>>
            <a target="_blank"   href="<?php echo site_url('shipment');?>"><i class=" icon-external-link"></i><span>受発注管理 </span> </a>
  			<a id="drop-2"class="down" href="#" ><span class="glyphicon glyphicon-chevron-left"></span></a> 
        </li>
         
         <li <?php if($this->router->fetch_class()=='PurchaseController'){ echo 'class="active"';} ?>><a target="_blank" href="<?php echo site_url('purchase');?>"><i class="icon-inbox"></i><span>仕入管理 </span> </a>
            <a id="drop-4"class="down" href="#" ><span class="glyphicon glyphicon-chevron-left"></span></a> 
            <ul>
                <li><a target="_blank"   href="<?php echo site_url('purchase');?>">仕入管理</a></li>
                <li><a target="_blank"   href="<?php echo site_url('purchase');?>/export-purchase">出庫管理</a></li>
                <li><a target="_blank"   href="<?php echo site_url('purchase');?>/debt">仕入請求管理</a></li>
            </ul>   
        </li>
        <li <?php if(($this->router->fetch_class()=='BusinessController') || ($this->router->fetch_class()=='OperationController')){ echo 'class="active"';} ?>><a target="_blank"  href="<?php echo site_url('business-management');?>"><i class="icon-book"></i><span>業務管理  </span> </a>
            <a id="drop-5"class="down" href="#" ><span class="glyphicon glyphicon-chevron-left"></span></a>  
			<ul>
                <li><a target="_blank"   href="<?php echo site_url('business-management');?>">営業管理</a></li>
                <li><a target="_blank"   href="<?php echo site_url('business');?>/inventory">在庫管理</a></li>
				<li><a target="_blank"   href="<?php echo site_url('operation');?>/produce">生産管理</a></li>
            </ul>
        </li>
        <li <?php 
        if($this->router->fetch_class()!='AdminController' && $this->router->fetch_class()!='OrderController' && $this->router->fetch_class()!='SaleController' && $this->router->fetch_class()!='ShipmentController' && $this->router->fetch_class()!='PurchaseController' && $this->router->fetch_class()!='BusinessController' && $this->router->fetch_class()!='OperationController'){

             echo 'class="active"';} ?>>
        <a target="_blank"  href="<?php echo site_url('master');?>"><i class=" icon-th"></i><span>マスタ管理  </span> </a>
            <a id="drop-6"class="down" href="#" ><span class="glyphicon glyphicon-chevron-left"></span></a> 
        </li>
       
    </ul>
</div>   
</nav>
