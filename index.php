<?php

use Stripe\SetupIntent;
use Stripe\Stripe ;

require_once ('vendor/autoload.php');
require('function.php');

define('STRIPE_KEY_PUBLIC', 'pk_test_8I8CLoJqelcPAjz60yP76o69003QmHvBTI');
define('STRIPE_KEY_SECRET', 'sk_test_Q7vui4OKspZy6f65miqAG7OS00ulI6nak3');


Stripe::setApiKey(STRIPE_KEY_SECRET);

$customer = \Stripe\Customer::create([
    'name' => 'jos',
    'email' => "js@free.Fr",
    'description' => 'My First Test Customer (created for API docs)',
]);


//dump($customer);




$product1 = \Stripe\Product::create(['name' => 'Don mensuel',]);
$product2 = \Stripe\Product::create(['name' => 'Don anuelle',]);

$plan1 = \Stripe\Price::create([
        'nickname' => 'Standard Monthly',
        'product' => $product1->id,
        'unit_amount' => 2000,
        'currency' => 'eur',
        'recurring' => [
            'interval' => 'month',
            'usage_type' => 'licensed',
        ],
    ]);

$plan2 = \Stripe\Price::create([
    'nickname' => 'Standard Monthly',
    'product' => $product2->id,
    'unit_amount' => 3000,
    'currency' => 'eur',
    'recurring' => [
        'interval' => 'year',
        'usage_type' => 'licensed',
    ],
]);




$setup  = SetupIntent::create([
    'payment_method_types' => ['sepa_debit'],
    'customer' => $customer->id,
    'usage' => 'off_session',
]);
/*

// creation client
$stripe = new \Stripe\StripeClient(STRIPE_KEY_SECRET);





// creation du produit
$product = $stripe->products->create(['name' => 'Gold Special',]);
//dump($product);

// creation du plan
$plan = $stripe->plans->create([
    'amount' => 2000,
    'currency' => 'eur',
    'interval' => 'month',
    'product' => $product->id,
]);
//dump($plan);

// creation du client
$customer = $stripe->customers->create([
    'email' => "js@free.Fr",
    'description' => 'My First Test Customer (created for API docs)',
]);
//dump($customer);

// creation du paiement intent
$paiementIntent = $stripe->paymentIntents->create([
    'amount' => 2000,
    'currency' => 'eur',
    'payment_method_types' => ['sepa_debit'],
    'customer' => $customer->id,
    'setup_future_usage'=>'off_session'

]);
//dump($paiementIntent);

/*
// creation du paiement intent setup
$setup_intent = $stripe->setupIntents->create([
    'payment_method_types' => ['sepa_debit'],
    'customer' => $customer->id,
]);
*/
//dump($setup_intent);










require 'form_sepa.php';