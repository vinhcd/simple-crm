<?php
/* @var \App\Module\User\Models\Data\Position[] $positions */

$permissionChecker = new \App\Support\PermissionChecker();
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
                            <h3 class="card-title">{{__('List of positions')}}</h3>
                        </div>
                        <div class="card-body">
                            <table id="depart-list" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>{{__('ID')}}</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Description')}}</th>
                                    <th>{{__('Edit')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($positions as $position)
                                <tr>
                                    <td>{{$position->getId()}}</td>
                                    <td>{{$position->getName()}}</td>
                                    <td>{{$position->getDescription()}}</td>
                                    <td>
                                        @if($permissionChecker->canEditPositions())
                                        <a href="{{ route('user_position_create_update', $position->getId()) }}" title="{{__('Edit')}}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('user_position_delete', $position->getId()) }}" title="{{__('Delete')}}" onclick="return confirm('Are you sure?')">
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
                <div class="col-12">
                    <a href="{{route('user_position_create_update')}}">
                        <button class="btn btn-dark">{{ __('Create position') }}</button>
                    </a>
                </div>
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
        $('#nav-user-position').addClass('active');

        $("#depart-list").DataTable({
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
