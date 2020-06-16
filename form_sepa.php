<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <title>Submit Payment</title>
        <script src="https://js.stripe.com/v3/"></script>

</head>
<body>



<form action="/form" method="post" id="setup-form">
    <div class="form-row inline">
        <div class="col">
            <label for="accountholder-name">
                Name
            </label>
            <input
                id="accountholder-name"
                name="accountholder-name"
                placeholder="Jenny Rosen"
                required
            />
        </div>

        <div class="col">
            <label for="email">
                Email Address
            </label>
            <input
                id="email"
                name="email"
                type="email"
                placeholder="jenny.rosen@example.com"
                required
            />
        </div>
    </div>

    <div class="form-row">
        <!--
          Using a label with a for attribute that matches the ID of the
          Element container enables the Element to automatically gain focus
          when the customer clicks on the label.
        -->
        <label for="iban-element">
            IBAN
        </label>
        <div id="iban-element">
            <!-- A Stripe Element will be inserted here. -->
        </div>
    </div>

    <!-- Add the client_secret from the SetupIntent as a data attribute   -->
    <button id="submit-button" data-secret="<?= $setup->client_secret ;?>">
        Set up SEPA Direct Debit
    </button>

    <!-- Used to display form errors. -->
    <div id="error-message" role="alert"></div>

    <!-- Display mandate acceptance text. -->
    <div id="mandate-acceptance">
        By providing your IBAN, you are authorizing *Rocketship Inc* and Stripe,
        our payment service provider, to send instructions to your bank to debit
        your account in accordance with those instructions. Subsequent payments are
        entitled to a refund from your bank under the terms and conditions of your
        agreement with your bank. A refund must be claimed within eight weeks
        starting from the date on which your account was debited.
    </div>
</form>



<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
        <script>
            var stripe = Stripe('pk_test_8I8CLoJqelcPAjz60yP76o69003QmHvBTI');
            var elements = stripe.elements();

            // Custom styling can be passed to options when creating an Element.
            var style = {
                base: {
                    color: '#32325d',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    },
                    ':-webkit-autofill': {
                        color: '#32325d',
                    },
                },
                invalid: {
                    color: '#fa755a',
                    iconColor: '#fa755a',
                    ':-webkit-autofill': {
                        color: '#fa755a',
                    },
                },
            };

            var options = {
                style: style,
                supportedCountries: ['SEPA'],
                // Elements can use a placeholder as an example IBAN that reflects
                // the IBAN format of your customer's country. If you know your
                // customer's country, we recommend that you pass it to the Element as the
                // placeholderCountry.
                placeholderCountry: 'FR',
            };

            // Create an instance of the IBAN Element
            var iban = elements.create('iban', options);

            // Add an instance of the IBAN Element into the `iban-element` <div>
            iban.mount('#iban-element');


            iban.on('change', function(event) {
                var displayError = document.getElementById('error-message');
                if (event.error) {
                    displayError.textContent = event.error.message;
                } else {
                    displayError.textContent = '';
                }
            });

            var form = document.getElementById('setup-form');
            var accountholderName = document.getElementById('accountholder-name');
            var email = document.getElementById('email');
            var submitButton = document.getElementById('submit-button');
            var clientSecret = submitButton.dataset.secret;

            form.addEventListener('submit', function(event) {
                event.preventDefault();

                stripe.confirmSepaDebitPayment(
                    clientSecret,
                    {
                        payment_method: {
                            sepa_debit: iban,
                            billing_details: {
                                name: accountholderName.value,
                                email: email.value,
                            },
                        },
                    }
                ) .then(function(result) {
                    // Handle result.error or result.setupIntent
                    console.log(result);
                    $.ajax({
                        url: "ajaxStripe.php",
                        type: "post",
                        data: {
                            setup_id: result.paymentIntent.id,
                            setup_pm: result.paymentIntent.payment_method,
                            customer: '<?= $customer->id; ?>',
                            //   intent_id: result.paymentIntent.id,
                            // intent_pm: result.paiementIntent.payment_method
                        } ,
                        success: function (response) {

                            // You will get response from your PHP page (what you echo or print)
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });


                });


/*
                stripe
                    .confirmSepaDebitSetup('', {
                        payment_method: {
                            sepa_debit: iban,
                            billing_details: {
                                name: accountholderName.value,
                                email: email.value,
                            },
                        },
                    })
                    .then(function(result1) {
                        // Handle result.error or result.setupIntent
                        console.log(result1.setupIntent);

/




                    });*/
            });

        </script>



</body>
</html>