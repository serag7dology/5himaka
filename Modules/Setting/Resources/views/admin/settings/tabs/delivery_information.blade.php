<div class="row">
    <div class="col-md-8">
        {{ Form::textarea('translatable[5himaka]', trans('setting::attributes.translatable.5himaka'), $errors, $settings, ['required' => true]) }}
        {{ Form::textarea('translatable[delivery_info]', trans('setting::attributes.translatable.delivery_info'), $errors, $settings, ['required' => true]) }}
        {{ Form::textarea('translatable[return_policy]', trans('setting::attributes.translatable.return_policy'), $errors, $settings, ['required' => true]) }}
        
    </div>
</div>
