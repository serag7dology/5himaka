@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('withdraw::withdraws.withdraw_requests'))

    <li class="active">{{ trans('withdraw::withdraws.withdraw_requests') }}</li>
@endcomponent

@component('admin::components.page.index_table')
    
    @slot('resource', 'withdraw_requests')
    @slot('name', trans('withdraw::withdraws.withdraw_requests_create'))
    @component('admin::components.table')
        @slot('thead')
            <tr>
                @include('admin::partials.table.select_all')
                <th>{{ trans('withdraw::withdraws.table.withdraw_way_name') }}</th>
                <th>{{ trans('withdraw::withdraws.table.withdraw_user_name') }}</th>
                <th>{{ trans('withdraw::withdraws.table.withdraw_field_name') }}</th>
                <th>{{ trans('withdraw::withdraws.table.withdraw_field_value') }}</th>
                <th>{{ trans('withdraw::withdraws.table.amount') }}</th>
                <th>{{ trans('withdraw::withdraws.table.approved') }}</th>

                <th data-sort>{{ trans('admin::admin.table.created') }}</th>
            </tr>
        @endslot
    @endcomponent
@endcomponent

@push('scripts')
    <script>
        new DataTable('#withdraw_requests-table .table', {
            columns: [
                { data: 'checkbox', orderable: false, searchable: false, width: '3%' },
                { data: 'withdraw_method.name', name: 'translations.withdraw_method.name', orderable: false, defaultContent: '' },
                { data: 'customer_name', name: 'customer_name', orderable: false, defaultContent: '' },
                { data: 'withdraw_method.field_name', name: 'translations.withdraw_method.field_name', orderable: false, defaultContent: '' },
                { data: 'withdraw_field_value', name: 'translations.withdraw_field_value', orderable: false, defaultContent: '' },
                { data: 'amount', name: 'translations.amount', orderable: false, defaultContent: '' },
                { data: 'status', name: 'confirm', searchable: false },

                { data: 'created', name: 'created_at', width: '30%' },
            ],
        });
    </script>
@endpush
