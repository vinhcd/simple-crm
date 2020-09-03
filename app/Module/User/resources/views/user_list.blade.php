<?php
/* @var \App\Module\User\Block\UserList $userListBlock */

$permissionChecker = new \App\Support\ModuleResourcePermissionChecker();
?>

@extends('layouts.master')

@section('custom-head')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@show

@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('List of users')}}</h3>
                        </div>
                        <div class="card-body">
                            <table id="user-list" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Full name')}}</th>
                                    <th>{{__('Email')}}</th>
                                    <th>{{__('Groups')}}</th>
                                    <th>{{__('Departments')}}</th>
                                    <th>{{__('Phone#')}}</th>
                                    <th>{{__('Expire')}}</th>
                                    <th>{{__('Edit')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($userListBlock->getTransformedData() as $user)
                                <tr>
                                    <td>{{$user['id']}}</td>
                                    <td>{{$user['full_name']}}</td>
                                    <td>{{$user['email']}}</td>
                                    <td>{{$user['groups']}}</td>
                                    <td>{{$user['departments']}}</td>
                                    <td>{{$user['phone']}}</td>
                                    <td>{{$user['contract_expire']}}</td>
                                    <td>
                                        @if($user['id'] != auth()->id() && $permissionChecker->canEditUsers())
                                        <a href="{{ route('user_create_update', $user['id']) }}" title="{{__('Edit')}}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('user_delete', $user['id']) }}" title="{{__('Delete')}}" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash-alt"></i>
                                        </a>&nbsp;&nbsp;
                                        <a href="{{ route('user_reset_pwd', $user['id']) }}" title="{{__('Reset password')}}"><i class="fa fa-key"></i></a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @if($permissionChecker->canEditUsers())
                <div class="col-12">
                    <a href="{{route('user_create_update')}}">
                        <button class="btn btn-dark">{{ __('Create user') }}</button>
                    </a>
                </div>
                @endif
            </div>
        </div>
    </section>
@stop

@section('custom-scripts')
    @include('user::includes.sidebar_script')
    <!-- DataTables -->
    <script src="{{url('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{url('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

    <script>
        $('#nav-user-user').addClass('active');

        $("#user-list").DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    </script>
@stop
