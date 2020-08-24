<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
        <img src="{{url('dist/img/AdminLTELogo.png')}}" alt="Neos Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Neos Corporation</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{upload_url(auth()->user()->getInfo()->getAvatar())}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{route('user_profile')}}" class="d-block">{{auth()->user()->getName()}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item" id="nav-group-manager">
                    <a href="#" class="nav-link" id="nav-group-manager-title">
                        <i class="nav-icon fa fa-money-bill"></i>
                        <p>{{__('PLAN')}}<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('manager_plan_list')}}" class="nav-link" id="nav-manager-plan">
                                <i class="nav-icon fa fa-usd"></i>
                                <p>{{__('Plans')}}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('manager_organization_list')}}" class="nav-link" id="nav-manager-organization">
                                <i class="nav-icon fas fa-building"></i>
                                <p>{{__('Organizations')}}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item" id="nav-group-user">
                    <a href="#" class="nav-link" id="nav-group-user-title">
                        <i class="nav-icon fas fa-user-edit"></i>
                        <p>{{__('COMPANY')}}<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('user_list')}}" class="nav-link" id="nav-user-user">
                                <i class="nav-icon fas fa-user"></i>
                                <p>{{__('Users')}}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('user_group_list')}}" class="nav-link" id="nav-user-group">
                                <i class="nav-icon fas fa-users"></i>
                                <p>{{__('Groups')}}</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('user_depart_list')}}" class="nav-link" id="nav-user-depart">
                                <i class="nav-icon fas fa-house-user"></i>
                                <p>{{__('Departments')}}</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{route('acl_list')}}" class="nav-link" id="nav-acl">
                        <i class="nav-icon fa fa-lock"></i>
                        <p>{{__('Roles')}}</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
