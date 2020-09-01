<?php
/* @var \App\Module\Contract\Block\ContractUserList $userListBlock*/

$permissionChecker = new \App\Support\ModuleResourcePermissionChecker();
$userData = $userListBlock->getUsersData();
?>

@extends('layouts.master')

@section('custom-head')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@show

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('User contracts')}}</h3>
                        </div>
                        <div class="card-body">
                            <table id="user-list" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 3%">ID</th>
                                    <th>{{__('User')}}</th>
                                    <th>{{__('Contract')}}</th>
                                    <th>{{__('Template')}}</th>
                                    <th>{{__('Start')}}</th>
                                    <th>{{__('End')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th style="width: 5%">{{__('Edit')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($userData as $contractUser)
                                <tr>
                                    <td>{{ $contractUser['id'] }}</td>
                                    <td>{{ $contractUser['username'] }}</td>
                                    <td>{{ $contractUser['contract'] }}</td>
                                    <td>{{ $contractUser['template'] }}</td>
                                    <td>{{ $contractUser['start'] }}</td>
                                    <td>{{ $contractUser['end'] }}</td>
                                    @if($contractUser['active'] == 1)
                                    <td class = "bg-olive color-palette">{{__('Active')}}</td>
                                    @else
                                    <td class = "bg-pink color-palette">{{__('Inactive')}}</td>
                                    @endif
                                    <td>
                                        @if($permissionChecker->canEditContracts())
                                        <a href="{{ route('contract_user_create_update', $contractUser['id']) }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('contract_user_delete', $contractUser['id']) }}" title="{{__('Delete')}}" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash-alt"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{route('contract_user_create_update')}}">
                        <button class="btn btn-dark">{{__('Create user contract')}}</button>
                    </a>
                </div>
            </div>
        </div>
    </section>
@stop

@section('custom-scripts')
    @include('contract::includes.sidebar_script')
    <!-- DataTables -->
    <script src="{{url('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{url('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

    <script>
        $('#nav-contract-user').addClass('active')

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
