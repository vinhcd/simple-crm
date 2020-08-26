<?php
/* @var \App\Module\User\Block\UserEdit $userEditBlock */

$userData = $userEditBlock->getUserData();
?>

@extends('layouts.master')

@section('custom-head')
    <link rel="stylesheet" href="{{url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{__('Create/edit user')}}</h3>
                        </div>
                        <form id="form-user" action="{{route('user_profile_update')}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $userData['id'] }}">
                            <input type="hidden" name="departments" value="0">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{__('User name')}}*</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ $userData['name'] }}" placeholder="{{__('Enter name')}}">
                                </div>
                                <div class="form-group">
                                    <label for="email">{{__('Email')}}*</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{ $userData['email'] }}" placeholder="{{__('Enter email')}}">
                                </div>
                                <div class="form-group">
                                    <label for="first_name">{{__('First name')}}</label>
                                    <input type="text" class="form-control" name="first_name" id="first_name" value="{{ $userData['first_name'] }}" placeholder="{{__('Enter firstname')}}">
                                </div>
                                <div class="form-group">
                                    <label for="last_name">{{__('Last name')}}</label>
                                    <input type="text" class="form-control" name="last_name" id="last_name" value="{{ $userData['last_name'] }}" placeholder="{{__('Enter lastname')}}">
                                </div>
                                <div class="form-group">
                                    <label for="birthday">{{__('Birthday')}}</label>
                                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                        <input type="text" name="birthday" id="birthday" value="{{ $userData['birthday'] }}" class="form-control datetimepicker-input" data-target="#reservationdate"/>
                                        <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sex">{{__('Sex')}}</label>
                                    <select class="form-control" name="sex" id="sex">
                                        <option value="">{{__('Other')}}</option>
                                        <option value="male" @if($userData['sex'] == 'male') selected @endif>{{__('Male')}}</option>
                                        <option value="female" @if($userData['sex'] == 'female') selected @endif>{{__('Female')}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="phone">{{__('Phone#')}}</label>
                                    <input type="text" class="form-control" name="phone" id="phone" value="{{ $userData['phone'] }}" placeholder="{{__('Enter phone number')}}">
                                </div>
                                <div class="form-group">
                                    <label for="personal_email">{{__('Personal email')}}</label>
                                    <input type="text" class="form-control" name="personal_email" id="personal_email" value="{{ $userData['personal_email'] }}" placeholder="{{__('Enter personal email')}}">
                                </div>
                                <div class="form-group">
                                    <label for="address">{{__('Address')}}</label>
                                    <textarea class="form-control" rows="3" name="address" id="address" placeholder="{{__('Enter address')}}">{{ $userData['address'] }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="description">{{__('Description')}}</label>
                                    <textarea class="form-control" rows="3" name="description" id="description" placeholder="{{__('Enter description')}}">{{ $userData['description'] }}</textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                <a href="{{ route('user_profile') }}" class="btn btn-secondary">{{__('Cancel')}}</a>
                            </div>
                        </form>
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
        $('#form-user').validate({
            rules: {
                email: {
                    required: true,
                    email: true,
                },
                name: {
                    required: true,
                    maxlength: 255
                },
                phone: {
                    digits: true,
                    maxlength: 50
                },
                personal_email: {
                    email: true,
                },
            },
            messages: {},
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid');
            }
        });
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    </script>
@stop
