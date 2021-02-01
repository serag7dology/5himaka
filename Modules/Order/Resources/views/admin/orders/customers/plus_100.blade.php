@extends('admin::layout')

@component('admin::components.page.header')
    @slot('title', trans('order::orders.plus_100_product'))

    <li class="active">{{ trans('order::orders.plus_100_product') }}</li>
@endcomponent

@section('content')
    <div class="box box-primary">
        <div class="box-body index-table" id="products-plus-100-table">
            @component('admin::components.table')
                @slot('thead')
                    <tr>
                        <th>{{ trans('order::orders.table.customer_name') }}</th>
                        <th>{{ trans('order::orders.table.total') }}</th>
                    </tr>
                @endslot
            @endcomponent
        </div>
    </div>
@endsection

@push('scripts')
    <script>
         DataTable.setRoutes('#products-plus-100-table .table', {
            index: '{{ "admin.orders.customers.products.plus" }}',
        });

        new DataTable('#products-plus-100-table .table', {
            columns: [
                { data: 'customer_full_name', orderable: false, searchable: false },
                { data: 'total_products' },
                
            ],
        });
    </script>
@endpush
