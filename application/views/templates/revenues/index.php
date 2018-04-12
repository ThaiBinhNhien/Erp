<style>
input[type="radio"]
	{
		width:auto !important;
	}
</style>
<div class="wrapper-contain order" id="revenues">
	<div class="row">
		<div class="col-md-6"><h3>未請求注文伝票（納品数チェック済み）</h3></div>
		
		<div class="right">
			<a href="<?php echo site_url('revenues/created_revenues');?>" class="print top-print print-auto">作成済請求書一覧</a>  
		</div>
		  
	</div>
<div class="row first-row">
    <form class="form-horizontal" role="form">
        <div class="row">
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="" class="col-md-4 control-label">注文伝票No:</label>
                    <div class="col-md-8">
                        <input class="form-control " >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="" class="col-md-4 control-label">売上(納品)日:</label>
                    <div class="col-md-8">
                        <span class="form-control form-control-input">
                            <input  class="datepicker" >
                            <span class="icon-large icon-calendar"></span>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group ">
                    <label  class="col-md-4 control-label center"> <span id="character">~</span></label>
                    <div class="col-md-8">
                        <span class="form-control form-control-input">
                            <input  class="datepicker" >
                            <span class="icon-large icon-calendar"></span>
                        </span>    
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="" class="col-md-4 control-label">ユーザ名:</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="inputLabel4" >
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="" class="col-md-4 control-label">注文日:</label>
                    <div class="col-md-8">
                        <span class="form-control form-control-input">
                            <input class="datepicker" >
                            <span class="icon-large icon-calendar"></span>
                        </span>   
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group ">
                    <label class="col-md-4 control-label center"> <span id="character">~</span></label>
                    <div class="col-md-8">
                        <span class="form-control form-control-input">
                            <input class="datepicker" >
                            <span class="icon-large icon-calendar"></span>
                        </span>    
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="" class="col-md-4 control-label">得意先:</label>
                    <div class="col-md-8">
                        <select class="form-control"><option></option></select>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4 col-lg-4">
                <div class="form-group">
                    <label for="" class="col-md-4 control-label">部署名:</label>
                    <div class="col-md-8">
                        <select class="form-control"><option></option></select>
                    </div>
                </div>
            </div>
        </div>
    </form>
 </div><!--End form-horizontal-->
<div class="row">
	<div class="row">
		<a href="" class="print left">表示</a>
	</div>
</div>
<div class="row first-row">        
		<a href="" class="print left">CSV出力</a>
		<a href="" class="print left">請求書一括作成</a>
		<a href="<?php echo site_url('revenues/add-revenues');?>" class="print right" style="margin-right:26px;">請求書作成</a>  
	</div>
<div class="row third-row margin-bottom-table" >
    <table  class="display datatable responsive cell-border" cellspacing="0" width="100%" id="revenues-table">
    <thead>
        <tr>
            <th>請求</th>
            <th>お得意先</th>
            <th>注文No</th>
            <th>部署名</th>
            <th>起票者</th>
            <th>注文数</th>
            <th>売上確定日</th>
            <th>納品数</th>
        </tr>
    </thead>
	
	
    <tbody>
        <tr>
            <td class="center-text"><input type="radio" name="first-row"/></td>
            <td>株式会社ニューオータニ</td>
            <td>10</td>
            <td>A部門</td>
            <td>大谷太郎</td>
            <td>500</td>
            <td>2016.09.22</td>
            <td>450</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>6</td>
            <td>B部門</td>
            <td>大谷太郎</td>
            <td>560</td>
            <td>2016.09.21</td>
            <td>500</td>

        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>5</td>
            <td>C部門</td>
            <td>大谷太郎</td>
            <td>670
            <td>2016.09.20</td>
            <td>670</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>2</td>
            <td>D部門</td>
            <td>大谷太郎</td>
            <td>670
            <td>2016.09.19</td>
            <td>350</td>
        </tr>
        <tr>
            <td style="text-align:center !important"><input type="radio" name="first-row"/></td>
            <td>株式会社ニューオータニ</td>
            <td>4</td>
            <td>Y部門</td>
            <td>大谷太郎</td>
            <td>670
            <td>2016.09.11</td>
            <td>250</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>1</td>
            <td>Z部門</td>
            <td>大谷太郎</td>
            <td>670
            <td>2016.09.10</td>
            <td>600</td>
        </tr>
		<tr>
            <td style="text-align:center !important"><input type="radio" name="first-row"/></td>
            <td>ABCホテル</td>
            <td>234</td>
            <td>A部門</td>
            <td>大谷太郎</td>
            <td>100
            <td>2016.09.19</td>
            <td>50</td>
        </tr> 
        <tr>
            <td></td>
            <td></td>
            <td>235</td>
            <td>B部門</td>
            <td>大谷太郎</td>
            <td>100
            <td>2016.09.15</td>
            <td>50</td>
        </tr>  
		<tr>
            <td class="center-text"><input type="radio" name="first-row"/></td>
            <td>XYZホテル</td>
            <td>123</td>
            <td>A部門</td>
            <td>大谷太郎</td>
            <td>350
            <td>2016.09.17</td>
            <td>130</td>
        </tr>
		<tr>
            <td class="center-text"><input type="radio" name="first-row"/></td>
            <td>XYZホテル</td>
            <td>123</td>
            <td>A部門</td>
            <td>大谷太郎</td>
            <td>350
            <td>2016.09.17</td>
            <td>130</td>
        </tr>  
		<tr>
            <td class="center-text"><input type="radio" name="first-row"/></td>
            <td>XYZホテル</td>
            <td>123</td>
            <td>A部門</td>
            <td>大谷太郎</td>
            <td>350
            <td>2016.09.17</td>
            <td>130</td>
        </tr>  
		<tr>
            <td class="center-text"><input type="radio" name="first-row"/></td>
            <td>XYZホテル</td>
            <td>123</td>
            <td>A部門</td>
            <td>大谷太郎</td>
            <td>350
            <td>2016.09.17</td>
            <td>130</td>
        </tr>  
    </tbody>
	</table>
	
</div><!--End row table-->
</div><!--End wrapper-contain-->

