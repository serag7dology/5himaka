<div class="row">
    <div class="col-md-8">        
    @if($isCustomer==false)
    {{ Form::select('user_id', trans('withdraw::attributes.requests.user_id'), $errors, $users, $withdrawsRequest,['required' => true]) }}
    @else
    {{ Form::hidden('user_id', $user_id,$errors,['required' => true]) }}
    @endif
    {{ Form::select('withdraw_way_id', trans('withdraw::attributes.requests.withdraw_way_id'), $errors, $withdraw_methods, $withdrawsRequest,['required' => true,'id'=>'withdraw_method_select']) }}

    {{ Form::text('withdraw_field_value', trans('withdraw::attributes.requests.withdraw_field_value'), $errors, $withdrawsRequest, ['required' => true]) }}

    {{ Form::textarea('withdraw_field_description', trans('withdraw::attributes.requests.withdraw_field_description'), $errors, $withdrawsRequest) }}

    {{ Form::number('amount', trans('withdraw::attributes.requests.amount'), $errors, $withdrawsRequest, ['required' => true]) }}
    @if($isCustomer==false)
    {{ Form::checkbox('confirm', trans('withdraw::attributes.requests.status'), trans('withdraw::attributes.requests.approve'), $errors, $withdrawsRequest) }}
    @endif
    </div>
</div>
