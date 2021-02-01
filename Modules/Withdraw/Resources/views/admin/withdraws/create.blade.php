@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.create', ['resource' => trans('withdraw::withdraws.withdraw')]))

    <li><a href="{{ route('admin.withdraws_ways.index') }}">{{ trans('withdraw::withdraws.withdraws') }}</a></li>
    <li class="active">{{ trans('admin::resource.create', ['resource' => trans('withdraw::withdraws.withdraw')]) }}</li>
@endcomponent

@section('content')
    <form method="POST" action="{{ route('admin.withdraws_ways.store') }}" class="form-horizontal" id="withdraw-create-form" novalidate>
        {{ csrf_field() }}

        {!! $tabs->render(compact('withdrawsWay')) !!}
    </form>
@endsection

@include('withdraw::admin.withdraws.partials.shortcuts')
