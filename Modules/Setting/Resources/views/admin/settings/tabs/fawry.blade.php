<div class="row">
    <div class="col-md-8">
        {{ Form::checkbox('fawry-enabled', trans('setting::attributes.fawry_enabled'), trans('setting::settings.form.fawry_enabled'), $errors, $settings,['onClick'=>'fawryChecked()']) }}
        {{ Form::text('translatable[fawry_label]', trans('setting::attributes.fawry_label'), $errors, $settings, ['required' => true]) }}
        {{ Form::textarea('translatable[fawry_description]', trans('setting::attributes.fawry_description'), $errors, $settings, ['rows' => 3, 'required' => true]) }}

        <div style="display:{{ old('fawry-enabled', array_get($settings, 'fawry-enabled')) ? 'block' : 'none' }}" id="fawry-fields">
            {{ Form::text('fawry_merchant_code', trans('setting::attributes.fawry_merchant_code'), $errors, $settings, ['required' => true]) }}
            {{ Form::password('fawry_merchant_sec_key', trans('setting::attributes.fawry_merchant_sec_key'), $errors, $settings, ['required' => true]) }}
        </div>
    </div>
</div>
<script>
function fawryChecked(){
    document.getElementById('fawry-fields').style.display = (document.getElementById('fawry-fields').style.display == 'none') ? 'block' : 'none';
}
</script>