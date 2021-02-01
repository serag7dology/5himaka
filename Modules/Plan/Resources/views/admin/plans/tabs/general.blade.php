<div class="row">
    <div class="col-md-8">
    
        {{ Form::number('subscription_cost', trans('plan::attributes.subscription_cost'), $errors, $plan, ['required' => true,'step'=>'0.1']) }}

        {{ Form::select('currency', trans('plan::attributes.currency'), $errors, trans('plan::plans.form.currencies'), $plan,['required'=>true]) }}
      
        {{ Form::select('duration', trans('plan::attributes.duration'), $errors, trans('plan::plans.form.duration'), $plan,['required'=>true]) }}

        {{ Form::number('limit', trans('plan::attributes.limit'), $errors, $plan, ['required' => true,'step'=>'0.1']) }}

        {{ Form::number('commission', trans('plan::attributes.commission'), $errors, $plan, ['required' => true,'step'=>'0.1']) }}

        {{ Form::number('max_people', trans('plan::attributes.num_invitations'), $errors, $plan, ['required' => true]) }}

        {{ Form::number('min_commission_to_appear', trans('plan::attributes.min_commission_to_appear'), $errors, $plan, ['required' => true,'step'=>'0.1']) }}

    </div>
</div>
