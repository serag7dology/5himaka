@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.create', ['resource' => trans('user::users.plans.plan')]))

    <li><a href="{{ route('admin.users_plans.index') }}">{{ trans('plan::plans.plans') }}</a></li>
    <li class="active">{{ trans('admin::resource.create', ['resource' => trans('user::users.plans.plans')]) }}</li>
@endcomponent

@section('content')
    <form method="POST" action="{{ route('admin.users_plans.store') }}" class="form-horizontal" id="plan-create-form" novalidate>
        {{ csrf_field() }}
        {!! $tabs->render(compact('usersPlan')) !!}

    </form>
@endsection

