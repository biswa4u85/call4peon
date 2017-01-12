$(function ()
{
    var isCustomScroll = $('body').css('overflow') === 'hidden';

    $('.jscroll').jscroll({
	loadingHtml: '<div class="alert alert-primary center">Loading ...</div>',
	debug: false,
	nextSelector: '.jscroll-next:last',
	isCustomScroll: isCustomScroll,
	isWindow: !isCustomScroll,
	customScroll: isCustomScroll ? '#wrapper' : 'window'
    });

//$('.jscroll').jscroll({
//    loadingHtml: '<div class="alert alert-primary center">Loading ...</div>',
//    padding: 20,
//    debug: true,
//    nextSelector: 'a.jscroll-next:last',
//    autoTrigger: false
//});
//$('.scroll').jscroll();
});