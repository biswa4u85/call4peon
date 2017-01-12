<!--================================ FOOTER AREA ==========================================-->
		<footer class="footer style-1 bg222">
			<div class="footer-bottom">
				<div class="container">
					<div class="row clearfix">
						<div class="col-md-8 col-sm-12 col-xs-12 pull-right margin-bottom-20">
							<nav class="footer-menu wsmenu clearfix">
								<ul class="wsmenu-list pull-right">
								    <li><a href="#header" class="">Home</a></li>
                                                                    <li><a href="#services">Services</a></li>
                                                                    <li><a href="#funfact">About</a></li>
                                                                    <li><a href="#terms">Terms</a></li>
                                                                    <li><a href="#press">Press</a></li>
                                                                    <li><a href="#contact">Contact</a></li>
								</ul>
							</nav>
						</div>
						<div class="col-md-4 col-sm-12 col-xs-12 pull-left margin-bottom-20">
							<div class="footer-copyright">
								<p><?php echo $this->config->item('COPYRIGHTED_TEXT');?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
	</div>
	<!--================================MODAL WINDOWS FOR REGISTER AND LOGIN FORMS ===========================================-->
        
	<!-- Modal Become a Peon form -->
	<div class = "modal fade" id = "become" tabindex = "-1" role = "dialog" aria-labelledby = "myModalLabel" aria-hidden = "true">
	   <div class = "listing-modal-3 modal-dialog">
		  <div class = "modal-content">
			 <div class = "modal-header">
				<button type = "button" class = "close" data-dismiss = "modal" aria-hidden = "true">&times;</button>
				<h4 class = "modal-title blue-1" id = "myModalLabel2"> Become a Peon</h4>
			 </div>
			 <div class = "modal-body">
				<div class=" listing-register-form">
                                        <?php include APPPATH . '/front-modules/views/add_peon.php'; ?>
				</div>
			 </div>
		  </div><!-- /.modal-content -->
	   </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
        
        <?php include APPPATH . '/front-modules/views/common_footer_files.php'; ?>
</body>
</html>