/* Profile Dropdown js */
$(document).ready(function () {
// Init Simple Cropper
    $('.cropme, .cropme1').simpleCropper();
    $('.deleteImage').click(function () {

	if (confirm('Are you sure you want to delete?')) {
	    var divselector = $(this).parent();
	    var selector = divselector.find('.file_image');
	    var selector1 = divselector.find('.deleteImage');
	    var profile = selector.data('div');
	    $.ajax({
		type: "POST",
		url: rootPath + "content/deleteImage",
		data: {
		    field: selector.data('field'),
		    table: selector.data('table'),
		    idvalue: selector.data('idvalue'),
		    idfield: selector.data('idfield')},
		success: function (response) {
		    var array = response.split(",");
		    var id = array[0];
		    var value = array[1];
		    $("#" + id).attr('src', value);
		    selector1.addClass('hidden');
		    if (profile === "profile") {
			$(".user_profile_img").attr('src', value);
		    }
		}
	    });
	}

    });
    $("#notificationLink").click(function ()
    {
	$("#notificationContainer").fadeToggle(300);
	$("#notification_count").fadeOut("slow");
	return false;
    });
    $("#quick_add_links").click(function ()
    {
	$(this).parent().toggleClass('open');
	$("#quicklinkContainer").toggle();
	return false;
    });
//Document Click
    $(document).click(function ()
    {
	$("#notificationContainer").hide();
	$("#quick_add_links").parent().removeClass('open');
	$("#quicklinkContainer").hide();
    });
//Popup Click
    $("#notificationsBody").click(function ()
    {
	return false
    });
    $("#notificationTitle").click(function ()
    {
	return false
    });
    $("#quicklinkContainer").click(function ()
    {
	return false
    });
    /* Dropdown left side menu js */
    $("#showmenu").click(function (e) {
	e.preventDefault();
	$("#menu").toggleClass("show");
    });
    $("#menu a").click(function (event) {
//event.preventDefault();
	if ($(this).next('ul').length) {
	    $(this).next().toggle('fast');
	    $(this).children('i:last-child').toggleClass('fa-angle-down fa-angle-left');
	}
    });
    $('[data-toggle="tooltip"]').tooltip()

    /* Drag and Drop js */

//    $("#sortable").sortable({
//        handle: '.handle',
//        update: function () {
//            var order = $('#sortable').sortable('serialize');
//        }
//    });

    // set effect for  hotelist gridview value
    $(".close_btn").click(function () {
// runEffect(this);
	var options = {};
	$(this).parents(".close_block").effect("fade", options, 1200);
	return true;
    });
    function sticky_relocate() {
	var window_top = $(window).scrollTop();
	var div_top = (typeof ($('#sticky-anchor').offset()) != 'undefined') ? $('#sticky-anchor').offset().top : 0;
	if (window_top > div_top) {
	    $('#sticky').addClass('stick');
	} else {
	    $('#sticky').removeClass('stick');
	}
    }

    $(function () {
	$(window).scroll(sticky_relocate);
	sticky_relocate();
    });
    /* Theme Changer Jquery */
    $("input:radio[name=theme]").click(function () {
	changeTheme($(this).val());
    });
    $(".panel-tab").click(function () {
	$(".Content-main").toggleClass("push");
    });
    function changeTheme(value) {
	$(".color").css({color: value});
	$(".dynamic_bg").css({background: value});
    }


    /* Switcher Fix Jquery */
    $(".panel-tab_new").click(function () {
	$(".Content-main-new").toggleClass("pull");
    });
    /* on click div hide and show js */
    $('.CommentClick').focus(function () {
	$(this).parent().next('.text_container').removeClass('hidden');
    });
    $('.Close').click(function () {
	$(this).parent().addClass('hidden');
    });
    $(".owner-detail-show").hide();
    $(".show-hide").click(function () {
	$(".owner-detail-show").slideToggle("slow");
	if ($(".show-hide button").text() == "Hide Details")
	{
	    $(".show-hide button").text("Show Details");
	}
	else
	{
	    $(".show-hide button").text("Hide Details");
	}
    });
    $('.showhide').click(function () {
	$('.category_more').toggleClass('check');
	if ($(this).text() == 'Show Less')
	    $(this).text('Show More');
	else
	    $(this).text('Show Less');
    });
    if ($("#sidebar-wrapper").length) {
	$("#sidebar-wrapper").mCustomScrollbar({
	    theme: "minimal"
	});
    }

    function myCustomFn(el) {

	var pxShow = -300; //height on which the button will show
	var fadeInTime = 1000; //how slow/fast you want the button to show
	var fadeOutTime = 1000; //how slow/fast you want the button to hide
	var scrollSpeed = 1000; //how slow/fast you want the button to scroll to top. can be a value, 'slow', 'normal' or 'fast'

    }

});
//* Stick div Quick Links jquery */
$(window).load(function () {
    setTimeout(function () {
	$(".sticky_div").each(function () {
	    var $top = ($(this).hasClass('owner-edit-div')) ? 55 : 66;
	    $(this).sticky({topSpacing: $top})
	})
    }, 200);
});
$(document).bind('dragover', function (e) {
    var dropZone = $('.post-comment-block'),
	    timeout = window.dropZoneTimeout;
    if (!timeout) {
	dropZone.addClass('in');
    } else {
	clearTimeout(timeout);
    }
    var found = false,
	    node = e.target;
    do {
	if (node === dropZone[0]) {
	    found = true;
	    break;
	}
	node = node.parentNode;
    } while (node != null);
    if (found) {
	dropZone.addClass('hover');
    } else {
	dropZone.removeClass('hover');
    }
    window.dropZoneTimeout = setTimeout(function () {
	window.dropZoneTimeout = null;
	dropZone.removeClass('in hover');
    }, 100);
});
/* Drag and Drop js */
$(document).ready(function () {
    
    //$('.portlet input').trigger('click');
//    $("#div_pagelayout").sortable({
//	handle: '.handle',
//	placeholder: "portlet-placeholder ui-corner-all",
//	update: function () {
//	    //var order = $('#sortable').sortable('serialize');
//	    var order = [];
//	    $('#div_pagelayout').find('h4.handle').each(function (e) {
//		order.push($(this).attr('id'));
//	    });
//
//	    var positions = order.join(',');
//	    alert(positions);
//	}
//    });

//    $('#sortable').sortable({
//        axis: 'y',
//        opacity: 0.7,
//        handle: '.spanclass',
//        update: function(event, ui) {
//	    alert("in update");
//            var list_sortable = $(this).sortable('toArray').toString();
//    		// change order in the database using Ajax
////            $.ajax({
////                url: 'set_order.php',
////                type: 'POST',
////                data: {list_order:list_sortable},
////                success: function(data) {
////                    //finished
////                }
////            });
//        }
//    }); // fin sortable





});
/* set div height with window body height */
/*$(function(){
 $('.rightcol').css({'height':(($(window).height()))+'px'});
 
 $(window).resize(function(){
 $('.rightcol').css({'height':(($(window).height()))+'px'});
 });
 });*/


/*$(document).ready(function() {
 $('.rightcol').css({'height':$('.leftcol').height()+70})
 });*/