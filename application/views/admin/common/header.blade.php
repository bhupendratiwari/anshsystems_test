<?php $ci = get_instance(); ?>
<header class="main-header">
    <a href="{{ lang_url('admin') }}" class="logo">
        <!-- Add the class icon to your logo image or logo icon to add the margining -->
        <span class="logo-mini"><b>AP</b></span>
       
        <span class="logo-lg">
            <img src="../assets/img/conseel_logo_new.png" class="img-responsive"/>
            
        </span>
    </a>

    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav change-site-lang">
                <!-- User Account: style can be found in dropdown.less -->
                
                @if(count($ci->language_list) > 1 && $ci->config->item('admin_multi_language'))
                <li class="dropdown">
                    <a  href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="selected-language"><span class="lang-sm" lang="{{ $ci->default_language }}"></span></span>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu ">
                        @foreach($ci->language_list as $k=>$v)
                        <li><a href="#"><span class="lang-sm lang-lbl-full" lang="{{ $v }}"></span></a></li>
                        @endforeach
                    </ul>
                </li>                
                @endif
                <li class="dropdown user user-menu">
                    <a href="{{ lang_url(ADMIN_DIR . 'logout') }}" >
                        <i class="fa fa-sign-out"></i>
                        <span>Logout</span>
                    </a>

                </li>
            </ul>
        </div>
    </nav>
</header>