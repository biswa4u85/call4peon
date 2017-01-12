<script type="text/javascript" src="<?php echo $this->config->item('front_assets_url'); ?>js/contact_form.js"></script>
<form id="contactForm" name="contactForm" class="contactForm" method="POST" enctype="multipart/form-data">
<div class="row contact-form"><!-- .row .contact-form -->
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 form-group"><!-- form-field -->
        <input class="input-field" type="text" placeholder="FIRST NAME" name="fname">
    </div><!-- form-field  end-->
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 form-group"><!-- form-field -->
            <input class="input-field" type="text" placeholder="LAST NAME" name="lname">
    </div><!-- form-field  end-->
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 form-group"><!-- form-field -->
            <input class="input-field" type="email" placeholder="EMAIL ADDRESS" name="email">
    </div><!-- form-field  end-->
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 form-group"><!-- form-field -->
            <input class="input-field" type="text" placeholder="TELEPHONE" name="telephone">
    </div><!-- form-field  end-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group"><!-- form-field -->
            <textarea class="input-field" placeholder="MESSAGE" name="message"></textarea>
    </div><!-- form-field  end-->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><!-- form-btn -->
             <input type="submit" class="contact-btn bgblue-1" value="SUBMIT MESSAGE" name="submit[]" />
    </div><!-- form-btn  end-->
</div>
    </form>
<div id="ContactSuccessMessage"></div>