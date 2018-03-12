<?php $CI = & get_instance(); ?>
@extends('defaults.login')
@section('title', 'Page Title')

@section('pg_content')
<style>
    .modal{color: #333 !important}
    .lnkModal{cursor: pointer}
</style>
<div class="login-logo">
    <a href="javascript:void(0)"><b>{{SITE_NM}}</b></a>
   
</div>
<div class="login-box-body" id="login-box">
    <p class="login-box-msg">{{lang('signinHeader')}}</p>
    {!! form_open(lang_url(ADMIN_DIR.'login'), ['method' => 'post', 'id' => 'frmLogin']) !!}
    <div class="form-group has-feedback">
        <input type="text" name="email" class="form-control required email" placeholder="{{ lang('email') }}" value="{{ set_value('email') }}"/>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        {!! form_error('email') !!}
    </div>
    <div class="form-group has-feedback">
        <input type="password" name="password" class="form-control required" placeholder="{{ lang('pswd') }}" {{ set_value('password') }}/>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        {!! form_error('password') !!}
    </div>          
    <div class="form-group">
        <button type="submit" class="btn btn-primary btn-block btn-login-submit">{{ lang('lblSignIn') }}</button>  
    </div>
   

    {!! form_close() !!}

</div>


<!-- COMPOSE MESSAGE MODAL -->
<div class="modal fade" id="compose-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">{{ lang('lblFrgtPwd') }}</h4>
            </div>
            <form action="javascript:void(0);" method="post" id="frmFrgtPwd">
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ lang('email') }}: </label>
                        <input name="email" type="email" class="form-control required email" placeholder="{{ lang('email') }}">
                    </div>
                </div>
                <div class="modal-footer clearfix">

                    <button type="submit" class="btn btn-primary">{{ lang('btnSubmit') }}</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">{{ lang('btnCancel') }}</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

@endsection

@section('scripts')
<script type="text/javascript">
    $(function () {
        $('.btn-login-submit').click(function(){
            $('[name='+global_token_nm+']').val(getCookie(global_token));
        });
        $('#frmLogin').validate({
            highlight: function (element) {
                element = $(element);
                var controlGroup = element.closest('.form-group');
                controlGroup.removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element) {
                element = $(element);
                var controlGroup = element.closest('.form-group');
                controlGroup.removeClass('has-error').addClass('has-success');
            }, errorPlacement: function(e,g){
                
            }
        });
        $('#frmFrgtPwd').validate();
        $('#frmFrgtPwd').submit(function (e) {
            e.preventDefault();
            var t = $(this);
            if (t.valid()) {
		var data = t.serializeArray();
		data.push({ "name": global_token_nm, "value": getCookie(global_token) });
		//data[global_token_nm] = getCookie(global_token);
                $.post('<?php echo lang_url(ADMIN_DIR . 'login/forgot_passowrd'); ?>', data, function (r) {
                    if (r == 1)
                        toastr['success']('{{lang('pwdResetSuccess')}}');
                    else
                        toastr['error']('{{lang('pwdResetFailure')}}');
                })
            }
        })
    });
</script>
@endsection
