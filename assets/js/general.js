$(function () {
    //$.getScript('//cdn.datatables.net/plug-ins/1.10.10/api/fnPagingInfo.js');
    /**
     * Scroll to element
     * @param object o
     * @returns none
     */
    $.fn.scrollTo = function (target, options, callback) {
        if (typeof options == 'function' && arguments.length == 2) {
            callback = options;
            options = target;
        }
        var settings = $.extend({
            scrollTarget: target,
            offsetTop: 50,
            duration: 2000,
            easing: 'swing'
        }, options);
        return this.each(function () {
            var scrollPane = $(this);
            var scrollTarget = (typeof settings.scrollTarget == "number") ? settings.scrollTarget : $(settings.scrollTarget);
            var scrollY = (typeof scrollTarget == "number") ? scrollTarget : scrollTarget.offset().top + scrollPane.scrollTop() - parseInt(settings.offsetTop);
            scrollPane.animate({scrollTop: scrollY}, parseInt(settings.duration), settings.easing, function () {
                if (typeof callback == 'function') {
                    callback.call(this);
                }
            });
        });
    }

})
function update_switch() {
    if ($('.make-switch').length > 0) {
        $('.make-switch').bootstrapSwitch({size: 'small', onText: jsConstants.grid.active, offText: jsConstants.grid.inactive, handleWidth: 50});
    }
}


