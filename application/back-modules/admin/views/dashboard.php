<?php include APPPATH . '/back-modules/views/header.php'; ?>
<div class="row">
              <div class="col-lg-12 ui-sortable">
                <div class="box ui-sortable-handle">
                  <header>
                    <div class="icons"><i class="fa fa-ship"></i></div>
                    <h5>Pending Shipment</h5>
                  </header>
                    <div id="collapse4" class="body">
                    <div id="collapseExample" class="chart collapse in">

            <div id="divlist">
                <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Contact No</th>
                            <th>Preffered Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (count($pending_shipment) > 0) {
                            foreach ($pending_shipment as $key => $value) {
                                ?>
                                <tr>
                                    <td><?php echo $value['vTitle']; ?></td>
                                    <td><?php echo $value['vContactNo']; ?></td>
                                    <td><?php echo date_format(date_create($value['vPreferredDate']), "d-M-Y") ; ?></td> 
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="3">
                                    No Data.
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
            </div>
</div></div></div>
<?php include APPPATH . '/back-modules/views/footer.php'; ?>