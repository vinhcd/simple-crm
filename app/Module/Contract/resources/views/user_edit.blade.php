<?php
/* @var \App\Module\Contract\Block\ContractUserEdit $contractUserEditBlock */

$contractUser = $contractUserEditBlock->getContractUser();
$contractData = $contractUserEditBlock->getContractData();
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
                            <h3 class="card-title">{{__('Create/Edit user contract')}}</h3>
                        </div>
                        <form id="form-user" action="{{route('contract_user_create_update', $contractUser->getId())}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $contractUser->getId() }}">
                            @if($contractUser->getId())
                            <input type="hidden" name="user" value="{{ $contractUser->getUserId() }}">
                            @endif
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="user">{{__('User')}}</label>
                                    <select class="form-control select2" name="user" id="user" @if($contractUser->getId()) disabled="disabled" @endif>
                                        <option value=""></option>
                                        @foreach($contractUserEditBlock->getAllUsers() as $user)
                                            <option value="{{$user->getId()}}" @if($contractUser->getUserId() == $user->getId()) selected @endif>{{$user->getFullName()}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="contract">{{__('Contract')}}</label>
                                    <select class="form-control select2" name="contract" id="contract" onchange="setTemplateOption()">
                                        <option value=""></option>
                                        @foreach($contractData as $contract)
                                            <option value="{{$contract['id']}}" @if($contract['id'] == $contractUser->getContractId()) selected @endif>{{$contract['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="template">{{__('Template')}}</label>
                                    <select class="form-control select2" name="template" id="template"></select>
                                </div>
                                <div class="form-group">
                                    <label for="start">{{__('Start')}}</label>
                                    <div class="input-group date reservationdate" id="start_wrp" data-target-input="nearest">
                                        <input type="text" name="start" id="start" value="{{ old('start', $contractUser->getStart()) }}"
                                               class="form-control datetimepicker-input" data-target="#start_wrp"/>
                                        <div class="input-group-append" data-target="#start_wrp" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="end">{{__('End')}}</label>
                                    <div class="input-group date reservationdate" id="end_wrp" data-target-input="nearest">
                                        <input type="text" name="end" id="end" value="{{ old('end', $contractUser->getEnd()) }}"
                                               class="form-control datetimepicker-input" data-target="#end_wrp"/>
                                        <div class="input-group-append" data-target="#end_wrp" data-toggle="datetimepicker">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="status">{{__('Status')}}</label>
                                    <select class="form-control" name="status" id="status">
                                        <option value="1" @if($contractUser->getActive()) selected @endif>{{__('Active')}}</option>
                                        <option value="0" @if(!$contractUser->getActive()) selected @endif>{{__('In active')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                <a href="{{ route('contract_user_list') }}" class="btn btn-secondary">{{__('Back')}}</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('custom-scripts')
    @include('contract::includes.sidebar_script')
    <script src="{{url('plugins/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{url('plugins/jquery-validation/additional-methods.min.js')}}"></script>
    <script src="{{url('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{url('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
    @include('contract::includes.js_validate')

    <script>
        $('#nav-contract-user').addClass('active');

        $('#form-user').validate({
            rules: {
                user: {
                    required: true,
                },
                contract: {
                    required: true,
                },
                template: {
                    required: true,
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

    <script>
        var contractData = <?php echo json_encode($contractData) ?>;

        function setTemplateOption() {
            var contractId = $('#contract').val();
            if (contractData.hasOwnProperty(contractId)) {
                var options = '';
                $.each(contractData[contractId].templates, function (key, template) {
                    options += '<option value="' + template.id + '">' + template.name + '</option>';
                })
                $('#template').html(options);
            }
        }
        setTemplateOption();
    </script>
@stop
