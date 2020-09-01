<?php
/* @var \App\Module\Contract\Block\ContractTemplateEdit $templateEditBlock */

$contractTemplate = $templateEditBlock->getContractTemplate();
?>

@extends('layouts.master')

@section('custom-head')
    <link rel="stylesheet" href="{{url('plugins/summernote/summernote-bs4.min.css')}}">
@stop

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-6">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">{{__('Create/Edit template')}}</h3>
                        </div>
                        <form action="{{route('contract_template_create_update', $contractTemplate->getId())}}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $contractTemplate->getId() }}">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">{{__('Name')}}</label>
                                    <input type="text" class="form-control" name="name" id="name"
                                           value="{{ old('name', $contractTemplate->getName()) }}"
                                           placeholder="Enter name">
                                </div>
                                <div class="form-group">
                                    <label for="contract_id">{{__('Contract')}}</label>
                                    <select class="form-control" name="contract_id" id="contract_id">
                                        @foreach($templateEditBlock->getContracts() as $contract)
                                        <option value="{{$contract['id']}}" @if($contractTemplate->getContractId() == $contract['id']) selected @endif>{{$contract['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="content">{{__('Content')}}</label>
                                    <textarea class="form-control" name="content" id="content"
                                              placeholder="{{__('Enter description')}}">{{ old('content', $contractTemplate->getContent()) }}</textarea>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                                <a href="{{ route('contract_template_list') }}" class="btn btn-secondary">{{__('Back')}}</a>
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
    <script src="{{url('plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script>
        $('#nav-contract-template').addClass('active');

        $('#content').summernote({height: 150});
    </script>
@stop
