<?php

use Stripe\SetupIntent;
use Stripe\Stripe as StripeAlias;

require_once ('vendor/autoload.php');
require('function.php');

define('STRIPE_KEY_PUBLIC', 'pk_test_8I8CLoJqelcPAjz60yP76o69003QmHvBTI');
define('STRIPE_KEY_SECRET', 'sk_test_Q7vui4OKspZy6f65miqAG7OS00ulI6nak3');


dump(STRIPE_KEY_PUBLIC);

// creation client
$stripe = new \Stripe\StripeClient(STRIPE_KEY_SECRET);



var_dump($_POST);

if ($_POST['setup_id']){

    dump($_POST);

    $sub = \Stripe\Subscription::create([
        'customer' => $customer->id,
        'items' => [
            [
                'price' => $plan2,
            ],
        ],
    ]);

    $sub = \Stripe\Subscription::create([
        'customer' => $customer->id,
        'items' => [
            [
                'price' => $plan1,
            ],
        ],
    ]);
    dump($sub);


    $stripe->paymentMethods->attach(
        $_POST['setup_pm'],
        ['customer' =>  $_POST['customer'],]
    );

    $sub =  $stripe->subscriptions->create([
        'customer' => $_POST['customer'],
        'items' => [['plan' =>  $_POST['plan']]],
        'default_payment_method' => $_POST['setup_pm']
    ]);

    dump($sub);
}
