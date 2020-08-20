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
                        <?php /* @var \App\Module\Manager\Api\Data\PlanInterface $plan */ ?>
                        <form action="{{route('manager_plan_create_update', $plan->id)}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $plan->id }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{__('Plan name')}}</label>
                                    <input type="text" class="form-control" name="name" id="name" value="{{ $plan->name }}" placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                    <label for="price">{{__('Price')}}</label>
                                    <input type="text" class="form-control" name="price" id="price" value="{{ $plan->price }}" placeholder="Enter price">
                                </div>
                                <div class="form-group">
                                    <label for="max_staff">{{__('Max staff')}}</label>
                                    <input type="text" class="form-control" name="max_staff" id="max_staff" value="{{ $plan->max_staff }}" placeholder="Enter maximum staff">
                                </div>
                                <div class="form-group">
                                    <label for="trial_days">{{__('Trial days')}}</label>
                                    <input type="text" class="form-control" name="trial_days" id="trial_days" value="{{ $plan->days_of_trial }}" placeholder="Enter trial days">
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
    @include('manager::includes.sidebar_script')
    <script>
        $('#nav-manager-plan').addClass('active')
    </script>
@stop
