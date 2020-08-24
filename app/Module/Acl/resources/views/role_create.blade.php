<?php
/* @var \App\Module\Acl\Block\RoleEdit $roleEditBlock */

$role = $roleEditBlock->getRole();
?>
@extends('layouts.master')

@section('custom-head')
    <link rel="stylesheet" href="{{url('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <form id="form-role" action="{{ route('role_create_update', ['id' => $role->getId()]) }}" method="post">
                            @csrf
                            <div class="card-header d-flex p-0">
                                <h3 class="card-title p-3">{{__('Create/edit role')}}</h3>
                                <ul class="nav nav-pills ml-auto p-2">
                                    <li class="nav-item"><a class="nav-link active" href="#tab_role" data-toggle="tab">{{__('General')}}</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#tab_group" data-toggle="tab">{{__('Edit groups')}}</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#tab_user" data-toggle="tab">{{__('Edit users')}}</a></li>
                                </ul>
                            </div>
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_role">
                                            <input type="hidden" name="id" value="{{ $role->getId() }}">
                                            <div class="form-group">
                                                <label for="name">{{__('Role name')}}*</label>
                                                <input type="text" class="form-control" name="name" id="name" value="{{ $role->getName() }}" placeholder="{{__('Enter name')}}">
                                            </div>
                                            <div class="form-group">
                                                <label for="active">{{__('Active')}}</label>
                                                <select class="form-control" name="active" id="active">
                                                    <option value="0">{{__('False')}}</option>
                                                    <option value="1" selected>{{__('True')}}</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="description">{{__('Description')}}</label>
                                                <textarea class="form-control" rows="3" name="description" id="description" placeholder="{{__('Enter description')}}">{{ $role->getDescription() }}</textarea>
                                            </div>
                                    </div>
                                    <div class="tab-pane" id="tab_group">
                                        <div class="form-group">
                                            <select class="duallistbox" multiple="multiple" name="groups[]">
                                                @foreach($roleEditBlock->getGroupsData() as $group)
                                                    <option @if($group['in_role']) selected @endif value="{{$group['id']}}">{{$group['name']}}</option>
                                                @endforeach
                                            </select>
                                            {{__('Choose groups from the LEFT and add to the RIGHT to put into role')}}
                                        </div>
                                    </div>
                                    <div class="tab-pane" id="tab_user">
                                        <div class="form-group">
                                            <select class="duallistbox" multiple="multiple" name="users[]">
                                                @foreach($roleEditBlock->getUsersData() as $user)
                                                    <option @if($user['in_role']) selected
                                                            @endif value="{{$user['id']}}">{{$user['name']}}</option>
                                                @endforeach
                                            </select>
                                            {{__('Choose users from the LEFT and add to the RIGHT to put into role')}}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                    <a href="{{ route('role_list') }}" class="btn btn-secondary">{{__('Back')}}</a>
                                </div>
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
    <script src="{{url('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
    <script>
        $('#nav-role').addClass('active');
        $('#form-role').validate({
            rules: {
                name: {
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
            selectorMinimalHeight: 200
        })
    </script>
@stop
