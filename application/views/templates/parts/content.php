<div class="container">
    <?php (isset($content))?$content:$content='dashboard';?>
    <?php $this->load->view('templates/'.$content);?>
</div> 