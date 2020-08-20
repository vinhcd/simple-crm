@extends('layouts.master')

@section('custom-head')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{url('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{url('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@show

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">{{__('Plan list')}}</h3>
                        </div>
                        <div class="card-body">
                            <table id="example2" class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 3%">ID</th>
                                    <th>Plan name</th>
                                    <th>Price</th>
                                    <th>Max staffs</th>
                                    <th>Trial days</th>
                                    <th style="width: 5%">Edit</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php /* @var \App\Module\Manager\Api\Data\PlanInterface $plan*/ ?>
                                @foreach ($plans as $plan)
                                <tr>
                                    <td>{{$plan->id}}</td>
                                    <td>{{$plan->name}}</td>
                                    <td>{{$plan->price}}</td>
                                    <td>{{$plan->max_staff}}</td>
                                    <td>{{$plan->days_of_trial}}</td>
                                    <td>
                                        <a href="{{ route('manager_plan_create_update', $plan->id) }}"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;
                                        <a href="{{ route('manager_plan_delete', $plan->id) }}"><i class="fa fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                </tbody>
                                @endforeach
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <a href="{{route('manager_plan_create_update')}}">
                        <button class="btn btn-dark">{{__('Create plan')}}</button>
                    </a>
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
