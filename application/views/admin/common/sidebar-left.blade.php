<?php
$CI = & get_instance();
$class = $CI->router->fetch_class();
$method = $CI->router->fetch_method();
?>

<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
          
            <li class="">
                <a href="{{ lang_url(ADMIN_DIR .'users') }}">
                    <i class="fa fa-dashboard"></i> <span>Manage Users</span>
                </a>
            </li>
            
            
            
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

@section('scripts')
@parent
<script type="text/javascript">
/*
    $(function () {
        $('#{{ $current_page }}').addClass('active');
        var parent_li = $('#{{ $current_page }}').parents('.treeview');
        parent_li.addClass('active');
        var down_arrow = parent_li.find('.fa-angle-left');
        down_arrow.removeClass('fa-angle-left');
        down_arrow.addClass('fa-angle-down');
    });
*/
</script>
@endsection
