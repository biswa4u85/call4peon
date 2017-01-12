<?php include APPPATH . '/back-modules/views/header.php'; ?>
<div class="row">
              <div class="col-lg-12 ui-sortable">
                <div class="box ui-sortable-handle">
                  <header>
                    <div class="icons"><i class="fa fa-ship"></i></div>
                    <h5>Modules</h5>
                    <div class="toolbar">
                      <div class="btn-group">
                     <div class="btn-group btn-group-sm previous">
                        <a href="<?php echo $this->config->item('admin_site_url'); ?>module_add" onclick="urlParse(this)" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="bottom" title="New Module"><i class="fa fa-fw fa-plus-circle"></i> New Module</a>
                    <?php // } ?>               
                <?php include APPPATH . '/back-modules/views/columnfields.php'; ?>
                      </div>
                    </div>
                  </header>
                    <div id="collapse4" class="body">
        <table id="list" class="table table-striped table-bordered" cellspacing="0" width="100%"></table>
                    </div>
</div></div></div>
<script>
    getgriddata('module_master');
</script>
<?php include APPPATH . '/back-modules/views/footer.php'; ?>
