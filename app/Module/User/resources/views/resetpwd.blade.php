<?php
/* @var \App\Module\User\Models\Data\User $user */
?>

@extends('layouts.master')

@section('title')
    Neos Corp | {{__('Reset password')}}
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
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{__('Reset password')}}</h3>
                        </div>
                        <form id="form-password" action="{{route('user_reset_pwd', $user->getId())}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->getId() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="password">{{__('New password')}}*</label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="{{__('Enter password')}}">
                                </div>
                                <div class="form-group">
                                    <label for="retype_password">{{__('Retype new password')}}*</label>
                                    <input type="password" class="form-control" name="retype_password" id="retype_password" placeholder="{{__('Enter password again')}}">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                <a href="{{ route('user_list') }}" class="btn btn-secondary">{{__('Cancel')}}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('custom-scripts')
    @include('user::includes.sidebar_script')
    <script src="{{url('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{url('plugins/jquery-validation/additional-methods.min.js')}}"></script>
    <script src="{{url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script>
        $('#nav-user-user').addClass('active');
        $('#form-password').validate({
            rules: {
                password: {
                    required: true,
                    minlength: 3,
                    maxlength: 255
                },
                retype_password: {
                    required: true,
                    minlength: 3,
                    maxlength: 255,
                    equalTo: "#password"
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
