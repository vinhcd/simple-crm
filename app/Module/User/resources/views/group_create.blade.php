<?php
/* @var \App\Module\User\Block\GroupEdit $groupEditBlock */

$group = $groupEditBlock->getGroup();
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
                @if($group->getName() != \App\Module\User\Api\Data\GroupInterface::SUPER_ADMIN)
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{__('Create/edit group')}}</h3>
                        </div>
                        <form id="form-user" action="{{ route('user_group_create_update', ['id' => $group->getId()]) }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $group->getId() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{__('Group name')}}*</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ $group->getName() }}" placeholder="{{__('Enter unique name')}}">
                                </div>
                                <div class="form-group">
                                    <label for="display_name">{{__('Display name')}}*</label>
                                    <input type="text" class="form-control" name="display_name" id="display_name" value="{{ $group->getDisplayName() }}" placeholder="{{__('Enter display name')}}">
                                </div>
                                <div class="form-group">
                                    <label for="priority">{{__('Priority')}}</label>
                                    <input type="text" class="form-control" name="priority" id="priority" value="{{ $group->getPriority() }}" placeholder="{{__('Priority')}}">
                                </div>
                                <div class="form-group">
                                    <label for="description">{{__('Description')}}</label>
                                    <input type="text" class="form-control" name="description" id="description" value="{{ $group->getDescription() }}" placeholder="{{__('Enter description')}}">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                <a href="{{ route('user_group_list') }}" class="btn btn-secondary">{{__('Back')}}</a>
                            </div>
                        </form>
                    </div>
                </div>
                @endif

                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{__('List of users')}}</h3>
                        </div>
                        <form id="form-user" action="{{ route('user_group_update_users', ['id' => $group->getId()]) }}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <select class="duallistbox" multiple="multiple" name="users[]">
                                                @foreach($groupEditBlock->getUsersData() as $user)
                                                <option @if($user['ingroup']) selected @endif value="{{$user['id']}}">{{$user['name']}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">{{__('Choose user from the LEFT and add to the RIGHT to put into group')}}</div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
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
    <script src="{{url('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>
    <script>
        $('#nav-user-group').addClass('active');
        $('#form-user').validate({
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
            selectorMinimalHeight: 200
        })
    </script>
@stop
