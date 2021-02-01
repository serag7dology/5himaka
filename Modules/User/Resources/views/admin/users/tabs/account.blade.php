<div class="row">
    <div class="col-md-8">
        {{ Form::text('first_name', trans('user::attributes.users.first_name'), $errors, $user, ['required' => true]) }}
        {{ Form::text('last_name', trans('user::attributes.users.last_name'), $errors, $user, ['required' => true]) }}
        {{ Form::email('email', trans('user::attributes.users.email'), $errors, $user, ['required' => true]) }}
        {{ Form::select('roles', trans('user::attributes.users.roles'), $errors, $roles, $user, ['multiple' => true, 'required' => true, 'class' => 'selectize prevent-creation']) }}
        {{ Form::text('national_id', trans('user::attributes.users.national_id'), $errors, $user) }}
        {{ Form::text('mobile', trans('user::attributes.users.mobile'), $errors, $user) }}
        {{ Form::text('pin', trans('user::attributes.users.pin'), $errors, $user) }}
        {{ Form::text('question', trans('user::attributes.users.question'), $errors, $user) }}
        {{ Form::text('answer', trans('user::attributes.users.answer'), $errors, $user) }}

        @if (request()->routeIs('admin.users.create'))
            {{ Form::password('password', trans('user::attributes.users.password'), $errors, null, ['required' => true]) }}
            {{ Form::password('password_confirmation', trans('user::attributes.users.password_confirmation'), $errors, null, ['required' => true]) }}
        @endif

        @if (request()->routeIs('admin.users.edit'))
            {{ Form::checkbox('is_paid', trans('user::attributes.users.is_paid'), trans('user::users.form.is_paid'), $errors, $user, ['disabled' => $user->id === $currentUser->id, 'checked' => old('is_paid', $user->isPaid())]) }}
            {{ Form::checkbox('activated', trans('user::attributes.users.activated'), trans('user::users.form.activated'), $errors, $user, ['disabled' => $user->id === $currentUser->id, 'checked' => old('activated', $user->isActivated())]) }}
            {{ Form::number('cadeau_acount', trans('user::attributes.users.cadeau_acount'), $errors, $user,['min'=>$user->cadeau_acount]) }}
        @endif
    </div>
</div>
