@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.create', ['resource' => trans('withdraw::withdraws.withdraw_request')]))

    <li><a href="{{ route('admin.withdraw_requests.index') }}">{{ trans('withdraw::withdraws.withdraw_request') }}</a></li>
    <li class="active">{{ trans('admin::resource.create', ['resource' => trans('withdraw::withdraws.withdraw_request')]) }}</li>
@endcomponent

@section('content')
    <form method="POST" action="{{ route('admin.withdraw_requests.store') }}" class="form-horizontal" id="withdraw-create-form" novalidate>
        {{ csrf_field() }}

        {!! $tabs->render(compact('withdrawsRequest')) !!}
    </form>
@endsection

@include('withdraw::admin.withdraws_requests.partials.shortcuts')
