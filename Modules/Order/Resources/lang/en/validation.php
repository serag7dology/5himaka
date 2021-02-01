<?php

return [
    'customer_email.required' => 'customer_email is required',
    'customer_email.max' => 'max length of customer_email is 255',
    'customer_phone.required'=> 'customer_phone is required',
    'billing_first_name.required'=> 'billing_first_name is required',
    'billing_last_name.required'=>  'last_first_name is required',
    'billing_address_1.required'=> 'billing_address_1 is required',
    'billing_city.required'=> 'billing_city is required',
    'billing_state.required'=> 'billing_state is required',
    'billing_zip.required'=> 'billing_zip is required',
    'billing_country.required'=>  'billing_country is required',
    'billing_country.in'=>  'billing_country not supported',
    'products.required'=> 'products are required', 
    'order_id.required'=> 'order_id is required', 
    'order_id.exists'=> 'order_id not exists', 
    'customer_email.email'=>'cutsomer_email must be email',
    'create_an_account.boolean'=>'create_an_account only accept true or false',
    'password.required_if' => 'password is required if create_an_account is true',
    'ship_to_different_address.boolean' =>'ship_to_different_address only accept true or false',
    'shipping_first_name.required_if'=> 'shipping first name is required if ship_to_different_address is true',
    'shipping_last_name.required_if'=> 'shipping last name is required if ship_to_different_address is true',
    'shipping_address_1.required_if'=> 'shipping address 1 is required if ship_to_different_address is true',
    'shipping_city.required_if'=> 'shipping city is required if ship_to_different_address is true',
    'shipping_zip.required_if'=>  'shipping zip is required if ship_to_different_address is true',
    'shipping_country.required_if'=> 'shipping country is required if ship_to_different_address is true',
    'shipping_state.required_if'=> 'shipping state is required if ship_to_different_address is true',
    'payment_method.required'=> 'payment_method is required',
    'shipping_method.required'=> 'shipping_method is required',
    'terms_and_conditions.accepted'=>'terms_and_conditions must be true',
    'price.required'=>'please sent your order price to check',
    'transaction_id.required'=>"transaction number is required"


];