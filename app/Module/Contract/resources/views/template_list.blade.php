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
                            <table id="template-list" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 3%">ID</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('Contract')}}</th>
                                    <th style="width: 50%">{{__('Content')}}</th>
                                    <th style="width: 5%">{{__('Edit')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php /* @var \App\Module\Contract\Api\Data\ContractTemplateInterface $contractTemplate */ ?>
                                @foreach ($contractTemplates as $contractTemplate)
                                <tr>
                                    <td>{{$contractTemplate->getId()}}</td>
                                    <td>{{$contractTemplate->getName()}}</td>
                                    <td>{{$contractTemplate->contract->getName()}}</td>
                                    <td>{{ substr($contractTemplate->getContent(), 0, 300) }} ...</td>
                                    <td>
                                        @if($permissionChecker->canEditContracts())
                                        <a href="{{ route('contract_template_create_update', $contractTemplate->getId()) }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('contract_template_delete', $contractTemplate->getId()) }}" title="{{__('Delete')}}" onclick="return confirm('Are you sure?')">
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
                    <a href="{{route('contract_template_create_update')}}">
                        <button class="btn btn-dark">{{__('Create template')}}</button>
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
        $('#nav-contract-template').addClass('active')

        $("#template-list").DataTable({
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
