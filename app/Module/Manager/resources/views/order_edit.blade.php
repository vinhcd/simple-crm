<?php
/* @var \App\Module\Manager\Block\OrderEdit $orderEditBlock */

$order = $orderEditBlock->getOrder();
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
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{__('Create/Edit order')}}</h3>
                        </div>
                        <form id="form-order" action="{{route('manager_order_edit', $order->getId())}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $order->getId() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="plan">{{__('Plan')}}</label>
                                    <select class="form-control" name="plan" id="plan">
                                        @foreach($orderEditBlock->getPlans() as $plan)
                                            <option value="{{$plan->getId()}}"
                                                    @if($plan->getId() == $order->getPlanId()) selected @endif>
                                                {{$plan->getName()}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="organization">{{__('Organization')}}</label>
                                    <select class="form-control select2" name="organization" id="organization">
                                        @foreach($orderEditBlock->getOrganizations() as $organization)
                                            <option value="{{$organization->getId()}}"
                                                    @if($organization->getId() == $order->getOrganizationId()) selected @endif>
                                                {{$organization->getName()}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="start">{{__('Start')}}</label>
                                    <div class="input-group date reservationdate" id="start_wrp" data-target-input="nearest">
                                        <input type="text" name="start" id="start" value="{{ old('start', $order->getStart()) }}"
                                               class="form-control datetimepicker-input" data-target="#start_wrp"/>
                                        <div class="input-group-append" data-target="#start_wrp" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="end">{{__('End')}}</label>
                                    <div class="input-group date reservationdate" id="end_wrp" data-target-input="nearest">
                                        <input type="text" name="end" id="end" value="{{ old('end', $order->getEnd()) }}"
                                               class="form-control datetimepicker-input" data-target="#end_wrp"/>
                                        <div class="input-group-append" data-target="#end_wrp" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="monthly_price">{{__('Monthly price')}}</label>
                                    <input type="text" class="form-control" name="monthly_price" id="monthly_price"
                                           value="{{ old('address', $order->getMonthlyPrice()) }}" placeholder="Enter price">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                <a href="{{ route('manager_order_list') }}" class="btn btn-secondary">{{__('Back')}}</a>
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
    <script src="{{url('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    @include('contract::includes.js_validate')

    <script>
        $('#nav-manager-order').addClass('active');

        $('#form-order').validate({
            rules: {
                plan: {
                    required: true,
                },
                organization: {
                    required: true,
                },
                monthly_price: {
                    required: true,
                    number: true,
                    min: 0,
                },
                start: {
                    required: true,
                    date: true
                },
                end: {
                    required: true,
                    date: true,
                    dateGreaterThan: '#start'
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
        $('.select2').select2({theme: 'bootstrap4'});
    </script>
@stop
