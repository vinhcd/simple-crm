<?php /* @var \App\Module\User\Models\Data\Group[] $groups */ ?>

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
                            <h3 class="card-title">{{__('List of groups')}}</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="group-list" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Display Name')}}</th>
                                    <th>{{__('Priority')}}</th>
                                    <th>{{__('Description')}}</th>
                                    <th>{{__('Edit')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($groups as $group)
                                <tr>
                                    <td>{{$group->getId()}}</td>
                                    <td>{{$group->getName()}}</td>
                                    <td>{{$group->getDisplayName()}}</td>
                                    <td>{{$group->getPriority()}}</td>
                                    <td>{{$group->getDescription()}}</td>
                                    <td>
                                        <a href="{{ route('user_group_create_update', $group->getId()) }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('user_group_delete', $group->getId()) }}"><i class="fa fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <div class="col-12">
                    <a href="{{route('user_group_create_update')}}">
                        <button class="btn btn-dark">{{ __('Create group') }}</button>
                    </a>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
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
        $('#nav-user-group').addClass('active');

        $("#group-list").DataTable({
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
