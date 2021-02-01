<!DOCTYPE html>
<html lang="{{ locale() }}">
    <head>
        <base href="{{ config('app.url') }}">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0">

        <title>
            @hasSection('title')
                @yield('title') - {{ setting('store_name') }}
            @else
                {{ setting('store_name') }}
            @endif
        </title>

        @stack('meta')

        <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500&display=swap" rel="stylesheet">

        @if (is_rtl())
            <link rel="stylesheet" href="{{ v(Theme::url('public/css/app.rtl.css')) }}">
        @else
            <link rel="stylesheet" href="{{ v(Theme::url('public/css/app.css')) }}">
        @endif
            <link rel="stylesheet" href="{{ v(Theme::url('public/css/chat.css')) }}">

        <link rel="shortcut icon" href="{{ $favicon }}" type="image/x-icon">

        @stack('styles')

        {!! setting('custom_header_assets') !!}
        <script src="https://www.gstatic.com/firebasejs/8.2.2/firebase-app.js"></script>

<!-- If you enabled Analytics in your project, add the Firebase SDK for Analytics -->
<script src="https://www.gstatic.com/firebasejs/8.2.2/firebase-analytics.js"></script>

<!-- Add Firebase products that you want to use -->
<script src="https://www.gstatic.com/firebasejs/8.2.2/firebase-auth.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.2.2/firebase-firestore.js"></script>
    <script>
      
       var firebaseConfig = {
            apiKey: "AIzaSyCERNG7EKI6NHQFJUmLUi2Pqwu5gbwTjr4",
            authDomain: "chat-a378a.firebaseapp.com",
            databaseURL: "https://chat-a378a.firebaseio.com",
            projectId: "chat-a378a",
            storageBucket: "chat-a378a.appspot.com",
            messagingSenderId: "565047459275",
            appId: "1:565047459275:web:9a5f6cbb648b4c3b628a4e"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
      
       
        // db.settings({
        //     timestampsInSnapshots:true 
        // })
        </script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
        <script>
            window.FleetCart = {
                baseUrl: '{{ config("app.url") }}',
                rtl: {{ is_rtl() ? 'true' : 'false' }},
                loggedIn: {{ auth()->check() ? 'true' : 'false' }},
                csrfToken: '{{ csrf_token() }}',
                stripePublishableKey: '{{ setting("stripe_publishable_key") }}',
                cart: {!! $cart !!},
                wishlist: {!! $wishlist !!},
                compareList: {!! $compareList !!},
                langs: {
                    'storefront::layout.next': '{{ trans("storefront::layout.next") }}',
                    'storefront::layout.prev': '{{ trans("storefront::layout.prev") }}',
                    'storefront::layout.search_for_products': '{{ trans("storefront::layout.search_for_products") }}',
                    'storefront::layout.all_categories': '{{ trans("storefront::layout.all_categories") }}',
                    'storefront::layout.most_searched': '{{ trans("storefront::layout.most_searched") }}',
                    'storefront::layout.search_for_products': '{{ trans("storefront::layout.search_for_products") }}',
                    'storefront::layout.category_suggestions': '{{ trans("storefront::layout.category_suggestions") }}',
                    'storefront::layout.product_suggestions': '{{ trans("storefront::layout.product_suggestions") }}',
                    'storefront::layout.product_suggestions': '{{ trans("storefront::layout.product_suggestions") }}',
                    'storefront::layout.more_results': '{{ trans("storefront::layout.more_results") }}',
                    'storefront::layout.shop_now': '{{ trans("storefront::layout.shop_now") }}',
                    'storefront::product_card.out_of_stock': '{{ trans("storefront::product_card.out_of_stock") }}',
                    'storefront::product_card.new': '{{ trans("storefront::product_card.new") }}',
                    'storefront::product_card.add_to_cart': '{{ trans("storefront::product_card.add_to_cart") }}',
                    'storefront::product_card.view_options': '{{ trans("storefront::product_card.view_options") }}',
                    'storefront::product_card.compare': '{{ trans("storefront::product_card.compare") }}',
                    'storefront::product_card.wishlist': '{{ trans("storefront::product_card.wishlist") }}',
                    'storefront::product_card.available': '{{ trans("storefront::product_card.available") }}',
                    'storefront::product_card.sold': '{{ trans("storefront::product_card.sold") }}',
                },
            };
        </script>

        {!! $schemaMarkup->toScript() !!}

        @stack('globals')

        @routes
    </head>

    <body class="{{ $theme }} {{ is_rtl() ? 'rtl' : 'ltr' }}">
        <div class="wrapper" id="app">
            @include('public.layout.top_nav')
            @include('public.layout.header')
            @include('public.layout.banner')



            @include('public.layout.navigation')
            @include('public.layout.breadcrumb')

            @yield('content')

            @include('public.home.sections.subscribe')
            @include('public.layout.footer')

            <div class="overlay"></div>

            @include('public.layout.sidebar_menu')
            @include('public.layout.sidebar_cart')
            @include('public.layout.alert')
            {{--  @include('public.layout.newsletter_popup')  --}}
            @include('public.layout.cookie_bar')
        </div>

        @stack('pre-scripts')

        <script src="{{ v(Theme::url('public/js/app.js')) }}"></script>

        @stack('scripts')

        {!! setting('custom_footer_assets') !!}
    </body>
</html>
