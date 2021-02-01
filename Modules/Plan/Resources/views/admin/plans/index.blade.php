@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('plan::plans.plans'))

    <li class="active">{{ trans('plan::plans.plans') }}</li>
@endcomponent

@component('admin::components.page.index_table')
    @slot('buttons', ['create'])
    @slot('resource', 'plans')
    @slot('name', trans('plan::plans.plan'))

    @component('admin::components.table')
        @slot('thead')
            <tr>
                @include('admin::partials.table.select_all')

                <th>{{ trans('plan::plans.table.subscription_cost') }}</th>
                <th>{{ trans('plan::plans.table.currency') }}</th>
                <th>{{ trans('plan::plans.table.limit') }}</th>
                <th>{{ trans('plan::plans.table.commission') }}</th>
                <th>{{ trans('plan::plans.table.num_invitations') }}</th>
                <th>{{ trans('plan::plans.table.min_commission_to_appear') }}</th>

                <th data-sort>{{ trans('admin::admin.table.created') }}</th>
            </tr>
        @endslot
    @endcomponent
@endcomponent

@push('scripts')
    <script>
        new DataTable('#plans-table .table', {
            columns: [
                { data: 'checkbox', orderable: false, searchable: false, width: '3%' },
                { data: 'subscription_cost', name: 'translations.subscription_cost', orderable: false, defaultContent: '' },
                { data: 'currency', name: 'translations.currency', orderable: false, defaultContent: '' },
                { data: 'limit', name: 'translations.limit', orderable: false, defaultContent: '' },
                { data: 'commission', name: 'translations.commission', orderable: false, defaultContent: '' },
                { data: 'max_people', name: 'translations.max_people', orderable: false, defaultContent: '' },
                { data: 'min_commission_to_appear', name: 'translations.min_commission_to_appear', orderable: false, defaultContent: '' },

                { data: 'created', name: 'created_at', width: '30%' },
            ],
        });
    </script>
@endpush
