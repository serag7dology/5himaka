@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.edit', ['resource' => trans('plan::plans.plan')]))
    @slot('subtitle', $plan->name)

    <li><a href="{{ route('admin.plans.index') }}">{{ trans('plan::plans.plans') }}</a></li>
    <li class="active">{{ trans('admin::resource.edit', ['resource' => trans('plan::plans.plan')]) }}</li>
@endcomponent

@section('content')
    <form method="POST" action="{{ route('admin.plans.update', $plan) }}" class="form-horizontal" id="plan-edit-form" novalidate>
        {{ csrf_field() }}
        {{ method_field('put') }}

        {!! $tabs->render(compact('plan')) !!}
    </form>
@endsection

@include('plan::admin.plans.partials.shortcuts')
