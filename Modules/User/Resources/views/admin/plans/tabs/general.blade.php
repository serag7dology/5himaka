<div class="row">
    <div class="col-sm-8">

        {{ Form::select('user_id', trans('user::attributes.plans.user_id'), $errors, $users, $usersPlan) }}
        {{ Form::select('parent_id', trans('user::attributes.plans.parent_id'), $errors, $parents, $usersPlan) }}

        {{ Form::select('plan_id', trans('user::attributes.plans.plan_id'), $errors, $plans, $usersPlan) }}
        {{ Form::text('start_date', trans('user::attributes.plans.start_date'), $errors, $usersPlan, ['class' => 'datetime-picker']) }}
        {{ Form::text('end_date', trans('user::attributes.plans.end_date'), $errors, $usersPlan, ['class' => 'datetime-picker']) }}
    </div>
</div>
