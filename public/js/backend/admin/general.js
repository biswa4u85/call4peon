var $timeout = 1000;
var xhr_grid = '';
var selected_order_list = '';
var call_feed = false;

jQuery.browser = {};
(function () {
    jQuery.browser.msie = false;
    jQuery.browser.version = 0;
    if (navigator.userAgent.match(/MSIE ([0-9]+)\./)) {
        jQuery.browser.msie = true;
        jQuery.browser.version = RegExp.$1;
    }
})();

$(document).ready(function (e) {
    $.validator.addMethod("phoneno", function (value, element) {
        return this.optional(element) || /^[0-9\+)(\[\]{}-]+$/.test(value);
    }, "Please enter a valid number");

    $.validator.addMethod("firstname", function (value, element) {
        return this.optional(element) || /^[a-zA-Z' ]+$/.test(value);
    }, "Please enter a valid first name");

    $.validator.addMethod("lastname", function (value, element) {
        return this.optional(element) || /^[a-zA-Z' ]+$/.test(value);
    }, "Please enter a valid last name");

    $.validator.addMethod("middlename", function (value, element) {
        return this.optional(element) || /^[a-zA-Z' ]+$/.test(value);
    }, "Please enter a valid middle name");

    $('.downloadlink').click(function (b) {
        b.preventDefault()
    })
    $('[name="submit[]"]').click(function (b) {
        $("#btnsubmit").val($(this).val());
    })
    $('.deleteattach').click(function (b) {
        b.preventDefault()
    })

    $('#widgetClose').click(function () {
        $('#spamcheckdiv').html('')
        $('#viewboxiframe').hide();
        $('#viewboxiframe').attr('src', '');
        $('#viewboxiframe').html('');
        $('#viewboxtitle').text('');
    });
    //    $('.loaderdiv').fadeOut(1000);
    setInterval(function () {
        sessiontimeout();
    }, (timeout * 60001));

    $('.profile_name').click(function () {
        //        alert($(this).data('mode'))
        if ($(this).data('mode') == 'closemenu') {
            $(this).data('mode', 'openmenu');
        } else {
            $(this).data('mode', 'closemenu');
        }
    })

    $('#dLabel').click(function () {
        if ($('#noti_count').text() != "") {
            $.ajax({
                type: 'POST',
                url: rootPath + 'feeds/updateNotificationCount',
                success: function (data) {
                    if (data == "update") {
                        $('#noti_count').remove();
                    }
                }
            });
        }
    });

    $('.rightdropdown').mouseleave(function () {
        if ($('.profile_name').data('mode') == 'openmenu') {
            $('.profile_name').trigger('click');
        }
    });
    $('.rightdropdown').mouseenter(function () {
        if ($('.profile_name').data('mode') == 'closemenu') {
            $('.profile_name').trigger('click');
        }
    });

    $('#notifications').scroll(function () {
        if (typeof ($('.jnotiscroll-next:last').attr('href')) != 'undefined' && $('#notification_panel').height() <= $('#notifications').scrollTop() + $('#notifications').height()) {
            retriveNotifications($('.jnotiscroll-next:last').attr('href'));
        }
    });

//    $('.column').find('div.portlet input').each(function (e) {
//	if ($(this).is(':checked')) {
//	    $(this).parent().addClass("mandatory_text");
//	}
//    });

    $(document).on('click', ".portlet input", function () {
        //$('.portlet input').click(function () {
        if ($(this).is(':checked')) {
            $(this).parent().parent().addClass("mandatory_text");
            var modulecustomid = $(this).parent().attr('id');
            $.ajax({
                type: 'POST',
                url: rootPath + 'user/update_mandatory_fields',
                data: {id: modulecustomid, mandatory: '1'},
                success: function (data) {
                }
            });
        } else {
            $(this).parent().parent().removeClass("mandatory_text");
            var modulecustomid = $(this).parent().attr('id');
            $.ajax({
                type: 'POST',
                url: rootPath + 'user/update_mandatory_fields',
                data: {id: modulecustomid, mandatory: '0'},
                success: function (data) {
                }
            });
        }
    });

    $(document).on('click', ".portlet a i.fa-trash-o", function () {
        var modulecustomid = $(this).parent().parent().attr('id');
        $.ajax({
            type: 'POST',
            url: rootPath + 'user/remove_field',
            data: {id: modulecustomid},
            success: function () {
                $('#modulesList').trigger('change');
            }
        });
    });

    $(document).on('click', ".portlet a i.fa-plus-square", function () {
        var modulecustomid = $(this).parent().parent().attr('id');
        $.ajax({
            type: 'POST',
            url: rootPath + 'user/add_field',
            data: {id: modulecustomid},
            success: function () {
                $('#modulesList').trigger('change');
            }
        });
    });

    $('#modulesList').change(function () {
        var data;
        $('#div_pagelayout').empty();
        var moduleid = $(this).val();
        var modulename = $("#modulesList option[value='" + moduleid + "']").text().trim();
        if (modulename == "Packages") {
            var packagetypeid = $('#packageType').val();

            $.ajax({
                type: 'POST',
                async: false,
                url: rootPath + 'package_type/get_package_type_list',
                success: function (result) {
                    $('#packageType').empty();
                    $('#packageType').append(result);
                    if (!packagetypeid) {
                        $("#packageType").select2("val", $("#packageType option:first").val());
                    } else {
                        $("#packageType").select2("val", packagetypeid);
                    }
                }
            });

            packagetypeid = $('#packageType').val();

            $('#div_package_type').show();
            $('#div_package_action').show();

            data = {id: moduleid, name: modulename, packagetypeid: packagetypeid};
            $('#a_edit_package_type').data('href', '');
            $('#a_edit_package_type').data('href', rootPath + 'package_type_add?f=ajax&m=edit&id=' + packagetypeid + '&N=Edit Package Type');
        } else {
            $('#div_package_type').hide();
            $('#div_package_action').hide();
            data = {id: moduleid, name: modulename};
        }
        $.ajax({
            type: 'POST',
            url: rootPath + 'user/customize_pagelayout',
            data: data,
            success: function (data) {
                $('#div_pagelayout').empty();
                $('#div_pagelayout').append(data);
            }
        });
    });

    $('#packageType').change(function () {
        var data;
        $('#div_pagelayout').empty();
        var moduleid = $('#modulesList').val();
        var modulename = $("#modulesList option[value='" + moduleid + "']").text().trim();
        var packagetypeid = $(this).val();

        data = {id: moduleid, name: modulename, packagetypeid: packagetypeid};
        $('#a_edit_package_type').data('href', '');
        $('#a_edit_package_type').data('href', rootPath + 'package_type_add?f=ajax&m=edit&id=' + packagetypeid + '&N=Edit Package Type');
        $.ajax({
            type: 'POST',
            url: rootPath + 'user/customize_pagelayout',
            data: data,
            success: function (data) {
                $('#div_pagelayout').empty();
                $('#div_pagelayout').append(data);
            }
        });
    });

    $('#modulesList').trigger('change');
    $('#packageType').trigger('change');

    jQuery.validator.addClassRules({
        clvName: {
            required: true,
            messages: {required: "Please enter name"}
        },
        clvCompany: {
            required: true,
            messages: {required: "Please enter company name"}
        },
        clvFirstName: {
            firstname: true,
            messages: {required: "Please enter firstname", firstname: "Please enter valid firstname"}
        },
        clvMiddleName: {
            middlename: true,
            messages: {required: "Please enter middlename", middlename: "Please enter valid middlename"}
        },
        clvLastName: {
            required: true,
            lastname: true,
            messages: {required: "Please enter lastname", lastname: "Please enter valid lastname"}
        },
        clvNickName: {
            firstname: true,
            messages: {nickname: "Please enter valid lastname"}
        },
        cliAccountId: {
            required: true,
            messages: {required: "Please select account name"}
        },
        'cliPrimaryRepId[]': {
            required: true,
            messages: {required: "Please select primary representative"}
        },
        cliPrimaryRepId: {
            required: true,
            messages: {required: "Please select primary representative"}
        },
        cliVendorId: {
            required: true,
            messages: {required: "Please select vendor"}
        },
        cliStageId: {
            required: true,
            messages: {required: "Please select stage"}
        },
        clvPhone: {
            minlength: 8,
            phoneno: true,
            messages: {minlength: "Please enter atleast 8 number", phoneno: "Please enter valid phone number"}
        },
        clvAssistantPhone: {
            minlength: 8,
            phoneno: true,
            messages: {minlength: "Please enter atleast 8 number", phoneno: "Please enter valid phone number"}
        },
        clvPhoneMobile: {
            minlength: 8,
            phoneno: true,
            messages: {minlength: "Please enter atleast 8 number", number: "Please enter numeric value"}
        },
        clvPhoneWork: {
            minlength: 8,
            phoneno: true,
            messages: {minlength: "Please enter atleast 8 number", number: "Please enter numeric value"}
        },
        clvPhoneOther: {
            minlength: 8,
            phoneno: true,
            messages: {minlength: "Please enter atleast 8 number", number: "Please enter numeric value"}
        },
        clfAnnualRevenue: {
            number: true,
            messages: {number: "Please enter numeric value"}
        },
        clfRevenue: {
            number: true,
            messages: {number: "Please enter numeric value"}
        },
        clfAmount: {
            number: true,
            messages: {number: "Please enter numeric value"}
        },
        cliProbability: {
            digits: true,
            messages: {number: "Please enter numeric value"}
        },
//        clvFax: {
//            required: true,
//            messages: {required: "Please enter fax no"}
//        },
        clvEmail: {
            email: true,
            messages: {email: "Please enter valid email"}
        },
        clvWebsite: {
            url: true,
            messages: {url: "Please enter valid url"}
        },
        clvZip: {
            required: true,
            messages: {required: "Please enter zip code"}
        },
        cliNoOfEmp: {
            digits: true,
            messages: {digits: "Please enter numeric value"}
        },
        cliEmployees: {
            digits: true,
            messages: {digits: "Please enter numeric value"}
        },
        clvBillingZip: {
            digits: true,
            messages: {digits: "Please enter digits"}
        },
        clvShippingZip: {
            digits: true,
            messages: {digits: "Please enter digits"}
        }
    });



});



function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ')
            c = c.substring(1);
        if (c.indexOf(name) != -1)
            return c.substring(name.length, c.length);
    }
    return "";
}

function preventcall() {
    window.event.preventDefault();
}

function getgriddata(table, html_id, editpath, listorder) {
    html_id = typeof (html_id) != 'undefined' ? html_id : 'list';
    listorder = typeof (listorder) != 'undefined' ? listorder : '';

    $('#' + html_id).html($('.loaderdiv').html());
    $('.loading').fadeOut(500);

    if (xhr_grid && xhr_grid.readystate != 4) {
        xhr_grid.abort();
    }
    $.ajax({
        type: 'POST',
        url: rootPath + 'content/getgridfields',
        data: {module: table, type: 'ajax'},
        success: function (data) {
            get_data = jQuery.parseJSON(data);
            setgrid(html_id, get_data.tbl, editpath, get_data.colsmodel, get_data.colshead, get_data.colstitle, get_data.options, get_data.columndatatypeArr, get_data.coldata, listorder, get_data.order_list, get_data.show_order_list);
        }
    });
}

function setgrid(html_id, table, editpath, Colsmodel, Colshead, Colstitle, options, datatypes, tblheads, listorder, order_list, show_order_list) {
    var importhref = $('.importbtn').attr('href');

    var exportid, classexport;
    if (html_id == 'tasklist') {
        exportid = $('#open_task').find('a.liexport');
        classexport = 'litask';
    } else if (html_id == 'eventlist') {
        exportid = $('#open_event').find('a.liexport');
        classexport = 'lievent';
    } else if (html_id == 'calllist') {
        exportid = $('#open_call').find('a.liexport');
        classexport = 'licall';
    } else {
        exportid = $('.liexport');
        classexport = 'liall';
    }
    $('.importbtn').attr('href', importhref + table.replace('_master', '').trim());
    $(exportid).each(function () {
        var urldata = $(this).attr('href');
        urldata += table.replace('_master', '').trim();
        if (html_id == 'tasklist' || html_id == 'eventlist' || html_id == 'calllist' || html_id == 'activitieslist') {
            if (typeof ($('#viewtbl').data('type')) != 'undefined') {
                urldata += '&type=' + $('#viewtbl').data('type') + '&typed=' + $('#viewtbl').data('idval');
            }
        }
        $(this).attr('href', urldata);
    });

    $mType = (typeof ($('#viewtbl').data('type')) != 'undefined') ? $('#viewtbl').data('type') : '';
    $mId = (typeof ($('#viewtbl').data('idval')) != 'undefined') ? $('#viewtbl').data('idval') : '';
    var dtable = $('#' + html_id).DataTable({
        ajax: {
            "url": rootPath + "content/list_ajax",
            "type": "POST",
            data: {tbl: table.trim(), mType: $mType, mId: $mId, listorder: listorder}
        },
        "destroy": true,
        "processing": true,
        "serverSide": true,
        "columns": Colstitle
                //        "columnDefs": Colsmodel
                //  columns: [{"title":"iContactGroupId"},{"title": "Group Name"},{"title": "Added By"},{"title": "Last Modified By"},{"title": "Added Date"},{"title": "Modified Date"},{"title": "Status"},{"title": "Action"}]
    });


    setTimeout(function () {
        $('.Delete').unbind('click');
        $(document).off('click', '.Delete');

        $(document).on('click', '.Delete', function (e) {
            var type = (typeof ($(this).data('type')) !== 'undefined') ? $(this).data('type') : '';
            //if (!confirm('Accounts you have chosen to delete may have various records associated to it. Any record(s) associated to these Accounts will also be deleted.'));
            if (type !== "") {
                if (!confirm('The ' + type + ' you have chosen to delete may have various records associated to it. Any record(s) associated to this ' + type + ' will also be deleted.'))
                    e.preventDefault();
            }
            else {
                if (!confirm('Are you sure you want to delete?'))
                    e.preventDefault();
            }
        });

        $('.roledelete').unbind('click');

        $('.roledelete').click(function (e) {
            alert("This role is assigned to several users so you cannot delete the role");
            e.preventDefault();
        });

        setInterval(function () {
            $('#' + html_id + ' td > a:parent').each(function (e) {
                $(this).parent().addClass('actioncol');
            })
        }, 500)
//
        $('#' + html_id + ' tbody').on('click', 'td', function (e) {
            if (!$(this).hasClass('actioncol')) {
                if ($('#' + html_id).data('type') == 'attach') {
                    $(this).parent().find('a.listeditbtn').trigger('click')
                } else {
                    var viewurlval = $(this).parent().find('a.listeditbtn').attr('href');
                    window.location.href = viewurlval;
                }
            }
        });

        $('#' + html_id + ' tbody tr').mouseenter(function () {
            $(this).css('background-color', '#e6e6e6');
            $(this).css('color', 'black');
            $(this).css('cursor', 'pointer');
        });
        $('#' + html_id + ' tbody tr').mouseleave(function () {
            $(this).css('background-color', '');
            $(this).css('color', '');
        });

        $('#' + html_id).parent().addClass('table_listing');
        $('#' + html_id).parent().parent().addClass('draw_listing');

        $('#refreshbtn').click(function () {
            dtable.search('');
            $('input[type=search]').val('');
            dtable.draw();

            setTimeout(function () {
                $('.Delete').unbind('click');
                $('.Delete').click(function (e) {
                    if (!confirm('Are you sure you want to delete?'))
                        e.preventDefault()
                })
                $('#' + html_id + ' td > a:parent').each(function (e) {
                    $(this).parent().addClass('actioncol');
                })

                $('#' + html_id + ' tbody tr').mouseenter(function () {
                    $(this).css('background-color', '#e6e6e6');
                    $(this).css('color', 'black');
                    $(this).css('cursor', 'pointer');
                });
                $('#' + html_id + ' tbody tr').mouseleave(function () {
                    $(this).css('background-color', '');
                    $(this).css('color', '');
                });
            }, (1000))
        });
    }, (1000))

    if (Colshead.length > 0) {
        var licontent = '';
        var optioncontent = '';
        var cnt = 0;
        var bool = true;
        var colids = [];
        for (var i = 0; i < (Colstitle.length - 1); i++) {
            if (Colstitle[i].sortable != false) {
                if (cnt > 0) {
                    var selected = '';
                    var chk = '';

                    if (Colstitle[i].selected == true) {
                        chk = 'checked=' + Colstitle[i].selected.toString();
                        selected = 'selected';
                    }
                    var classname, ulid, spid;
                    if (html_id == 'tasklist') {
                        ulid = $('#open_task').find('ul.columnul');
                        spid = $('#open_task').find('.columnsname');
                        classname = 'showtaskgrid';
                        optioncontent += '<option value="' + i + '" ' + selected + '><span>' + Colstitle[i].title + '</span></option>';
                        licontent += '<li rel="' + i + '" class=""><div class="checkbox"><label class="checkbox-custom"><i class="fa fa-fw fa-square-o"></i><input type="checkbox" class="colselectchkbox ' + classname + '" data-cnt="' + i + '" value="' + Colstitle[i].title + '" ' + chk + '><span>' + Colstitle[i].title + '</span></label></div></li>';
                    } else if (html_id == 'eventlist') {
                        ulid = $('#open_event').find('ul.columnul');
                        spid = $('#open_event').find('.columnsname');
                        classname = 'showeventgrid';
                        optioncontent += '<option value="' + i + '" ' + selected + '><span>' + Colstitle[i].title + '</span></option>';
                        licontent += '<li rel="' + i + '" class=""><div class="checkbox"><label class="checkbox-custom"><i class="fa fa-fw fa-square-o"></i><input type="checkbox" class="colselectchkbox ' + classname + '" data-cnt="' + i + '" value="' + Colstitle[i].title + '" ' + chk + '><span>' + Colstitle[i].title + '</span></label></div></li>';
                    } else if (html_id == 'calllist') {
                        ulid = $('#open_call').find('ul.columnul');
                        spid = $('#open_call').find('.columnsname');
                        classname = 'showcallgrid';
                        optioncontent += '<option value="' + i + '" ' + selected + '><span>' + Colstitle[i].title + '</span></option>';
                        licontent += '<li rel="' + i + '" class=""><div class="checkbox"><label class="checkbox-custom"><i class="fa fa-fw fa-square-o"></i><input type="checkbox" class="colselectchkbox ' + classname + '" data-cnt="' + i + '" value="' + Colstitle[i].title + '" ' + chk + '><span>' + Colstitle[i].title + '</span></label></div></li>';
                    } else {
                        spid = $('.columnsname');
                        ulid = $('.columnul');
                        classname = 'showcolumngrid';
                        optioncontent += '<option value="' + i + '" ' + selected + '><span>' + Colstitle[i].title + '</span></option>';
                        licontent += '<li rel="' + i + '" class=""><div class="checkbox"><label class="checkbox-custom"><i class="fa fa-fw fa-square-o"></i><input type="checkbox" class="colselectchkbox ' + classname + '" data-cnt="' + i + '" value="' + Colstitle[i].title + '" ' + chk + '><span>' + Colstitle[i].title + '</span></label></div></li>';
                    }
                    colids.push(i)
                }
                cnt++;
            }
        }
        $(ulid).html(licontent)
        $(spid).html(optioncontent);
        $('.columnsname').multiselect({
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            buttonContainer: '<div class="btn-group-sm" />',
            nonSelectedText: 'Select Columns',
            numberDisplayed: 0
        });
    }

//    $('.' + classname).click(function (e) {
//        // Get the column API object
//        var column = dtable.column($(this).attr('data-cnt'));
//        // Toggle the visibility
//        column.visible(!column.visible());
//    });

    $('.' + classname).change(function (e) {
        var column = '';
        var columnval = '';
        var selectedColumns = $('.' + classname).val();

        $('.' + classname).parent().find('.multiselect-container li').each(function (e) {
            columnval = $(this).find('input[type=checkbox]').val();
            if (isNumeric(columnval)) {
                column = dtable.column(columnval);
                // Toggle the visibility            
                if ($.inArray(columnval, selectedColumns) > -1) {
                    column.visible(true);
                } else {
                    column.visible(false);
                }
            }
        });
    });

    if (show_order_list == 1)
    {
        if (order_list.length > 0) {
            var optioncontent = '';
            var licontent = '';
            var ulid = '';
            var slid = '';

            if (html_id == 'tasklist') {
                slid = ulid = $('#open_task').find('.select_list_order');
            } else if (html_id == 'eventlist') {
                slid = ulid = $('#open_event').find('.select_list_order');
            } else if (html_id == 'calllist') {
                slid = ulid = $('#open_call').find('.select_list_order');
            } else {
                slid = ulid = $('.select_list_order');
            }

            for (var oi = 0; oi < order_list.length; oi++) {
                var class_name = '';
                var selected = '';
                if ((selected_order_list == "" && oi == 0) || order_list[oi].value == selected_order_list) {
                    class_name = 'active';
                    selected = 'selected';
                }
                optioncontent += '<option value="' + order_list[oi].value + '" ' + selected + '><span>' + order_list[oi].label + '</span></option>';
                licontent += '<li class="' + class_name + '"><a href="javascript:void(0)" class="order_list' + html_id + '" data-value="' + order_list[oi].value + '">' + order_list[oi].label + '</a></li>';

            }
            $(slid).html(optioncontent)

            $(slid).multiselect({
                enableFiltering: true,
                enableCaseInsensitiveFiltering: true,
                buttonContainer: '<div class="btn-group-sm" />',
                nonSelectedText: 'Filter List',
                numberDisplayed: 1
            });

            $(slid).unbind('change');
            $(slid).change(function (e) {
                //$('.order_list' + html_id).parent().removeClass('active');
                //$(this).parent().addClass('active');
                dtable.destroy();
                selected_order_list = $(this).val();
                getgriddata(table, html_id, editpath, $(this).val());
            })
//            $('.order_list' + html_id).unbind('click');
//            $('.order_list' + html_id).click(function (e) {
//                $('.order_list' + html_id).parent().removeClass('active');
//                $(this).parent().addClass('active');
//                dtable.destroy();
//                selected_order_list = $(this).data('value');
//                getgriddata(table, html_id, editpath, $(this).data('value'));
//            })

        }
    }
    else {
        if (html_id == 'tasklist') {
            $('#open_task').find('.div_order_list').hide();
        } else if (html_id == 'eventlist') {
            $('#open_event').find('.div_order_list').hide();
        } else if (html_id == 'calllist') {
            $('#open_call').find('.div_order_list').hide();
        } else {
            $('.div_order_list').hide();
        }
    }

//    $('.select_list_order').change(function (e) {
//        var column = '';
//        var columnval = '';
//        var selectedColumns = $('.' + classname).val();
//
//        $('.select_list_order').find('.multiselect-container li').each(function (e) {
//            columnval = $(this).find('input[type=checkbox]').val();
//            if (isNumeric(columnval)) {
//                column = dtable.column(columnval);
//                // Toggle the visibility            
//                if ($.inArray(columnval, selectedColumns) > -1) {
//                    column.visible(true);
//                } else {
//                    column.visible(false);
//                }
//            }
//        });
//    });

    $('#showallcol').click(function (e) {
        // Get the column API object
        $('.colselectchkbox').each(function () {
            if (Colstitle[$(this).data('cnt')].visible != false) {
                $(this).prop('checked', true)
                dtable.column($(this).data('cnt')).visible(true);
            } else {
                $(this).removeAttr('checked')
                dtable.column($(this).data('cnt')).visible(false);
            }
            $('input.input-sm').val('').trigger('keyup');

        })

        //        dtable.columns(colids).visible(true);
        // Toggle the visibility

    });

    $('.refresh').click(function (e) {
        dtable.draw();
        setTimeout(function () {
            $('.Delete').unbind('click');
            $('.Delete').click(function (e) {
                if (!confirm('Are you sure you want to delete?'))
                    e.preventDefault()
            })
            $('#' + html_id + ' td > a:parent').each(function (e) {
                $(this).parent().addClass('actioncol');
            })

            $('#' + html_id + ' tbody tr').mouseenter(function () {
                $(this).css('background-color', '#e6e6e6');
                $(this).css('color', 'black');
                $(this).css('cursor', 'pointer');
            });
            $('#' + html_id + ' tbody tr').mouseleave(function () {
                $(this).css('background-color', '');
                $(this).css('color', '');
            });
        }, 1000);
    });

    //footer search code
    //    $('#list thead').after('<tfoot></tfoot>')
    //    $('#list tfoot').append($('#list thead tr').clone());
    //    
    //    var title = $('#list thead th').eq( $(this).index() ).text();
    //   $('#list tfoot th').each( function () {
    //       
    //          $(this).html( '<input type="text" class="col-md-12 colsearch" placeholder="Search..."/>' );
    //          dtable.columns().eq( 0 ).each( function ( colIdx ) {
    //            $('input.colsearch', dtable.column(colIdx).footer()).on('keyup change', function () {
    //                dtable
    //                        .column(colIdx)
    //                        .search(this.value)
    //                        .draw();
    //            });
    //
    //        });
    //     })

    //    var i=0;
    //    $.when( $('#list thead th').each( function () {
    //        var title = $('#list thead th').eq( $(this).index() ).text();
    //        
    ////        if(i==0){
    ////            $('#list thead tr:first').after($('#list thead tr').clone());            
    ////        }
    //        
    //        if(i < $('#list tr:first th').length-1){
    //            $(this).append( '<br><input type="text" class="col-md-12" placeholder="Search..."/>' );
    //            var col = $(this).parent().children().index($(this));
    //            //$('#list thead tr:last th:nth-child('+col+')').html('<input type="text" class="col-md-12" placeholder="Search..."/>' );            
    //        }
    //        i++;
    //        dtable.columns().eq( 0 ).each( function ( colIdx ) {
    //        $( 'input', dtable.column( colIdx ).header() ).on( 'keyup change', function () {
    //            dtable
    //                .column( colIdx )
    //                .search( this.value )
    //                .draw();
    //        } );
    //       
    //    } );
    //    } )).done(function(){
    //        dtable.draw();
    //    });

}

//function setgrid_old1(table, editpath, Colsmodel, Colshead, Colstitle, options, datatypes, tblheads) {
//
////    var dtable = $('#list').DataTable({
////        ajax: {
////            "url": rootPath + "content/list_ajax",
////            "type": "POST",
////            data: {tbl: table.trim()}
////        },
////        "processing": true,
////        "serverSide": true,
////        "columns": Colstitle
//////        "columnDefs": Colsmodel
////                //  columns: [{"title":"iContactGroupId"},{"title": "Group Name"},{"title": "Added By"},{"title": "Last Modified By"},{"title": "Added Date"},{"title": "Modified Date"},{"title": "Status"},{"title": "Action"}]
////    });
//
//    var oTable = $('#list').dataTable({
//        "bProcessing": true,
//        "bServerSide": true,
//        "sAjaxSource": rootPath + "content/list_ajax?tbl="+table.trim(),
//        "bJQueryUI": true,
//        "sPaginationType": "full_numbers",
//        "iDisplayStart ": 20,
//        "aoColumns":Colstitle,
////        "oLanguage": {
////            "sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
////        },
//        "fnInitComplete": function () {
//            //oTable.fnAdjustColumnSizing();
//        },
//        'fnServerData': function (sSource, aoData, fnCallback)
//        {
//            $.ajax
//                    ({
//                        'dataType': 'json',
//                        'type': 'POST',
//                        'url': sSource,
//                        'data': aoData,
//                        'success': fnCallback
//                    });
//        }
//    });
//    
//     if (Colshead.length > 0) {
//        var licontent = '';
//        var cnt = 0;
//        var bool = true;
//        var colids = [];
//        for (var i = 0; i < (Colstitle.length - 1); i++) {
//            if (Colstitle[i].bVisible != false) {
//                if (cnt > 0) {
//                    licontent += '<li rel="' + i + '" class=""><div class="checkbox"><label class="checkbox-custom"><i class="fa fa-fw fa-square-o"></i><input type="checkbox" class="colselectchkbox showcolumngrid" data-cnt="' + i + '" value="' + Colstitle[i].sTitle + '" checked="true"><span>' + Colstitle[i].sTitle + '</span></label></div></li>';
//                    colids.push(i)
//                }
//                cnt++;
//            }
//        }
//        $('.columnul').html(licontent)
//    }
//
//    $('.showcolumngrid').click(function (e) {
//        // Get the column API object
//        var column = oTable.sColumns($(this).attr('data-cnt'));
//        // Toggle the visibility
//        column.bVisible(!column.bVisible());
//    });
//    $('#showallcol').click(function (e) {
//        // Get the column API object
//        $('.colselectchkbox').prop('checked', true)
//        oTable.sColumns(colids).bVisible(true);
//        // Toggle the visibility
//
//    });
//
//}


var documentHtml = function (html)
{
    var result = String(html)
            .replace(/<\!DOCTYPE[^>]*>/i, '')
            .replace(/<(html|head|body|title|meta)([\s\>])/gi, '<div class="document-$1"$2')
            .replace(/<\/(html|head|body|title|meta)\>/gi, '</div>');

    return $.trim(result);
}

function urlParse(obj) {
    sessiontimeout();
    var type = 'list';

    if ($(obj).hasClass('btn') || $(obj).hasClass('addbtn')) {
        type = 'form';

    }
    if (!$(obj).hasClass('confirmed') && $(obj).hasClass('dellink')) {

        $('#confirmbtn').click(function () {
            $('#confirmbtn').html('<i class="fa fa-ban"></i> Please Wait...');
            $('#confirmbtn').attr('disabled', true);
            $(obj).addClass('confirmed');
            urlParse(obj);
        });
        $('#alertboxlink').trigger('click')

        return false;

    } else if ($(obj).hasClass('confirmed') && $(obj).hasClass('dellink')) {
        type = 'del';
        $('#confirmbtn').html('Confirm');
        $('#confirmbtn').attr('disabled', false);
    }

    if ($(obj).hasClass('refreshbtntop')) {
        type = $(obj).data('type');
    }

    if (type == 'list' || type == 'form') {
        $('#RightsideMain').hide();
        $('.loaderdiv').fadeIn();
    }

    if (!$(obj).hasClass('signout')) {

        if (!$(obj).hasClass('myaccount') && parent_url) {
            $.ajax({
                type: 'POST',
                url: rootPath + 'content/forbidden',
                data: {type: type, selfurl: $(obj).data('href'), call: 'ajax'},
                success: function (data) {
                    //            console.log(data)
                    if (data == 1) {
                        if ($(obj).data('href') != 'javascript:void(0)') {
                            $.ajax({
                                type: 'POST',
                                url: $(obj).data('href'),
                                data: {type: 'ajax'},
                                success: function (data) {

                                    var pushurl = $(obj).data('href');
                                    //                                    var currentPageVar = $("#list").getGridParam('page');
                                    if (type == 'del') {
                                        if ($(obj).hasClass('advancecampaigndel')) {
                                            pushurl = pushurl.split('?');
                                            var campaignid = $(obj).data('href');
                                            campaignid = campaignid.split('&');
                                            var newurl = pushurl[0] + '?' + campaignid[1];
                                            window.history.pushState("", "Title", newurl);
                                            $('#cancelbtn').trigger('click')
                                            //                                            alert($('input.ui-pg-input').val())
                                            $("#list").setGridParam({datatype: 'json'}).trigger('reloadGrid');
                                        } else {
                                            pushurl = pushurl.split('?');
                                            window.history.pushState("", "Title", pushurl[0]);
                                            $('#cancelbtn').trigger('click')
                                            //                                            alert($('input.ui-pg-input').val())
                                            $("#list").setGridParam({datatype: 'json'}).trigger('reloadGrid');
                                        }
                                    } else {
                                        display_page(data);
                                        window.history.pushState("", "Title", $(obj).data('href'));
                                    }
                                    $('#refreshlink').data('href', $(obj).data('href'));
                                    $('#refreshlink').data('type', type);
                                    default_sidebar();
                                }
                            });
                        }
                    } else {
                        display_page(data);
                        window.history.pushState("", "Title", $(obj).data('href'));
                        setTimeout(function () {
                            default_sidebar();
                        }, 1000)
                    }
                }

            });
            //} else if ($(obj).hasClass('myaccount')) {
        } else {
            if ($(obj).data('href') != 'javascript:void(0)') {
                $.ajax({
                    type: 'POST',
                    url: $(obj).data('href'),
                    data: {type: 'ajax'},
                    success: function (data) {

                        var pushurl = $(obj).data('href');
                        if (type == 'del') {
                            if ($(obj).hasClass('advancecampaigndel')) {
                                pushurl = pushurl.split('?');
                                var campaignid = $(obj).data('href');
                                campaignid = campaignid.split('&');
                                var newurl = pushurl[0] + '?' + campaignid[1];
                                window.history.pushState("", "Title", newurl);
                                $('#cancelbtn').trigger('click')
                                $("#list").setGridParam({datatype: 'json', page: $('input.ui-pg-input').val()}).trigger('reloadGrid');
                            } else {
                                pushurl = pushurl.split('?');
                                window.history.pushState("", "Title", pushurl[0]);
                                $('#cancelbtn').trigger('click')
                                $("#list").setGridParam({datatype: 'json', page: $('input.ui-pg-input').val()}).trigger('reloadGrid');
                            }
                        } else {
                            display_page(data);
                            window.history.pushState("", "Title", $(obj).data('href'));
                        }
                        $('#refreshlink').data('href', $(obj).data('href'));
                        $('#refreshlink').data('type', type);
                        default_sidebar();
                    }
                });
            }
        }
    } else {
        window.location.replace('signout');
    }

    if (!$(obj).hasClass('btn')) {
        $('#cssmenu a').removeClass('current');
        $('#cssmenu a').removeClass('now');

        $('#cssmenu li.active_new').find('a:first').addClass('current');
        $('#cssmenu li.active_new').find('a:first').addClass('now');
        $(obj).addClass('current');
        $(obj).addClass('now');
    }

}

function display_page(data) {
    var trimeddiv = documentHtml(data);
    var jHtmlObject = jQuery(trimeddiv);
    var editor = jQuery("<p>").append(jHtmlObject);
    var allcontent = editor.find("#RightsideMain").html();
    $('#RightsideMain').html(allcontent);
    $('.loaderdiv').fadeOut(function () {
        $('#RightsideMain').show()
    });
}


function onloadbody() {
    $('#RightsideMain').hide()
    $('.loaderdiv').fadeOut(function () {
        $('#RightsideMain').show()
    });
}

function ajaxformsubmit(formname) {
    //    console.log($(':button[type="submit"]').attr('class'))
    //    alert(1)
    $(':button[type="submit"]').html('<i class="fa fa-ban"></i> Please Wait...');
    $(':button[type="submit"]').attr('disabled', true);
    var form = $(formname);
    var options = {
        target: '#RightsideMain', // target element(s) to be updated with server response 
        beforeSubmit: showRequest, // pre-submit callback 
        success: showResponse  // post-submit callback 
                // other available options: 
                //url:       url         // override for form's 'action' attribute 
                //type:      type        // 'get' or 'post', override for form's 'method' attribute 
                //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
                //clearForm: true        // clear all form fields after successful submit 
                //resetForm: true        // reset the form after successful submit 

                // $.ajax options can be used here too, for example: 
                //timeout:   3000 
    };
    //    alert($(form).attr('id'))
    $(form).ajaxSubmit(options);

}


function showRequest(formData, jqForm, options) {
    var queryString = $.param(formData);
    return true;
}

function showResponse(responseText, statusText, xhr, $form) {
    if ($form.attr('id') == 'admin-form') {
        if ($('#vProfileImage').val() != '')
            getprofimg();

        getUserName();
    }

    $(':button[type="submit"]').html('<i class="fa fa-check-circle"></i> Save');
    $(':button[type="submit"]').attr('disabled', false);
    $('#RightsideMain').hide();
    $('.loaderdiv').show().fadeIn();
    $.ajax({
        type: 'POST',
        url: responseText,
        success: function (data) {
            //                console.log(data)
            var trimeddiv = documentHtml(data);
            var jHtmlObject = jQuery(trimeddiv);
            var editor = jQuery("<p>").append(jHtmlObject);
            var allcontent = editor.find("#RightsideMain").html();
            $('#RightsideMain').html(allcontent);
            window.history.pushState("", "Title", responseText);
            $('.loaderdiv').fadeOut(function () {
                $('#RightsideMain').show()
            });
        }
    });
}

function showviewpage(obj, href) {
    if (typeof (href) == 'undefined') {
        href = $(obj).data('href');
    }
    $('#spamcheckdiv').html('')
    $('#viewboxiframe').show()
    $('#viewboxiframe').attr('src', href);
    var namedata = href.split('N=');
    $('#viewboxtitle').text(namedata[1])
    var iframeobj = $('#viewboxiframe');
    $('#viewboxlink').trigger('click');
}


function sessiontimeout() {
    $.ajax({
        type: 'POST',
        url: 'chksession1',
        success: function (data) {
            if (data == 'timeout') {
                $.ajax({
                    type: 'POST',
                    url: rootPath + 'signout',
                    success: function (data) {
                        window.location.replace(window.location.href);
                    }});
            } else if (data == 'true') {
                //                        alert(1)
            } else {
                //                window.location.href = 'signout';
                window.location.replace('signout');
                //                    alert('timeover')
            }
        }
    });
}


function getUserName() {

    $.ajax({
        type: 'POST',
        url: rootPath + 'content/getProfileName',
        success: function (data) {
            if (data != '') {
                $('.profile_name').text(data)
            }
        }
    });

}

function input_show_close(data) {
    $(data).parent().find('a').toggleClass('input_edit_show');
    //    console.log($(data).parent().parent().parent().append('<input value=""/>'));
}

function  confirmdelete(obj) {
    if (!confirm("Are you sure you want to delete?"))
        return false;
}

function showformpage(obj, href) {
    if (typeof (href) == 'undefined') {
        href = $(obj).data('href');
    }
    if ($(obj).data('module') == 'product') {
        if ($("#iVendorId").val() == '') {
            $('#ProductsForm').valid();
            return false;
        }
    }
    $('#viewformiframe').html($('.loaderdiv').html());
    $('#viewformiframe .loading .loading_txt').hide();
    $('#viewformiframe .loading').show();
    $.ajax({
        async: true,
        url: href,
        success: function (results) {
            $('#viewformiframe').html(results)
        }
    });
    var namedata = href.split('N=');
    $('#viewformtitle').text(namedata[1]);
    $('#viewformlink').trigger('click');
}


function showinputview(obj, fieldname) {
    var objparent = $(obj).parent()
    var cls = $(valuefield).data('id')
    var valuefield = $(objparent).parent().find('span.valuefield');
    if ($(obj).hasClass('edit-icon')) {
        $('.closebtn-icon').addClass('hidden');
        $('.edit-icon').removeClass('hidden')
        $('.inputbox').each(function () {
            $(this).parent().html($(this).data('obj'));
            //            console.log($(this).parent().parent().attr('class'));
            $(this).remove();
        });
        $(objparent).find('a.closebtn-icon').removeClass('hidden')
        $(obj).addClass('hidden');
        var objid = $(valuefield).data('id');
        var validstatus = $(valuefield).data('valid') == true ? 'cl' + objid : '';

        if ($(valuefield).hasClass('spaninput')) {
            $(valuefield).html('<input id="inputdata" name="inputdata" class="inputbox currinput ' + validstatus + '" value="' + $(valuefield).text() + '" data-class="' + $(valuefield).data('class') + '" data-obj="' + $(valuefield).html() + '">')
        } else if ($(valuefield).hasClass('spanselect')) {
            var selectedText = $(valuefield).text();
            var selecthtml = $(valuefield).data('html');
            var objselect = $(selecthtml);
            $(objselect).find('option').each(function (e) {
                if ($(this).text() == selectedText)
                {
                    $(objselect).val($(this).val());
                }
            });
            objselect.attr('id', 'inputdata').attr('name', 'inputdata').addClass('inputbox').data('class', $(valuefield).data('class')).data('obj', $(valuefield).html());
            $(valuefield).html(objselect)
        } else if ($(valuefield).hasClass('spantextarea')) {
            var selecthtml = $(valuefield).data('html');
            var objselect = $(selecthtml);
            objselect.attr('id', 'inputdata').attr('name', 'inputdata').addClass('inputbox').data('class', $(valuefield).data('class')).data('obj', $(valuefield).html());
            objselect.val($(valuefield).text().trim())
            $(valuefield).html(objselect)
        }
        $('#inputdata').focus()

    } else if ($(obj).hasClass('closebtn-icon')) {

        if ($(obj).hasClass('truebtn')) {
            if (!$(obj).parents('.form-group:first').hasClass('require_field') && !$('#inputdata').hasClass('error')) {
                $.ajax({
                    type: 'POST',
                    url: rootPath + 'content/updateviewdata',
                    data: {value: $('#inputdata').val(), field: fieldname, tbl: $('#viewtbl').data('table'), idval: $('#viewtbl').data('idval'), idfield: $('#viewtbl').data('idfield')},
                    success: function (data) {
                        $(objparent).find('a.edit-icon').removeClass('hidden')
                        $(objparent).find('a.closebtn-icon').addClass('hidden')
                        $(obj).parents('.form-group:first').removeClass('require_field')
                        $('span.require_field').remove()
                        if ($(valuefield).hasClass('spaninput')) {
                            $(valuefield).html($('#inputdata').val())
                        } else if ($(valuefield).hasClass('spanselect')) {
                            if ($('#inputdata option:selected').text().charAt(0) != '-')
                                $(valuefield).html($('#inputdata option:selected').text())
                            else
                                $(valuefield).html('---')
                        } else if ($(valuefield).hasClass('spantextarea')) {
                            $(valuefield).html($('#inputdata').val())
                        }
                    }
                });
            }
        } else if ($(obj).hasClass('falsebtn')) {
            $('#inputdata').css('color', 'gray!important')
            $('span.require_field').remove()
            $(objparent).find('a.edit-icon').removeClass('hidden')
            $(objparent).find('a.closebtn-icon').addClass('hidden')
            $(obj).parents('.form-group:first').removeClass('require_field')
            //            if ($(valuefield).hasClass('spaninput')){
            //                $(valuefield).html($('#inputdata').data('obj'))
            ////                $('.' + cls).html($('#inputdata').data('obj'))
            //            }else if ($(valuefield).hasClass('spanselect'))
            //                $(valuefield).html($('#inputdata').data('obj'))
            //            else if ($(valuefield).hasClass('span'))
            $(valuefield).html($('#inputdata').data('obj'))
        }
        //        if ($(valuefield).hasClass('spaninput') && succ)
        //            $(valuefield).html($('#inputdata').val())
        //        else if ($(valuefield).hasClass('spanselect') && succ)
        //            $(valuefield).html($('#inputdata option:selected').text())
    }
    $('#inputdata').keypress(function (e) {
        if (e.which == 13) {
            $(this).focus();
            return false;
        }
    })
}

function addMcomment(obj) {
    var counter = $('#addcommenttext').data('count')
    var textval = $('#addcommenttext').val()
    if (textval != null && textval != '' && textval !== undefined) {
        addNote(textval)
        $('#addcommenttext').val('')
    } else {
        alert('Please add your comment')
    }
}
function addScomment(obj) {
    var textid = $(obj).parents('div.post-comment-block_bottom').find('textarea.CommentClick');
    var textval = $(textid).val()
    var textthread = $(textid).attr('data-thread')
    if (textval != null && textval != '' && textval !== undefined) {
        addNote(textval, textthread, $(obj).parents('div.Comment_Right_block:first').find('ul.feed_comment_show'))
        $(textid).val('');
    } else {
        alert('Please add your comment')
    }
}


function addNote(textval, threadid, obj) {
    var noteid = '';
    $.ajax({
        url: rootPath + 'notes/note_add',
        data: {type: $('#viewtbl').data('type'), idval: $('#viewtbl').data('idval'), idfield: $('#viewtbl').data('idfield'), tDescription: textval, iThreadId: threadid},
        type: 'POST',
        success: function (data) {
            if (data != '') {
                noteid = data;
                if (threadid != '' && threadid != null && threadid !== undefined) {
                    $('#hiddentrigger').data('feedobj', obj);
                    $('#hiddentrigger').data('threadid', threadid);
                }
                $('#hiddentrigger').val(noteid);
                $('#hiddentrigger').trigger('click');
            }
        }
    }).done(function () {
        $.ajax({
            url: rootPath + 'notes/notes_list',
            data: {type: $('#viewtbl').data('type'), idval: $('#viewtbl').data('idval'), idfield: $('#viewtbl').data('idfield'), iNoteId: noteid, iThreadId: threadid},
            type: 'POST',
            success: function (data) {
                if (data != '') {
//                    console.log(data)
                    var uploadid = 'uploadfile' + noteid;
                    if (threadid != '' && threadid != null && threadid !== undefined) {
                        $(obj).append(data)
//***************************************attachment file code*************************//
//                        var uploadObj = $(obj).find('div.subuploaddiv').uploadFile({
//                        url: rootPath + "public/uploadfiles/upload.php", //url donde se enviará la petición
//                        multiple: true, //defino que no se puedan arrastrar y soltar mas de 1 archivo
//                        allowedTypes: "png,jpg,jpeg", // extensiones permitidas
//                        fileName: "myfile", //nombre del archivo a enviar por $_Files
//                        showDelete: true, //mostrar botón eliminar
//                        showDone: false, //ocultar botón de Hecho
//                        showProgress: true, //mostrar barra de progreso
//                        showPreview: true, //mostrar previsualización de las imagenes a cargar
//                        autoSubmit: true, //deshabilitar el envio del archivo automaticamente, para poder ser enviado se utiliza la función startUpload()
//                        showDownload: true,
//                        returnType: "json",
//                        showPreivew: true,
//                        maxFileCount: 5, //número máximo de archivos a subir
//                        maxFileSize: 3145728, //tamaño máximo permitido de los archivos en bytes, en MB: 3MB
//                        maxFileCountErrorStr: "Maximum file limit", //string que aparece al momento de tener un error del número máximo de archivos
//                        dragDropStr: "<span><b> Drag & Drop</b></span>",
//                        sizeErrorStr: "Too big size of file not accepted", //string que aparece cuando los archivos superan el tamaño máximo permitido
//                        extErrorStr: "External error occured", //string que aparece cuando existe un error en las extensiones de los archivos a cargar
//                        cancelStr: "Cancel", //string del botón cancelar
//                        uploadButtonClass: "attach_text", //clase del botón de carga, se definió una clase de bootstrap
//                        dragdropWidth: "100%", //defino el ancho del area donde se arrastra y sueltan los archivos
//                        statusBarWidth: "100%", //defino el acho de la barra de estado.
//                        previewWidth: "20%",
//                        dynamicFormData: function ()
//                        {
//                            var data = {
//                                userid: userid, //id de la imagen
//                            };
//                            return data; //debo retornar data para poder que se envien junto con las imagenes.
//                        },
//                        deleteCallback: function (data, pd) {
//                            for (var i = 0; i < data.length; i++) {
//                                $.post(rootPath + "public/uploadfiles/delete.php", {op: "delete", name: data[i]},
//                                function (resp, textStatus, jqXHR) {
//                                });
//                            }
//                            pd.statusbar.hide(); //You choice.
//                        },
//                        downloadCallback: function (files, pd)
//                        {
//                            location.href = rootPath + "public/uploadfiles/download.php?filename=" + files[0];
//                        },
//                        onSuccess: function (files, data, xhr, pd) //función que se llama despues de haber subido los archivos.
//                        {
//                            $("#Message").html(data); // Mostrar la respuestas del script PHP.
//                        },
//                        onSubmit: function (data)
//                        {
//                            $.ajax({
//                                url: rootPath + 'notes/notes_attachment',
//                                    data: {vFileName: data.toString(), eItemType: $('#viewtbl').data('type'), iItemId: $('#viewtbl').data('idval'), iNoteId: noteid, iUserId: userid},
//                                type: 'POST',
//                                success: function (data) {
//                                    if (data != '') {
//                                        
//                                    }
//                                }
//                            })
//                        }
//                    });
//***************************************end attachment file code*************************//
                    } else {
                        if ($('#allcommnets').find('.commented-block:first').length > 0)
                            $('#allcommnets').find('.commented-block:first').before(data)
                        else
                            $('#allcommnets').html(data)
//                        console.log(data)
                        var uploadObj = $('.uploaddiv:first').uploadFile({
                            url: rootPath + "public/uploadfiles/upload.php", //url donde se enviará la petición
                            multiple: true, //defino que no se puedan arrastrar y soltar mas de 1 archivo
//                            allowedTypes: "png,jpg,jpeg", // extensiones permitidas
                            fileName: "myfile", //nombre del archivo a enviar por $_Files
                            showDelete: false, //mostrar botón eliminar
                            showDone: false, //ocultar botón de Hecho
                            showProgress: true, //mostrar barra de progreso
                            showPreview: true, //mostrar previsualización de las imagenes a cargar
                            autoSubmit: true, //deshabilitar el envio del archivo automaticamente, para poder ser enviado se utiliza la función startUpload()
                            showDownload: false,
                            returnType: "json",
                            showPreivew: true,
                            maxFileCount: 5, //número máximo de archivos a subir
                            maxFileSize: 3145728, //tamaño máximo permitido de los archivos en bytes, en MB: 3MB
                            maxFileCountErrorStr: "Maximum file limit", //string que aparece al momento de tener un error del número máximo de archivos
                            dragDropStr: "<span><b> Drag & Drop</b></span>",
                            sizeErrorStr: "Too big size of file not accepted", //string que aparece cuando los archivos superan el tamaño máximo permitido
                            extErrorStr: "External error occured", //string que aparece cuando existe un error en las extensiones de los archivos a cargar
                            cancelStr: "Cancel", //string del botón cancelar
                            uploadButtonClass: "attach_text", //clase del botón de carga, se definió una clase de bootstrap
                            dragdropWidth: "100%", //defino el ancho del area donde se arrastra y sueltan los archivos
                            statusBarWidth: "100%", //defino el acho de la barra de estado.
                            previewWidth: "20%",
                            dynamicFormData: function ()
                            {
                                var data = {
                                    userid: userid, //id de la imagen
                                    companyid: companyid, //id de la imagen
                                };
                                return data; //debo retornar data para poder que se envien junto con las imagenes.
                            },
                            deleteCallback: function (data, pd) {
                                for (var i = 0; i < data.length; i++) {
                                    $.post(rootPath + "public/uploadfiles/delete.php", {op: "delete", name: data[i]},
                                    function (resp, textStatus, jqXHR) {
                                    });
                                }
                                pd.statusbar.hide(); //You choice.
                            },
                            downloadCallback: function (files, pd)
                            {
                                location.href = rootPath + "public/uploadfiles/download.php?filename=" + files[0] + '&companyid=' + companyid + '&userid=' + userid;
                            },
                            onSuccess: function (files, data, xhr, pd) //función que se llama despues de haber subido los archivos.
                            {
                                $("#Message").html(data); // Mostrar la respuestas del script PHP.
                            },
                            onSubmit: function (data)
                            {
                                $.ajax({
                                    url: rootPath + 'notes/notes_attachment',
                                    data: {vFileName: data.toString(), eItemType: $('#viewtbl').data('type'), iItemId: $('#viewtbl').data('idval'), iNoteId: noteid, iUserId: userid},
                                    type: 'POST',
                                    success: function (data) {
                                        if (data != '') {
//                                            alert(2)
                                        }
                                    }
                                })
                            },
                            onSelect: function (files) {
                                setTimeout(function () {
                                    var j = files.length - 1;
                                    for (var i in files) {
                                        if (typeof (files[i].name) != 'undefined') {
                                            var fileExtension = files[i].name.replace(/^.*\./, '');
                                            var filetype = getFileType(fileExtension).toLowerCase();
                                            if (filetype != 'image' && j > -1) {
                                                p = (j == 0) ? 'first' : ((j == (files.length)) ? 'last' : 'nth-child(' + j + ')');
                                                //$('.ajax-file-upload-statusbar:' + p).prepend('<i class="fa fa-file-' + filetype + '-o"></i>');
                                                $('.ajax-file-upload-statusbar').eq(j).prepend('<i class="fa fa-5x fa-file-' + filetype + '-o"></i>');
                                            }
                                            j--;
                                        }
                                    }
                                }, 200);
                            }
                        });
                    }
                    $('.CommentClick').focus(function () {
                        $('.text_container').addClass('hidden');
                        $(this).parent().next('.text_container').removeClass('hidden');
                    });
                    $('.Close').click(function () {
                        $(this).parent().addClass('hidden');
                    });

//                    $('.ajax-file-upload-statusbar').remove()
//                    $('.ajax-file-upload-green').remove()
//                    $('.ajax-file-upload-red').remove()
                }
            }
        });
    });
}

function deletenote(obj, noteid, docid) {
//    alert(noteid)
    if (!confirm('Are you sure you want to delete?'))
        return false;

    var path = 'notes/note_delete';
    if ($(obj).hasClass('attach_image') && docid != null && docid != '' && docid !== undefined)
        path = 'notes/attach_delete';
    else
        docid = '';

    $.ajax({
        url: rootPath + path,
        data: {noteid: noteid, iDocumentId: docid},
        type: 'POST',
        success: function (data) {
            if (data != '') {
                if ($(obj).hasClass('attach_image') && !$(obj).hasClass('deleteattach')) {
                    $(obj).parent().remove()
                } else if ($(obj).hasClass('deleteattach')) {
                    $('#refreshbtn').trigger('click')
                } else
                    $('#subfeed' + noteid).remove()
            }
        }
    });
}

function deletehotelimage(obj, imageid) {
//    alert(noteid)
    if (!confirm('Are you sure you want to delete?'))
        return false;

    path = 'hotels/image_delete';
    $.ajax({
        url: rootPath + path,
        data: {imageid: imageid},
        type: 'POST',
        success: function (data) {
            if (data != '') {
                if ($(obj).hasClass('attach_image') && !$(obj).hasClass('deleteattach')) {
                    $(obj).parent().remove()
                } else if ($(obj).hasClass('deleteattach')) {
                    $('#refreshbtn').trigger('click')
                } else
                    $('#subfeed' + noteid).remove()
            }
        }
    });
}

function deletefeed(obj, feedid, docid) {
//    alert(noteid)
    if (!confirm('Are you sure you want to delete?'))
        return false;

    var path = 'feeds/feed_delete';
    if ($(obj).hasClass('attach_image') && docid != null && docid != '' && docid !== undefined)
        path = 'feeds/attach_delete';
    else
        docid = '';

    $.ajax({
        url: rootPath + path,
        data: {feedid: feedid, iDocumentId: docid},
        type: 'POST',
        success: function (data) {
            if (data != '') {
                if ($(obj).hasClass('attach_image') && !$(obj).hasClass('deleteattach')) {
                    $(obj).parent().remove()
                } else if ($(obj).hasClass('deleteattach')) {
                    $('#refreshbtn').trigger('click')
                } else
                    $('#subfeed' + feedid).remove()
            }
        }
    });
}


function addMfeed(obj) {
    var counter = $('#addcommenttext').data('count')
    var textval = $('#addcommenttext').val()
    if (textval != null && textval != '' && textval !== undefined) {
        addFeed(textval)
        $('#addcommenttext').val('')
    } else {
        alert('Please add your comment')
    }
}
function addSfeed(obj) {
    var textid = $(obj).parents('div.post-comment-block_bottom').find('textarea.CommentClick');
    var textval = $(textid).val()
    var textthread = $(textid).attr('data-thread')
    if (textval != null && textval != '' && textval !== undefined) {
        addFeed(textval, textthread, $(obj).parents('div.Comment_Right_block:first').find('ul.feed_comment_show'))
        $(textid).val('');
    } else {
        alert('Please add your comment')
    }
}


function addFeed(textval, threadid, obj) {
    var activityid = '';
    $.ajax({
        url: rootPath + 'feeds/feed_add',
        data: {tMessage: textval, iThreadId: threadid},
        type: 'POST',
        success: function (data) {
            if (data != '') {
                activityid = data;
            }
        }
    }).done(function () {
        $.ajax({
            url: rootPath + 'feeds/feeds_list',
            data: {iActivityId: activityid, iThreadId: threadid, from: 'ajax'},
            type: 'POST',
            success: function (data) {
                if (data != '') {
                    console.log(data)
                    if (threadid)
                        $(obj).append(data)
                    else
                        $('#allfeeds').prepend(data)
                    $('.CommentClick').focus(function () {
                        $('.text_container').addClass('hidden');
                        $(this).parent().next('.text_container').removeClass('hidden');
                    });
                    $('.Close').click(function () {
                        $(this).parent().addClass('hidden');
                    });
                    $('#hiddentrigger').val(activityid);
                    $('#hiddentrigger').trigger('click');
//                    var uploadid = 'uploadfile' + activityid;
//                    if (threadid != '' && threadid != null && threadid !== undefined) {
//                        $(obj).append(data)
//***************************************attachment file code*************************//
//                        var uploadObj = $(obj).find('div.subuploaddiv').uploadFile({
//                        url: rootPath + "public/uploadfiles/upload.php", //url donde se enviará la petición
//                        multiple: true, //defino que no se puedan arrastrar y soltar mas de 1 archivo
//                        allowedTypes: "png,jpg,jpeg", // extensiones permitidas
//                        fileName: "myfile", //nombre del archivo a enviar por $_Files
//                        showDelete: true, //mostrar botón eliminar
//                        showDone: false, //ocultar botón de Hecho
//                        showProgress: true, //mostrar barra de progreso
//                        showPreview: true, //mostrar previsualización de las imagenes a cargar
//                        autoSubmit: true, //deshabilitar el envio del archivo automaticamente, para poder ser enviado se utiliza la función startUpload()
//                        showDownload: true,
//                        returnType: "json",
//                        showPreivew: true,
//                        maxFileCount: 5, //número máximo de archivos a subir
//                        maxFileSize: 3145728, //tamaño máximo permitido de los archivos en bytes, en MB: 3MB
//                        maxFileCountErrorStr: "Maximum file limit", //string que aparece al momento de tener un error del número máximo de archivos
//                        dragDropStr: "<span><b> Drag & Drop</b></span>",
//                        sizeErrorStr: "Too big size of file not accepted", //string que aparece cuando los archivos superan el tamaño máximo permitido
//                        extErrorStr: "External error occured", //string que aparece cuando existe un error en las extensiones de los archivos a cargar
//                        cancelStr: "Cancel", //string del botón cancelar
//                        uploadButtonClass: "attach_text", //clase del botón de carga, se definió una clase de bootstrap
//                        dragdropWidth: "100%", //defino el ancho del area donde se arrastra y sueltan los archivos
//                        statusBarWidth: "100%", //defino el acho de la barra de estado.
//                        previewWidth: "20%",
//                        dynamicFormData: function ()
//                        {
//                            var data = {
//                                userid: userid, //id de la imagen
//                            };
//                            return data; //debo retornar data para poder que se envien junto con las imagenes.
//                        },
//                        deleteCallback: function (data, pd) {
//                            for (var i = 0; i < data.length; i++) {
//                                $.post(rootPath + "public/uploadfiles/delete.php", {op: "delete", name: data[i]},
//                                function (resp, textStatus, jqXHR) {
//                                });
//                            }
//                            pd.statusbar.hide(); //You choice.
//                        },
//                        downloadCallback: function (files, pd)
//                        {
//                            location.href = rootPath + "public/uploadfiles/download.php?filename=" + files[0];
//                        },
//                        onSuccess: function (files, data, xhr, pd) //función que se llama despues de haber subido los archivos.
//                        {
//                            $("#Message").html(data); // Mostrar la respuestas del script PHP.
//                        },
//                        onSubmit: function (data)
//                        {
//                            $.ajax({
//                                url: rootPath + 'notes/notes_attachment',
//                                    data: {vFileName: data.toString(), eItemType: $('#viewtbl').data('type'), iItemId: $('#viewtbl').data('idval'), iNoteId: noteid, iUserId: userid},
//                                type: 'POST',
//                                success: function (data) {
//                                    if (data != '') {
//                                        
//                                    }
//                                }
//                            })
//                        }
//                    });
////***************************************end attachment file code*************************//
//                    } else {
//                        if ($('#allcommnets').find('.commented-block:first').length > 0)
//                            $('#allcommnets').find('.commented-block:first').before(data)
//                        else
//                            $('#allcommnets').html(data)
////                        console.log(data)
//                        var uploadObj = $('.uploaddiv:first').uploadFile({
//                            url: rootPath + "public/uploadfiles/upload.php", //url donde se enviará la petición
//                            multiple: true, //defino que no se puedan arrastrar y soltar mas de 1 archivo
////                            allowedTypes: "png,jpg,jpeg", // extensiones permitidas
//                            fileName: "myfile", //nombre del archivo a enviar por $_Files
//                            showDelete: false, //mostrar botón eliminar
//                            showDone: false, //ocultar botón de Hecho
//                            showProgress: true, //mostrar barra de progreso
//                            showPreview: true, //mostrar previsualización de las imagenes a cargar
//                            autoSubmit: true, //deshabilitar el envio del archivo automaticamente, para poder ser enviado se utiliza la función startUpload()
//                            showDownload: false,
//                            returnType: "json",
//                            showPreivew: true,
//                            maxFileCount: 5, //número máximo de archivos a subir
//                            maxFileSize: 3145728, //tamaño máximo permitido de los archivos en bytes, en MB: 3MB
//                            maxFileCountErrorStr: "Maximum file limit", //string que aparece al momento de tener un error del número máximo de archivos
//                            dragDropStr: "<span><b> Drag & Drop</b></span>",
//                            sizeErrorStr: "Too big size of file not accepted", //string que aparece cuando los archivos superan el tamaño máximo permitido
//                            extErrorStr: "External error occured", //string que aparece cuando existe un error en las extensiones de los archivos a cargar
//                            cancelStr: "Cancel", //string del botón cancelar
//                            uploadButtonClass: "attach_text", //clase del botón de carga, se definió una clase de bootstrap
//                            dragdropWidth: "100%", //defino el ancho del area donde se arrastra y sueltan los archivos
//                            statusBarWidth: "100%", //defino el acho de la barra de estado.
//                            previewWidth: "20%",
//                            dynamicFormData: function ()
//                            {
//                                var data = {
//                                    userid: userid, //id de la imagen
//                                    companyid: companyid, //id de la imagen
//                                };
//                                return data; //debo retornar data para poder que se envien junto con las imagenes.
//                            },
//                            deleteCallback: function (data, pd) {
//                                for (var i = 0; i < data.length; i++) {
//                                    $.post(rootPath + "public/uploadfiles/delete.php", {op: "delete", name: data[i]},
//                                    function (resp, textStatus, jqXHR) {
//                                    });
//                                }
//                                pd.statusbar.hide(); //You choice.
//                            },
//                            downloadCallback: function (files, pd)
//                            {
//                                location.href = rootPath + "public/uploadfiles/download.php?filename=" + files[0] + '&companyid=' + companyid + '&userid=' + userid;
//                            },
//                            onSuccess: function (files, data, xhr, pd) //función que se llama despues de haber subido los archivos.
//                            {
//                                $("#Message").html(data); // Mostrar la respuestas del script PHP.
//                            },
//                            onSubmit: function (data)
//                            {
//                                $.ajax({
//                                    url: rootPath + 'notes/notes_attachment',
//                                    data: {vFileName: data.toString(), eItemType: $('#viewtbl').data('type'), iItemId: $('#viewtbl').data('idval'), iNoteId: noteid, iUserId: userid},
//                                    type: 'POST',
//                                    success: function (data) {
//                                        if (data != '') {
////                                            alert(2)
//                                        }
//                                    }
//                                })
//                            },
//                            onSelect: function (files) {
//                                setTimeout(function () {
//                                    var j = files.length - 1;
//                                    for (var i in files) {
//                                        if (typeof (files[i].name) != 'undefined') {
//                                            var fileExtension = files[i].name.replace(/^.*\./, '');
//                                            var filetype = getFileType(fileExtension).toLowerCase();
//                                            if (filetype != 'image' && j > -1) {
//                                                p = (j == 0) ? 'first' : ((j == (files.length)) ? 'last' : 'nth-child(' + j + ')');
//                                                //$('.ajax-file-upload-statusbar:' + p).prepend('<i class="fa fa-file-' + filetype + '-o"></i>');
//                                                $('.ajax-file-upload-statusbar').eq(j).prepend('<i class="fa fa-5x fa-file-' + filetype + '-o"></i>');
//                                            }
//                                            j--;
//                                        }
//                                    }
//                                }, 200);
//                            }
//                        });
//                    }
//                    $('.CommentClick').focus(function () {
//                        $('.text_container').addClass('hidden');
//                        $(this).parent().next('.text_container').removeClass('hidden');
//                    });
//                    $('.Close').click(function () {
//                        $(this).parent().addClass('hidden');
//                    });
//                    
//                    $('.ajax-file-upload-statusbar').remove()
//                    $('.ajax-file-upload-green').remove()
//                    $('.ajax-file-upload-red').remove()
                }
            }
        });
    });
}

function date_diff(from_date, end_date) {
    var date1 = new Date(from_date);
    var date2 = new Date(end_date);
    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
    return diffDays;
}

function time_diff(from_date, end_date) {
    var date1 = new Date(from_date);
    var date2 = new Date(end_date);
    var timeDiff = Math.abs(date2.getTime() - date1.getTime());
    timeDiff = Date.parse(date1) < Date.parse(date2);
    return timeDiff;
}

function cancelAction() {
    window.location.href = document.referrer
}

function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
}

