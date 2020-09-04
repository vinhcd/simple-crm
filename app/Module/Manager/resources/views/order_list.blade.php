<?php
/* @var \App\Module\Manager\Block\OrderList $ordersListBlock*/

$permissionChecker = new \App\Support\ModuleResourcePermissionChecker();

$ordersData = $ordersListBlock->getOrdersData();
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
                            <h3 class="card-title">{{__('Orders')}}</h3>
                        </div>
                        <div class="card-body">
                            <table id="order-list" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 3%">ID</th>
                                    <th>{{__('Plan')}}</th>
                                    <th>{{__('Organization')}}</th>
                                    <th>{{__('Start')}}</th>
                                    <th>{{__('End')}}</th>
                                    <th>{{__('Monthly price')}}</th>
                                    <th style="width: 5%">{{__('Edit')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($ordersData as $order)
                                <tr>
                                    <td>{{ $order['id'] }}</td>
                                    <td>{{ $order['plan'] }}</td>
                                    <td>{{ $order['organization'] }}</td>
                                    <td>{{ $order['start'] }}</td>
                                    <td>{{ $order['end'] }}</td>
                                    <td>{{ $order['monthly_price'] }}</td>
                                    <td>
                                        @if($permissionChecker->canEditOrders())
                                        <a href="{{ route('manager_order_edit', $order['id']) }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('manager_order_delete', $order['id']) }}" title="{{__('Delete')}}" onclick="return confirm('Are you sure?')">
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
                    <a href="{{route('manager_order_edit')}}">
                        <button class="btn btn-dark">{{__('Create new order')}}</button>
                    </a>
                </div>
            </div>
        </div>
    </section>
@stop

@section('custom-scripts')
    @include('manager::includes.sidebar_script')
    <!-- DataTables -->
    <script src="{{url('plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{url('plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{url('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>

    <script>
        $('#nav-manager-order').addClass('active')

        $("#order-list").DataTable({
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
