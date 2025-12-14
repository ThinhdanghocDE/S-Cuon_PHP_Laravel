<?php

return [

    'tmn_code' => env('VNPAY_TMN_CODE'),

    'hash_secret' => env('VNPAY_HASH_SECRET'),

    'pay_url' => env('VNPAY_URL'),

    'return_url' => env('VNPAY_RETURN_URL'),

    'ipn_url' => env('VNPAY_IPN_URL'),

    'version' => '2.1.0',

    'locale' => 'vn',

    'currency' => 'VND',

    'order_type' => 'other',
];
