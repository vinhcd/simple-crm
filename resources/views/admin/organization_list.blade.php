@extends('admin.layouts.master')

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
                                    <th>Organization name</th>
                                    <th>UUID</th>
                                    <th>Phone#</th>
                                    <th>Tax#</th>
                                    <th>Address</th>
                                    <th>Register Date</th>
                                    <th>Plan#</th>
                                    <th>Comment</th>
                                    <th style="width: 5%">Edit</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($organizations as $organization)
                                <tr>
                                    <td>{{$organization->id}}</td>
                                    <td>{{$organization->name}}</td>
                                    <td>{{$organization->uuid}}</td>
                                    <td>{{$organization->phone_number}}</td>
                                    <td>{{$organization->tax_number}}</td>
                                    <td>{{$organization->address}}</td>
                                    <td>{{$organization->register_date}}</td>
                                    <td>{{$organization->plan_id}}</td>
                                    <td>{{$organization->comment}}</td>
                                    <td>
                                        <i class="fa fa-edit"></i>&nbsp;&nbsp;
                                        <i class="fa fa-trash-alt"></i>
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
                    <a href="{{route('admin_organization_create')}}">
                        <button class="btn btn-dark">{{__('Create organization')}}</button>
                    </a>
                </div>
            </div>
        </div>
    </section>
@stop

@section('custom-scripts')
    <script>
        $('#nav-organization').addClass('active')
    </script>
@stop
