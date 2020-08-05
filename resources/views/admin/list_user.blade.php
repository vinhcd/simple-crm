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
                            <h3 class="card-title">User list</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th class="w-25">Username</th>
                                    <th class="w-25">Email</th>
                                    <th>Role</th>
                                    <th class="w-25">Comment</th>
                                    <th>Remove?</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role_id}}</td>
                                    <td>{{$user->comment}}</td>
                                    <td><i class="fa fa-trash-alt"></i></td>
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
                    <a href="{{route('admin_create')}}">
                        <button class="btn btn-dark">Create a new user</button>
                    </a>
                </div>
            </div>
        </div>
    </section>
@stop
