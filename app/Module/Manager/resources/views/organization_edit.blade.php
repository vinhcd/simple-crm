<?php
/* @var \App\Module\Manager\Block\OrganizationEdit $orgEditBlock */

$org = $orgEditBlock->getOrganization();
?>

@extends('layouts.master')

@section('custom-head')
    <link rel="stylesheet" href="{{url('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
@endsection

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{__('Create organization')}}</h3>
                        </div>
                        <form id="form-organization" action="{{route('manager_organization_edit', $org->getId())}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $org->getId() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{__('Organization name')}}</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="{{ old('name', $org->getName()) }}" placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                    <label for="phone_number">{{__('Phone')}}</label>
                                    <input type="text" class="form-control" name="phone_number" id="phone_number"
                                           value="{{ old('phone_number', $org->getPhoneNumber()) }}" placeholder="Enter phone">
                                </div>
                                <div class="form-group">
                                    <label for="domain">{{__('Domain')}}</label>
                                    <input type="text" class="form-control" name="domain" id="domain"
                                           value="{{ old('domain', $org->getDomain()) }}" placeholder="Enter domain">
                                </div>
                                <div class="form-group">
                                    <label for="email">{{__('Email')}}</label>
                                    <input type="email" class="form-control" name="email" id="email"
                                           value="{{ old('email', $org->getEmail()) }}" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="tax_number">{{__('Tax')}}</label>
                                    <input type="text" class="form-control" name="tax_number" id="tax_number"
                                           value="{{ old('tax_number', $org->getTaxNumber()) }}" placeholder="Enter tax number">
                                </div>
                                <div class="form-group">
                                    <label for="address">{{__('Address')}}</label>
                                    <input type="text" class="form-control" name="address" id="address"
                                           value="{{ old('address', $org->getAddress()) }}" placeholder="Enter address">
                                </div>
                                <div class="form-group">
                                    <label for="register_date">{{__('Register date')}}</label>
                                    <div class="input-group date reservationdate" id="register_date_wrp" data-target-input="nearest">
                                        <input type="text" name="register_date" id="register_date"
                                               value="{{ old('register_date', $org->getRegisterDate()) }}"
                                               class="form-control datetimepicker-input" data-target="#register_date_wrp"/>
                                        <div class="input-group-append" data-target="#register_date_wrp" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="description">{{__('Description')}}</label>
                                    <textarea class="form-control" rows="3" name="description" id="description"
                                              placeholder="{{__('Enter description')}}">{{ old('description', $org->getDescription()) }}</textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                <a href="{{ route('manager_organization_list') }}" class="btn btn-secondary">{{__('Back')}}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('custom-scripts')
    @include('manager::includes.sidebar_script')
    <script src="{{url('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{url('plugins/jquery-validation/additional-methods.min.js')}}"></script>
    <script src="{{url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    <script>
        $('#nav-manager-organization').addClass('active')

        $('#form-organization').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                domain: {
                    required: true,
                    maxlength: 255
                },
                register_date: {
                    required: true,
                    date: true
                },
                phone_number: {
                    required: true,
                    digits: true,
                    maxlength: 10,
                },
                email: {
                    required: true,
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

        $('.reservationdate').datetimepicker({
            format: 'YYYY-MM-DD'
        });
    </script>
@stop
