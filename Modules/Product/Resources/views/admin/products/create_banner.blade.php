@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('admin::resource.create_banner', ['resource' => trans('product::attributes.banner')]))

    <li><a href="{{ route('admin.products.index') }}">{{ trans('product::products.products') }}</a></li>
    <li class="active">{{ trans('admin::resource.create_banner', ['resource' => trans('product::attributes.create_banner')]) }}</li>
@endcomponent

@section('content')
@if(session()->has('errors'))

{{session()->get('errors')}}
@endif
    <form method="POST" action="{{ route('admin.products.store_banner') }}" class="form-horizontal" enctype="multipart/form-data"  novalidate>
        {{ csrf_field() }}

        {{ Form::select('product_ids', trans('product::attributes.banner'), $errors, $product, $product, ['class' => 'selectize prevent-creation', 'multiple' => true,'required' =>true]) }}
    
        <div class="form-group">
            <label for="" class="col-md-3 control-label text-left">{{ trans('product::attributes.banner_image') }}</label>
            <div class="col-md-3">
            <input type="file" name="banner_image" class="form-control " required>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-md-3 control-label text-left">{{ trans('product::attributes.details') }}</label>
            <div class="col-md-9">
            <textarea name="details" id="" cols="30"class="form-control "rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label for="" class="col-md-3 control-label text-left">{{ trans('product::attributes.details_ar') }}</label>
            <div class="col-md-9">
            <textarea name="details_translation" id="" cols="30"class="form-control "rows="3"></textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-3"></div>
            <div class="col-md-3">
            <button type="submit" class="btn btn-primary btn-actions btn-create">{{ trans('product::attributes.save') }}</button>
            </div>
        </div>
   




    </form>
@endsection

@include('product::admin.products.partials.shortcuts')
