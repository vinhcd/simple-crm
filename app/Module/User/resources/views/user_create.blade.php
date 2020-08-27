<?php
/* @var \App\Module\User\Block\UserEdit $userEditBlock */

$userData = $userEditBlock->getUserData();
?>

@extends('layouts.master')

@section('custom-head')
    <link rel="stylesheet" href="{{url('plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{url('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form id="form-user" action="{{route('user_create_update', ['id' => $userData['id']])}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{__('Create/edit user')}}</h3>
                            </div>
                            <input type="hidden" name="id" value="{{ $userData['id'] }}">
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
                                    <label for="uuid">{{__('UUID')}}</label>
                                    <input type="text" class="form-control" name="uuid" id="uuid" value="{{ $userData['uuid'] }}" placeholder="{{__('Enter uuid')}}">
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
                                    <label for="contact_phone">{{__('Contact phone')}}</label>
                                    <input type="text" class="form-control" name="contact_phone" id="contact_phone" value="{{ $userData['contact_phone'] }}" placeholder="{{__('Enter contact phone')}}">
                                </div>
                                <div class="form-group">
                                    <label for="contact_email">{{__('Contact email')}}</label>
                                    <input type="text" class="form-control" name="contact_email" id="contact_email" value="{{ $userData['contact_email'] }}" placeholder="{{__('Enter contact email')}}">
                                </div>
                                <div class="form-group">
                                    <label for="address1">{{__('Address1')}}</label>
                                    <textarea class="form-control" rows="3" name="address1" id="address1" placeholder="{{__('Enter address1')}}">{{ $userData['address1'] }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="address2">{{__('Address2')}}</label>
                                    <textarea class="form-control" rows="3" name="address2" id="address2" placeholder="{{__('Enter address2')}}">{{ $userData['address2'] }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="description">{{__('Description')}}</label>
                                    <textarea class="form-control" rows="3" name="description" id="description" placeholder="{{__('Enter description')}}">{{ $userData['description'] }}</textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                <a href="{{ route('user_list') }}" class="btn btn-secondary">{{__('Cancel')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{__('Group/Department/Position')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <label>{{__('Groups')}}</label>
                                    <select class="select2bs4" name="groups[]" multiple="multiple"
                                            data-placeholder="{{__('Select groups')}}" style="width: 100%;">
                                        @foreach($userEditBlock->getGroups() as $group)
                                            <option value="{{$group['id']}}"
                                                    @if(in_array($group['id'], $userData['groups'])) selected @endif>{{$group['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{__('Positions')}}</label>
                                    <select class="select2bs4" name="positions[]" multiple="multiple"
                                            data-placeholder="{{__('Select positions')}}" style="width: 100%;">
                                        @foreach($userEditBlock->getPositions() as $position)
                                            <option value="{{$position['id']}}"
                                                    @if(in_array($position['id'], $userData['positions'])) selected @endif>{{$position['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{__('Departments')}}</label>
                                    <select class="select2bs4" name="departments[]" multiple="multiple"
                                            data-placeholder="{{__('Select departments')}}" style="width: 100%;">
                                        @foreach($userEditBlock->getDepartments() as $department)
                                            <option value="{{$department['id']}}"
                                                    @if(in_array($department['id'], $userData['departments'])) selected @endif>{{$department['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
@stop

@section('custom-scripts')
    @include('user::includes.sidebar_script')
    <script src="{{url('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{url('plugins/jquery-validation/additional-methods.min.js')}}"></script>
    <script src="{{url('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script>
        $('#nav-user-user').addClass('active');
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
                birthday: {
                    date: true
                },
                phone: {
                    digits: true,
                    maxlength: 50
                },
                contact_phone: {
                    digits: true,
                    maxlength: 50
                },
                personal_email: {
                    email: true,
                },
                contact_email: {
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
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })
    </script>
@stop
