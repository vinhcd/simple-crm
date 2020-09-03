<?php
/* @var \App\Module\User\Block\DepartEdit $departmentEditBlock */

$department = $departmentEditBlock->getDepartment();
?>
@extends('layouts.master')

@section('custom-head')
    <link rel="stylesheet" href="{{url('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form id="form-depart" action="{{ route('user_depart_create_update', ['id' => $department->getId()]) }}" method="post">
                @csrf
                <div class="row">
                    <div class="col-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{__('Create/edit department')}}</h3>
                            </div>
                            <input type="hidden" name="id" value="{{ $department->getId() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{__('Name')}}*</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="{{ old('name', $department->getName()) }}" placeholder="{{__('Enter unique name')}}">
                                </div>
                                <div class="form-group">
                                    <label for="display_name">{{__('Display name')}}*</label>
                                    <input type="text" class="form-control" name="display_name" id="display_name"
                                           value="{{ old('display_name', $department->getDisplayName()) }}" placeholder="{{__('Enter display name')}}">
                                </div>
                                <div class="form-group">
                                    <label for="description">{{__('Description')}}</label>
                                    <textarea class="form-control" rows="3" name="description" id="description"
                                              placeholder="{{__('Enter description')}}">{{ old('description', $department->getDescription()) }}</textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                <a href="{{ route('user_depart_list') }}" class="btn btn-secondary">{{__('Back')}}</a>
                            </div>
                        </div>
                    </div>

                    <div class="col-6">
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">{{__('List of users')}}</h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select class="duallistbox" multiple="multiple" name="users[]">
                                                @foreach($departmentEditBlock->getUsersData() as $user)
                                                <option @if($user['in_department']) selected @endif value="{{$user['id']}}">{{$user['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">{{__('Choose user from the LEFT and add to the RIGHT to put into department')}}</div>
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
    <script src="{{url('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
    <script>
        $('#nav-user-depart').addClass('active');
        $('#form-depart').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                display_name: {
                    required: true,
                    maxlength: 255
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
        $('.duallistbox').bootstrapDualListbox({
            selectorMinimalHeight: 224
        })
    </script>
@stop
