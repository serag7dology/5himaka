<div class="row">
    <div class="col-md-8">
        {{ Form::text('name', trans('withdraw::attributes.name'), $errors, $withdrawsWay, ['required' => true]) }}
        {{ Form::text('field_name', trans('withdraw::attributes.field_name'), $errors, $withdrawsWay, ['required' => true]) }}
        {{ Form::checkbox('is_active', trans('product::attributes.is_active'), trans('withdraw::attributes.enable_method'), $errors, $withdrawsWay) }}

    </div>
</div>
