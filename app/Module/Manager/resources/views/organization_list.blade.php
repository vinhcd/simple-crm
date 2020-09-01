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
                            <h3 class="card-title">{{__('Organization list')}}</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 3%">ID</th>
                                    <th>{{__('Name')}}</th>
                                    <th>{{__('UUID')}}</th>
                                    <th>{{__('Phone')}}</th>
                                    <th>{{__('Tax')}}</th>
                                    <th>{{__('Address')}}</th>
                                    <th>{{__('Register Date')}}</th>
                                    <th>{{__('Plan')}}</th>
                                    <th>{{__('Description')}}</th>
                                    <th style="width: 5%">{{__('Edit')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php /* @var \App\Module\Manager\Api\Data\OrganizationInterface $organization */ ?>
                                @foreach ($organizations as $organization)
                                <tr>
                                    <td>{{$organization->getId()}}</td>
                                    <td>{{$organization->getName()}}</td>
                                    <td>{{$organization->getUuid()}}</td>
                                    <td>{{$organization->getPhoneNumber()}}</td>
                                    <td>{{$organization->getTaxNumber()}}</td>
                                    <td>{{$organization->getAddress()}}</td>
                                    <td>{{$organization->getRegisterDate()}}</td>
                                    <td>{{$organization->getPlan() ? $organization->getPlan()->getName() : ''}}</td>
                                    <td>{{$organization->getDescription()}}</td>
                                    <td>
                                        @if($permissionChecker->canEditOrganizations())
                                        <a href="{{ route('manager_organization_create_update', $organization->getId()) }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('manager_organization_delete', $organization->getId()) }}" title="{{__('Delete')}}" onclick="return confirm('Are you sure?')">
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
                    <a href="{{route('manager_organization_create_update')}}">
                        <button class="btn btn-dark">{{__('Create organization')}}</button>
                    </a>
                </div>
            </div>
        </div>
    </section>
@stop

@section('custom-scripts')
    @include('manager::includes.sidebar_script')
    <script>
        $('#nav-manager-organization').addClass('active')
    </script>
@stop