OTable = [];
settings = [];
isLanguageEnabled = [];
keyId = [];
_lng = [];
DtTable = {
    init: function (tblSelector, uSettings, index) {
        isLanguageEnabled[index] = false;
        customSearch = false;
        _lng[index] = site_language;
        settings[index] = {
            bProcessing: true,
            bServerSide: true,
            sAjaxSource: '',
            fnServerData: function (sSource, aoData, fnCallback) {
                aoData.push({"name": global_token_nm, "value": getCookie(global_token)});
                aoData = DtTable.setGridCustomParams(uSettings, aoData);
                if (isLanguageEnabled[index]) {
                    aoData.push({name: 'language_preference', value: _lng[index]});
                }
                $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: sSource,
                    data: aoData,
                    success: fnCallback
                });
            },
            aoColumns: [],
            order: [[0, "DESC"]],
            buttons:[],
            fnServerParams: function (aoData) {
                setTitle(aoData, this)
            },
            fnDrawCallback: function (oSettings) {
                update_switch();
                $('#total_count').html("<b>Total "+oSettings._iRecordsTotal+"</b>");
            },
            fixedHeader: true,
            colReorder: {
                reorderCallback: function () {
                    update_switch();
                }
            },
            //stateSave: true,
            //pageLength: 25,
            lengthMenu: [[25, 50, 100, 200, 500], [25, 50, 100, 200, 500]],
           
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.10/i18n/' + jsConstants.grid.language + '.json?_=' + Math.random(),
                buttons: {
                    colvis: jsConstants.grid.toggleColumns
                },
                //sLengthMenu: "_MENU_ " + jsConstants.grid.ttlResults
            }
        }
        opColWidth = '10%';
        stColWidth = '10%';
        tblIndex = typeof index !== 'undefined' ? index : 0;
        keyId = typeof uSettings.keyId !== 'undefined' && uSettings.keyId !== '' ? uSettings.keyId : 'id';
        type = 'display';
        isLanguageEnabled[index] = typeof uSettings.language_dropdwon !== 'undefined' ? true : isLanguageEnabled[index];

        // Extend default datatable settigns:
        if (typeof uSettings.datatableSettings !== 'undefined') {
            $.extend(settings[index], uSettings.datatableSettings);
        }

        settings[index].sAjaxSource = typeof uSettings.url !== 'undefined' ? uSettings.url : settings[index].sAjaxSource;
        settings[index].aoColumns = typeof uSettings.aoColumns !== 'undefined' ? uSettings.aoColumns : settings[index].aoColumns;
        settings[index].order = typeof uSettings.order !== 'undefined' ? uSettings.order : settings[index].order;

        if (typeof uSettings.statusColumn !== 'undefined') {
            var stKey = typeof uSettings.statusColumn.key !== 'undefined' ? uSettings.statusColumn.key : 'status';
            stColWidth = typeof uSettings.statusColumn.colWidth !== 'undefined' && uSettings.statusColumn.colWidth !== '' ? uSettings.statusColumn.colWidth : stColWidth;

            var oSt = {mData: stKey, title: jsConstants.grid.status, bSearchable: false, sWidth: stColWidth, render: function (data, type, row) {
                    var stStr = type === 'export' ? (row[stKey] == 1 ? jsConstants.grid.active : jsConstants.grid.inactive) : '<input type="checkbox" name="my-checkbox" class="make-switch" ' + (row[stKey] == 1 ? 'checked' : '') + ' data-action="' + uSettings.statusColumn.url + '" data-grid-index="' + tblIndex + '" data-id = "' + row[keyId] + '">';
                    var op1 = stStr.replace(/\_\_ID\_\_/g, row[keyId]);
                    return op1;
                }, sClass: 'text-center'};
            (settings[index].aoColumns).push(oSt);
        }

        op = '';
        if (typeof uSettings.operation !== 'undefined') {
            opColWidth = typeof uSettings.operation.colWidth !== 'undefined' && uSettings.operation.colWidth !== '' ? uSettings.operation.colWidth : opColWidth;

            if (typeof uSettings.operation.view !== 'undefined') {
                op += '<a href="' + uSettings.operation.view + '" class="btnDtTblView" data-id="__ID__" data-grid-index="' + tblIndex + '"><i class="fa fa-search	"></i>';
            }
            if (typeof uSettings.operation.edit !== 'undefined') {
                op += '<a href="' + uSettings.operation.edit + '" class="btnDtTblEdit" data-id="__ID__" data-grid-index="' + tblIndex + '"><i class="fa fa-pencil"></i></a>';
            }
            if (typeof uSettings.operation.delete !== 'undefined') {
               // op += '<a href="' + uSettings.operation.delete + '" class="btnDtTblDelete" data-toggle="confirmation" data-popout="true" data-id="__ID__" data-grid-index="' + tblIndex + '" data-placement="left"><i class="fa fa-trash-o"></i>';
           op+= '<button  class="btnDtTblDelete" data-toggle="confirmation" data-popout="true"  data-btn-ok-label="Yes" data-btn-ok-icon="glyphicon glyphicon-share-alt"  data-btn-ok-class="btn-success" data-placement="left" data-btn-cancel-label="No" data-btn-cancel-icon="glyphicon glyphicon-ban-circle"  data-btn-cancel-class="btn-danger" data-title="Are you sure want to delete the record?" data-content="" onclick="javascript:deleteRecord(this)" data-url="'+uSettings.operation.delete+'" data-id="__ID__" data-grid-index="' + tblIndex + '" ><i class="fa fa-trash-o"></i></button>'
              
            }

 if (typeof uSettings.operation.download !== 'undefined') {
                op += '<a href="' + uSettings.operation.download + '" class="btnDtTblDownload" data-id="__ID__" data-grid-index="' + tblIndex + '"><i class="fa glyphicon glyphicon-download"></i>';
            }
            
            if (typeof uSettings.operation.view_inquiries !== 'undefined') {
                op += '<a href="' + uSettings.operation.view_inquiries + '" class="" data-id="__ID__" data-grid-index="' + tblIndex + '"><i class="fa glyphicon glyphicon-list"></i>';
            }
            op = (typeof uSettings.operation.rowOperation !== 'undefined') ? op + uSettings.operation.rowOperation : op;

            if (op != '') {
                var oOp = {mData: "operation", title: jsConstants.grid.operation, bSearchable: false, bSortable: false, sWidth: opColWidth, render: function (data, type, row) {
                        var op1 = op.replace(/\_\_ID\_\_/g, row[keyId]);
                        return op1;
                    }, sClass: 'text-center'};
                (settings[index].aoColumns).push(oOp);
            }

        }


        if (typeof uSettings.buttons !== 'undefined') {
            //(settings[index].buttons).push(uSettings.buttons);
            console.log(settings[index]);
            (settings[index].buttons).push(uSettings.buttons);
        }
        if (isLanguageEnabled[index] && language_list.length > 0) {
            _lng[index] = typeof uSettings.language_dropdwon.selected_language !== 'undefined' ? uSettings.language_dropdwon.selected_language : '';
            var _bTxt = typeof uSettings.language_dropdwon.selected_language !== 'undefined' && uSettings.language_dropdwon.selected_language != '' ? '<span class="lang-sm lang-lbl-en" lang="' + uSettings.language_dropdwon.selected_language + '"></span>' : jsConstants.grid.selectLanguage;

            var langOpts = [];

            $.each(language_list, function (k, v) {
                langOpts.push({
                    className: (_lng[index] == v ? 'active' : ''),
                    text: '<span class="lang-sm lang-lbl-en" lang="' + v + '" data-grid-index = ' + index + '></span>',
                    action: function (e, dt, node, config) {
                        DtTable.changeLanguage(dt, node, index);
                    }
                });
            })
            var btnLanguages = [{
                    extend: 'collection',
                    text: _bTxt,
                    className: 'grid-lang-dropdown',
                    buttons: langOpts,
                    fade: true
                }];
            if(settings[index].buttons.length)
                (settings[index].buttons).unshift(btnLanguages);
            else
                settings[index].buttons = $.extend(settings[index].buttons, btnLanguages);
            
            if(settings[index].buttons.length == 0){
                settings[index].dom = "<'row'<'col-xs-6'l><'col-xs-6'f>r>" +
                    "t" +
                    "<'row'<'col-xs-6'i><'col-xs-6'p>>";                
            }
        }
        
        OTable[tblIndex] = $(tblSelector).dataTable(settings[index]);
        return OTable[tblIndex];

    },
    changeLanguage: function (dt, node, index) {
        _lng[index] = $(node).find('span').attr('lang');
        $(node).parents('ul').find('li').removeClass('active');
        $(node).addClass('active');

        var _tblId = $(OTable[index]).attr('id');
        console.log(settings[index]);
        var _s = OTable[index].fnSettings();
        //OTable[index].fnDestroy();
        //OTable[index].dataTable(settings[index]);
        dt.ajax.reload();
        
        OTable[index].fnDraw(_s);
    },
    setGridCustomParams: function (uSettings, aoData) {
        var c = typeof uSettings.customSearch !== 'undefined' ? uSettings.customSearch.selectors : [];
        $.each(c, function (k, v) {
            aoData.push({name: k, "value": $(v).val()});
        });
        return aoData;
    }

}

