<!--
{% macro navlink(endpoint,text,icon) %}
{%- if request.endpoint.endswith(endpoint) == True %}
-->
<!--
<li class="active"><a href="{{endpoint}}"><i class="{{icon}}"></i><span>{{text}}</span> </a> </li>
<!-- {%- else %}    -->
<!--
<li><a href="{{endpoint}}"><i class="{{icon}}"></i><span>{{text}}</span> </a> </li>
-->
<!--
{%- endif %}
{% endmacro %}
-->
<div class="subnavbar">
  <div class="subnavbar-inner">
    <div class="container">
      <ul class="mainnav">
    <li class="active"><a href="<?php echo site_url('');?>"><i class="icon-home"></i><span>Home</span> </a> </li>
        <li class="dropdown subnavbar-open-right"><a href="<?php echo site_url('order');?>">" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-list-alt"></i><span>注文管理</span></a> 
           <ul class="dropdown-menu ">
                <li><a href="<?php echo site_url('order');?>/add_order">Add Order</a></li>
            	<li><a href="<?php echo site_url('order');?>/add_order1">Add Order 1</a></li>
                <li><a href="<?php echo site_url('order');?>/banquet">Banquet</a></li>
                <li><a href="<?php echo site_url('order');?>/checklist">Checklist</a></li>
                <li><a href="<?php echo site_url('order');?>/pageOrder">Page Order</a></li>
                <li><a href="<?php echo site_url('order');?>/revenue">Revenue</a></li>
                <li><a href="<?php echo site_url('order');?>/delivery">Delivery</a></li>
                <li><a href="<?php echo site_url('order');?>/customersOrders">Customers Orders</a></li>
                <li><a href="<?php echo site_url('order');?>/customersOrders_2">Customers Orders 2</a></li>
                <li><a href="<?php echo site_url('order');?>/customersOrders_3">Customers Orders 3</a></li>
                <li><a href="<?php echo site_url('order');?>/customersOrders_4">Customers Orders 4</a></li>
                <li><a href="<?php echo site_url('order');?>/externalOrders">External Orders</a></li>
            </ul> 
        </li>
        <li><a href="<?php echo site_url('business-management'); ?>"><i class="icon-facetime-video"></i><span>業務管理</span> </a></li>
        <li><a href="charts.html"><i class="icon-bar-chart"></i><span>出荷管理</span> </a> </li>
        <li><a href="shortcodes.html"><i class="icon-book"></i><span>仕入管理</span> </a> </li>
        <li><a href="shortcodes.html"><i class="icon-list-alt"></i><span>業務管理</span> </a> </li>
        <li><a><i class="icon-table"></i><span>マスター管理</span> </a></li>
      </ul>
    </div>
    <!-- /container --> 
  </div>
  <!-- /subnavbar-inner --> 
</div>
<!-- /subnavbar -->