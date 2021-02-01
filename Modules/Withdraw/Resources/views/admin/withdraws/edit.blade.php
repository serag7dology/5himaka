@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.edit', ['resource' => trans('withdraw::withdraws.withdraw')]))
    @slot('subtitle', $withdrawsWay->name)

    <li><a href="{{ route('admin.withdraws_ways.index') }}">{{ trans('withdraw::withdraws.withdraws') }}</a></li>
    <li class="active">{{ trans('admin::resource.edit', ['resource' => trans('withdraw::withdraws.withdraw')]) }}</li>
@endcomponent

@section('content')
    <form method="POST" action="{{ route('admin.withdraws_ways.update', $withdrawsWay) }}" class="form-horizontal" id="withdraw-edit-form" novalidate>
        {{ csrf_field() }}
        {{ method_field('put') }}

        {!! $tabs->render(compact('withdrawsWay')) !!}
    </form>
@endsection

@include('withdraw::admin.withdraws.partials.shortcuts')
