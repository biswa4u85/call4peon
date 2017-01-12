<?php 
include APPPATH . '/back-modules/views/header.php';
//$editpermission = $this->general->check_permission('form', "customers_edit", 'ajax');
?>
<div class="row">
              <div class="col-lg-12 ui-sortable">
                <div class="box ui-sortable-handle">
                  <header>
                    <div class="icons"><i class="fa fa-ship"></i></div>
                    <h5>Peons</h5>
                    <div class="toolbar">
                      <div class="btn-group">
                          <div class="btn-group btn-group-sm previous">
                    <?php
                    $addpermission = $this->general->check_permission('form', 'user-add', 'ajax');
                    if ($addpermission == 1) {
                        ?>
                        <a href="<?php echo $this->config->item('admin_url'); ?>user-add" onclick="urlParse(this)" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="bottom" title="New User"><i class="fa fa-fw fa-plus-circle"></i> New User</a>
                    <?php } ?>
                <?php include APPPATH . '/back-modules/views/columnfields.php'; ?>
                      </div>
                    </div>
                  </header>
                    <div id="collapse4" class="body">
        <table id="list" class="table table-striped table-bordered" cellspacing="0" width="100%"></table>
                    </div>
</div></div></div>
<script>
    getgriddata('user_master');
</script>
<?php include APPPATH . '/back-modules/views/footer.php'; ?>