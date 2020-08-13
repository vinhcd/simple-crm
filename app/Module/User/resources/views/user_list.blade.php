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
                            <h3 class="card-title">{{ __('User list') }}</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 3%">ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Full name</th>
                                    <th>Description</th>
                                    <th style="width: 5%">Edit</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php /* @var \App\Module\User\Api\Data\UserInterface $user */ ?>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{$user->getId()}}</td>
                                    <td>{{$user->getName()}}</td>
                                    <td>{{$user->getEmail()}}</td>
                                    <td>{{$user->getFirstName()}} {{$user->getLastName()}}</td>
                                    <td>{{$user->getDescription()}}</td>
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
                    <a href="{{route('user_create_update')}}">
                        <button class="btn btn-dark">{{ __('Create user') }}</button>
                    </a>
                </div>
            </div>
        </div>
    </section>
@stop

@section('custom-scripts')
    <script>
        $('#nav-user').addClass('active')
    </script>
@stop
