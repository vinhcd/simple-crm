<?php
    $permissionChecker = new \App\Support\ModuleResourcePermissionChecker();
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
                            <h3 class="card-title">{{__('Contract list')}}</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 3%">ID</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Display name')}}</th>
                                    <th>{{__('Type')}}</th>
                                    <th>{{__('Description')}}</th>
                                    <th style="width: 5%">{{__('Edit')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php /* @var \App\Module\Contract\Api\Data\ContractInterface $contract */ ?>
                                @foreach ($contracts as $contract)
                                <tr>
                                    <td>{{$contract->getId()}}</td>
                                    <td>{{$contract->getName()}}</td>
                                    <td>{{$contract->getType()}}</td>
                                    <td>{{$contract->getDisplayName()}}</td>
                                    <td>{{$contract->getDescription()}}</td>
                                    <td>
                                        @if($permissionChecker->canEditContracts())
                                        <a href="{{ route('contract_create_update', $contract->getId()) }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('contract_delete', $contract->getId()) }}" title="{{__('Delete')}}" onclick="return confirm('Are you sure?')">
                                            <i class="fa fa-trash-alt"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{route('contract_create_update')}}">
                        <button class="btn btn-dark">{{__('Create contract')}}</button>
                    </a>
                </div>
            </div>
        </div>
    </section>
@stop

@section('custom-scripts')
    @include('contract::includes.sidebar_script')
    <script>
        $('#nav-contract-contract').addClass('active')
    </script>
@stop