$(document).on('switchChange.bootstrapSwitch', '.make-switch', function (event, state) {
    var curState = state;
    var t = $(this);
    var st = curState == true ? 1 : 0;

    var data = {};
    data['status'] = st;
    data['id'] = t.data('id');
    data[global_token_nm] = getCookie(global_token);
    $.post(t.data('action'), data, function (r) {
        toastr['success'](jsConstants.statusChanged);
    });
});


/*$(document).on('click', '.btnDtTblDelete', function (e) {
    e.preventDefault();
    var t = $(this);

    if (confirm(jsConstants.cnfrmDelete)) {
        var data = {};
        data['id'] = t.data('id');
        data[global_token_nm] = getCookie(global_token);
        $.post($(this).attr('href'), data, function (r) {
            if (r.success)
                toastr['success'](jsConstants.deleteSuccess);
            else
                toastr['error'](jsConstants.deleteFailure);
            OTable[t.data('grid-index')].fnDraw();
        }, 'json');
    }
});*/




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
        if (c.indexOf(name) == 0)
            return c.substring(name.length, c.length);
    }
    return "";
}

$('.change-site-lang .dropdown-menu li a').click(function(e){
    e.preventDefault();
    var selLang = $(this).find('span').attr('lang');

    if(selLang != site_language)
        window.location.href = base_url + selLang + request_uri;
})