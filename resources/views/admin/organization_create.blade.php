@extends('admin.layouts.master')

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
                        <form action="{{route('admin_organization_create')}}" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{__('Organization name')}}</label>
                                    <input type="text" class="form-control" name="name" id="name" placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                    <label for="phone_number">{{__('Phone #')}}</label>
                                    <input type="text" class="form-control" name="phone_number" id="phone_number" placeholder="Enter phone">
                                </div>
                                <div class="form-group">
                                    <label for="tax_number">{{__('Tax #')}}</label>
                                    <input type="text" class="form-control" name="tax_number" id="tax_number" placeholder="Enter tax number">
                                </div>
                                <div class="form-group">
                                    <label for="address">{{__('Address')}}</label>
                                    <input type="text" class="form-control" name="address" id="address" placeholder="Enter address">
                                </div>
                                <div class="form-group">
                                    <label for="register_date">{{__('Register date')}}</label>
                                    <input type="text" class="form-control" name="register_date" id="register_date" placeholder="Enter register date">
                                </div>
                                <div class="form-group">
                                    <label for="plan_id">{{__('Plan')}}</label>
                                    <input type="text" class="form-control" name="plan_id" id="plan_id" placeholder="Enter plan">
                                </div>
                                <div class="form-group">
                                    <label for="comment">{{__('Comment')}}</label>
                                    <input type="text" class="form-control" name="comment" id="comment" placeholder="Enter comment">
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
        $('#nav-organization').addClass('active')
    </script>
@stop
