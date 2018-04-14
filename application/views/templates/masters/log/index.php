
<style>
img{
    height:22px;

}
.dataTables_wrapper .dataTables_filter {
    float: left !important;
    margin-top: 15px !important;
}
.dataTables_wrapper .dataTables_filter input {
    margin-left: 0 !important;
}
</style>
<div class="wrapper-contain order" id="receive-order">
  <div>
        <h3><?php echo $title; ?></h3>
    </div>
    <br>
	<div class="row third-row" id="list-table">
        <table  class="display datatable dataTable responsive cell-border" id="tableLog" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th width=15%>日時</th>
                    <th width=10%>ユーザ</th>
                    <th width=15%>テーブル</th>
                    <th width=15%>アクセス名</th>
                    <th width=45%>情報</th>
                </tr>
            </thead>
		
		 <tbody>
            <?php 
            if(isset($data_log)) {
            foreach ($data_log as $key => $value) { ?>
                    <tr>
                        <td><?php echo $value["date"]; ?></td>
                        <td><?php echo $value["user"]; ?></td>
                        <td><?php echo $value["table"]; ?></td>
                        <td><?php echo $value["name_access"]; ?></td>
                        <td><?php echo $value["infor"]; ?></td>
                    </tr>
            <?php } } ?>
            </tbody>
        </table>
		
		</div> 

        <div>
        </div>
</div>
<script>
var url_get_log = "<?= base_url('master/get_log') ?>";
</script>
