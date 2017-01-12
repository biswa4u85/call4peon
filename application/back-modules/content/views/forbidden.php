<?php include APPPATH . '/back-modules/views/header.php'; ?>
<div class="common_whitebg close_block">
    <div class="col-md-12">
        <div class="row padbottom">
            <div class="col-md-6">
                <h2 class="headline text-info">Forbidden</h2>
            </div>
            <div class="col-md-6">
            </div>
        </div>
        <div class="error-page">
            <h3><i class="fa fa-warning text-danger"></i>You don't have permissions to access this page.</h3>
            <p>
                We could not permit the page you are looking for. Meanwhile, you may <a class="error-link" href='<?php echo $this->config->item('admin_site_url'); ?>dash'>return to dashboard</a>.
            </p>
        </div>
    </div>
</div>
<?php include APPPATH . '/back-modules/views/footer.php'; ?>