@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('withdraw::withdraws.withdraw'))

    <li class="active">{{ trans('withdraw::withdraws.withdraw') }}</li>
@endcomponent

@component('admin::components.page.index_table')
    @slot('buttons', ['create'])
    @slot('resource', 'withdraws_ways')
    @slot('name', trans('withdraw::withdraws.withdraw_create'))

    @component('admin::components.table')
        @slot('thead')
            <tr>
                @include('admin::partials.table.select_all')

                <th>{{ trans('withdraw::withdraws.table.name') }}</th>
                <th>{{ trans('withdraw::withdraws.table.field_name') }}</th>
                <th>{{ trans('withdraw::withdraws.table.status') }}</th>
         

                <th data-sort>{{ trans('admin::admin.table.created') }}</th>
            </tr>
        @endslot
    @endcomponent
@endcomponent

@push('scripts')
    <script>
        new DataTable('#withdraws_ways-table .table', {
            columns: [
                { data: 'checkbox', orderable: false, searchable: false, width: '3%' },
                { data: 'name', name: 'translations.name', orderable: false, defaultContent: '' },
                { data: 'field_name', name: 'translations.field_name', orderable: false, defaultContent: '' },
                { data: 'status', name: 'translations.status', orderable: false, defaultContent: '' },

                { data: 'created', name: 'created_at', width: '30%' },
            ],
        });
    </script>
@endpush
