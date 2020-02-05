
<script type="text/javascript" src="https://js.squareupsandbox.com/v2/paymentform">
</script>

<!-- link to the local custom styles for SqPaymentForm -->
<link rel="stylesheet" type="text/css" href="mysqpaymentform.css">

<div id="sq-card-number"></div>
<div class="third" id="sq-expiration-date"></div>
<div class="third" id="sq-cvv"></div>
<div class="third" id="sq-postal-code"></div>

<script type="text/javascript">
    // Create and initialize a payment form object
    const paymentForm = new SqPaymentForm({
        // Initialize the payment form elements

        //TODO: Replace with your sandbox application ID
        applicationId: "REPLACE_WITH_APPLICATION_ID",
        inputClass: 'sq-input',
        autoBuild: false,
        // Customize the CSS for SqPaymentForm iframe elements
        inputStyles: [{
            fontSize: '16px',
            lineHeight: '24px',
            padding: '16px',
            placeholderColor: '#a0a0a0',
            backgroundColor: 'transparent',
        }],
        // Initialize the credit card placeholders
        cardNumber: {
            elementId: 'sq-card-number',
            placeholder: 'Card Number'
        },
        cvv: {
            elementId: 'sq-cvv',
            placeholder: 'CVV'
        },
        expirationDate: {
            elementId: 'sq-expiration-date',
            placeholder: 'MM/YY'
        },
        postalCode: {
            elementId: 'sq-postal-code',
            placeholder: 'Postal'
        },
        // SqPaymentForm callback functions
        callbacks: {
            /*
            * callback function: cardNonceResponseReceived
            * Triggered when: SqPaymentForm completes a card nonce request
            */
            cardNonceResponseReceived: function (errors, nonce, cardData) {
                if (errors) {
                    // Log errors from nonce generation to the browser developer console.
                    console.error('Encountered errors:');
                    errors.forEach(function (error) {
                        console.error('  ' + error.message);
                    });
                    alert('Encountered errors, check browser developer console for more details');
                    return;
                }
                alert(`The generated nonce is:\n${nonce}`);
                //TODO: Replace alert with code in step 2.1
            }
        }
    });
    //TODO: paste code from step 1.1.4
</script>
