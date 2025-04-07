<?php
/**
 * PayPal Setting & API Credentials
 * Created by Raza Mehdi <srmk@outlook.com>.
 */

 return [
    'mode' => env('PAYPAL_MODE', 'sandbox'),
    'sandbox' => [
        'client_id' => env('PAYPAL_SANDBOX_CLIENT_ID'),
        'client_secret' => env('PAYPAL_SANDBOX_CLIENT_SECRET'),
    ],
    'live' => [
        'client_id' => env('PAYPAL_LIVE_CLIENT_ID'),
        'client_secret' => env('PAYPAL_LIVE_CLIENT_SECRET'),
    ],
    'currency_rate' => env('PAYPAL_CURRENCY_RATE', 0.1), // MAD to USD conversion rate
    'payment_action' => 'Sale',
    'currency' => 'USD',
    'notify_url' => '',
    'locale' => 'en_US',
    'validate_ssl' => true,
];
