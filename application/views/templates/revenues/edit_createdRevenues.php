<style>
    .full-table{
        width:100%;
     
    }
    .full-table tr,.full-table td,.full-table th{
          border:1px solid black;
        height:34px;
        
    }
    .full-table td{
        padding-right:9px;
        padding-left:9px;
    }
    .full-table th{
        text-align: center;
    }
    caption{
        background:none;
    }
    .add_revenues{
        // margin:9px;
    }
	.full-table input{
		height:34px;
		width:100%;
		padding:0;
		margin:0;
		border:none;
		padding-left:2px;
	}
    .detail-table{
margin:9px;
        margin-top:27px;
    }
    .detail-table input{
        margin:0;
        width:100%;
      //  height:34px;
        padding:0;
        height:100%;
        border:none;
    }
    .align-right{
        text-align: right;
    }
    .print-1{
        width:92px;
    }
    .td-input{
        padding:0 !important;
    }
</style>
<div class="wrapper-contain revenues order">
<div class="row">
    <div class="col-md-8">
    
                <table >
            <tr>
               <td>注文No:</td>
               <td>000-001</td>
            </tr>
            <tr>
               <td>注文日:</td>
               <td>2016年9月26日（月）</td>
            </tr>
            <tr>
               <td>注文伝票起票者:</td>
               <td>帝王太郎</td>
            </tr>
            <tr>
               <td>得意先名:</td>
               <td><input type="text" value="株式会社ニューオータニ" ></td>
                <td>部署:</td>
               <td><input type="text" value="マネージメントサービス課" ></td>
            </tr>
            <tr>
               <td>売上確定:</td>
               <td>2016年9月30日（木）</td>
            </tr>
            <tr>
               <td>請求No:</td>
               <td>001</td>
           </tr>

        </table>
    
        </div>
</div>
<!--<div class="row">
    <div class="btn-center">
                    <a href="" class="print">削除</a>
                    <a href="" class="print">編集</a>
                    <a href="" class="print"><i class="fa fa-print"></i>印刷 </a>
                </div>
</div>-->
<div class="row">
<table class="full-table">
                        <thead>
                            <tr>
                                <th>商品ID</th>
                                <th>商品名</th>
                                <th>結束単位</th>
                                <th>規格</th>
                                <th>COLOR</th>
                                <th>注文数</th>
                                <th>単価</th>
                                <th>金額</th>
                                <th>納品数</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1014</td>
                                <td>KDスーツ</td>
                                <td>50</td>
                                <td>250*300</td>
                                <td>黄糸</td>
                                <td>10</td>
                                <td>20</td>
                                <td>200</td>
                                <td></td>
                            </tr>
                          
                            <tr>
                                <td>1016</td>
                                <td>Kシーツ</td>
                                <td>50</td>
                                <td>276*300</td>
                                <td>青糸</td>
                                <td>20</td>
                                <td>20</td>
                                <td>400</td>
                                <td></td>
                
                            </tr>
                            <tr>
                                <td>1022</td>
                                <td>シーツ</td>
                                <td>50</td>
                                <td></td>
                                <td></td>
                                <td>30</td>
                                <td>30</td>
                                <td>900</td>
                                <td></td>
                               
                            </tr>
                             <tr>
                                <td>1014</td>
                                <td>シーツ</td>
                                <td>50</td>
                                <td></td>
                                <td></td>
                                <td>40</td>
                                <td>0</td>
                                <td>0</td>
                                <td></td>
                               
                            </tr>
                            <tr>
                                <td>合計</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>100</td>
                                <td></td>
                                <td>2700</td>
                                <td></td>
                                
                            </tr>
                        </tbody>
                    </table>
    <div class="row" style="margin:9px;">
                    <label>備考（納品）</label>
                    <textarea class="form-control" rows="5">デユベピンクはサイズLが在庫切れなので、サイズMのものを納品させていただきます。
デュベブラックは140品だけあり、不足5品は別のタイミングで納品する。
</textarea><br>

    </div>
<div class="row">
    <label style="float:right;"><input type="checkbox">売上確定</label>
    </div>
<div class="row">
    <a style="float:right;" href="#dialog-form" class="print save-created">保存</a>
    <a style="float:right;" href="" class="print">戻る</a>

    </div>
</div>		                               
</div>	
