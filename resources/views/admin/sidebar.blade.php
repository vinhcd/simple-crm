<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('admin_dashboard')}}" class="brand-link">
        <img src="{{url('dist/img/AdminLTELogo.png')}}" alt="Neos Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Neos Corporation</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{url('dist/img/hungnt.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{route('admin_plan_list')}}" class="nav-link" id="nav-plan">
                        <i class="nav-icon fa fa-usd"></i>
                        <p>{{__('Plans')}}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin_organization_list')}}" class="nav-link" id="nav-organization">
                        <i class="nav-icon fas fa-building"></i>
                        <p>{{__('Organizations')}}</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('admin_user_list')}}" class="nav-link" id="nav-user">
                        <i class="nav-icon fas fa-user"></i>
                        <p>{{__('Admin users')}}</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
