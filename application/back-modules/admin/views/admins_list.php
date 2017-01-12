<?php include APPPATH . '/back-modules/views/header.php'; ?>
<div class="row">
              <div class="col-lg-12 ui-sortable">
                <div class="box ui-sortable-handle">
                  <header>
                    <div class="icons"><i class="fa fa-ship"></i></div>
                    <h5>Admins</h5>
                    <div class="toolbar">
                      <div class="btn-group">
                     <div class="btn-group btn-group-sm previous">
                    <?php
                    $addpermission = $this->general->check_permission('form', 'admin-add', 'ajax');
                    if ($addpermission == 1) {
//                        ?>
                        <a href="<?php echo $this->config->item('admin_site_url'); ?>admin-add" onclick="urlParse(this)" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="bottom" title="New Admin"><i class="fa fa-fw fa-plus-circle"></i> New Admin</a>
                    <?php } ?>
                </div>                
                <?php include APPPATH . '/back-modules/views/columnfields.php'; ?>
                      </div>
                    </div>
                  </header>
                    <div id="collapse4" class="body">
        <table id="list" class="table table-striped table-bordered" cellspacing="0" width="100%"></table>
                    </div>
</div></div></div>
<script>
    getgriddata('admin');
</script>
<?php include APPPATH . '/back-modules/views/footer.php'; ?>
