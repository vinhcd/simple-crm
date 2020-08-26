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
                                <form id="form-avatar"
                                      enctype="multipart/form-data"
                                      action="{{route('user_change_avatar', $user->getId())}}"
                                      method="post">
                                    @csrf
                                    <img class="profile-user-img img-fluid img-circle"
                                         src="{{upload_url($user->getInfo()->getAvatar())}}"
                                         alt="User profile picture"
                                         style="cursor: pointer"
                                         id="profile-picture">
                                    <input type="file" style="display: none" id="avatar" name="avatar" accept="image/*">
                                </form>
                            </div>

                            <h3 class="profile-username text-center">{{$user->getName()}}</h3>

                            <p class="text-muted text-center">Software Engineer</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>{{__('Email')}}</b> <a class="float-right">{{$user->getEmail()}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{__('Full name')}}</b> <a class="float-right">{{$user->getFullName()}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{__('Birthday')}}</b> <a class="float-right">{{$user->getInfo()->getBirthday()}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{__('Sex')}}</b> <a class="float-right">{{$user->getInfo()->getSex()}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{__('Phone')}}</b> <a class="float-right">{{$user->getInfo()->getPhone()}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{__('Personal email')}}</b> <a class="float-right">{{$user->getInfo()->getPersonalEmail()}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{__('Address')}}</b> <a class="float-right">{{$user->getInfo()->getAddress()}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>{{__('Description')}}</b> <a class="float-right">{{$user->getInfo()->getDescription()}}</a>
                                </li>
                            </ul>

                            <a href="{{route('user_profile_update')}}" class="btn btn-primary btn-block"><b>{{__('Update profile')}}</b></a>
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
    <script>
        $('#profile-picture').click(function () {
            $('#avatar').trigger('click');
        });
        $('#avatar').change(function () {
            $('#form-avatar').submit();
        });
    </script>
@stop
