<?php defined('BASEPATH') OR exit('No direct script access allowed');
$CI = & get_instance(); ?><!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>{{ $page_title }}</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="{{ base_url(SITE_CSS) }}/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ base_url(SITE_CSS) }}/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ base_url(SITE_CSS) }}/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ base_url(SITE_CSS) }}/morris/morris.css" rel="stylesheet" type="text/css" />
        <link href="{{ base_url(SITE_CSS) }}/jvectormap/jquery-jvectormap-1.2.2.css" rel="stylesheet" type="text/css" />
        <link href="{{ base_url(SITE_CSS) }}/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />
        <link href="{{ base_url(SITE_CSS) }}/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ base_url(SITE_CSS) }}/datatables.min.css" rel="stylesheet" type="text/css" />

        <link href="{{ base_url(SITE_CSS) }}/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ base_url(SITE_CSS) }}/skins/skin-blue.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ base_url(SITE_CSS) }}/admin.css" rel="stylesheet" type="text/css" />
        <link href="{{ base_url(SITE_CSS) }}/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ base_url(SITE_CSS.'toastr.min.css') }}" rel="stylesheet" type="text/css" />

        <script src="{{ base_url(SITE_JS) }}/jquery.min.js"></script>
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        @yield('styles')

        <script>
            global_token_nm = "{{ $CI->config->item('csrf_token_name') }}";
            global_token = "{{ $CI->config->item('csrf_cookie_name') }}";
            site_url = '{{ lang_url() . '/' . ADMIN_DIR }}';
            site_language = '{{ $CI->default_language }}';
            language_list = {!! json_encode($CI->language_list) !!};
            jsConstants = {!! json_encode(lang('jsConstants')) !!};
            request_uri = '{{ substr(uri_string(),2) }}';
            base_url = '{{ base_url() }}';
        </script>
    </head>
    <body class="hold-transition login-page">
        <div class="login-box">
            @yield('pg_content')
        </div>

        <script src="{{ base_url(SITE_JS) }}/jquery-ui-1.10.3.min.js" type="text/javascript"></script>
        <script src="{{ base_url(SITE_JS) }}/bootstrap.min.js" type="text/javascript"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="{{ base_url(SITE_JS) }}/plugins/morris/morris.min.js" type="text/javascript"></script>
        <script src="{{ base_url(SITE_JS) }}/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="{{ base_url(SITE_JS) }}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="{{ base_url(SITE_JS) }}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <script src="{{ base_url(SITE_JS) }}/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <script src="{{ base_url(SITE_JS) }}/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <script src="{{ base_url(SITE_JS) }}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <script src="{{ base_url(SITE_JS) }}/plugins/iCheck/icheck.min.js" type="text/javascript"></script>


        <script src="{{ base_url(SITE_JS) }}/datatables.min.js" type="text/javascript"></script>
        <script src="{{ base_url(SITE_JS) }}/general.js" type="text/javascript"></script>

        <!-- AdminLTE App -->
        <script src="{{ base_url(SITE_JS.'AdminLTE/app.min.js') }}" type="text/javascript"></script>

        <script src="{{ base_url(SITE_JS.'validator/jquery.validate.min.js') }}" type="text/javascript"></script>
        <script src="{{base_url(SITE_JS.'bootstrap-switch.min.js')}}" type="text/javascript"></script>
        <script type="text/javascript" src="{{ base_url(SITE_JS.'toastr.min.js') }}"></script>
        <script type="text/javascript" src="{{ base_url(SITE_JS.'plugins/ckeditor/ckeditor.js') }}"></script>
        <script type="text/javascript">
            toastr.options = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-full-width",
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            <?php
            $flsh_msg = $CI->session->userdata('flsh_msg');
            if ($flsh_msg != '') {
                $flsh_msg_type = $CI->session->userdata('flsh_msg_type');
                echo "toastr['$flsh_msg_type']('$flsh_msg');";
                unset_flash_msg();
            }
            ?>

        </script>

        <!-- scripts starts -->
        @yield('scripts')    
        <!-- scripts ends -->
    </body>
</html>
