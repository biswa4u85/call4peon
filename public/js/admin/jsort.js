/*
 * jSort - jQury sorting plugin
 * http://do-web.com/jsort/overview
 *
 * Copyright 2011, Miriam Zusin
 * Dual licensed under the MIT or GPL Version 2 licenses.
 * http://do-web.com/jsort/license
 */

 (function($){$.fn.jSort=function(options){var options=$.extend({sort_by:"p",item:"div",order:"asc",is_num:false,sort_by_attr:false,attr_name:""},options);return this.each(function(){var a=this,hndl=a,titles=[],i=0;$(a).find(options.item).each(function(){var a,b=$(this).find(options.sort_by);if(options.sort_by_attr)a=b.attr(options.attr_name).toLowerCase();else a=b.text().toLowerCase();titles.push([a,i]);$(this).attr("rel","sort"+i);i++});a.sortNum=function(a,b){return eval(a[0]-b[0])};a.sortABC=function(a,b){return a[0]>b[0]?1:-1};if(options.is_num)titles.sort(hndl.sortNum);else titles.sort(hndl.sortABC);if(options.order=="desc")if(options.is_num)titles.reverse(hndl.sortNum);else titles.reverse(hndl.sortABC);for(var t=0;t<titles.length;t++){var el=$(hndl).find(options.item+"[rel='sort"+titles[t][1]+"']");$(hndl).append(el)}})}})(jQuery);