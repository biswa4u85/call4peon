</div><!-- /.outer -->
      </div><!-- /#content -->
      <div id="right" class="bg-light lter">Right....</div><!-- /#right -->
    </div></div><!-- /#wrap -->
    <footer class="Footer bg-dark dker">
      <p><?php echo $this->config->item('COPYRIGHTED_TEXT');?></p>
    </footer><!-- /#footer -->

    <!-- #helpModal -->
    <div id="helpModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Change Photo</h4>
          </div>
          <div class="modal-body">
            <div class="profile_img_left cropme"> 
                <img class="user_profile_img" src="<?php echo $img_url; ?>" alt=""/>
                <input type="file" class="file_image"  data-idvalue="<?php echo $this->session->userdata('iUserId'); ?>" data-idfield="iUserId" data-field="vProfileImage" data-table="user_master" data-div="profile" /> 
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal --><!-- /#helpModal -->
    <script>
      $(function() {
        //Metis.MetisTable();
        //Metis.metisSortable();
       // Metis.formGeneral();
       // Metis.formWysiwyg();
      });
    </script>
<?php include APPPATH . '/back-modules/views/notification_message.php'; ?>
</body>
</html>