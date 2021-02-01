@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('user::users.plans.plans'))

    <li class="active">{{ trans('user::users.plans.plans') }}</li>
@endcomponent

@component('admin::components.page.index_table')
    @slot('buttons', ['create'])
    @slot('resource', 'users_plans')
    @slot('name', trans('user::users.plans.userplan'))

    @component('admin::components.table')
        @slot('thead')
            <tr>
                @include('admin::partials.table.select_all')

                <th>{{ trans('user::users.plans.table.customer_name') }}</th>
                <th>{{ trans('user::users.plans.table.customer_parent_name') }}</th>

                <th>{{ trans('user::users.plans.table.plan_cost') }}</th>
                <th>{{ trans('user::users.plans.table.start_date') }}</th>
                <th>{{ trans('user::users.plans.table.end_date') }}</th>
           

                <th data-sort>{{ trans('admin::admin.table.created') }}</th>
            </tr>
        @endslot
    @endcomponent
@endcomponent

@push('scripts')
    <script>
        new DataTable('#users_plans-table .table', {
            columns: [
                { data: 'checkbox', orderable: false, searchable: false, width: '3%' },

                { data: 'customer_name', name: 'customer_name', orderable: false, defaultContent: '' },
                { data: 'parent_name', name: 'parent_name', orderable: false, defaultContent: '' },

                { data: 'plan_cost', name: 'plan_cost', orderable: false, defaultContent: '' },

                { data: 'start_date', name: 'end_date', orderable: false, defaultContent: '' },
                { data: 'end_date', name: 'end_date', orderable: false, defaultContent: '' },
                

                { data: 'created', name: 'created_at', width: '30%' },
            ],
        });
    </script>
@endpush
