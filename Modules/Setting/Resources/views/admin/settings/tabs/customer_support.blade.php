<div class="row">
    <div class="col-md-8">
        {{ Form::text('translatable[customer_support_phone]', trans('setting::attributes.translatable.customer_support_phone'), $errors, $settings, ['required' => true]) }}
        {{ Form::text('translatable[customer_support_mail]', trans('setting::attributes.translatable.customer_support_mail'), $errors, $settings, ['required' => true]) }}
        {{ Form::text('translatable[customer_support_work_hours_and_days]', trans('setting::attributes.translatable.customer_support_work_hours_and_days'), $errors, $settings, ['required' => true]) }}
        
    </div>
</div>