function checkFName(data) {
    return data === "NA" || data.match(/^[a-zA-Z ]+$/);
}

function deleteActivity(data) {
    if (confirm('Are you sure you want to delete?')) {
        $.ajax({
            url: $(data).data('href'),
            success: function (data) {
                notyfy({
                    text: 'Data deleted successfully',
                    type: 'success',
                    layout: 'top',
                    timeout: 3500
                });
                $("#notyfy_container_top").show();
                $('#activitieslist').parent().parent().parent().next('.refresh').trigger('click');
            }
        });
    }
    return false;
}

function deleteUser(data) {
    var id = $(data).data('id');
    if (confirm('Are you sure you want to delete?')) {
        showformpage('', $(data).data('href'));
    }
    return false;
}

function getFileType($ext) {
    var $file_type = 'other';

    /* archive extensions */
    var $archive_types = new Array('zip', 'tar', 'tar.gz');

    /* audio extensions */
    var $audio_types = new Array('mp3', 'wav', 'midi', 'aac', 'ogg', 'wma', 'm4a', 'mid', 'orb', 'aif');

    /* excel/csv extensions */
    var $excel_types = new Array('xls', 'xlsx', 'csv');

    /* images extensions */
    var $image_types = new Array('jpeg', 'bmp', 'png', 'gif', 'jpg', 'tiff');

    /* pdf extensions */
    var $pdf_types = new Array('pdf');

    /* power point extensions */
    var $ppt_types = new Array('ppt', 'pptx', 'pps', 'ppsx');

    /* text extensions */
    var $text_types = new Array('txt');

    /* movie extensions */
    var $video_types = new Array('mov', 'flv', 'mpeg', 'mpg', 'mp4', 'avi', 'wmv', 'qt', '3gp');

    /* word extensions */
    var $doc_types = new Array('doc', 'docx');

    /* document extensions */
    //$document_types = new Array('txt', 'pdf', 'ppt', 'pps', 'xls', 'doc', 'xlsx', 'pptx', 'ppsx', 'docx', 'csv');

    if ($.inArray($ext.toLowerCase(), $archive_types) > -1) {
        $file_type = 'Archive';
    } else if ($.inArray($ext.toLowerCase(), $audio_types) > -1) {
        $file_type = 'Audio';
    } else if ($.inArray($ext.toLowerCase(), $excel_types) > -1) {
        $file_type = 'Excel';
    } else if ($.inArray($ext.toLowerCase(), $image_types) > -1) {
        $file_type = 'Image';
    } else if ($.inArray($ext.toLowerCase(), $pdf_types) > -1) {
        $file_type = 'PDF';
    } else if ($.inArray($ext.toLowerCase(), $ppt_types) > -1) {
        $file_type = 'Powerpoint';
    } else if ($.inArray($ext.toLowerCase(), $text_types) > -1) {
        $file_type = 'Text';
    } else if ($.inArray($ext.toLowerCase(), $video_types) > -1) {
        $file_type = 'Video';
    } else if ($.inArray($ext.toLowerCase(), $doc_types) > -1) {
        $file_type = 'Word';
    }
    return $file_type;
}

