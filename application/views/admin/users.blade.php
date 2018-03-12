@extends('defaults.layout')

@section('pg_content')
<?php $ci = &get_instance() ?>
<!-- Right side column. Contains the navbar and content of the page -->
<aside class="right-side">                
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>{{ lang('pgTitle_users') }}</h1>
		
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="box">
            <div class="box-header">
                <div class="box-title col-md-8">{{ lang('pgTitle_users') }}</div>
                <div class="col-md-4 text-right"><a href="" class="lnkNewCat"  data-toggle="modal" data-target="#add-new-user"><i class="fa fa-plus"></i> {{ lang('addNew') }}</a></div>
             </div>
            <div class="box-body table-responsive">
                <div class="dt-buttons btn-group"><a class="btn btn-default buttons-csv buttons-html5" tabindex="0" aria-controls="tblAdmin"><span>Export</span></a></div>
                <div style="text-align:right;float:right;" id="total_count"></div>
          
                <table id="tblAdmin" class="table table-striped table-bordered table-hover" width="100%"></table>
            </div>
            <div class="clearfix"></div>
        </div>
    </section><!-- /.content -->
</aside>
<div class="modal fade" id="add-new-user" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <form action="javascript:void(0);" method="post" id="frmUser">
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ lang('email') }} </label>
                        <input name="email" type="text" class="form-control required email" placeholder="{{ lang('email') }}">
                    </div>
                    <div class="form-group"  id="pwd_div" style="display:none;">
                        <label>{{ lang('pswd') }}</label>
                        <input name="password" type="password" class="form-control required " placeholder="{{ lang('pswd') }}">
                    </div>
                    
                     <div class="form-group">
                        <label>{{ lang('first_name') }} </label>
                        <input name="first_name" type="text" class="form-control required" placeholder="{{ lang('first_name') }}">
                    </div>
                    
                    
                     <div class="form-group">
                        <label>{{ lang('last_name') }} </label>
                        <input name="last_name" type="text" class="form-control required" placeholder="{{ lang('last_name') }}">
                    </div>
                    
                    <div class="form-group">
                        <label>Primary Use </label>
                        <input name="primary_use" type="text" class="form-control required" placeholder="Primary Use">
                    </div>
                    
                    
                    <!-- <div class="form-group">
                        <label>{{ lang('pswd') }} </label>
                        <input name="password" type="password" class="form-control required" placeholder="{{ lang('pswd') }}">
                    </div>-->
                    
                    <div class="form-group">
                        <label>{{ lang('status') }} </label><div class="clearfix"></div>
                        <div class="col-md-3">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" id="optionsRadios1" value="1" class="required" checked>
                                    {{ lang('active') }}
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="status" id="optionsRadios1" value="0" class="required">
                                    {{ lang('inactive') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer clearfix">

                    <button type="submit" class="btn btn-success">{{ lang('btnSubmit') }}</button>
                    <button type="button" class="btn btn-grey" data-dismiss="modal">{{ lang('btnCancel') }}</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@endsection

@section('scripts')

<script type="text/javascript">

$(function(){	
    $('#frmUser').validate({
        errorPlacement: function(error, element) {
            if (element.attr("name") == "status") {
                error.appendTo($(element).parents('.form-group'));
            } else {
                error.insertAfter(element);
            }
        }
    });
});

var uSettings = {
	url: '<?php echo lang_url(ADMIN_DIR . 'users/get_list');?>',
	aoColumns: [
        { mData: "id", title : '{{ lang('id') }}', bVisible: false},
        { mData: "email", title : '{{ lang('email') }}', sWidth:'20%'},  
        { mData: "first_name", title : '{{ lang('first_name') }}', sWidth:'25%'},
        { mData: "last_name", title : '{{ lang('last_name') }}', sWidth:'20%'},
        { mData: "primary_use", title : 'Primary Use', sWidth:'20%'},
        { mData: "gender", title : 'Gender', sWidth:'5%'},
        { mData: "birthdate", title : 'BirthDate', sWidth:'20%'},
       // { mData: "app_version", title : 'App Version', sWidth:'20%'},
        { mData: "Conseel Pro", title : 'Conseel Pro', sWidth:'20%'},
        { mData: "Conseel Lite", title : 'Conseel Lite', sWidth:'20%'},
        
        { mData: "created_date", title : 'Installation Date', sWidth:'20%'}
       
       
    ],
	statusColumn: {
		url: site_url + 'users/update_status/__ID__',
	},
	operation:{
		
		edit: '{{ lang_url(ADMIN_DIR . "users/get_details/__ID__") }}',
		delete: '{{ lang_url(ADMIN_DIR . "users/delete/__ID__") }}',
               
		colWidth: '15%',
	},
        
          /*   buttons: [{
 	extend: 'csv',
 	text: 'Export',
     
      columns:[1,2,3,4],
 	exportOptions: {
 		modifier: {
 			search: 'applied',
 			order: 'applied',
                       
                      
 		}
               
 	}
 }],*/
	order : [[0, 'DESC']],
	datatableSettings: {
        dom: 'Bfrtip'
        //"pageLength": 1,
        }
}

var gridTable = DtTable.init('#tblAdmin', uSettings,1);

$(document).on('click','.btnDtTblEdit',function(e){
    e.preventDefault();
    var t = $(this);
    $('#add-new-user').modal('show');
    $('#add-new-user .modal-title').html('Edit User');
    $()
    $.getJSON(t.attr('href'),function(r){
        $('#add-new-user form').attr('action','<?php echo lang_url(ADMIN_DIR . 'Users/edit');?>/'+r.user_id);
        $('[name="first_name"]').val(r.user_first_name);
         $('[name="last_name"]').val(r.user_last_name);
         $('[name="email"]').val(r.user_email);
         $('[name="email"]').attr('readonly',true);
         $('[name="primary_use"]').val(r.primary_use);
        $('[name="status"][value="'+r.user_status+'"]').iCheck('check');
    });
});

$(document).on('click','.lnkNewCat',function(e){
    e.preventDefault();
    var t = $(this);
    $('#add-new-user form').attr('action','<?php echo lang_url(ADMIN_DIR . 'Users/add/');?>');
    $('#add-new-user .modal-title').html('Add new User');
    $('#add-new-user').modal('show');
    $('#pwd_div').show();
    $('[name="email"]').attr('readonly',false);
    $('[name="first_name"]').val('');
    $('[name="last_name"]').val('');
    $('[name="email"]').val('');    
    $('#add-new-user label.error').remove();
});

$(document).on('submit','#frmUser', function(e){
    e.preventDefault();
    var t = $(this);
    if(t.valid()){
        t.find('[type="submit"]').attr('disabled','disabled');
		var data = t.serializeArray();
		data.push({ "name": global_token_nm, "value": getCookie(global_token) });
		data[global_token_nm] = getCookie(global_token);
        $.post(t.attr('action'), data, function(r){
            t.find('[type="submit"]').removeAttr('disabled');
            if(r.success){
                $('#add-new-user').modal('hide');
                toastr['success'](r.msg);
                gridTable.fnDraw();
            }else{
                toastr['error'](r.msg);
            }
        },'json');
    }
});

$(document).on('click','.buttons-csv',function(e)
{
    e.preventDefault();
   
    var searchVal=$('.input-sm').val();
    var download_url='<?php echo lang_url(ADMIN_DIR . 'users/csv_download'); ?>'
    $.ajax({
                    dataType: 'json',
                    type: "POST",
                    url: '<?php echo lang_url(ADMIN_DIR . 'users/get_users'); ?>',
                    data: {'sSearch':searchVal},
                    success:function(response)
            {
                download_url+='?filename='+response.filename;
                window.location.href=download_url;
            }
                });
})


function deleteRecord(obj)
{ 
    $(obj).confirmation({
  rootSelector: '[data-toggle=confirmation]',
  onConfirm: function() {
   var data = {};
        data['id'] = $(obj).data('id');
       // data[global_token_nm] = getCookie(global_token);
        $.post($(obj).data('url'), data, function (r) {
            if (r.success)
                toastr['success'](jsConstants.deleteSuccess);
            else
                toastr['error'](jsConstants.deleteFailure);
            window.OTable[$(obj).data('grid-index')].fnDraw();
        }, 'json');
       
  },
  onCancel: function() {
      
    
  }
 
}
 
        );
}


</script>
@endsection
