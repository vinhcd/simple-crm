<?php
$permissionChecker = new \App\Support\ModuleResourcePermissionChecker();
/* @var \App\Module\User\Api\Data\UserInterface $user*/
$user = \Illuminate\Support\Facades\Auth::user();
?>

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
                <a href="{{route('user_profile')}}">
                    <img src="{{upload_url(auth()->user()->getInfo()->getAvatar())}}" class="img-circle elevation-2" alt="User Image">
                </a>
            </div>
            <div class="info">
                <a href="{{route('user_profile')}}" class="d-block">{{auth()->user()->getName()}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                @if($permissionChecker->canReadOrganizations() || $permissionChecker->canReadPlans())
                <li class="nav-item" id="nav-group-manager">
                    <a href="#" class="nav-link" id="nav-group-manager-title">
                        <p>{{__('PLAN')}}<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if($permissionChecker->canReadPlans())
                        <li class="nav-item">
                            <a href="{{route('manager_plan_list')}}" class="nav-link" id="nav-manager-plan">
                                <i class="nav-icon fa fa-usd"></i>
                                <p>{{__('Plans')}}</p>
                            </a>
                        </li>
                        @endif
                        @if($permissionChecker->canReadOrganizations())
                        <li class="nav-item">
                            <a href="{{route('manager_organization_list')}}" class="nav-link" id="nav-manager-organization">
                                <i class="nav-icon fas fa-building"></i>
                                <p>{{__('Organizations')}}</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                @if($permissionChecker->canReadUsers() || $permissionChecker->canReadGroups()
                    || $permissionChecker->canReadPositions() || $permissionChecker->canReadDepartments())
                <li class="nav-item" id="nav-group-user">
                    <a href="#" class="nav-link" id="nav-group-user-title">
                        <p>{{__('COMPANY')}}<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if($permissionChecker->canReadUsers())
                        <li class="nav-item">
                            <a href="{{route('user_list')}}" class="nav-link" id="nav-user-user">
                                <i class="nav-icon fas fa-user"></i>
                                <p>{{__('Users')}}</p>
                            </a>
                        </li>
                        @endif
                        @if($permissionChecker->canReadGroups())
                        <li class="nav-item">
                            <a href="{{route('user_group_list')}}" class="nav-link" id="nav-user-group">
                                <i class="nav-icon fas fa-users"></i>
                                <p>{{__('Groups')}}</p>
                            </a>
                        </li>
                        @endif
                        @if($permissionChecker->canReadPositions())
                            <li class="nav-item">
                                <a href="{{route('user_position_list')}}" class="nav-link" id="nav-user-position">
                                    <i class="nav-icon fas fa-clipboard"></i>
                                    <p>{{__('Positions')}}</p>
                                </a>
                            </li>
                        @endif
                        @if($permissionChecker->canReadDepartments())
                        <li class="nav-item">
                            <a href="{{route('user_depart_list')}}" class="nav-link" id="nav-user-depart">
                                <i class="nav-icon fas fa-house-user"></i>
                                <p>{{__('Departments')}}</p>
                            </a>
                        </li>
                        @endif
                    </ul>
                </li>
                @endif

                @if($permissionChecker->canReadContracts() || $permissionChecker->canEditContracts())
                <li class="nav-item" id="nav-group-contract">
                    <a href="#" class="nav-link" id="nav-group-contract-title">
                        <p>{{__('CONTRACT')}}<i class="fas fa-angle-left right"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        @if($permissionChecker->canReadContracts())
                            <li class="nav-item">
                                <a href="{{route('contract_list')}}" class="nav-link" id="nav-contract-contract">
                                    <i class="nav-icon fa fa-file-contract"></i>
                                    <p>{{__('Contracts')}}</p>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
                @endif

                @if($user->isSuperAdmin())
                <li class="nav-item">
                    <a href="{{route('role_list')}}" class="nav-link" id="nav-role">
                        <i class="nav-icon fa fa-lock"></i>
                        <p>{{__('Roles')}}</p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
