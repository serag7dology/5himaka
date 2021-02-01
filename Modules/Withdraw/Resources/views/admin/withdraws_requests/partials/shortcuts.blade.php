@push('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('admin::admin.shortcuts.back_to_index', ['name' => trans('withdraw::withdraws.withdraw')]) }}</dd>
    </dl>
@endpush

@push('scripts')
    <script>
        keypressAction([
            { key: 'b', route: "{{ route('admin.withdraw_requests.index') }}" }
        ]);

        $("#withdraw_method_select").change(function(){
            $.ajax({
                type:'POST',
                url:"{{ route('admin.withdraw_requests.field') }}",
                dataType:'html',
                data:{
                        _token:"{{csrf_token()}}",
                        step_id:step_id
                        },
                success:function(data){
                    $(".subject").html(data);
                    
                }
            });
        });
    </script>
@endpush
