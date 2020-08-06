@extends('admin.layouts.master')

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
                        <form action="{{route('admin_plan_create')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{__('Plan name')}}</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                    <label for="price">{{__('Price')}}</label>
                                    <input type="text" class="form-control" name="price" id="price" placeholder="Enter price">
                                </div>
                                <div class="form-group">
                                    <label for="max_staff">{{__('Max staff')}}</label>
                                    <input type="text" class="form-control" name="max_staff" id="max_staff" placeholder="Enter maximum staff">
                                </div>
                                <div class="form-group">
                                    <label for="trial_days">{{__('Trial days')}}</label>
                                    <input type="text" class="form-control" name="trial_days" id="trial_days" placeholder="Enter trial days">
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
    <script>
        $('#nav-plan').addClass('active')
    </script>
@stop
