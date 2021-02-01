@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.edit', ['resource' => trans('user::users.plans.plan')]))

    <li><a href="{{ route('admin.users_plans.index') }}">{{ trans('user::users.plans.plans') }}</a></li>
    <li class="active">{{ trans('admin::resource.edit', ['resource' => trans('user::users.plans.plan')]) }}</li>
@endcomponent

@section('content')
    <form method="POST" action="{{ route('admin.users_plans.update', $usersPlan) }}" class="form-horizontal" id="plan-edit-form" novalidate>
        {{ csrf_field() }}
        {{ method_field('put') }}

        {!! $tabs->render(compact('usersPlan')) !!}
    </form>
@endsection

