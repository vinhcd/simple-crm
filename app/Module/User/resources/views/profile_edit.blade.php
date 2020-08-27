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
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{__('User name')}}</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ $userData['name'] }}" disabled>
                                </div>
                                <div class="form-group">
                                    <label for="email">{{__('Email')}}</label>
                                    <input type="email" class="form-control" name="email" id="email" value="{{ $userData['email'] }}" disabled>
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
                                    <label for="contact_phone">{{__('Contact phone')}}</label>
                                    <input type="text" class="form-control" name="contact_phone" id="contact_phone" value="{{ $userData['contact_phone'] }}" placeholder="{{__('Enter contact phone')}}">
                                </div>
                                <div class="form-group">
                                    <label for="contact_email">{{__('Contact email')}}</label>
                                    <input type="text" class="form-control" name="contact_email" id="contact_email" value="{{ $userData['contact_email'] }}" placeholder="{{__('Enter contact email')}}">
                                </div>
                                <div class="form-group">
                                    <label for="address1">{{__('Primary residence address')}}</label>
                                    <textarea class="form-control" rows="3" name="address1" id="address1" placeholder="{{__('Enter address1')}}">{{ $userData['address1'] }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="address2">{{__('Current address')}}</label>
                                    <textarea class="form-control" rows="3" name="address2" id="address2" placeholder="{{__('Enter address2')}}">{{ $userData['address2'] }}</textarea>
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
    @include('user::includes.js_validate')
    <script>
        $('#form-user').validate({
            rules: {
                phone: {
                    digits: true,
                    maxlength: 10,
                },
                contact_phone: {
                    digits: true,
                    maxlength: 10,
                    notEqualTo: ['#phone']
                },
                personal_email: {
                    email: true,
                    notEqualTo: ['#email']
                },
                contact_email: {
                    email: true,
                    notEqualTo: ['#email', '#personal_email']
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
