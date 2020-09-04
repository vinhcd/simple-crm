<?php
/* @var \App\Module\Manager\Block\PlanEdit $planEditBlock */

$plan = $planEditBlock->getPlan();
?>

@extends('layouts.master')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{__('Creating plan')}}</h3>
                        </div>
                        <form id="form-plan" action="{{route('manager_plan_edit', $plan->getId())}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $plan->getId() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{__('Plan name')}}</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="{{ old('name', $plan->getName()) }}" placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                    <label for="monthly_price">{{__('Monthly price')}}</label>
                                    <input type="text" class="form-control" name="monthly_price" id="monthly_price"
                                           value="{{ old('monthly_price', $plan->getMonthlyPrice()) }}" placeholder="Enter price">
                                </div>
                                <div class="form-group">
                                    <label for="max_staff">{{__('Max staff')}}</label>
                                    <input type="text" class="form-control" name="max_staff" id="max_staff"
                                           value="{{ old('max_staff',  $plan->getMaxStaff()) }}" placeholder="Enter maximum staff">
                                </div>
                                <div class="form-group">
                                    <label for="trial_days">{{__('Trial days')}}</label>
                                    <input type="text" class="form-control" name="trial_days" id="trial_days"
                                           value="{{ old('trial_days', $plan->getTrialDays()) }}" placeholder="Enter trial days">
                                </div>
                                <div class="form-group">
                                    <label for="description">{{__('Description')}}</label>
                                    <textarea class="form-control" rows="3" name="description" id="description"
                                              placeholder="{{__('Enter description')}}">{{ old('description', $plan->getDescription()) }}</textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                <a href="{{ route('manager_plan_list') }}" class="btn btn-secondary">{{__('Back')}}</a>
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
    <script>
        $('#nav-manager-plan').addClass('active');

        $('#form-plan').validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255,
                },
                monthly_price: {
                    required: true,
                    number: true,
                    min: 0,
                },
                max_staff: {
                    required: true,
                    digits: true,
                    min: 0,
                },
                trial_days: {
                    required: true,
                    digits: true,
                    min: 0,
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
    </script>
@stop
