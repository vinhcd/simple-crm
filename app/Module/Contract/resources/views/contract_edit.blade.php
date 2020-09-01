<?php
/* @var \App\Module\Contract\Block\ContractEdit $contractEditBlock */

$contract = $contractEditBlock->getContract();
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
                            <h3 class="card-title">{{__('Create/Edit contract')}}</h3>
                        </div>
                        <form action="{{route('contract_create_update', $contract->getId())}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $contract->getId() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{__('Name')}}</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="{{ old('name', $contract->getName()) }}"
                                           placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                    <label for="type">{{__('Type')}}</label>
                                    <input type="text" class="form-control" name="type" id="type"
                                           value="{{ old('type', $contract->getType()) }}"
                                           placeholder="Enter type">
                                </div>
                                <div class="form-group">
                                    <label for="description">{{__('Description')}}</label>
                                    <textarea class="form-control" rows="3" name="description" id="description"
                                              placeholder="{{__('Enter description')}}">{{ old('description', $contract->getDescription()) }}</textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                <a href="{{ route('contract_list') }}" class="btn btn-secondary">{{__('Back')}}</a>
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
    <script>
        $('#nav-contract-contract').addClass('active')
    </script>
@stop
