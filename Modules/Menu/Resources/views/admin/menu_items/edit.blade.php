@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.edit', ['resource' => trans('menu::menu_items.menu_item')]))
    @slot('subtitle', $menuItem->title)

    <li><a href="{{ route('admin.menus.edit', $menuId) }}">{{ trans('admin::resource.edit', ['resource' => trans('menu::menus.menu')]) }}</a></li>
    <li class="active">{{ trans('admin::resource.edit', ['resource' => trans('menu::menu_items.menu_item')]) }}</li>
@endcomponent

@section('content')
    <form method="POST" action="{{ route('admin.menus.items.update', [$menuId, $menuItem]) }}" class="form-horizontal" id="menu-item-edit-form" novalidate>
        {{ csrf_field() }}
        {{ method_field('put') }}

        {!! $tabs->render(compact('menuId', 'menuItem')) !!}
    </form>
@endsection

@include('menu::admin.menu_items.partials.shortcuts')
