@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.create', ['resource' => trans('plan::plans.plan')]))

    <li><a href="{{ route('admin.plans.index') }}">{{ trans('plan::plans.plans') }}</a></li>
    <li class="active">{{ trans('admin::resource.create', ['resource' => trans('plan::plans.plan')]) }}</li>
@endcomponent

@section('content')
    <form method="POST" action="{{ route('admin.plans.store') }}" class="form-horizontal" id="plan-create-form" novalidate>
        {{ csrf_field() }}

        {!! $tabs->render(compact('plan')) !!}
    </form>
@endsection

@include('plan::admin.plans.partials.shortcuts')