function retriveNotifications(url) {

    $.ajax({
        type: "POST",
        async: false,
        //url: rootPath + "cases/get_cases_list",
        url: url,
        data: {from: 'ajax'},
        success: function (result) {
            if (result != "no data") {
                $('#notification_panel').append(result);
            } else {
                var no_cases_string = '<div class="linodata">No data found </div>';
                $('#notification_panel').append(no_cases_string);
            }
            $('[data-toggle="tooltip"]').tooltip();
        }
    });
}

function quickadd(obj) {
    $('#viewformiframe').html($('.loaderdiv').html());
    $('#viewformiframe .loading .loading_txt').hide();
    $('#viewformiframe .loading').show();


    $.ajax({
        type: "POST",
        async: true,
        url: rootPath + 'mailbox/quickAddData',
        data: {type: $(obj).data('val'), detail: $('#detail').val(), emaildetail: $('#emaildetail').val()},
        success: function (data) {
            $('#viewformiframe').html(data);
        }
    });
//    var namedata = href.split('N=');
    if ($(obj).data('val') == 'lead') {
        $('#viewformtitle').text("Lead");
    } else {
        $('#viewformtitle').text("Vendor");
    }
    $('#viewformlink').trigger('click');
}
$(document).ready(function (e) {


    $('#changepass').click(function () {
        $(this).hide()
        $('.changepassdiv').show()
        $('#cancelbtn').show()
    })

    $('#cancelbtn').click(function () {
        $(this).hide()
        $('.changepassdiv').hide()
        $('#changepass').show()
    })
    $('#changeimage').click(function () {
        $(this).hide()
        $('#profile_image').show()
        $('.imgclass').hide()
        $('#cancelimgbtn').show()
        $('#Deleteimg').hide()
    })
    $('#changeimg').click(function () {
        $(this).hide()
        $('#vImage').show()
        $('#vProfileImg').hide()
        $('#cancelimgbtn').show()
        $('#Deleteimg').hide()
    })
    $('#cancelimgbtn').click(function () {
        $(this).hide()
        $('#profile_image').hide()
        $('.imgclass').show()
        $('#changeimage').show()
        $('#Deleteimg').show()
    });
});