<?php
/* @var \App\Module\User\Models\Data\User $user */
?>

@extends('layouts.master')

@section('title')
    Neos Corp | {{__('Profile')}}
@stop

@section('custom-head')
    <link rel="stylesheet" href="{{url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                     src="../../dist/img/user4-128x128.jpg"
                                     alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">{{$user->getName()}}</h3>

                            <p class="text-muted text-center">Software Engineer</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Email</b> <a class="float-right">{{$user->getEmail()}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Full name</b> <a class="float-right">{{$user->getFullName()}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Birthday</b> <a class="float-right">{{$user->getInfo()->getBirthday()}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Phone</b> <a class="float-right">{{$user->getInfo()->getPhone()}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Address</b> <a class="float-right">{{$user->getInfo()->getAddress()}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Description</b> <a class="float-right">{{$user->getInfo()->getDescription()}}</a>
                                </li>
                            </ul>

                            <a href="{{route('user_create_update', ['id' => $user->getId()])}}" class="btn btn-primary btn-block"><b>{{__('Update profile')}}</b></a>
                            <a href="{{route('user_change_pwd')}}" class="btn btn-primary btn-block"><b>{{__('Change password')}}</b></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('custom-scripts')
    <script src="{{url('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{url('plugins/jquery-validation/additional-methods.min.js')}}"></script>
    <script src="{{url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
@stop
