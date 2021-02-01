<div class="row">
    <div class="col-md-8">
        {{ Form::number('translatable[min_commission_to_purchasing_and_selling]', trans('setting::attributes.translatable.min_commission_to_purchasing_and_selling'), $errors, $settings, ['required' => true]) }}
        {{ Form::number('translatable[min_commission_to_wihdraw]', trans('setting::attributes.translatable.min_commission_to_wihdraw'), $errors, $settings, ['required' => true]) }}
        {{ Form::number('translatable[max_points]', trans('setting::attributes.translatable.max_points'), $errors, $settings, ['required' => true]) }}
        {{ Form::number('translatable[min_points_to_convert_to_money]', trans('setting::attributes.translatable.min_points_to_convert_to_money'), $errors, $settings, ['required' => true]) }}
        {{ Form::number('translatable[each_member_equal_to_points]', trans('setting::attributes.translatable.each_member_equal_to_points'), $errors, $settings, ['required' => true,'step'=>0.1]) }}
        {{ Form::number('translatable[each_point_equal_to_money]', trans('setting::attributes.translatable.each_point_equal_to_money'), $errors, $settings, ['required' => true,'step'=>0.1]) }}
        
    </div>
</div>
